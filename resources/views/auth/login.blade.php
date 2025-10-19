@extends('layouts.app')

@section('title','Login')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Masuk</h2>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            @if($errors->any())
                <div class="mb-3 p-2 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-3">
                <label class="block text-sm">Nama pengguna atau Email</label>
                <input name="username" value="{{ old('username') }}" class="w-full border p-2 rounded" placeholder="admin atau admin@example.com" />
                @error('username')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="block text-sm">Kata sandi</label>
                <input type="password" name="password" class="w-full border p-2 rounded" />
                @error('password')<div class="text-red-600">{{ $message }}</div>@enderror
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Masuk</button>
                <a href="{{ route('register') }}" class="text-sm">Belum punya akun?</a>
            </div>
        </form>
    </div>
@endsection
