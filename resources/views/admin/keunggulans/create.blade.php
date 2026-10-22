@extends('layouts.dash')

@section('title', 'Tambah Keunggulan')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.keunggulans.store') }}">
      @csrf
      @include('admin.keunggulans._form')
      <button type="submit" class="btn btn-primary btn-block">Simpan</button>
    </form>
  </div>
@endsection
