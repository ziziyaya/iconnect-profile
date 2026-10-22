@extends('layouts.dash')

@section('title', 'Tambah Paket')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.pakets.store') }}">
      @csrf
      @include('admin.pakets._form')
      <button type="submit" class="btn btn-primary btn-block">Simpan Paket</button>
    </form>
  </div>
@endsection
