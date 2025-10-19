@extends('layouts.app')

@section('title','Register')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm p-8 rounded-xl shadow-xl">
            <h2 class="text-2xl font-extrabold mb-4">Buat Akun Baru</h2>
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input name="name" value="{{ old('name') }}" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input name="email" value="{{ old('email') }}" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border-gray-200 p-3 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="flex items-center justify-between gap-2">
                    <button class="px-5 py-3 bg-indigo-600 text-white rounded-lg shadow hover:brightness-105 transition">Daftar</button>
                    <a href="{{ route('login') }}" class="text-sm text-indigo-700">Sudah punya akun?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
