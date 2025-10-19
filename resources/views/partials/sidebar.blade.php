<aside class="w-64 flex flex-col self-stretch min-h-0 p-4 bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-lg sidebar-glow relative overflow-hidden">
    @php
        $user = auth()->user();
        $name = $user->name ?? 'Tamu';
        // initials
        $initials = trim(collect(explode(' ', $name))->map(function($p){ return substr($p,0,1); })->join('')) ?: 'U';
        $role = $user->role ?? 'guest';
        $color = $role === 'admin' ? '#2563EB' : ($role === 'user' ? '#10B981' : '#6B7280');
        $svg = rawurlencode("<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120'><rect width='100%' height='100%' fill='{$color}' rx='20' ry='20'/><text x='50%' y='55%' font-size='48' font-family='Arial' fill='white' dominant-baseline='middle' text-anchor='middle'>{$initials}</text></svg>");
        $avatar = "data:image/svg+xml;utf8,{$svg}";
    @endphp

    <div class="mb-6 flex items-center gap-3">
        <div class="w-14 h-14 rounded-lg overflow-hidden shadow-md border-2 border-white/20">
            @if($user->avatar)
                <img src="{{ asset('uploader/avatars/'.$user->avatar) }}" alt="avatar" class="w-full h-full object-cover" />
            @else
                <img src="{{ $avatar }}" alt="avatar" class="w-full h-full object-cover" />
            @endif
        </div>
        <div>
            <div class="font-semibold">{{ $name }}</div>
            <div class="text-sm text-gray-300">{{ ucfirst($role) }}</div>
        </div>
    </div>

    <nav class="space-y-2 text-sm">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Dashboard</a>
        <a href="{{ route('permintaan.index') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Permintaan</a>

        @if($user && $user->role === 'admin')
            <div class="mt-4 font-semibold text-xs text-gray-400">Admin</div>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Manajemen User</a>
            <a href="{{ route('admin.reports') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Laporan</a>
            <a href="{{ route('admin.settings') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Pengaturan Kantor</a>
        @endif

        @if($user && $user->role === 'user')
            <div class="mt-4 font-semibold text-xs text-gray-400">User</div>
            <a href="{{ route('permintaan.create') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Buat Permintaan</a>
            <a href="{{ route('permintaan.history') }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 transition-shadow hover:shadow-lg">Riwayat Permintaan</a>
        @endif
    </nav>

    <div class="mt-auto pt-6">
        <div class="text-xs text-gray-400">© {{ date('Y') }} Sistem Permintaan</div>
    </div>
    
    {{-- decorative falling stars background --}}
    <div class="sidebar-stars pointer-events-none" aria-hidden="true">
        @for($i=0;$i<18;$i++)
            <div class="star" style="left: {{ rand(0,100) }}%; animation-delay: {{ rand(0,1000)/1000 }}s; width: {{ rand(6,18) }}px; height: {{ rand(6,18) }}px;"></div>
        @endfor
    </div>
</aside>

<style>
/* subtle glow animation for sidebar */
.sidebar-glow{
    animation: sidebarGlow 3.5s infinite ease-in-out;
}
@keyframes sidebarGlow{
    0%{ box-shadow: 0 0 0 rgba(37,99,235,0.0); }
    50%{ box-shadow: 0 8px 24px rgba(37,99,235,0.08); }
    100%{ box-shadow: 0 0 0 rgba(37,99,235,0.0); }
}

/* falling stars animation */
.sidebar-stars{
    position: absolute;
    inset: 0 0 0 0;
    z-index: 0;
}
.sidebar-stars .star{
    position: absolute;
    top: -10%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.95), rgba(255,255,255,0.6));
    border-radius: 50%;
    opacity: 0.9;
    transform: translateY(-20px) rotate(0deg);
    animation: fall 6s linear infinite;
}
@keyframes fall{
    0%{ transform: translateY(-10%) rotate(0deg); opacity: 0.0; }
    10%{ opacity: 0.9; }
    100%{ transform: translateY(120%) rotate(360deg); opacity: 0.0; }
}

.sidebar-glow > *{ z-index: 2; }


</style>
