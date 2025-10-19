@extends('layouts.app')

@section('title','Daftar Permintaan')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Daftar Permintaan</h2>

        <div class="mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}" class="border p-2 rounded flex-1" />
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Cari</button>
            </form>
        </div>

        <div class="space-y-4">
            @foreach($items as $item)
                <div class="p-4 border rounded flex justify-between items-center bg-gray-50">
                    <div class="flex items-start gap-3">
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <input type="checkbox" class="select-item mt-1" value="{{ $item->id }}" />
                        @endif
                        <div>
                            <a href="{{ route('permintaan.show', $item) }}" class="text-lg font-medium">{{ $item->judul }}</a>
                            <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi, 120) }}</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('permintaan.edit', $item) }}" class="px-3 py-1 bg-yellow-400 rounded">Edit</a>
                        <form action="{{ route('permintaan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus permintaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="mt-4 flex gap-2">
                <button id="preview-selected" class="px-4 py-2 bg-indigo-600 text-white rounded">Preview & Export Selected</button>
            </div>
        @endif

        <div class="mt-6">{{ $items->links() }}</div>

        <div class="mt-6">{{ $items->links() }}</div>
    </div>
    @if(auth()->check() && auth()->user()->role === 'admin')
        <script>
            document.getElementById('preview-selected').addEventListener('click', function(){
                const ids = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
                if (!ids.length) {
                    alert('Pilih minimal satu permintaan');
                    return;
                }
                const url = new URL("{{ route('admin.permintaan.preview') }}", window.location.origin);
                url.searchParams.set('ids', ids.join(','));
                window.location = url.toString();
            });
        </script>
    @endif
@endsection
