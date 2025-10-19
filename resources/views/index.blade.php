@extends('layouts.app')

@section('title','Selamat Datang')

@section('content')
    <div class="bg-white rounded shadow p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-4xl font-bold">Selamat Datang di Sistem Permintaan</h1>
                <p class="text-gray-600 mt-2">Kelola permintaan dengan mudah. Silakan login untuk memulai.</p>
            </div>
            <div class="space-y-2">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-200 rounded">Daftar</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Go to Dashboard</a>
                @endguest
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded">
                <h3 class="font-semibold">Kelola</h3>
                <p class="text-sm">Buat, edit, dan lacak permintaan Anda.</p>
            </div>
            <div class="p-4 bg-white border rounded">
                <h3 class="font-semibold">Aman</h3>
                <p class="text-sm">Hak akses dibedakan antara admin dan user.</p>
            </div>
            <div class="p-4 bg-white border rounded">
                <h3 class="font-semibold">Modern</h3>
                <p class="text-sm">Tampilan responsif berbasis Tailwind CSS.</p>
            </div>
        </div>
    </div>
@endsection
