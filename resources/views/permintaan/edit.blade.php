@extends('layouts.app')

@section('title','Edit Permintaan')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Permintaan</h2>

        <form method="POST" action="{{ route('permintaan.update', $permintaan) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('permintaan._form')
        </form>
    </div>

    @stack('scripts')
@endsection
