@extends('layouts.app')

@section('title','Login')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm p-8 rounded-xl shadow-xl">
            <h2 class="text-2xl font-extrabold mb-4">Masuk ke Sistem Permintaan</h2>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                @if($errors->any())
                    <div class="mb-3 p-2 bg-red-100 text-red-700 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama pengguna atau Email</label>
                    <input name="username" value="{{ old('username') }}" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="admin atau admin@example.com" />
                    @error('username')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Kata sandi</label>
                    <input type="password" name="password" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('password')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="flex items-center justify-between gap-2">
                    <button class="px-5 py-3 bg-indigo-600 text-white rounded-lg shadow hover:brightness-105 transition">Masuk</button>
                    <a href="{{ route('register') }}" class="text-sm text-indigo-700">Belum punya akun?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
