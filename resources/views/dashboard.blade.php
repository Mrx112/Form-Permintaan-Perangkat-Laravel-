@extends('layouts.app')

@section('title','Dashboard')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-sm text-gray-500">Ringkasan singkat aktivitas sistem</p>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('permintaan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Buat Permintaan</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Login / Daftar</a>
                @endauth
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="p-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded">
                        <div class="text-sm">Total Permintaan</div>
                        <div class="text-3xl font-bold">{{ $total }}</div>
                    </div>
                    <div class="p-4 bg-white border rounded">
                        <div class="text-sm text-gray-500">Aksi cepat</div>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('permintaan.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Buat Permintaan</a>
                            <a href="{{ route('permintaan.index') }}" class="px-3 py-2 bg-gray-200 rounded">Lihat Semua</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white border rounded p-4">
                    <h3 class="font-semibold mb-3">Permintaan Terbaru</h3>
                    @if($latest->isEmpty())
                        <div class="text-gray-500">Tidak ada permintaan.</div>
                    @else
                        <ul class="space-y-3">
                            @foreach($latest as $item)
                                <li class="p-3 border rounded flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('permintaan.show', $item) }}" class="font-medium">{{ $item->judul }}</a>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi, 80) }}</div>
                                    </div>
                                    <div class="text-sm text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <aside>
                <div class="bg-white border rounded p-4 mb-4">
                    <h4 class="font-semibold mb-2">Login cepat</h4>
                    @guest
                        <a href="{{ route('login') }}" class="block px-3 py-2 bg-indigo-600 text-white rounded">Login</a>
                        <a href="{{ route('register') }}" class="block mt-2 px-3 py-2 bg-gray-200 rounded">Daftar</a>
                    @else
                        <div class="text-sm">Masuk sebagai <strong>{{ auth()->user()->name }}</strong></div>
                        <div class="mt-2"><a href="{{ route('permintaan.index') }}" class="text-indigo-600">Kelola Permintaan saya</a></div>
                    @endguest
                </div>

                <div class="bg-white border rounded p-4">
                    <h4 class="font-semibold mb-2">Bantuan</h4>
                    <p class="text-sm text-gray-500">Butuh bantuan? Hubungi admin atau cek dokumentasi.</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
