@extends('layouts.app')

@section('title','Pengaturan Kantor')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-2xl font-semibold mb-4">Pengaturan Kantor</h2>
    <p>Placeholder for office settings.</p>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm">Nama Kantor</label>
            <input type="text" name="office" value="{{ old('office', $office ?? '') }}" class="mt-1 block w-full border rounded p-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm">Alamat</label>
            <textarea name="address" class="mt-1 block w-full border rounded p-2">{{ old('address', $address ?? '') }}</textarea>
        </div>
        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
