@extends('layouts.app')

@section('title','User Management')

@section('content')
<div class="p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Buat User</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 p-2 rounded text-green-800 mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="min-w-full">
            <thead>
                <tr class="text-left">
                    <th class="p-2">ID</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="border-t">
                    <td class="p-2">{{ $u->id }}</td>
                    <td class="p-2">{{ $u->name }}</td>
                    <td class="p-2">{{ $u->email }}</td>
                    <td class="p-2">{{ $u->role ?? 'user' }}</td>
                    <td class="p-2">
                        <div class="flex gap-2">
                            @if(!$u->approved)
                                <form method="POST" action="{{ route('admin.users.approve', $u) }}">
                                    @csrf
                                    <button class="px-2 py-1 bg-green-600 text-white rounded">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.sendActivation', $u) }}">
                                    @csrf
                                    <button class="px-2 py-1 bg-blue-600 text-white rounded">Kirim Aktivasi</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Yakin?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
