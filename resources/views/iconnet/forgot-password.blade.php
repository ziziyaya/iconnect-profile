<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lupa Password - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    /* ===== BACKGROUND: taruh gambarmu di images/bg-auth.jpg (atau ganti path di bawah) ===== */
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

      <!-- Langkah 1: email -->
      <section id="step1">
        <h1 class="text-center text-lg font-bold sm:text-xl lg:text-2xl">Lupa Password</h1>
        <p class="mt-0.5 text-center text-[11px] text-slate-600 sm:text-sm lg:text-[15px]">Masukkan email akunmu untuk mengatur ulang password.</p>
        <form id="formEmail" novalidate class="mt-3 space-y-2.5 sm:mt-4 sm:space-y-3 lg:space-y-3.5">
          <div><label for="email" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Email</label>
            <input id="email" type="email" autocomplete="email" placeholder="Masukan email" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm" /></div>
          <button type="submit" class="mt-1 h-9 w-full rounded-full bg-brand-btn text-[11px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.25)] transition hover:brightness-110 sm:h-10 sm:text-xs lg:h-11 lg:text-sm">Lanjutkan</button>
        </form>
      </section>

      <!-- Langkah 2: password baru -->
      <section id="step2" class="hidden">
        <h1 class="text-center text-lg font-bold sm:text-xl lg:text-2xl">Password Baru</h1>
        <p class="mt-0.5 break-all text-center text-[11px] text-slate-600 sm:text-sm lg:text-[15px]">Buat password baru untuk <span id="emailShow"></span></p>
        <form id="formReset" novalidate class="mt-3 space-y-2.5 sm:mt-4 sm:space-y-3 lg:space-y-3.5">
          <div><label for="password" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Password Baru</label>
            <div class="relative"><input id="password" type="password" autocomplete="new-password" placeholder="Masukan kata sandi baru" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm pr-10" /><button type="button" data-toggle="password" aria-label="Tampilkan password" class="absolute inset-y-0 right-3 flex items-center text-black"><svg class="eye-on h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/></svg><svg class="eye-off hidden h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/><path d="M3 3l18 18"/></svg></button></div></div>
          <div><label for="password2" class="mb-1 block text-[11px] font-medium sm:text-xs lg:text-sm">Konfirmasi Password</label>
            <div class="relative"><input id="password2" type="password" autocomplete="new-password" placeholder="Ulangi kata sandi baru" class="h-9 w-full rounded-md border border-slate-300 bg-white px-3 text-[11px] text-black outline-none placeholder:text-slate-400 focus:border-brand-btn sm:h-10 sm:text-xs lg:h-11 lg:text-sm pr-10" /><button type="button" data-toggle="password2" aria-label="Tampilkan password" class="absolute inset-y-0 right-3 flex items-center text-black"><svg class="eye-on h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/></svg><svg class="eye-off hidden h-4 w-4 sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7.500 11-7.500S23 12 23 12s-4 7.500-11 7.500S1 12 1 12z"/><circle cx="12" cy="12" r="3" fill="currentColor"/><path d="M3 3l18 18"/></svg></button></div></div>
          <button type="submit" class="mt-1 h-9 w-full rounded-full bg-brand-btn text-[11px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.25)] transition hover:brightness-110 sm:h-10 sm:text-xs lg:h-11 lg:text-sm">Simpan Password</button>
        </form>
      </section>

      <p class="mt-3 text-center text-[11px] sm:text-xs lg:text-sm">Ingat password? <a href="{{ url('login') }}" class="text-[#1A73C8] underline">Login</a></p>
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


    RULES.password  = { msg: 'Password minimal 8 karakter dan mengandung huruf serta angka.', test: v => v.length >= 8 && /[A-Za-z]/.test(v) && /\d/.test(v) };
    RULES.password2 = { msg: 'Konfirmasi password tidak sama.', test: v => v === document.getElementById('password').value };
    bind('email', RULES.email);
    bind('password', RULES.password);
    bind('password2', RULES.password2);

    // Lupa password memakai fitur reset password Laravel:
    //  langkah 1 -> server mengirim link reset ke email,
    //  langkah 2 -> link dari email membuka halaman ini dengan token, lalu password baru disimpan di server.
    const RESET = ICONNET_API.reset;   // { token, email } bila dibuka dari link email
    let targetEmail = RESET ? RESET.email : '';
    const busy = (form, on) => { const b = form.querySelector('[type="submit"]'); if (b) b.disabled = on; };

    if (RESET) {
      document.getElementById('emailShow').textContent = targetEmail;
      document.getElementById('step1').classList.add('hidden');
      document.getElementById('step2').classList.remove('hidden');
      document.getElementById('password').focus();
    }

    document.getElementById('formEmail').addEventListener('submit', e => {
      e.preventDefault();
      const input = document.getElementById('email');
      if (!check(input, RULES.email)) return input.focus();
      const email = input.value.trim().toLowerCase();
      busy(e.target, true);
      ICONNET_API.request('POST', 'api/v1/auth/forgot', { email })
        .then(res => {
          sessionStorage.setItem('iconnet_notice', res.message || 'Link reset password telah dikirim ke email Anda.');
          location.href = '{{ url('login') }}';
        })
        .catch(err => { busy(e.target, false); setError(input, err.message); input.focus(); });
    });

    document.getElementById('formReset').addEventListener('submit', e => {
      e.preventDefault();
      const p1 = document.getElementById('password'), p2 = document.getElementById('password2');
      const ok1 = check(p1, RULES.password), ok2 = check(p2, RULES.password2);
      if (!ok1) return p1.focus();
      if (!ok2) return p2.focus();
      if (!RESET) return;
      busy(e.target, true);
      ICONNET_API.request('POST', 'api/v1/auth/reset', { token: RESET.token, email: targetEmail, password: p1.value, password_confirmation: p2.value })
        .then(() => {
          sessionStorage.setItem('iconnet_notice', 'Password berhasil diubah. Silakan login.');
          location.href = '{{ url('login') }}';
        })
        .catch(err => { busy(e.target, false); setError(p1, err.message); p1.focus(); });
    });
  </script>
</body>
</html>
