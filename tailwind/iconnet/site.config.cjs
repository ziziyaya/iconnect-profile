/** Website publik (beranda, keseruan, tentang kami, paket & harga, hubungi kami).
 *  Gabungan palet brand dari semua halaman publik (warna yang sama, nilai sama). Output: css/site.css */
module.exports = {
  content: {
    relative: true,
    files: ['../../resources/views/iconnet/index.blade.php', '../../resources/views/iconnet/keseruan.blade.php', '../../resources/views/iconnet/keseruan-detail.blade.php', '../../resources/views/iconnet/tentang-kami.blade.php', '../../resources/views/iconnet/paket-harga.blade.php', '../../resources/views/iconnet/hubungi-kami.blade.php']
  },
  theme: {
    extend: {
      fontFamily: { sans: ['Poppins', 'sans-serif'] },
      colors: {
        brand: {
          cyan: '#1FB5D4', navy: '#091E35', blue: '#19579B', active: '#1084C9', ink: '#0B1B3A', violet: '#5B5FA8',
          deep: '#0F1B6B', tab: '#0A0A6E', price: '#E4002B', gold: '#C9A52A'
        }
      }
    }
  }
};
