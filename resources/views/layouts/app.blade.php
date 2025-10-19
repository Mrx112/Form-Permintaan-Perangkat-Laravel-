<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Permintaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('permintaan.index') }}" class="flex items-center text-xl font-semibold">Permintaan</a>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <span class="text-sm">Halo, {{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-1 hover:text-indigo-600 transition">Login</a>
                            <a href="{{ route('register') }}" class="px-3 py-1 hover:text-indigo-600 transition">Register</a>
                        @endauth
                        <a href="{{ route('permintaan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition">Buat Permintaan</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            @auth
                @include('partials.sidebar')
            @endauth

            <main class="flex-1 py-6">
                <div class="max-w-6xl mx-auto px-4">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <footer class="bg-white border-t mt-6">
            <div class="max-w-6xl mx-auto px-4 py-4 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <div>© {{ date('Y') }} Sistem Permintaan - IT Hardware</div>
                    <div>Copyright By Adi Susilo</div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
