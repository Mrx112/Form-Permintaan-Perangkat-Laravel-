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

        <div class="flex flex-1 min-h-0">
            @auth
                @include('partials.sidebar')
            @endauth

            <main class="flex-1 py-6 min-h-0 overflow-auto">
                <div class="max-w-6xl mx-auto px-4">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <footer class="bg-white border-t">
            <div class="max-w-6xl mx-auto px-4 py-4 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <div>© {{ date('Y') }} Sistem Permintaan - IT Hardware</div>
                    <div>Copyright By Adi Susilo</div>
                </div>
            </div>
        </footer>
    </div>

    {{-- global loading overlay --}}
    <div id="global-loader" class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="text-center">
            <div class="mx-auto mb-4 w-20 h-20 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 animate-pulse flex items-center justify-center shadow-lg">
                <img src="{{ asset('favicon.ico') }}" alt="logo" class="w-10 h-10" />
            </div>
            <div class="text-gray-700 font-medium">Memuat...</div>
        </div>
    </div>

    <script>
        // Show loader on internal navigation (links/forms)
        (function(){
            const loader = document.getElementById('global-loader');
            function show(){ loader.classList.remove('hidden'); loader.classList.add('flex'); }
            function hide(){ loader.classList.remove('flex'); loader.classList.add('hidden'); }

            // Intercept clicks on same-origin links
            document.addEventListener('click', function(e){
                const a = e.target.closest('a');
                if (!a) return;
                const href = a.getAttribute('href');
                if (!href) return;
                // ignore external links or anchors
                if (href.startsWith('http') || href.startsWith('mailto:') || href.startsWith('#')) return;
                show();
            });

            // Show on forms submit
            document.addEventListener('submit', function(e){ show(); });

            // Hide loader after window load (in case it was shown during initial navigation)
            window.addEventListener('load', hide);
            // Also hide after 10s as fallback
            setTimeout(hide, 10000);
        })();
    </script>
</body>
</html>
