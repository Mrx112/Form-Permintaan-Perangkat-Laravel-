@extends('layouts.app')

@section('title','Daftar Permintaan')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold">Daftar Permintaan</h2>
            <form method="GET" class="flex gap-2">
                <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}" class="border-gray-200 p-2 rounded-lg" />
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Cari</button>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach($items as $item)
                <div class="p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <input type="checkbox" class="select-item mt-1" value="{{ $item->id }}" />
                            @endif
                            <div>
                                <a href="{{ route('permintaan.show', $item) }}" class="text-lg font-medium text-indigo-700">{{ $item->judul }}</a>
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($item->deskripsi, 120) }}</div>
                                <div class="text-xs text-gray-400 mt-2">Dibuat {{ $item->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('permintaan.edit', $item) }}" class="px-3 py-2 bg-yellow-400 rounded">Edit</a>
                            <form action="{{ route('permintaan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus permintaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-red-500 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="mt-4 flex gap-2">
                <button id="preview-selected" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Preview & Export Selected</button>
            </div>
        @endif

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
