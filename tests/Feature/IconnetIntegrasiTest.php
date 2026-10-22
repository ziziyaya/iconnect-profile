<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Uji integrasi halaman & API frontend ICONNET dengan backend Laravel.
 */
class IconnetIntegrasiTest extends TestCase
{
    use RefreshDatabase;

    private function akun(string $role, string $status = 'approved'): User
    {
        $user = new User();
        $user->name = ucfirst($role).' Uji';
        $user->email = $role.'_'.uniqid().'@uji.test';
        $user->password = Hash::make('password123');
        $user->role = $role;
        $user->status = $status;
        $user->save();

        return $user;
    }

    private function fotoDataUrl(): string
    {
        return 'data:image/png;base64,'.base64_encode(UploadedFile::fake()->image('f.png', 20, 20)->getContent());
    }

    public function test_halaman_publik_tampil(): void
    {
        foreach (['/', '/keseruan', '/keseruan-detail', '/tentang-kami', '/paket-harga', '/hubungi-kami', '/login', '/signup', '/forgot-password'] as $url) {
            $this->get($url)->assertOk()->assertSee('window.ICONNET_SERVER', false);
        }
        $this->get('/index.html')->assertRedirect('/');
    }

    public function test_sign_up_menunggu_verifikasi_lalu_bisa_login_setelah_disetujui(): void
    {
        $this->postJson('/api/v1/auth/register', [
            'nama' => 'Budi Magang', 'email' => 'Budi@Sekolah.test', 'password' => 'rahasia123',
            'telepon' => '081234567890', 'gender' => 'L', 'sekolah' => 'SMKN 1',
        ])->assertOk();

        $budi = User::where('email', 'budi@sekolah.test')->firstOrFail();
        $this->assertSame(['karyawan', 'pending'], [$budi->role, $budi->status]);

        $this->postJson('/api/v1/auth/login', ['email' => 'budi@sekolah.test', 'password' => 'rahasia123'])
            ->assertStatus(403)->assertJsonPath('notice', 'Akun Anda masih menunggu verifikasi admin.');
        $this->assertGuest();

        $this->actingAs($this->akun('admin'))
            ->postJson('/api/v1/peserta/verifikasi', ['email' => 'budi@sekolah.test', 'status' => 'disetujui'])
            ->assertOk();
        $this->assertSame('approved', $budi->fresh()->status);

        auth()->logout();
        $this->postJson('/api/v1/auth/login', ['email' => 'budi@sekolah.test', 'password' => 'rahasia123'])
            ->assertOk()->assertJsonPath('redirect', 'beranda');
    }

    public function test_akses_halaman_sesuai_role(): void
    {
        $this->get('/beranda')->assertRedirect('/login');

        $karyawan = $this->akun('karyawan');
        $this->actingAs($karyawan)->get('/beranda')->assertOk();
        $this->actingAs($karyawan)->get('/kelola-beranda')->assertRedirect(url('beranda'));
        $this->actingAs($karyawan)->putJson('/api/v1/kelola/tentang', ['about' => 'x'])->assertForbidden();

        $admin = $this->akun('admin');
        $this->actingAs($admin)->get('/verifikasi-user')->assertOk();
        $this->actingAs($admin)->get('/profil')->assertRedirect('/profil-admin');

        $this->actingAs($this->akun('superadmin'))->get('/kelola-paket-harga')->assertOk();
    }

    public function test_absen_masuk_pulang_dan_izin(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        $user = $this->akun('karyawan');

        $this->actingAs($user)->postJson('/api/v1/presensi/pulang', ['foto' => $this->fotoDataUrl()])->assertStatus(409);
        $this->actingAs($user)->postJson('/api/v1/presensi/masuk', ['foto' => $this->fotoDataUrl()])->assertOk();
        $this->actingAs($user)->postJson('/api/v1/presensi/masuk', ['foto' => $this->fotoDataUrl()])->assertStatus(409);
        $this->actingAs($user)->postJson('/api/v1/presensi/pulang', ['foto' => $this->fotoDataUrl()])->assertOk();

        $absen = Absensi::where('user_id', $user->id)->firstOrFail();
        $this->assertNotNull($absen->jam_pulang);
        Storage::disk('public')->assertExists($absen->foto_masuk);

        $besok = date('Y-m-d', strtotime('+1 day'));
        $this->actingAs($user)->post('/api/v1/izin', [
            'jenis' => 'sakit', 'start' => $besok, 'end' => $besok, 'alasan' => 'Demam tinggi',
            'bukti' => UploadedFile::fake()->image('surat.jpg'),
        ], ['Accept' => 'application/json'])->assertOk();

        $izin = Izin::where('user_id', $user->id)->firstOrFail();
        $this->assertSame(['sakit', 'pending'], [$izin->jenis, $izin->status]);
        Storage::disk('local')->assertExists($izin->bukti);

        $this->actingAs($user)->get('/izin/'.$izin->id.'/bukti')->assertOk();
        $this->actingAs($this->akun('karyawan'))->get('/izin/'.$izin->id.'/bukti')->assertForbidden();
    }

    public function test_hapus_akun_peserta_tidak_menghapus_riwayat(): void
    {
        $user = $this->akun('karyawan');
        Absensi::create(['user_id' => $user->id, 'tanggal' => date('Y-m-d'), 'jam_masuk' => '08:00:00']);

        $this->actingAs($this->akun('admin'))
            ->postJson('/api/v1/peserta/hapus', ['email' => $user->email])->assertOk();

        $this->assertSoftDeleted($user);
        $this->assertSame(1, Absensi::where('user_id', $user->id)->count());
    }

    public function test_superadmin_kelola_konten(): void
    {
        Storage::fake('public');
        $sa = $this->akun('superadmin');

        $this->actingAs($sa)->postJson('/api/v1/kelola/banner', [
            'jenis' => 'foto', 'foto' => $this->fotoDataUrl(),
        ])->assertOk()->assertJsonCount(1, 'list');

        $this->actingAs($sa)->postJson('/api/v1/kelola/paket', [
            'kategori' => 'promo', 'mbps' => 50, 'hargaNormal' => 329000, 'hargaPromo' => 299000,
            'kapasitas' => '10-12 Perangkat', 'kualitas' => 'Lancar Streaming HD',
        ])->assertOk()->assertJsonPath('list.0.hargaPromo', 299000);

        $this->actingAs($sa)->putJson('/api/v1/kelola/tentang', ['about' => 'Tentang baru'])->assertOk();
        $this->get('/tentang-kami')->assertSee('Tentang baru');
    }
}
