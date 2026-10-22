<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    /* ===== BACKGROUND: gambar ada di images/bg-auth.jpg ===== */
    body {
      background: #000 url('{{ asset('images/bg-auth.jpg') }}') center / cover no-repeat fixed;
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/auth.config.js -->
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
</head>
<body class="font-sans text-black antialiased">
  <main class="flex h-[100dvh] items-center justify-center overflow-y-auto px-4 py-4">
    <div class="w-full max-w-[340px] rounded-2xl bg-white px-5 py-5 shadow-[0_10px_40px_rgba(0,0,0,0.45)] sm:max-w-[440px] sm:px-6 sm:py-6 lg:max-w-[480px] lg:px-7 lg:py-7">
      <h1 class="text-center text-lg font-bold sm:text-xl lg:text-2xl">Sign Up</h1>
      <p class="mt-0.5 text-center text-[11px] text-slate-600 sm:text-sm lg:text-[15px]">Lengkapi informasi untuk membuat akun.</p>
      <form novalidate class="mt-3 space-y-2.5 sm:mt-4 sm:space-y-3 lg:space-y-3.5">
        <div><label for="nama" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Nama</label>
          <input id="nama" type="text" autocomplete="name" placeholder="Masukan nama lengkap" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
        <div><label for="email" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Email</label>
          <input id="email" type="email" autocomplete="email" placeholder="Masukan email" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
        <div><label for="password" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Password</label>
          <div class="relative">
            <input id="password" type="password" autocomplete="new-password" placeholder="Masukan kata sandi" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm pr-10" />
            <button type="button" data-toggle="password" aria-label="Tampilkan password" class="absolute inset-y-0 right-3 flex items-center text-black"><svg class="eye-on h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/></svg><svg class="eye-off hidden h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/><path d="M3 3l18 18"/></svg></button>
          </div></div>
        <div class="grid grid-cols-2 gap-2.5 sm:gap-4">
          <div><label for="gender" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Jenis Kelamin</label>
            <div class="relative">
              <select id="gender" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm appearance-none pr-8">
                <option value="" selected>Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
              <svg class="pointer-events-none absolute right-2.5 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-600 sm:h-3.5 sm:w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </div></div>
          <div><label for="telepon" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Telepon</label>
            <input id="telepon" type="tel" inputmode="numeric" autocomplete="tel" value="+62 " class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
        </div>
        <div><label for="sekolah" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Nama Sekolah / Institusi</label>
          <input id="sekolah" type="text" placeholder="Masukan nama sekolah / institusi" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
        <button type="submit" class="mt-1 h-9 w-full rounded-full bg-brand-btn text-[11px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.25)] transition hover:brightness-110 sm:h-10 sm:text-xs lg:h-11 lg:text-sm">Sign Up</button>
      </form>
      <p class="mt-3 text-center text-[11px] sm:text-xs lg:text-sm">Sudah memiliki akun? <a href="{{ url('login') }}" class="text-[#1A73C8] underline">Login</a></p>
    </div>
  </main>
  
  <script>
    // Tampilkan / sembunyikan password
    document.querySelectorAll('[data-toggle]').forEach(btn => btn.addEventListener('click', () => {
      const input = document.getElementById(btn.dataset.toggle);
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.querySelector('.eye-on').classList.toggle('hidden', show);
      btn.querySelector('.eye-off').classList.toggle('hidden', !show);
    }));

    // ===== Validasi form (frontend) =====
    // Catatan: validasi ini hanya untuk kenyamanan pengguna. Backend tetap WAJIB memvalidasi ulang.
    const RULES = {
      nama:    { msg: 'Nama minimal 3 huruf dan hanya boleh berisi huruf.',          test: v => v.trim().length >= 3 },
      email:   { msg: 'Format email tidak valid. Contoh: nama@email.com',            test: v => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim()) },
      telepon: { msg: 'Nomor tidak valid. Contoh: +62 813-5174-9606', test: v => /^\+62 8\d{2}-\d{4}-\d{3,4}$/.test(v) },
      gender:  { msg: 'Pilih jenis kelamin.',                                         test: v => v !== '' },
      sekolah: { msg: 'Nama sekolah / institusi minimal 3 karakter.',                 test: v => v.trim().length >= 3 }
    };
    // Filter karakter saat mengetik / paste
    const FILTERS = {
      nama:    v => v.replace(/[^\p{L}\s.'-]/gu, '').replace(/\s{2,}/g, ' ').slice(0, 60),
      telepon: v => {                                            // prefix +62 tetap, format 813-5174-9606
        let d = v.startsWith('+62') ? v.slice(3) : v;
        d = d.replace(/\D/g, '');
        if (!v.startsWith('+62') && d.startsWith('62')) d = d.slice(2);
        d = d.replace(/^0+/, '').slice(0, 11);
        const parts = [d.slice(0, 3), d.slice(3, 7), d.slice(7, 11)].filter(Boolean);
        return '+62 ' + parts.join('-');
      },
      sekolah: v => v.replace(/\s{2,}/g, ' ').slice(0, 80)
    };

    function fieldBox(input) { return input.closest('.relative') || input; }
    function setError(input, msg) {
      let p = document.getElementById(input.id + '-error');
      if (!msg) {
        if (p) p.remove();
        input.classList.remove('!border-red-500');
        input.removeAttribute('aria-invalid');
        return;
      }
      if (!p) {
        p = document.createElement('p');
        p.id = input.id + '-error';
        p.className = 'mt-1 text-[10px] leading-snug text-red-600 sm:text-xs';
        fieldBox(input).after(p);
      }
      p.textContent = msg;
      input.classList.add('!border-red-500');
      input.setAttribute('aria-invalid', 'true');
    }
    function check(input, rule) {
      const ok = rule.test(input.value);
      setError(input, ok ? '' : rule.msg);
      return ok;
    }
    function bind(id, rule, filter) {
      const input = document.getElementById(id);
      if (!input) return;
      input.addEventListener('input', () => {
        if (filter) { const f = filter(input.value); if (f !== input.value) input.value = f; }
        if (input.getAttribute('aria-invalid')) check(input, rule);   // hilangkan error begitu sudah benar
      });
      input.addEventListener(input.tagName === 'SELECT' ? 'change' : 'blur', () => check(input, rule));
    }

    RULES.password = { msg: 'Password minimal 8 karakter dan mengandung huruf serta angka.', test: v => v.length >= 8 && /[A-Za-z]/.test(v) && /\d/.test(v) };
    ['nama', 'email', 'password', 'telepon', 'gender', 'sekolah'].forEach(id => bind(id, RULES[id], FILTERS[id]));

    document.querySelector('form').addEventListener('submit', e => {
      e.preventDefault();
      const ids = ['nama', 'email', 'password', 'telepon', 'gender', 'sekolah'];
      const results = ids.map(id => check(document.getElementById(id), RULES[id]));
      const firstBad = ids.find((id, i) => !results[i]);
      if (firstBad) { document.getElementById(firstBad).focus(); return; }
      // Daftar ke server Laravel: akun baru otomatis berstatus 'menunggu' verifikasi admin
      // (password di-hash di server, email dicek unik di database).
      const email = document.getElementById('email').value.trim().toLowerCase();
      const btn = e.submitter || document.querySelector('form [type="submit"]');
      if (btn) btn.disabled = true;
      ICONNET_API.request('POST', 'api/v1/auth/register', {
        nama: document.getElementById('nama').value.trim(), email,
        password: document.getElementById('password').value,
        gender: document.getElementById('gender').value,
        telepon: document.getElementById('telepon').value,
        sekolah: document.getElementById('sekolah').value.trim()
      }).then(() => {
        sessionStorage.setItem('iconnet_notice', 'Akun berhasil dibuat. Menunggu verifikasi admin.');
        location.href = '{{ url('login') }}';
      }).catch(err => {
        if (btn) btn.disabled = false;
        const id = ['nama', 'email', 'password', 'telepon', 'gender', 'sekolah'].includes(err.field) ? err.field : 'email';
        setError(document.getElementById(id), err.message);
        document.getElementById(id).focus();
      });
    });
  </script>
</body>
</html>
