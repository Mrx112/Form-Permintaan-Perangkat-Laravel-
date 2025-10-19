@extends('layouts.app')

@section('title','Dashboard')

@section('content')
    <div class="space-y-6">
        <header class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold">Dashboard</h1>
                <p class="text-sm text-gray-500">Ringkasan singkat aktivitas sistem</p>
            </div>
            <div>
                @auth
                    <a href="{{ route('permintaan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow">Buat Permintaan</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow">Login / Daftar</a>
                @endauth
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-6 bg-gradient-to-r from-indigo-600 to-pink-500 text-white rounded-lg shadow">
                        <div class="text-sm">Total Permintaan</div>
                        <div class="text-4xl font-bold">{{ $total }}</div>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow">
                        <div class="text-sm text-gray-500">Aksi cepat</div>
                        <div class="mt-3 flex gap-3">
                            <a href="{{ route('permintaan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Buat Permintaan</a>
                            <a href="{{ route('permintaan.index') }}" class="px-4 py-2 bg-gray-100 rounded">Lihat Semua</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-3">Permintaan Terbaru</h3>
                    @if($latest->isEmpty())
                        <div class="text-gray-500">Tidak ada permintaan.</div>
                    @else
                        <ul class="space-y-3">
                            @foreach($latest as $item)
                                <li class="p-3 border rounded flex justify-between items-center hover:shadow-sm transition">
                                    <div>
                                        <a href="{{ route('permintaan.show', $item) }}" class="font-medium text-indigo-700">{{ $item->judul }}</a>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi, 80) }}</div>
                                    </div>
                                    <div class="text-sm text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <aside class="space-y-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <h4 class="font-semibold mb-2">Profil</h4>
                    @guest
                        <a href="{{ route('login') }}" class="block px-3 py-2 bg-indigo-600 text-white rounded">Login</a>
                        <a href="{{ route('register') }}" class="block mt-2 px-3 py-2 bg-gray-100 rounded">Daftar</a>
                    @else
                        <div class="text-sm">Masuk sebagai <strong>{{ auth()->user()->name }}</strong></div>
                        <div class="mt-2"><a href="{{ route('permintaan.index') }}" class="text-indigo-600">Kelola Permintaan saya</a></div>
                    @endguest
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h4 class="font-semibold mb-2">Bantuan</h4>
                    <p class="text-sm text-gray-500">Butuh bantuan? Hubungi admin atau cek dokumentasi.</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
