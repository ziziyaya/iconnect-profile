<?php

namespace App\Support;

use App\Models\Absensi;
use App\Models\Banner;
use App\Models\Izin;
use App\Models\Paket;
use App\Models\Pengaturan;
use App\Models\Perjalanan;
use App\Models\Testimoni;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Jembatan data antara database Laravel dan halaman frontend ICONNET.
 *
 * Frontend aslinya membaca data dari localStorage dengan key & bentuk tertentu
 * (lihat CATATAN-REVIEW.md frontend). Kelas ini menyusun data ASLI dari database
 * dengan bentuk yang sama persis, lalu dikirim ke halaman lewat window.ICONNET_SERVER.
 * Dengan begitu tampilan & logika halaman tetap sama, tetapi sumber datanya database.
 *
 * Pemetaan role:  karyawan (database) <-> user (frontend)
 * Pemetaan status akun: pending/approved/rejected <-> menunggu/disetujui/ditolak
 */
class IconnetData
{
    public const STATUS_KE_FRONTEND = [
        'pending' => 'menunggu',
        'approved' => 'disetujui',
        'rejected' => 'ditolak',
    ];

    /* =====================================================================
       Akun & sesi
       ===================================================================== */

    public static function role(?User $user): string
    {
        if ($user === null) {
            return 'user';
        }
        if ($user->role === 'superadmin') {
            return 'superadmin';
        }
        if ($user->role === 'admin') {
            return 'admin';
        }

        return 'user';
    }

    /** Halaman beranda sesuai role (path relatif dari root aplikasi). */
    public static function homePath(?User $user): string
    {
        $role = self::role($user);
        if ($role === 'superadmin') {
            return 'beranda-superadmin';
        }
        if ($role === 'admin') {
            return 'beranda-admin';
        }

        return 'beranda';
    }

    /** Pengganti localStorage 'iconnet_session' = { email, nama, role } */
    public static function session(?User $user): ?array
    {
        if ($user === null) {
            return null;
        }

        return [
            'email' => strtolower($user->email),
            'nama' => $user->name,
            'role' => self::role($user),
            'sekolah' => $user->sekolah ?? '',
        ];
    }

    /** Satu akun dalam bentuk 'iconnet_users' (tanpa password). */
    public static function userRow(User $user): array
    {
        return [
            'email' => strtolower($user->email),
            'nama' => $user->name,
            'role' => self::role($user),
            'sekolah' => $user->sekolah ?? '',
            'telepon' => $user->telepon ?? '',
            'gender' => $user->jenis_kelamin ?? '',
            'tanggalDaftar' => $user->created_at ? $user->created_at->toIso8601String() : '',
        ];
    }

    /** Peserta yang sudah disetujui (dipakai halaman superadmin sebagai daftar peserta). */
    public static function pesertaAktif(): array
    {
        return User::where('role', 'karyawan')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get()
            ->map(fn (User $u) => self::userRow($u))
            ->all();
    }

    /** Bentuk data untuk iconnet-data.js (Verifikasi User, Akun User, Beranda Admin). */
    public static function pesertaRow(User $user): array
    {
        $jk = '-';
        if ($user->jenis_kelamin === 'L') {
            $jk = 'Laki-laki';
        } elseif ($user->jenis_kelamin === 'P') {
            $jk = 'Perempuan';
        }

        return [
            'id' => strtolower($user->email),
            'nama' => $user->name,
            'email' => $user->email,
            'telepon' => $user->telepon ?: '-',
            'jk' => $jk,
            'sekolah' => $user->sekolah ?: '-',
            'status' => self::STATUS_KE_FRONTEND[$user->status] ?? 'menunggu',
            'alasan' => $user->status === 'rejected' ? ($user->alasan_penolakan ?? '') : '',
        ];
    }

    public static function semuaPeserta(): array
    {
        return User::where('role', 'karyawan')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->map(fn (User $u) => self::pesertaRow($u))
            ->all();
    }

    /* =====================================================================
       File (foto banner, kegiatan, presensi)
       ===================================================================== */

