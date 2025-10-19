@extends('layouts.app')

@section('title','Lihat User')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Detail User</h2>

    <div class="mb-3"><strong>Nama:</strong> {{ $user->name }}</div>
    <div class="mb-3"><strong>Email:</strong> {{ $user->email }}</div>
    <div class="mb-3"><strong>Role:</strong> {{ $user->role }}</div>
    <div class="mb-3"><strong>Approved:</strong> {{ $user->approved ? 'Ya' : 'Belum' }}</div>

    <div class="flex gap-2 mt-4">
        @if(!$user->approved)
            <form method="POST" action="{{ route('admin.users.sendActivation', $user) }}">
                @csrf
                <button class="px-3 py-1 bg-indigo-600 text-white rounded">Kirim Email Aktivasi</button>
            </form>
        @endif
        <a href="{{ route('admin.users.index') }}" class="px-3 py-1 bg-gray-200 rounded">Kembali</a>
    </div>
</div>
@endsection
