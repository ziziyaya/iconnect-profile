@extends('layouts.dash')

@section('title', 'Edit Keunggulan')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.keunggulans.update', $keunggulan->id) }}">
      @csrf
      @method('PUT')
      @include('admin.keunggulans._form')
      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
