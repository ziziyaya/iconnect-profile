{{-- Disisipkan di awal <head> setiap halaman frontend ICONNET.
     window.ICONNET_SERVER = data asli dari database untuk halaman ini (App\Support\IconnetData),
     menggantikan data contoh / localStorage pada versi frontend statis. --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <script>
    window.ICONNET_SERVER = {!! json_encode(array_merge($iconnet ?? [], ['base' => url('/')]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
  </script>
  <script src="{{ asset('js/iconnet-api.js') }}?v={{ @filemtime(public_path('js/iconnet-api.js')) }}"></script>
