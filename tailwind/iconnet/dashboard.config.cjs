/** Dashboard peserta & admin (breakpoint default Tailwind).
 *  Sama persis dengan tailwind.config lama di halaman-halaman ini. Output: css/dashboard.css */
module.exports = {
  content: { relative: true, files: ['../../resources/views/iconnet/beranda.blade.php', '../../resources/views/iconnet/absensi.blade.php', '../../resources/views/iconnet/beranda-admin.blade.php'] },
  theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { navy: '#05052E', cyan2: '#02B6D1', ink: '#0B0B3B' } } }
};
