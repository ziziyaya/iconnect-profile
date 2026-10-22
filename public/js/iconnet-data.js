/* =========================================================
   ICONNET - DATA PESERTA (sumber data tunggal untuk halaman admin)
   Dipakai oleh: verifikasi-user, akun-user, beranda-admin

   VERSI LARAVEL: daftar peserta diambil dari database (tabel users, role karyawan),
   dikirim server lewat iconnet-api.js dengan key 'iconnet_peserta'.
   1. Sign up      -> akun baru berstatus 'menunggu' (users.status = pending)
   2. Verifikasi   -> admin setujui / tolak -> disimpan ke database (approved / rejected + alasan)
   3. Akun User    -> menampilkan akun berstatus 'disetujui'; hapus akun = soft delete di database
                      (akun tidak bisa login lagi, riwayat presensinya tetap tersimpan)
   4. Beranda      -> kartu ringkasan & progress bar dihitung dari data yang sama (ICONNET.counts())
   ========================================================= */
(function () {
  var KEY = 'iconnet_peserta';

  function low(s) { return String(s || '').trim().toLowerCase(); }
  function read() { return window.ICONNET_API ? ICONNET_API.read(KEY, []) : []; }

  // Semua peserta (bukan admin/superadmin), lengkap dengan status terkini. id = email (huruf kecil)
  function getAll() {
    return read().map(function (p) {
      p.id = low(p.email);
      if (!p.alasan) p.alasan = undefined;
      return p;
    });
  }

  // Simpan respons server (daftar peserta terbaru) lalu beri tahu halaman
  function apply(res) {
    if (res && Array.isArray(res.peserta)) ICONNET_API.write(KEY, res.peserta);
    notify();
    return res;
  }
  function fail(err) {
    alert((err && err.message) || 'Gagal menyimpan perubahan. Coba lagi.');
    location.reload();   // muat ulang supaya tampilan sama dengan data di server
  }

  // Sign up kini lewat halaman signup (API /api/v1/auth/register)
  function registerUser() {
    throw new Error('Pendaftaran akun dilakukan lewat halaman Sign Up (server).');
  }

  // Dipanggil admin di halaman Verifikasi User
  function saveDecision(email, status, alasan) {
    return ICONNET_API.request('POST', 'api/v1/peserta/verifikasi', { email: email, status: status, alasan: alasan || '' })
      .then(apply, fail);
  }

  // Dipanggil admin di halaman Akun User: akun hilang dari semua halaman & tidak bisa login lagi
  function deleteAccount(email) {
    return ICONNET_API.request('POST', 'api/v1/peserta/hapus', { email: email })
      .then(apply, fail);
  }

  // Ringkasan untuk Beranda Admin
  function counts() {
    var c = { menunggu: 0, disetujui: 0, ditolak: 0, total: 0 };
    getAll().forEach(function (p) { if (p.status in c) { c[p.status]++; c.total++; } });
    return c;
  }

  function notify() { try { window.dispatchEvent(new Event('iconnet:users-updated')); } catch (e) {} }

  // Panggil callback tiap data berubah
  function onChange(fn) {
    window.addEventListener('iconnet:users-updated', fn);
    window.addEventListener('pageshow', fn);
  }

  window.ICONNET = { getAll: getAll, registerUser: registerUser, saveDecision: saveDecision, deleteAccount: deleteAccount, counts: counts, onChange: onChange };
})();
