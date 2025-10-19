@extends('layouts.app')

@section('title','Laporan')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold mb-4">Laporan Permintaan</h2>

    <form method="GET" action="{{ route('admin.reports') }}" class="mb-6">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm">Format</label>
                <select name="format" class="mt-1 block w-full border rounded p-2">
                    <option value="csv">CSV</option>
                    <option value="xlsx">XLSX (simple)</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Tampilkan</button>
        </div>
    </form>

    @if(request()->hasAny(['from','to']))
        <div class="mb-4 text-sm text-gray-600">Menampilkan laporan dari <strong>{{ request('from') }}</strong> sampai <strong>{{ request('to') }}</strong></div>
    @endif

    @if(!empty($items) && $items->count())
        <form method="POST" action="{{ route('admin.permintaan.export') }}">
            @csrf
            <input type="hidden" name="format" value="{{ request('format', 'csv') }}" />
            <input type="hidden" name="from" value="{{ request('from') }}" />
            <input type="hidden" name="to" value="{{ request('to') }}" />
            <div class="overflow-x-auto mt-4">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-sm text-gray-600">
                            <th class="px-2 py-1">#</th>
                            <th class="px-2 py-1">Judul</th>
                            <th class="px-2 py-1">User</th>
                            <th class="px-2 py-1">Kategori</th>
                            <th class="px-2 py-1">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="px-2 py-1">{{ $item->id }}</td>
                                <td class="px-2 py-1">{{ $item->judul }}</td>
                                <td class="px-2 py-1">{{ optional($item->user)->name }}</td>
                                <td class="px-2 py-1">{{ $item->category }}</td>
                                <td class="px-2 py-1">{{ $item->created_at->format('Y-m-d') }}</td>
                            </tr>
                            <input type="hidden" name="ids[]" value="{{ $item->id }}" />
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Export hasil</button>
            </div>
        </form>
    @else
        <div class="mt-4 text-sm text-gray-500">Tidak ada data untuk rentang tanggal yang dipilih.</div>
    @endif
</div>
@endsection
