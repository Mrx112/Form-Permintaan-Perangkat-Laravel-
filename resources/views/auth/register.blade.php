@extends('layouts.app')

@section('title','Register')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Register</h2>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-sm">Nama</label>
                <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" />
                @error('name')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="block text-sm">Email</label>
                <input name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" />
                @error('email')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="block text-sm">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" />
            </div>
            <div class="mb-3">
                <label class="block text-sm">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" />
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Daftar</button>
                <a href="{{ route('login') }}" class="text-sm">Sudah punya akun?</a>
            </div>
        </form>
    </div>
@endsection
