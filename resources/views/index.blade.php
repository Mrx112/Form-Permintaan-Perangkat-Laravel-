@extends('layouts.app')

@section('title','Selamat Datang')

@section('content')
    <div class="relative overflow-hidden rounded-lg">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-pink-500 to-yellow-400 opacity-80 animate-[gradient_8s_linear_infinite]" style="filter: blur(40px); transform: scale(1.2);"></div>
        <div class="relative z-10 py-24">
            <div class="max-w-5xl mx-auto px-4 text-center text-white">
                <h1 class="text-5xl md:text-6xl font-extrabold drop-shadow-lg">Sistem Permintaan</h1>
                <p class="mt-4 text-lg md:text-2xl text-white/90">Kelola permintaan perangkat dan layanan dengan cepat dan mudah.</p>

                <div class="mt-8 flex items-center justify-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow hover:scale-105 transform transition">Daftar</a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-800/30 border border-white/30 text-white rounded-lg shadow hover:scale-105 transform transition">Masuk</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow hover:scale-105 transform transition">Ke Dashboard</a>
                    @endguest
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white/10 rounded-lg backdrop-blur-sm border border-white/10">
                        <h3 class="text-xl font-semibold">Autosave & Lampiran</h3>
                        <p class="mt-2 text-sm text-white/80">Simpan draf secara otomatis dan unggah lampiran untuk permintaan Anda.</p>
                    </div>
                    <div class="p-6 bg-white/10 rounded-lg backdrop-blur-sm border border-white/10">
                        <h3 class="text-xl font-semibold">Approval Admin</h3>
                        <p class="mt-2 text-sm text-white/80">Alur persetujuan akun dan permintaan oleh admin.</p>
                    </div>
                    <div class="p-6 bg-white/10 rounded-lg backdrop-blur-sm border border-white/10">
                        <h3 class="text-xl font-semibold">Laporan & Ekspor</h3>
                        <p class="mt-2 text-sm text-white/80">Filter berdasarkan tanggal dan ekspor CSV untuk analisis.</p>
                    </div>
                </div>
            </div>
        </div>
        <svg class="absolute left-0 bottom-0 w-full h-40 text-white/10" preserveAspectRatio="none" viewBox="0 0 1440 320"><path fill="currentColor" d="M0,160L48,165.3C96,171,192,181,288,181.3C384,181,480,171,576,149.3C672,128,768,96,864,96C960,96,1056,128,1152,133.3C1248,139,1344,117,1392,106.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>

    <style>
    @keyframes gradient { 0%{ background-position:0% 50% } 50%{ background-position:100% 50% } 100%{ background-position:0% 50% } }
    .animate-\[gradient_8s_linear_infinite\]{ background-size: 400% 400%; animation: gradient 8s linear infinite; }
    </style>

    <div class="mt-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded shadow">
                    <h4 class="font-semibold">Cepat & Intuitif</h4>
                    <p class="text-sm text-gray-600 mt-2">Antarmuka didesain agar Anda bisa menyelesaikan tugas dengan sedikit klik.</p>
                </div>
                <div class="p-6 bg-white rounded shadow">
                    <h4 class="font-semibold">Terintegrasi</h4>
                    <p class="text-sm text-gray-600 mt-2">Fitur upload, notifikasi email, dan laporan yang mudah dipakai.</p>
                </div>
                <div class="p-6 bg-white rounded shadow">
                    <h4 class="font-semibold">Dapat dikembangkan</h4>
                    <p class="text-sm text-gray-600 mt-2">Struktur Laravel memudahkan penambahan fitur dan integrasi eksternal.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
