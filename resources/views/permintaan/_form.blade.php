@csrf

@if(isset($permintaan))
    <input type="hidden" name="_method" value="PUT" />
@endif

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Judul</label>
    <input name="judul" id="judul" value="{{ old('judul', $permintaan->judul ?? '') }}" class="mt-1 block w-full border-gray-200 rounded-lg p-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        @error('judul')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="6" class="mt-1 block w-full border-gray-200 rounded-lg p-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $permintaan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex items-center gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 border-gray-200 rounded-lg p-2 shadow-sm">
                @php $s = old('status', $permintaan->status ?? 'draft'); @endphp
                <option value="draft" {{ $s=='draft'?'selected':'' }}>Draft</option>
                <option value="pending" {{ $s=='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ $s=='approved'?'selected':'' }}>Approved</option>
                <option value="rejected" {{ $s=='rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>

        <div class="ml-auto text-sm text-gray-500" id="autosave-status">Not saved</div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="category" class="mt-1 block w-full border rounded p-2">
                @php $cat = old('category', $permintaan->category ?? '') @endphp
                <option value="">-- Pilih Kategori --</option>
                <option value="new_device" {{ $cat=='new_device'?'selected':'' }}>Permintaan Perangkat Baru</option>
                <option value="replacement" {{ $cat=='replacement'?'selected':'' }}>Penggantian Perangkat</option>
                <option value="repair" {{ $cat=='repair'?'selected':'' }}>Perbaikan</option>
                <option value="other" {{ $cat=='other'?'selected':'' }}>Lainnya</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Kuantitas</label>
            <input type="number" name="quantity" min="1" value="{{ old('quantity', $permintaan->meta['quantity'] ?? 1) }}" class="mt-1 block w-full border-gray-200 rounded-lg p-2 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipe Hardware</label>
            <input name="hardware_type" value="{{ old('hardware_type', $permintaan->hardware_type ?? '') }}" class="mt-1 block w-full border-gray-200 rounded-lg p-2 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Asset Tag / Serial</label>
            <input name="asset_tag" value="{{ old('asset_tag', $permintaan->asset_tag ?? '') }}" class="mt-1 block w-full border-gray-200 rounded-lg p-2 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input name="location" value="{{ old('location', $permintaan->location ?? '') }}" class="mt-1 block w-full border-gray-200 rounded-lg p-2 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
            <input type="date" name="estimated_completion" value="{{ old('estimated_completion', isset($permintaan->estimated_completion) ? $permintaan->estimated_completion->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-200 rounded-lg p-2 shadow-sm" />
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Lampiran Foto / Bukti</label>
            <input type="file" name="attachments[]" multiple class="mt-1 block w-full" />
            @if(!empty($permintaan->attachments))
                <div class="mt-2 flex gap-2">
                    @foreach($permintaan->attachments as $a)
                        <div class="relative">
                            <img src="{{ asset('uploader/' . $a) }}" class="w-24 h-24 object-cover rounded" />
                            <form method="POST" action="{{ route('permintaan.attachment.delete', ['permintaan' => $permintaan->id, 'filename' => $a]) }}" class="absolute top-0 right-0">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white rounded-full p-1 hover:bg-red-700 text-xs">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="pt-4 flex gap-2">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Simpan</button>
        <a href="{{ route('permintaan.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Batal</a>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        // Simple autosave
        let timer;
        const delay = 1500; // ms
        const id = {{ isset($permintaan) ? $permintaan->id : 'null' }};

        const statusEl = document.getElementById('autosave-status');
        const formData = () => ({
            id: id,
            judul: document.getElementById('judul')?.value,
            deskripsi: document.getElementById('deskripsi')?.value,
            status: document.getElementById('status')?.value,
        });

        function autosave() {
            const data = formData();
            statusEl.textContent = 'Saving...';
            fetch("{{ route('permintaan.autosave') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            }).then(r => r.json()).then(json => {
                statusEl.textContent = 'Saved';
                setTimeout(()=> statusEl.textContent = 'All changes saved', 800);
            }).catch(e => {
                statusEl.textContent = 'Save failed';
            });
        }

        ['input','change'].forEach(ev => {
            document.addEventListener(ev, function(e){
                if (!['judul','deskripsi','status'].includes(e.target.id)) return;
                clearTimeout(timer);
                timer = setTimeout(autosave, delay);
            });
        });
    })();
</script>
@endpush
