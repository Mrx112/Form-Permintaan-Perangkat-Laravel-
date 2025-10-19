@extends('layouts.app')

@section('title','Buat User')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Buat User</h2>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label class="block text-sm">Nama</label>
            <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" />
            @error('name')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" />
            @error('email')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" />
            @error('password')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="block text-sm">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" />
        </div>
        <div class="mb-3">
            <label class="block text-sm">Role</label>
            <select name="role" class="w-full border p-2 rounded">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <div class="text-xs text-gray-500 mt-1">Pilih role: <strong>Admin</strong> memiliki akses manajemen (user, permintaan, laporan). <strong>User</strong> hanya dapat membuat/lihat permintaan sendiri.</div>
        </div>
        <div class="flex justify-end">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
