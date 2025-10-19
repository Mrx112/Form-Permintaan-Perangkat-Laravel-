@extends('layouts.app')

@section('title', $permintaan->judul)

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-2">{{ $permintaan->judul }}</h2>
        <div class="text-sm text-gray-500 mb-4">Status: <strong>{{ $permintaan->status }}</strong></div>
        <div class="prose">
            {!! nl2br(e($permintaan->deskripsi)) !!}
        </div>
        <div class="mt-6">
            <a href="{{ route('permintaan.edit', $permintaan) }}" class="px-3 py-2 bg-yellow-400 rounded">Edit</a>
            <a href="{{ route('permintaan.index') }}" class="px-3 py-2 bg-gray-200 rounded">Kembali</a>
        </div>
    </div>
@endsection
