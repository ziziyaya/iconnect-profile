<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - ICONNET</title>

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
  <div id="notice" class="pointer-events-none fixed left-1/2 top-4 z-50 -translate-x-1/2 -translate-y-4 opacity-0 transition duration-300" role="status">
    <div class="rounded-xl bg-white px-4 py-2.5 text-xs font-medium shadow-[0_6px_20px_rgba(0,0,0,0.3)] sm:text-sm" id="noticeText"></div>
  </div>
  <main class="flex h-[100dvh] items-center justify-center overflow-y-auto px-4 py-4">
    <div class="w-full max-w-[340px] rounded-2xl bg-white px-5 py-5 shadow-[0_10px_40px_rgba(0,0,0,0.45)] sm:max-w-[440px] sm:px-6 sm:py-6 lg:max-w-[480px] lg:px-7 lg:py-7">
      <h1 class="text-center text-lg font-bold sm:text-xl lg:text-2xl">Login</h1>
      <p class="mt-0.5 text-center text-[11px] text-slate-600 sm:text-sm lg:text-[15px]">Silakan masuk ke akun Anda.</p>
      <form novalidate class="mt-3 space-y-2.5 sm:mt-4 sm:space-y-3 lg:space-y-3.5">
        <div><label for="email" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Email</label>
          <input id="email" type="email" autocomplete="email" placeholder="Masukan email" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
        <div>
          <div class="mb-1 flex items-center justify-between">
            <label for="password" class="text-[11px] font-medium sm:text-xs lg:text-sm">Password</label>
            <a href="{{ url('forgot-password') }}" class="text-[10px] sm:text-xs lg:text-[13px]">Forgot password?</a>
          </div>
          <div class="relative">
            <input id="password" type="password" autocomplete="current-password" placeholder="Masukan kata sandi" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm pr-10" />
            <button type="button" data-toggle="password" aria-label="Tampilkan password" class="absolute inset-y-0 right-3 flex items-center text-black"><svg class="eye-on h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/></svg><svg class="eye-off hidden h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/><path d="M3 3l18 18"/></svg></button>
          </div></div>
        <button type="submit" class="!mt-4 h-9 w-full rounded-full bg-brand-btn text-[11px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.25)] transition hover:brightness-110 sm:h-10 sm:text-xs lg:h-11 lg:text-sm">Login</button>
      </form>
      <div class="my-3 flex items-center gap-3 text-[10px] sm:my-4 sm:text-xs">
        <span class="h-px flex-1 bg-slate-500"></span>OR<span class="h-px flex-1 bg-slate-500"></span>
      </div>
      <div class="space-y-2.5 sm:space-y-3">
        <a href="#" id="btnGoogle" class="flex h-9 w-full items-center justify-center gap-2 rounded-full border border-slate-300 bg-white text-[11px] transition hover:bg-slate-50 sm:h-10 sm:text-xs lg:h-11 lg:text-sm"><svg class="h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.500c3.540 0 6.710 1.220 9.210 3.600l6.850-6.850C35.900 2.380 30.470 0 24 0 14.620 0 6.510 5.380 2.560 13.220l7.980 6.190C12.430 13.720 17.740 9.500 24 9.500z"/><path fill="#4285F4" d="M46.980 24.550c0-1.570-.15-3.090-.38-4.550H24v9.020h12.940c-.58 2.960-2.260 5.480-4.780 7.180l7.730 6c4.510-4.180 7.090-10.360 7.090-17.650z"/><path fill="#FBBC05" d="M10.530 28.590c-.48-1.450-.76-2.990-.76-4.590s.27-3.140.76-4.590l-7.980-6.190C.92 16.460 0 20.120 0 24c0 3.880.92 7.540 2.560 10.780l7.970-6.190z"/><path fill="#34A853" d="M24 48c6.480 0 11.930-2.130 15.890-5.810l-7.730-6c-2.150 1.450-4.920 2.300-8.160 2.300-6.260 0-11.570-4.220-13.470-9.910l-7.980 6.190C6.510 42.620 14.620 48 24 48z"/></svg>Continue with Google</a>
        <a href="#" id="btnApple" class="flex h-9 w-full items-center justify-center gap-2 rounded-full border border-slate-300 bg-white text-[11px] transition hover:bg-slate-50 sm:h-10 sm:text-xs lg:h-11 lg:text-sm"><svg class="h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 384 512" fill="currentColor"><path d="M318.700 268.700c-.2-36.700 16.400-64.400 50-84.800-18.800-26.900-47.200-41.700-84.700-44.600-35.500-2.800-74.300 20.700-88.500 20.700-15 0-49.400-19.700-76.400-19.700C63.300 141.200 4 184.800 4 273.500q0 39.300 14.400 81.200c12.800 36.700 59 126.700 107.200 125.200 25.200-.6 43-17.900 75.800-17.900 31.800 0 48.300 17.900 76.400 17.900 48.600-.7 90.400-82.500 102.600-119.300-65.200-30.700-61.700-90-61.700-91.900zm-56.600-164.200c27.300-32.400 24.800-61.900 24-72.500-24.100 1.400-52 16.400-67.900 34.900-17.500 19.800-27.800 44.300-25.600 71.900 26.100 2 49.900-11.400 69.500-34.300z"/></svg>Continue with Apple</a>
      </div>
      <p class="mt-3 text-center text-[11px] sm:text-xs lg:text-sm">Belum memiliki akun? <a href="{{ url('signup') }}" class="text-[#1A73C8] underline">Sign Up</a></p>
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
      telepon: { msg: 'Nomor tidak valid. Gunakan angka, diawali 08 atau 628 (10–13 digit).', test: v => /^08\d{8,11}$/.test(v) || /^628\d{8,11}$/.test(v) },
      gender:  { msg: 'Pilih jenis kelamin.',                                         test: v => v !== '' },
      sekolah: { msg: 'Nama sekolah / institusi minimal 3 karakter.',                 test: v => v.trim().length >= 3 }
    };
    // Filter karakter saat mengetik / paste
    const FILTERS = {
      nama:    v => v.replace(/[^\p{L}\s.'-]/gu, '').replace(/\s{2,}/g, ' ').slice(0, 60),
      telepon: v => v.replace(/\D/g, '').slice(0, 14),          // hanya angka, tidak bisa huruf
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

    RULES.password = { msg: 'Password wajib diisi.', test: v => v.length > 0 };
    ['email', 'password'].forEach(id => bind(id, RULES[id]));

    document.querySelector('form').addEventListener('submit', e => {
      e.preventDefault();
      const ids = ['email', 'password'];
      const results = ids.map(id => check(document.getElementById(id), RULES[id]));
      const firstBad = ids.find((id, i) => !results[i]);
      if (firstBad) { document.getElementById(firstBad).focus(); return; }
      // Login ke server Laravel (password dicek & di-hash di server, sesi disimpan di cookie).
      const email = document.getElementById('email').value.trim().toLowerCase();
      const pass = document.getElementById('password').value;
      const btn = e.submitter || document.querySelector('form [type="submit"]');
      if (btn) btn.disabled = true;
      ICONNET_API.request('POST', 'api/v1/auth/login', { email, password: pass })
        .then(res => {
          sessionStorage.setItem('iconnet_toast', 'Login Berhasil');   // ditampilkan di Beranda
          location.href = homeFor(res.session && res.session.role);
        })
        .catch(err => {
          if (btn) btn.disabled = false;
          if (err.data && err.data.notice) return showNotice(err.data.notice, 6000);   // belum disetujui admin / ditolak
          setError(document.getElementById(err.field === 'email' ? 'email' : 'password'), err.message);
        });
    });

    // Halaman tujuan setelah login, sesuai role akun.
    // Admin -> beranda-admin.html, Superadmin -> beranda-superadmin.html, lainnya -> beranda.html
    function homeFor(role) {
      if (role === 'admin') return '{{ url('beranda-admin') }}';
      if (role === 'superadmin') return '{{ url('beranda-superadmin') }}';   // ganti jika nama file berbeda
      return '{{ url('beranda') }}';
    }

    // ===== Notifikasi (toast kecil) =====
    let noticeTimer;
    function showNotice(msg, ms = 3500) {
      const el = document.getElementById('notice');
      document.getElementById('noticeText').textContent = msg;
      el.classList.remove('opacity-0', '-translate-y-4');
      clearTimeout(noticeTimer);
      noticeTimer = setTimeout(() => el.classList.add('opacity-0', '-translate-y-4'), ms);
    }
    (function () {   // notifikasi dari halaman lain (daftar akun / reset password)
      const msg = sessionStorage.getItem('iconnet_notice');
      if (!msg) return;
      sessionStorage.removeItem('iconnet_notice');
      requestAnimationFrame(() => showNotice(msg));
    })();

    // ===== Login dengan Google & Apple =====
    // Wajib diisi dulu (lihat panduan di bawah). Kalau kosong, tombol menampilkan pemberitahuan.
    const GOOGLE_CLIENT_ID = '';    // OAuth Client ID (Web) dari Google Cloud Console
    const APPLE_CLIENT_ID = '';     // "Services ID" dari Apple Developer
    const APPLE_REDIRECT_URI = '';  // URL https yang terdaftar di Services ID Apple

    function loadScript(src) {
      return new Promise((resolve, reject) => {
        if (document.querySelector('script[src="' + src + '"]')) return resolve();
        const s = document.createElement('script');
        s.src = src; s.onload = resolve; s.onerror = () => reject(new Error('gagal memuat ' + src));
        document.head.appendChild(s);
      });
    }
    // Login Google / Apple: token WAJIB diverifikasi di server (mis. Laravel Socialite) sebelum dipakai.
    // Selama verifikasi server belum dipasang, akun tidak dimasukkan dari data browser.
    function socialLogin({ email, provider }) {
      email = String(email || '').trim().toLowerCase();
      if (!email) { showNotice('Email tidak diterima dari ' + provider + '.'); return; }
      showNotice('Login dengan ' + provider + ' belum diaktifkan di server. Silakan login dengan email dan password.', 6000);
    }

    async function loginGoogle() {
      if (!GOOGLE_CLIENT_ID) return showNotice('Login Google belum dikonfigurasi (isi GOOGLE_CLIENT_ID).', 5000);
      if (location.protocol === 'file:') return showNotice('Login Google tidak bisa lewat file://. Buka lewat http://localhost atau https.', 5000);
      try {
        await loadScript('https://accounts.google.com/gsi/client');
        const client = google.accounts.oauth2.initTokenClient({
          client_id: GOOGLE_CLIENT_ID,
          scope: 'openid email profile',
          callback: async (resp) => {
            if (resp.error) return showNotice('Login Google dibatalkan.');
            try {
              const r = await fetch('https://www.googleapis.com/oauth2/v3/userinfo', { headers: { Authorization: 'Bearer ' + resp.access_token } });
              const p = await r.json();
              socialLogin({ email: p.email, nama: p.name, provider: 'Google' });
            } catch (e) { showNotice('Gagal mengambil data akun Google.'); }
          },
          error_callback: () => showNotice('Login Google dibatalkan.')
        });
        client.requestAccessToken();
      } catch (e) { showNotice('Gagal memuat Login Google. Periksa koneksi internet.'); }
    }

    async function loginApple() {
      if (!APPLE_CLIENT_ID || !APPLE_REDIRECT_URI) return showNotice('Login Apple belum dikonfigurasi (isi APPLE_CLIENT_ID & APPLE_REDIRECT_URI).', 5000);
      if (location.protocol !== 'https:') return showNotice('Login Apple hanya berjalan di https (domain terverifikasi).', 5000);
      try {
        await loadScript('https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/id/appleid.auth.js');
        AppleID.auth.init({ clientId: APPLE_CLIENT_ID, scope: 'name email', redirectURI: APPLE_REDIRECT_URI, usePopup: true });
        const res = await AppleID.auth.signIn();
        const payload = JSON.parse(atob(res.authorization.id_token.split('.')[1].replace(/-/g, '+').replace(/_/g, '/')));
        const nm = res.user && res.user.name ? [res.user.name.firstName, res.user.name.lastName].filter(Boolean).join(' ') : '';
        socialLogin({ email: payload.email, nama: nm, provider: 'Apple' });
      } catch (e) {
        showNotice(e && e.error === 'popup_closed_by_user' ? 'Login Apple dibatalkan.' : 'Login Apple gagal. Coba lagi.');
      }
    }
    // Status verifikasi akun (menunggu / ditolak) ditampilkan oleh server saat login.

    document.getElementById('btnGoogle').addEventListener('click', e => { e.preventDefault(); loginGoogle(); });
    document.getElementById('btnApple').addEventListener('click', e => { e.preventDefault(); loginApple(); });
  </script>
</body>
</html>
