@extends('layouts.app')

@section('title','Preview Export')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Preview Permintaan untuk Ekspor</h2>

    <form method="POST" action="{{ route('admin.permintaan.export') }}">
        @csrf
        <input type="hidden" name="format" value="csv" />
        <div class="mb-4">
            <label class="block text-sm font-medium">Pilih Format</label>
            <select name="format" class="mt-1 block w-48 border rounded p-2">
                <option value="csv">CSV</option>
                <option value="xlsx">Excel (.xlsx)</option>
            </select>
        </div>

        <div class="mb-4 bg-white p-3 rounded shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left"><th class="p-2">ID</th><th class="p-2">Judul</th><th class="p-2">User</th><th class="p-2">Status</th></tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item->id }}</td>
                            <td class="p-2">{{ $item->judul }}</td>
                            <td class="p-2">{{ optional($item->user)->name }}</td>
                            <td class="p-2">{{ $item->status }}</td>
                        </tr>
                        <input type="hidden" name="ids[]" value="{{ $item->id }}" />
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Download</button>
            <a href="{{ route('permintaan.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
