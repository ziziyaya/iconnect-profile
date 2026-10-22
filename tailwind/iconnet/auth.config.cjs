/** Login, sign up & lupa password.
 *  Sama persis dengan tailwind.config lama di halaman-halaman ini. Output: css/auth.css */
module.exports = {
  content: { relative: true, files: ['../../resources/views/iconnet/login.blade.php', '../../resources/views/iconnet/signup.blade.php', '../../resources/views/iconnet/forgot-password.blade.php'] },
  theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] }, colors: { brand: { btn: '#1D62A8' } } } }
};
