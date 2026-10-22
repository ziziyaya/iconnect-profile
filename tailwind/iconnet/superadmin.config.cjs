/** Beranda superadmin: warna navy berbeda (#03045E) dari dashboard lain.
 *  Sama persis dengan tailwind.config lama di halaman ini. Output: css/superadmin.css */
module.exports = {
  content: { relative: true, files: ['../../resources/views/iconnet/beranda-superadmin.blade.php'] },
  theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { navy: '#03045E', cyan2: '#02B6D1', ink: '#0B0B3B' } } }
};
