<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Izin;
use App\Support\IconnetData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Presensi peserta (halaman absensi.html):
 *  - absen masuk / pulang dengan foto kamera (aturan sama dengan AbsensiController lama:
 *    satu absen masuk per hari, absen pulang hanya setelah masuk, foto disimpan di storage public)
 *  - pengajuan izin / sakit (disimpan di tabel izins, status awal 'pending' seperti IzinController lama)
 * Jam presensi memakai jam SERVER (zona Asia/Makassar), bukan jam perangkat.
 */
class PresensiController extends Controller
{
    private const MAX_FOTO_BYTES = 5 * 1024 * 1024;

    public function masuk(Request $request)
    {
        $request->validate(['foto' => ['required', 'string']]);

        $user = $request->user();
        $hariIni = date('Y-m-d');

        $sudahAda = Absensi::where('user_id', $user->id)->where('tanggal', $hariIni)->first();
        if ($sudahAda !== null) {
            return response()->json(['message' => 'Kamu sudah absen masuk hari ini.'] + $this->dataTerbaru($user->id), 409);
        }

        $foto = $this->simpanFotoBase64($request->foto, 'masuk', $user->id);
        if ($foto === null) {
            return response()->json(['message' => 'Foto presensi tidak valid. Silakan ambil foto ulang.'], 422);
        }

        $absensi = new Absensi();
        $absensi->user_id = $user->id;
        $absensi->tanggal = $hariIni;
        $absensi->jam_masuk = date('H:i:s');
        $absensi->foto_masuk = $foto;
        $absensi->save();

        return response()->json(['message' => 'Absen masuk berhasil disimpan.'] + $this->dataTerbaru($user->id));
    }

    public function pulang(Request $request)
    {
        $request->validate(['foto' => ['required', 'string']]);

        $user = $request->user();
        $hariIni = date('Y-m-d');

        $absensi = Absensi::where('user_id', $user->id)->where('tanggal', $hariIni)->first();
        if ($absensi === null) {
            return response()->json(['message' => 'Kamu belum absen masuk hari ini.'] + $this->dataTerbaru($user->id), 409);
        }
        if ($absensi->jam_pulang !== null) {
            return response()->json(['message' => 'Kamu sudah absen pulang hari ini.'] + $this->dataTerbaru($user->id), 409);
        }

        $foto = $this->simpanFotoBase64($request->foto, 'pulang', $user->id);
        if ($foto === null) {
            return response()->json(['message' => 'Foto presensi tidak valid. Silakan ambil foto ulang.'], 422);
        }

        $absensi->jam_pulang = date('H:i:s');
        $absensi->foto_pulang = $foto;
        $absensi->save();

        return response()->json(['message' => 'Absen pulang berhasil disimpan.'] + $this->dataTerbaru($user->id));
    }

    public function izin(Request $request)
    {
        $hariIni = date('Y-m-d');

        $request->validate([
            'jenis' => ['required', 'in:izin,sakit'],
            'start' => ['required', 'date_format:Y-m-d', 'after_or_equal:'.$hariIni],
            'end' => ['required', 'date_format:Y-m-d', 'after_or_equal:start'],
            'alasan' => ['required', 'string', 'min:5', 'max:500'],
            'bukti' => ['required', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:10240'],
        ], [
            'start.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'end.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'alasan.min' => 'Jelaskan alasan izin Anda.',
            'bukti.required' => 'Lampirkan bukti chat atau surat izin.',
            'bukti.mimes' => 'Format file harus PNG, JPG, atau PDF.',
            'bukti.max' => 'Ukuran file maksimal 10MB.',
        ]);

        if ((strtotime($request->end) - strtotime($request->start)) / 86400 + 1 > 31) {
            return response()->json(['message' => 'Pengajuan maksimal 31 hari.'], 422);
        }

        $user = $request->user();
        $file = $request->file('bukti');
        // Bukti izin bisa berisi data pribadi (surat dokter): disimpan di disk privat, dibuka lewat route yang dicek login
        $path = $file->store('izin', 'local');

        $izin = new Izin();
        $izin->user_id = $user->id;
        $izin->jenis = $request->jenis;
        $izin->tanggal = $request->start;
        $izin->tanggal_selesai = $request->end;
        $izin->alasan = trim($request->alasan);
        $izin->bukti = $path;
        $izin->bukti_nama = Str::limit($file->getClientOriginalName(), 200, '');
        $izin->status = 'pending';
        $izin->save();

        return response()->json(['message' => 'Pengajuan berhasil dikirim.'] + $this->dataTerbaru($user->id));
    }

    /** Buka file bukti izin: pemilik pengajuan, admin, atau superadmin. */
    public function bukti(Request $request, int $id)
    {
        $izin = Izin::findOrFail($id);
        $user = $request->user();

        if ($izin->user_id !== $user->id && ! $user->isStaff()) {
            abort(403);
        }
        if (! $izin->bukti || ! Storage::disk('local')->exists($izin->bukti)) {
            abort(404);
        }

        return Storage::disk('local')->response($izin->bukti, $izin->bukti_nama ?: basename($izin->bukti), [
            'Cache-Control' => 'private, max-age=0',
        ], 'inline');
    }

    private function dataTerbaru(int $userId): array
    {
        return [
            'attendance' => IconnetData::attendance($userId),
            'leave' => IconnetData::leaves($userId),
        ];
    }

    /**
     * Foto kamera dikirim sebagai data URL (data:image/jpeg;base64,...).
     * Disimpan sebagai file gambar di storage public 'absensi/' (folder yang sama dengan sistem lama).
     */
    private function simpanFotoBase64(string $dataUrl, string $jenis, int $userId): ?string
    {
        if (! preg_match('#^data:image/(png|jpe?g|webp);base64,#i', $dataUrl, $m)) {
            return null;
        }
        $isi = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);
        if ($isi === false || strlen($isi) > self::MAX_FOTO_BYTES || @getimagesizefromstring($isi) === false) {
            return null;
        }

        $ext = strtolower($m[1]) === 'png' ? 'png' : (strtolower($m[1]) === 'webp' ? 'webp' : 'jpg');
        $namaFile = 'absensi/'.$jenis.'_'.$userId.'_'.time().'.'.$ext;
        Storage::disk('public')->put($namaFile, $isi);

        return $namaFile;
    }
}
