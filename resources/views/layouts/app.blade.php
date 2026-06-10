<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SI-INTELIZZ') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900"
    x-data="{ 
        sidebarOpen: window.innerWidth > 1024 ? (localStorage.getItem('sidebarState') === 'false' ? false : true) : false,
        isMobile: window.innerWidth < 1024
    }"
    x-init="
        $watch('sidebarOpen', value => { if(!isMobile) localStorage.setItem('sidebarState', value) });
        window.addEventListener('resize', () => { isMobile = window.innerWidth < 1024; if(isMobile) sidebarOpen = false });
    ">

    <div class="h-screen w-full flex overflow-hidden bg-slate-50">

        <div x-show="isMobile && sidebarOpen"
            x-transition:enter="transition opacity-ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] lg:hidden">
        </div>

        <aside
            :class="{
                'w-72': sidebarOpen && !isMobile,
                'w-20': !sidebarOpen && !isMobile,
                'translate-x-0 w-72': sidebarOpen && isMobile,
                '-translate-x-full': !sidebarOpen && isMobile
            }"
            class="bg-slate-900 border-r border-slate-800 flex-shrink-0 h-full transition-all duration-300 ease-in-out z-[70] shadow-2xl overflow-hidden fixed lg:relative">
            <livewire:layout.navigation />
        </aside>

        <div class="flex-1 flex flex-col h-full min-w-0 overflow-y-auto overflow-x-hidden relative">

            <header class="sticky top-0 bg-[#182a20]/80 backdrop-blur-xl border-b border-white/5 h-16 shrink-0 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-400 hover:bg-white/5 hover:text-emerald-400 transition-all focus:outline-none border border-transparent hover:border-white/5">
                        <svg class="w-6 h-6" :class="sidebarOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    @if (isset($header))
                    <div class="font-bold text-slate-200 tracking-tight leading-none uppercase text-xs sm:text-sm md:text-lg border-l-2 border-white/10 pl-4">
                        {{ $header }}
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:block relative">
                        <input type="text" placeholder="Ketik untuk mencari..." class="bg-[#24382d] border border-white/5 text-slate-300 text-xs rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 w-48 lg:w-64 placeholder-slate-500">
                        <svg class="w-4 h-4 absolute right-3 top-2.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div class="hidden sm:flex items-center mr-2">
                        
                        <div x-data="{ openNotif: false }" class="relative border-r border-white/10 pr-4 mr-2">
    <button @click="openNotif = !openNotif" class="text-slate-400 hover:text-emerald-400 relative p-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        
        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full border border-[#182a20] animate-ping"></span>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full border border-[#182a20]"></span>
        @endif
    </button>

    <div x-show="openNotif" style="display: none;" @click.away="openNotif = false" 
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="absolute right-0 mt-3 w-80 bg-[#1a2621] border border-white/10 rounded-xl shadow-2xl py-2 z-50">
        
        <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center">
            <span class="text-white font-bold text-sm">Notifikasi Deadline</span>
            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                <span class="bg-rose-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ auth()->user()->unreadNotifications->count() }} Berkas</span>
            @endif
        </div>

        <div class="max-h-72 overflow-y-auto custom-scrollbar">
            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                @foreach(auth()->user()->unreadNotifications as $notif)
                    <a href="{{ url($notif->data['url'] ?? '#') }}" class="block px-4 py-3 hover:bg-white/5 border-b border-white/5 last:border-0 transition-colors">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Sistem Peringatan</span>
                            <span class="text-[10px] font-bold text-rose-400">Segera Cek!</span>
                        </div>
                        <p class="text-xs text-slate-200 font-medium truncate">{{ $notif->data['pesan'] }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            @else
                <div class="px-4 py-6 text-center">
                    <svg class="w-8 h-8 text-emerald-500/50 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-slate-400 italic">Semua berkas aman.<br>Tidak ada deadline mendesak.</p>
                </div>
            @endif
        </div>
    </div>
</div>

                    </div>

                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-sm font-black shadow-lg border border-emerald-400/30 cursor-pointer group relative">
                        @if(Auth::check())
                        {{ substr(Auth::user()->name, 0, 1) }}
                        <div class="absolute top-12 right-0 bg-[#13241b] border border-white/10 shadow-xl text-slate-200 text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                            {{ Auth::user()->name }}
                        </div>
                        @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-slate-50">
                <div class="max-w-full mx-auto">
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                        x-show="show"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            if (window.innerWidth < 1024) {
                window.dispatchEvent(new CustomEvent('close-sidebar'));
            }
        });
    </script>
</body>

</html>