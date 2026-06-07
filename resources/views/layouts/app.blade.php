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

    <!-- KUNCI HEIGHT DI SINI: h-screen w-full -->
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

        <!-- WRAPPER KONTEN KANAN: h-full -->
        <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

            <header class="bg-[#182a20] border-b border-white/5 h-16 shrink-0 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-40">
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
                    <!-- Search Bar Meniru Referensi Gambar -->
                    <div class="hidden md:block relative">
                        <input type="text" placeholder="Type to search" class="bg-[#24382d] border border-white/5 text-slate-300 text-xs rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 w-48 lg:w-64 placeholder-slate-500">
                        <svg class="w-4 h-4 absolute right-3 top-2.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <!-- Ikon Notifikasi (Dummy meniru gambar) -->
                    <div class="hidden sm:flex items-center gap-2 mr-2">
                        <button class="text-slate-400 hover:text-emerald-400 relative p-1.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="absolute top-1 right-0.5 w-2 h-2 bg-rose-500 rounded-full border border-[#182a20]"></span>
                        </button>
                        <button class="text-slate-400 hover:text-emerald-400 relative p-1.5 border-r border-white/10 pr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>

                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-sm font-black shadow-lg border border-emerald-400/30 cursor-pointer group relative">
                        @if(Auth::check())
                        {{ substr(Auth::user()->name, 0, 1) }}
                        <div class="absolute top-12 right-0 bg-[#13241b] border border-white/10 shadow-xl text-slate-200 text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">
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

            <!-- AREA SCROLL: flex-1 overflow-y-auto -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50">
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