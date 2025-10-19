@extends('layouts.app')

@section('title','Buat Permintaan')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-extrabold mb-4">Buat Permintaan</h2>

        <form method="POST" action="{{ route('permintaan.store') }}" enctype="multipart/form-data">
            @include('permintaan._form')
        </form>
    </div>

    @stack('scripts')
@endsection
