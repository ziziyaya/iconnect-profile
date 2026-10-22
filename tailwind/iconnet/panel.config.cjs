/** Halaman panel dengan breakpoint lg = 900px (riwayat, profil, rekap, kelola tampilan).
 *  Sama persis dengan tailwind.config lama di halaman-halaman ini. Output: css/panel.css */
module.exports = {
  content: {
    relative: true,
    files: [
      '../../resources/views/iconnet/riwayat.blade.php', '../../resources/views/iconnet/profil.blade.php', '../../resources/views/iconnet/profil-admin.blade.php', '../../resources/views/iconnet/profil-superadmin.blade.php',
      '../../resources/views/iconnet/riwayat-superadmin.blade.php', '../../resources/views/iconnet/rekap-superadmin.blade.php',
      '../../resources/views/iconnet/kelola-beranda.blade.php', '../../resources/views/iconnet/kelola-tentang-kami.blade.php', '../../resources/views/iconnet/kelola-paket-harga.blade.php', '../../resources/views/iconnet/kelola-hubungi-kami.blade.php'
    ]
  },
  theme: {
    screens: { sm: '640px', md: '768px', lg: '900px', xl: '1280px', '2xl': '1536px' },
    extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { navy: '#05052E', cyan2: '#02B6D1', ink: '#0B0B3B' } }
  }
};
