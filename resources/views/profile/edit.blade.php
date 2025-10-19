@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Edit Profil</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Avatar (jpg, png, webp)</label>
                <input type="file" name="avatar" accept="image/*" class="mt-1 block w-full" />
                @if($user->avatar)
                    <div class="mt-3">
                        <img src="{{ asset('uploader/avatars/'.$user->avatar) }}" alt="avatar" class="w-24 h-24 object-cover rounded-lg border"/>
                    </div>
                @endif
            </div>

            <div>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
@endsection
