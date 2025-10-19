@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-extrabold mb-4">Edit Profil</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-200 rounded-lg px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Avatar (jpg, png, webp)</label>
                <input type="file" name="avatar" accept="image/*" class="mt-1 block w-full" />
                @if($user->avatar)
                    <div class="mt-3 flex items-center gap-4">
                        <img src="{{ asset('uploader/avatars/'.$user->avatar) }}" alt="avatar" class="w-24 h-24 object-cover rounded-lg border"/>
                        <div>
                            <form method="POST" action="{{ route('profile.avatar.delete') }}">
                                @csrf
                                <button class="px-3 py-2 bg-red-500 text-white rounded">Hapus avatar</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow">Simpan</button>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600">Batal</a>
            </div>
        </form>
    </div>
@endsection
