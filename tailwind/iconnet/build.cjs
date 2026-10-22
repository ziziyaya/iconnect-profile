/* =====================================================================
   Build CSS Tailwind untuk halaman frontend ICONNET (resources/views/iconnet).
     npm run build          -> Vite (halaman Breeze) + CSS ICONNET (minify) ke public/css/
     npm run build:iconnet  -> hanya CSS ICONNET
     npm run watch:iconnet  -> build ulang otomatis setiap file Blade ICONNET diubah
   Tiap grup halaman punya config sendiri karena tailwind.config lamanya berbeda
   (warna navy / breakpoint lg / palet brand). Lihat tailwind/iconnet/<grup>.config.cjs.
   ===================================================================== */
const { spawn } = require('child_process');
const path = require('path');

const GROUPS = ['dashboard', 'superadmin', 'panel', 'auth', 'site'];
const watch = process.argv.includes('--watch');
const root = path.resolve(__dirname, '..', '..');
const cli = require.resolve('tailwindcss/lib/cli.js');

// Data browser (caniuse) sudah dibundel di dalam Tailwind v3, peringatan "outdated" dimatikan.
const env = { ...process.env, BROWSERSLIST_IGNORE_OLD_DATA: '1' };

function run(group) {
  const args = [cli, '-c', `tailwind/iconnet/${group}.config.cjs`, '-i', 'tailwind/iconnet/input.css', '-o', `public/css/${group}.css`, watch ? '--watch' : '--minify'];
  return new Promise((resolve, reject) => {
    const p = spawn(process.execPath, args, { cwd: root, env, stdio: ['ignore', 'inherit', 'pipe'] });
    let err = '';
    p.stderr.on('data', d => { err += d; if (watch) process.stderr.write(`[${group}] ${d}`); });
    p.on('close', code => {
      if (code === 0) { if (!watch) console.log(`OK  public/css/${group}.css`); resolve(); }
      else { process.stderr.write(err); reject(new Error(`Build ${group} gagal (exit ${code})`)); }
    });
  });
}

(async () => {
  if (watch) { await Promise.all(GROUPS.map(run)); return; }
  for (const g of GROUPS) await run(g);
  console.log('Build CSS ICONNET selesai tanpa error.');
})().catch(e => { console.error(e.message); process.exit(1); });
