@extends('layouts.app')

@section('title','Riwayat Permintaan')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold mb-4">Riwayat Permintaan</h2>

    <div class="space-y-4">
        @foreach($items as $item)
            <div class="p-4 border rounded flex justify-between items-center bg-gray-50">
                <div>
                    <a href="{{ route('permintaan.show', $item) }}" class="text-lg font-medium">{{ $item->judul }}</a>
                    <div class="text-sm text-gray-500">Kategori: {{ $item->category ?? '-' }} · Kuantitas: {{ $item->meta['quantity'] ?? 1 }}</div>
                </div>
                <div class="text-sm text-gray-500">{{ $item->created_at->format('Y-m-d') }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
</div>
@endsection
