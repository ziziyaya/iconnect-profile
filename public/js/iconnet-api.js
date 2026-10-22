/* =========================================================================
   iconnet-api.js  -  penghubung halaman frontend ICONNET dengan backend Laravel
   -------------------------------------------------------------------------
   Versi statis frontend menyimpan data di localStorage. Di versi Laravel:
   - DATA BACA : dikirim server saat halaman dibuka (window.ICONNET_SERVER),
                 dibaca dengan ICONNET_API.read('<key lama>', fallback).
                 Key & bentuk datanya sama persis dengan kontrak localStorage lama
                 (iconnet_session, iconnet_attendance, iconnet_leave, iconnet_users, ...).
   - DATA TULIS: dikirim ke API Laravel (ICONNET_API.request / upload), lalu
                 data di memori diperbarui dengan ICONNET_API.write().
   localStorage hanya dipakai untuk preferensi tampilan (iconnet_sidebar) &
   sessionStorage untuk notifikasi sekali tampil (iconnet_toast / iconnet_notice).
   ========================================================================= */
(function (global) {
  'use strict';

  var S = global.ICONNET_SERVER || {};
  var DATA = {};
  var BASE = String(S.base || '').replace(/\/+$/, '');

  function clone(v) { return v === undefined ? undefined : JSON.parse(JSON.stringify(v)); }

  DATA.iconnet_session = S.session || null;
  var src = S.data || {};
  Object.keys(src).forEach(function (k) { DATA[k] = src[k]; });

  // Bersihkan data contoh versi statis yang mungkin masih tersimpan di browser
  // (termasuk password polos akun demo). Preferensi tampilan tidak dihapus.
  (function cleanLegacy() {
    try {
      var keep = { iconnet_sidebar: 1 };
      var del = [];
      for (var i = 0; i < localStorage.length; i++) {
        var k = localStorage.key(i);
        if (k && k.indexOf('iconnet_') === 0 && !keep[k]) del.push(k);
      }
      del.forEach(function (k) { localStorage.removeItem(k); });
    } catch (e) {}
  })();

  function url(path) {
    path = String(path || '');
    if (/^https?:\/\//i.test(path)) return path;
    return BASE + '/' + path.replace(/^\/+/, '');
  }
  function csrf() {
    var m = document.querySelector('meta[name="csrf-token"]');
    return m ? m.getAttribute('content') : '';
  }

  /** Error dari server: { status, message, field, data } */
  function ApiError(status, body) {
    body = body || {};
    var msg = body.message || body.notice || '';
    if (!msg && body.errors) {
      var first = Object.keys(body.errors)[0];
      if (first) msg = body.errors[first][0];
    }
    if (body.errors && !body.field) body.field = Object.keys(body.errors)[0];
    this.status = status;
    this.message = msg || (status === 0 ? 'Tidak dapat terhubung ke server. Periksa koneksi internet.' : 'Terjadi kesalahan pada server. Coba lagi.');
    this.field = body.field || '';
    this.data = body;
  }

  /**
   * Kirim request JSON / FormData ke Laravel. Mengembalikan Promise berisi JSON balasan.
   * Sesi habis (401) atau token CSRF kedaluwarsa (419) -> diarahkan ke halaman login.
   */
  function request(method, path, body) {
    var isForm = typeof FormData !== 'undefined' && body instanceof FormData;
    var headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf() };
    if (body !== undefined && !isForm) headers['Content-Type'] = 'application/json';
    return fetch(url(path), {
      method: method,
      headers: headers,
      credentials: 'same-origin',
      body: body === undefined ? undefined : (isForm ? body : JSON.stringify(body))
    }).then(function (res) {
      return res.text().then(function (t) {
        var json = {};
        try { json = t ? JSON.parse(t) : {}; } catch (e) { json = {}; }
        if (res.ok) return json;
        if ((res.status === 401 || res.status === 419) && S.session) {
          alert(res.status === 419 ? 'Sesi halaman sudah kedaluwarsa. Silakan login kembali.' : 'Sesi login berakhir. Silakan login kembali.');
          location.href = url('login');
        }
        throw new ApiError(res.status, json);
      });
    }, function () { throw new ApiError(0, {}); });
  }

  function logout() {
    var go = function () { location.href = url('login'); };
    request('POST', 'api/v1/auth/logout').then(go, go);
  }

  /** Data terbaru dari server untuk halaman superadmin (pembaruan berkala). */
  function reload(halaman) {
    return request('GET', 'api/v1/kelola/data/' + encodeURIComponent(halaman)).then(function (st) {
      DATA.iconnet_session = st.session || DATA.iconnet_session;
      var d = st.data || {};
      Object.keys(d).forEach(function (k) { DATA[k] = d[k]; });
      return st;
    });
  }

  global.ICONNET_API = {
    /** Pengganti JSON.parse(localStorage.getItem(key)) ?? fallback */
    read: function (key, fallback) {
      return Object.prototype.hasOwnProperty.call(DATA, key) && DATA[key] !== null && DATA[key] !== undefined ? clone(DATA[key]) : fallback;
    },
    /** Perbarui data di memori (setelah server menyimpan perubahan). */
    write: function (key, value) { DATA[key] = clone(value); },
    has: function (key) { return Object.prototype.hasOwnProperty.call(DATA, key); },
    session: function () { return clone(DATA.iconnet_session); },
    jamMasuk: S.jamMasuk || '08:00:00',
    reset: S.reset || null,
    url: url,
    request: request,
    reload: reload,
    logout: logout,
    ApiError: ApiError
  };
})(window);
