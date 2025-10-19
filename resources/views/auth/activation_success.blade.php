@extends('layouts.app')

@section('title','Aktivasi Berhasil')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Akun Diaktifkan</h2>
    <p>Halo {{ $user->name }}, akun Anda telah diaktifkan. Silakan <a href="{{ route('login') }}" class="text-indigo-600">masuk</a> sekarang.</p>
</div>
@endsection