    /** Path di database -> URL. Path relatif disk 'public' (sama dengan view lama: asset('storage/...')). */
    public static function fileUrl(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }
        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }
        if (Str::startsWith($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    /* =====================================================================
       Presensi & izin
       ===================================================================== */

    public static function jamMasukStandar(): string
    {
        $jam = Pengaturan::instance()->jam_masuk_standar;

        return $jam ? substr((string) $jam, 0, 8) : '08:00:00';
    }

    /** Status hadir / terlambat dari jam masuk (aturan sama dengan DashboardController lama). */
    public static function statusMasuk(?string $jamMasuk, ?string $jamStandar = null): ?string
    {
        if (! $jamMasuk) {
            return null;
        }
        $jamStandar = $jamStandar ?? self::jamMasukStandar();

        return substr($jamMasuk, 0, 8) > $jamStandar ? 'terlambat' : 'hadir';
    }

    /** Tanggal-tanggal yang dihitung untuk satu izin: hari kerja saja (sama seperti absensi.html). */
    public static function hariIzin(string $mulai, ?string $selesai): array
    {
        $semua = [];
        $tgl = Carbon::parse($mulai);
        $akhir = Carbon::parse($selesai ?: $mulai);
        for ($i = 0; $i < 366 && $tgl->lte($akhir); $i++) {
            $semua[] = $tgl->copy();
            $tgl->addDay();
        }
        $kerja = array_values(array_filter($semua, fn (Carbon $d) => $d->isWeekday()));
        $dipakai = count($kerja) ? $kerja : $semua;

        return array_map(fn (Carbon $d) => $d->format('Y-m-d'), $dipakai);
    }

    /**
     * Pengganti localStorage 'iconnet_attendance':
     * [{ email, date, masuk, pulang, status, fotoMasuk, fotoPulang }]
     * Hari izin/sakit (pengajuan yang tidak ditolak) ikut menjadi record berstatus izin/sakit.
     */
    public static function attendance(?int $userId = null, bool $denganIdentitas = false): array
    {
        $jamStandar = self::jamMasukStandar();

        $absensis = Absensi::with(['user' => fn ($q) => $q->withTrashed()])
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        $rows = [];
        foreach ($absensis as $a) {
            if (! $a->user) {
                continue;
            }
            $tanggal = substr((string) $a->tanggal, 0, 10);
            $kunci = $a->user_id.'|'.$tanggal;
            $row = [
                'email' => strtolower($a->user->email),
                'date' => $tanggal,
                'masuk' => $a->jam_masuk ? substr((string) $a->jam_masuk, 0, 8) : null,
                'pulang' => $a->jam_pulang ? substr((string) $a->jam_pulang, 0, 8) : null,
                'status' => self::statusMasuk($a->jam_masuk, $jamStandar),
                'fotoMasuk' => self::fileUrl($a->foto_masuk),
                'fotoPulang' => self::fileUrl($a->foto_pulang),
            ];
            if ($denganIdentitas) {
                $row['nama'] = $a->user->name;
                $row['sekolah'] = $a->user->sekolah ?? '';
            }
            $rows[$kunci] = $row;
        }

        $izins = Izin::with(['user' => fn ($q) => $q->withTrashed()])
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->where('status', '!=', 'rejected')
            ->orderBy('tanggal')
            ->get();

        foreach ($izins as $izin) {
            if (! $izin->user) {
                continue;
            }
            $jenis = $izin->jenis === 'sakit' ? 'sakit' : 'izin';
            foreach (self::hariIzin((string) $izin->tanggal, $izin->tanggal_selesai ? (string) $izin->tanggal_selesai : null) as $tanggal) {
                $kunci = $izin->user_id.'|'.$tanggal;
                if (isset($rows[$kunci]) && $rows[$kunci]['masuk']) {
                    continue; // sudah absen masuk: tidak ditimpa (aturan sama dengan absensi.html)
                }
                $row = [
                    'email' => strtolower($izin->user->email),
                    'date' => $tanggal,
                    'masuk' => null,
                    'pulang' => null,
                    'status' => $jenis,
                    'fotoMasuk' => '',
                    'fotoPulang' => '',
                ];
                if ($denganIdentitas) {
                    $row['nama'] = $izin->user->name;
                    $row['sekolah'] = $izin->user->sekolah ?? '';
                }
                $rows[$kunci] = $row;
            }
        }

        $rows = array_values($rows);
        usort($rows, fn ($x, $y) => strcmp($x['date'], $y['date']));

        return $rows;
    }

    /** Pengganti localStorage 'iconnet_leave'. File bukti dibuka lewat route yang dicek login. */
    public static function leaves(?int $userId = null, bool $denganIdentitas = false): array
    {
        return Izin::with(['user' => fn ($q) => $q->withTrashed()])
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->where('status', '!=', 'rejected')
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get()
            ->filter(fn (Izin $i) => $i->user !== null)
            ->map(function (Izin $i) use ($denganIdentitas) {
                $jenis = $i->jenis === 'sakit' ? 'sakit' : 'izin';
                $row = [
                    'id' => $i->id,
                    'email' => strtolower($i->user->email),
                    'jenis' => $jenis === 'sakit' ? 'Sakit' : 'Izin',
                    'status' => $jenis,
                    'start' => substr((string) $i->tanggal, 0, 10),
                    'end' => substr((string) ($i->tanggal_selesai ?: $i->tanggal), 0, 10),
                    'alasan' => $i->alasan,
                    'fileName' => $i->bukti ? ($i->bukti_nama ?: basename($i->bukti)) : '',
                    'bukti' => $i->bukti ? route('iconnet.izin.bukti', $i->id) : '',
                    'createdAt' => $i->created_at ? $i->created_at->toIso8601String() : '',
                ];
                if ($denganIdentitas) {
                    $row['nama'] = $i->user->name;
                    $row['sekolah'] = $i->user->sekolah ?? '';
                }

                return $row;
            })
            ->values()
            ->all();
    }

    /* =====================================================================
       Konten website (dikelola superadmin)
       ===================================================================== */

    /** Pengganti 'iconnet_banner' (bentuk data halaman Kelola Beranda). */
    public static function banners(): array
    {
        return Banner::orderBy('urutan')->orderBy('id')->get()->map(fn (Banner $b) => [
            'id' => $b->id,
            'jenis' => $b->jenis === 'foto' ? 'foto' : 'lengkap',
            'judul' => $b->judul ?? '',
            'deskripsi' => $b->deskripsi ?? '',
            'teksTombol' => $b->teks_tombol ?? '',
            'aktif' => (bool) ($b->aktif ?? true),
            'foto' => self::fileUrl($b->gambar),
            'fotoNama' => $b->gambar ? basename($b->gambar) : '',
        ])->all();
    }

    /** Pengganti 'iconnet_kegiatan' (tabel testimonis = "Keseruan Bersama", sama dengan beranda lama). */
    public static function kegiatan(): array
    {
        return Testimoni::orderBy('urutan')->orderByDesc('tanggal')->orderByDesc('id')->get()->map(fn (Testimoni $t) => [
            'id' => $t->id,
            'tanggal' => $t->tanggal ? substr((string) $t->tanggal, 0, 10) : substr((string) $t->created_at, 0, 10),
            'judul' => $t->judul,
            'highlight' => $t->highlight ?? '',
            'deskripsi' => $t->deskripsi ?? '',
            'teksTombol' => '',
            'aktif' => true,
            'foto' => self::fileUrl($t->foto),
            'fotoNama' => $t->foto ? basename($t->foto) : '',
        ])->all();
    }

    /** Pengganti 'iconnet_tentang_kami' = { about, timeline } */
    public static function tentang(): array
    {
        return [
            'about' => (string) (Pengaturan::instance()->tentang ?? ''),
            'timeline' => Perjalanan::orderBy('urutan')->orderBy('id')->get()->map(fn (Perjalanan $p) => [
                'id' => $p->id,
                'tahun' => $p->tahun,
                'judul' => $p->judul,
                'deskripsi' => $p->deskripsi,
            ])->all(),
        ];
    }

    /**
     * Pengganti 'iconnet_paket_harga'.
     * Kolom 'harga' = harga yang dibayar. Promo: hargaPromo = harga, hargaNormal = harga_normal (dicoret).
     * fitur[0] = kapasitas, fitur[1..] = kualitas.
     */
    public static function paketRow(Paket $p): array
    {
        $fitur = is_array($p->fitur) ? array_values($p->fitur) : [];
        $promo = $p->kategori === 'promo';
        $punyaNormal = $promo && $p->harga_normal && $p->harga_normal > $p->harga;

        return [
            'id' => $p->id,
            'kategori' => $promo ? 'promo' : 'reguler',
            'durasi' => $p->durasi ?? '',
            'mbps' => (int) $p->kecepatan_mbps,
            'hargaNormal' => (int) ($punyaNormal ? $p->harga_normal : $p->harga),
            'hargaPromo' => (int) ($punyaNormal ? $p->harga : 0),
            'kapasitas' => (string) ($fitur[0] ?? ''),
            'kualitas' => implode(', ', array_slice($fitur, 1)),
            'terlaris' => (bool) $p->is_popular,
        ];
    }

    public static function paket(): array
    {
        return Paket::orderBy('urutan')->orderBy('id')->get()->map(fn (Paket $p) => self::paketRow($p))->all();
    }

    /** Pengganti 'iconnet_hubungi_kami' (kolom tabel pengaturans). */
    public static function hubungi(): array
    {
        $p = Pengaturan::instance();

        return [
            'alamat' => (string) ($p->alamat ?? ''),
            'callCenter' => (string) ($p->call_center ?? ''),
            'whatsapp' => (string) ($p->no_wa_sales ?? ''),
            'email' => (string) ($p->email ?? ''),
            'jam' => (string) ($p->jam_operasional ?? ''),
            'instagram' => (string) ($p->instagram ?? ''),
            'facebook' => (string) ($p->facebook ?? ''),
            'tiktok' => (string) ($p->tiktok ?? ''),
            'twitter' => (string) ($p->twitter ?? ''),
        ];
    }

    /** Semua konten website publik. */
    public static function konten(): array
    {
        return [
            'iconnet_banner' => self::banners(),
            'iconnet_kegiatan' => self::kegiatan(),
            'iconnet_tentang_kami' => self::tentang(),
            'iconnet_paket_harga' => self::paket(),
            'iconnet_hubungi_kami' => self::hubungi(),
        ];
    }

    /* =====================================================================
       Data per halaman
       ===================================================================== */

    /** Data yang dibutuhkan tiap halaman (hanya data yang memang boleh dilihat role tersebut). */
    public static function untukHalaman(string $halaman, ?User $user): array
    {
        $data = [];
        $diri = $user ? [self::userRow($user)] : [];

        switch ($halaman) {
            case 'index':
            case 'keseruan':
            case 'keseruan-detail':
            case 'tentang-kami':
            case 'paket-harga':
            case 'hubungi-kami':
            case 'kelola-beranda':
            case 'kelola-tentang-kami':
            case 'kelola-paket-harga':
            case 'kelola-hubungi-kami':
                $data = self::konten();
                break;

            case 'beranda':
                $data['iconnet_attendance'] = self::attendance($user->id);
                break;

            case 'absensi':
                $data['iconnet_users'] = $diri;
                $data['iconnet_attendance'] = self::attendance($user->id);
                $data['iconnet_leave'] = self::leaves($user->id);
                break;

            case 'riwayat':
                $data['iconnet_attendance'] = self::attendance($user->id);
                $data['iconnet_leave'] = self::leaves($user->id);
                break;

            case 'profil':
            case 'profil-admin':
            case 'profil-superadmin':
                $data['iconnet_users'] = $diri;
                break;

            case 'beranda-admin':
            case 'verifikasi-user':
            case 'akun-user':
                $data['iconnet_users'] = $diri;
                $data['iconnet_peserta'] = self::semuaPeserta();
                break;

            case 'beranda-superadmin':
                $data['iconnet_users'] = self::pesertaAktif();
                $data['iconnet_attendance'] = self::attendance(null, true);
                break;

            case 'riwayat-superadmin':
            case 'rekap-superadmin':
                $data['iconnet_users'] = self::pesertaAktif();
                $data['iconnet_attendance'] = self::attendance(null, true);
                $data['iconnet_leave'] = self::leaves(null, true);
                break;
        }

        return [
            'session' => self::session($user),
            'data' => $data,
            'jamMasuk' => self::jamMasukStandar(),
        ];
    }
}
