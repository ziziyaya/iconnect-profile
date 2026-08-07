@extends('layouts.dash')

@section('title', 'Edit Paket')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.pakets.update', $paket->id) }}">
      @csrf
      @method('PUT')
      @include('admin.pakets._form')
      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
