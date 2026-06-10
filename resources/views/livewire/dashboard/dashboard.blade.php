<div wire:poll.15s class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] text-slate-200 font-sans relative">
    
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>

    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 15% 50%, rgba(255,255,255,0.08), transparent 25%), radial-gradient(circle at 85% 30%, rgba(255,255,255,0.08), transparent 25%);"></div>

    <div class="max-w-7xl mx-auto space-y-6 relative z-10">

        <div class="space-y-4 animate-fade-in-up">
            @if (session()->has('message'))
                <div class="bg-[#24382d] border-l-4 border-emerald-500 p-4 rounded-xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/20 rounded-lg">
                            <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">Berhasil!</h3>
                            <p class="text-xs text-slate-400">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($periode) && $periode)
                @if($isPeriodeAktif)
                    <div class="bg-[#24382d] border-l-4 border-emerald-500 p-4 rounded-xl shadow-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-white">PORTAL PELAPORAN DIBUKA</h3>
                                <p class="text-xs text-slate-400">Batas Waktu: {{ \Carbon\Carbon::parse($periode->tanggal_buka)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($periode->tanggal_tutup)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-[#24382d] border-l-4 border-rose-500 p-4 rounded-xl shadow-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-white">PORTAL PELAPORAN DITUTUP</h3>
                                <p class="text-xs text-slate-400">Staf tidak dapat membuat laporan baru di luar batas waktu.</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2 animate-fade-in-up delay-100">
            <div>
                <h2 class="text-[15px] font-medium text-white flex items-center gap-2">
                    <span class="font-bold">Hey {{ Auth::user()->name }}</span> - here's what's happening with your intelligence data today
                </h2>
                @if(Auth::user()->role === 'admin')
                <p class="text-xs text-yellow-400 mt-1">Anda memiliki {{ $totalPending ?? 0 }} Laporan yang menunggu verifikasi.</p>
                @endif
            </div>
            
            <div class="flex gap-2">
                @if(Auth::user()->role === 'admin')
                <button wire:click="aturPeriode" class="bg-emerald-600 hover:bg-emerald-500 border border-emerald-400/50 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-lg shadow-emerald-500/20 transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Atur Periode
                </button>
                @endif
                </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 animate-fade-in-up delay-200">
            <div class="bg-[#24382d] rounded-[1.25rem] p-5 shadow-lg relative overflow-hidden border border-white/5">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Total Lapinhar</h3>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-semibold text-white">{{ number_format($totalLapinhar ?? 0) }}</span>
                        <span class="text-[10px] font-medium text-emerald-400">+ Laporan</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#24382d] rounded-[1.25rem] p-5 shadow-lg relative overflow-hidden border border-white/5">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Buronan (DPO)</h3>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-semibold text-white">{{ number_format($totalDpo ?? 0) }}</span>
                        <span class="text-[10px] font-medium text-rose-400">Target</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#24382d] rounded-[1.25rem] p-5 shadow-lg relative overflow-hidden border border-white/5">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Ormas Aktif</h3>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-semibold text-white">{{ number_format($totalOrmas ?? 0) }}</span>
                        <span class="text-[10px] font-medium text-emerald-400">+ Lembaga</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#24382d] rounded-[1.25rem] p-5 shadow-lg relative overflow-hidden border border-white/5">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Pengawasan WNA</h3>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-semibold text-white">{{ number_format($totalWna ?? 0) }}</span>
                        <span class="text-[10px] font-medium text-emerald-400">+ Orang</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up delay-300">
            
            <div class="lg:col-span-2 bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[15px] font-medium text-white">Grafik Pemetaan Intelijen</h3>
                    
                    <form action="{{ route('reports.pemetaan') }}" method="POST" id="formCetakPemetaan" class="m-0">
                        @csrf
                        <input type="hidden" name="chart_image" id="chart_image_input">
                        <button type="button" onclick="submitCetakPemetaan()" class="text-xs text-slate-300 hover:text-white flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </form>
                </div>
                <div class="flex-1 relative min-h-[260px] w-full bg-white rounded-lg p-2" wire:ignore>
                    <canvas id="intelChart"></canvas>
                </div>
            </div>

            <div class="bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5 flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-[15px] font-medium text-white">Menunggu Verifikasi</h3>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1 cursor-pointer hover:text-white transition">
                        Total: {{ $totalPending ?? 0 }} <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <div class="space-y-6 flex-1">
                    @if(isset($totalPending) && $totalPending > 0)
                        @php
                            $maxPending = max(
                                $pending['lapinhar'] ?? 0, 
                                $pending['dpo'] ?? 0, 
                                $pending['ormas'] ?? 0, 
                                $pending['wna'] ?? 0, 
                                $pending['jms'] ?? 0, 
                                $pending['pam'] ?? 0,
                                1
                            );
                        @endphp

                        @foreach([
                            ['label' => 'Lapinhar', 'route' => 'lapinhar.index', 'count' => $pending['lapinhar'] ?? 0, 'color' => '#5e61ff'],
                            ['label' => 'Data DPO', 'route' => 'dpo.index', 'count' => $pending['dpo'] ?? 0, 'color' => '#34d399'],
                            ['label' => 'Data Ormas', 'route' => 'ormas.index', 'count' => $pending['ormas'] ?? 0, 'color' => '#f43f5e'],
                            ['label' => 'Data WNA', 'route' => 'wna.index', 'count' => $pending['wna'] ?? 0, 'color' => '#eab308'],
                            // [PERBAIKAN] Menambahkan PAM SDO dan JMS
                            ['label' => 'PAM SDO', 'route' => 'pam-sdo.index', 'count' => $pending['pam'] ?? 0, 'color' => '#a855f7'],
                            ['label' => 'Data JMS', 'route' => 'jms.index', 'count' => $pending['jms'] ?? 0, 'color' => '#0ea5e9'],
                        ] as $item)
                            @if($item['count'] > 0)
                            <a href="{{ route($item['route']) }}" wire:navigate class="block group">
                                <div class="flex justify-between text-[11px] text-slate-300 mb-2 group-hover:text-white transition">
                                    <span>{{ $item['label'] }}</span>
                                    <span>{{ $item['count'] }}</span>
                                </div>
                                <div class="w-full bg-[#1e2f25] rounded-full h-1.5 overflow-hidden border border-white/5">
                                    <div class="h-1.5 rounded-full transition-all duration-1000" style="width: {{ ($item['count'] / $maxPending) * 100 }}%; background-color: {{ $item['color'] }};"></div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-500 space-y-3 pb-8">
                            <svg class="w-10 h-10 text-emerald-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[11px] font-medium">Semua data terverifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up delay-300">

            <div class="lg:col-span-2 bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-[15px] font-medium text-white">Aktivitas Intelijen Terbaru</h3>
                        <p class="text-[11px] text-slate-400 mt-1">Laporan & data terbaru dari seluruh modul sistem.</p>
                    </div>
                    <a href="{{ route('logs.index') }}" wire:navigate class="text-[10px] font-medium text-slate-300 bg-white/5 hover:bg-white/10 px-3 py-2 rounded-lg transition flex items-center gap-1">
                        See Activity <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="space-y-2">
                    @if(isset($latestActivities) && count($latestActivities) > 0)
                        @foreach($latestActivities as $item)
                        <a href="{{ $item->url }}" wire:navigate class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:p-4 hover:bg-white/5 rounded-xl transition cursor-pointer gap-4 group">
                            <div class="flex items-center gap-4 w-full sm:w-1/3">
                                <div class="flex items-center w-24 shrink-0">
                                    @if($item->status == 'disetujui')
                                        <div class="flex items-center gap-2 bg-emerald-500/10 px-2 py-1 rounded-full border border-emerald-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                                            <span class="text-[10px] text-emerald-300 font-medium">Disetujui</span>
                                        </div>
                                    @elseif($item->status == 'ditolak')
                                        <div class="flex items-center gap-2 bg-rose-500/10 px-2 py-1 rounded-full border border-rose-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-rose-400 shadow-[0_0_8px_rgba(244,63,94,0.8)]"></div>
                                            <span class="text-[10px] text-rose-300 font-medium">Ditolak</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 bg-amber-500/10 px-2 py-1 rounded-full border border-amber-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                                            <span class="text-[10px] text-amber-300 font-medium">Pending</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[13px] font-medium text-slate-200 truncate w-32 sm:w-auto">{{ $item->judul }}</p>
                                    <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <div class="flex-1 w-full sm:w-auto">
                                <p class="text-[12px] font-medium text-slate-300 truncate">{{ $item->deskripsi }}</p>
                                <p class="text-[10px] text-slate-500 mt-0.5 group-hover:text-slate-400 transition-colors">Data Masuk</p>
                            </div>
                            
                            <div class="flex justify-between w-full sm:w-auto sm:justify-end items-center gap-4 shrink-0">
                                <span class="text-[10px] font-black tracking-widest {{ $item->warna }} bg-white/5 px-2 py-1 rounded-md">{{ $item->modul }}</span>
                                <div class="text-slate-500 group-hover:text-white transition p-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <p class="text-[12px] text-slate-400">Belum ada aktivitas terbaru di sistem.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5 flex flex-col">
                <div class="mb-6">
                    <h3 class="text-[15px] font-medium text-white flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        Early Warning System
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Peringatan ambang batas waktu (H-30) seluruh modul intelijen.</p>
                </div>
                
                <div class="space-y-2 flex-1">
                    @if(isset($earlyWarnings) && $earlyWarnings->count() > 0)
                        @foreach($earlyWarnings as $warning)
                        @php
                            // Menghitung selisih hari secara real-time
                            $sisaHari = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($warning->deadline)->startOfDay(), false);
                            $isExpired = $sisaHari < 0;
                        @endphp
                        <a href="{{ $warning->url }}" wire:navigate class="flex items-center justify-between p-2.5 hover:bg-white/5 rounded-xl transition group border border-transparent hover:border-white/5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-[9px] font-black border tracking-wider shrink-0 {{ $warning->badge }}">
                                    {{ substr($warning->modul, 0, 3) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[13px] font-semibold text-slate-200 truncate max-w-[120px] sm:max-w-[150px]">{{ $warning->nama }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ $warning->sub_text }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                @if($isExpired)
                                    <p class="text-[12px] font-bold text-rose-400 animate-pulse">Expired</p>
                                @elseif($sisaHari == 0)
                                    <p class="text-[12px] font-bold text-amber-400">Hari Ini!</p>
                                @else
                                    <p class="text-[12px] font-bold text-emerald-400">{{ intval($sisaHari) }} Hari</p>
                                @endif
                                <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider block mt-0.5">{{ $warning->modul }}</span>
                            </div>
                        </a>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-500 space-y-2 pb-6">
                            <svg class="w-8 h-8 opacity-40 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[11px] italic text-slate-400">Semua batas waktu aman.<br>Tidak ada deadline mendesak.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-white/5 text-center sm:text-left">
                    <span class="text-[9px] text-slate-500 font-black uppercase tracking-[0.2em]">Monitoring Kejari Banjarmasin</span>
                </div>
            </div>

        </div>

    </div>

    @if(isset($showPeriodeModal) && $showPeriodeModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0f1713]/80 backdrop-blur-sm transition-opacity" wire:click="$set('showPeriodeModal', false)"></div>
            <div class="relative bg-[#24382d] rounded-[1.25rem] shadow-2xl w-full max-w-md overflow-hidden border border-white/10 animate-fade-in-up">
                <div class="px-6 py-5 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-[15px] font-medium text-white">Atur Waktu Pelaporan</h3>
                    <button wire:click="$set('showPeriodeModal', false)" class="text-slate-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-5">
                    <p class="text-[11px] text-slate-400 leading-relaxed">Tentukan batas waktu (periode) pelaporan. Jika waktu saat ini berada di luar tanggal yang ditentukan, staf tidak akan bisa membuat dokumen laporan baru.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-medium text-slate-300 mb-1.5">Tanggal Dibuka</label>
                            <input type="date" wire:model="tanggal_buka" class="w-full bg-[#1e2f25] border border-white/10 rounded-lg text-sm text-slate-200 focus:ring-1 focus:ring-[#5e61ff] focus:border-[#5e61ff] px-4 py-2.5 transition [color-scheme:dark]">
                            @error('tanggal_buka') <span class="text-rose-400 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-medium text-slate-300 mb-1.5">Tanggal Ditutup</label>
                            <input type="date" wire:model="tanggal_tutup" class="w-full bg-[#1e2f25] border border-white/10 rounded-lg text-sm text-slate-200 focus:ring-1 focus:ring-[#5e61ff] focus:border-[#5e61ff] px-4 py-2.5 transition [color-scheme:dark]">
                            @error('tanggal_tutup') <span class="text-rose-400 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-[#1e2f25]/50 border-t border-white/5 flex justify-between items-center">
                    <button wire:click="resetPeriode" wire:confirm="Yakin ingin mereset/menghapus periode pelaporan?" class="text-[11px] text-rose-400 hover:text-rose-300 font-medium transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Reset Waktu
                    </button>
                    <div class="flex gap-2">
                        <button wire:click="$set('showPeriodeModal', false)" class="px-4 py-2 text-[11px] font-medium text-slate-400 hover:text-white transition bg-white/5 rounded-lg">Batal</button>
                        <button wire:click="simpanPeriode" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-medium rounded-lg shadow-lg shadow-emerald-500/20 transition">Simpan Aturan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function submitCetakPemetaan() {
        const canvas = document.getElementById('intelChart'); 
        if (canvas) {
            const base64Image = canvas.toDataURL("image/png");
            document.getElementById('chart_image_input').value = base64Image;
            document.getElementById('formCetakPemetaan').submit();
        } else {
            alert('Grafik belum selesai dimuat atau ID canvas tidak ditemukan.');
        }
    }

    document.addEventListener('livewire:initialized', () => {
        const ctx = document.getElementById('intelChart');
        if(ctx) {
            const chartCtx = ctx.getContext('2d');
            const moduleColors = ['#34d399', '#f43f5e', '#5e61ff', '#eab308', '#a855f7', '#0ea5e9'];

            let gradient1 = chartCtx.createLinearGradient(0, 0, 0, 300);
            gradient1.addColorStop(0, 'rgba(94, 97, 255, 0.4)');
            gradient1.addColorStop(1, 'rgba(94, 97, 255, 0.01)');

            let gradient2 = chartCtx.createLinearGradient(0, 0, 0, 300);
            gradient2.addColorStop(0, 'rgba(52, 211, 153, 0.4)');
            gradient2.addColorStop(1, 'rgba(52, 211, 153, 0.01)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['DPO', 'Ormas', 'Lapinhar', 'WNA', 'PAM SDO', 'JMS'],
                    datasets: [
                        {
                            label: 'Proses / Kerawanan',
                            data: [
                                {{ $chartData['dpo_buron'] ?? 0 }}, 
                                {{ $chartData['ormas_waspada'] ?? 0 }}, 
                                {{ $chartData['lapinhar_pending'] ?? 0 }}, 
                                {{ $chartData['wna_warning'] ?? 0 }},
                                {{ $chartData['pam_berjalan'] ?? 0 }},
                                {{ $chartData['jms_terjadwal'] ?? 0 }}
                            ],
                            borderColor: '#5e61ff',
                            backgroundColor: gradient1,
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: moduleColors,
                            pointBorderColor: '#182a20',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Selesai / Kondusif',
                            data: [
                                {{ $chartData['dpo_tertangkap'] ?? 0 }}, 
                                {{ $chartData['ormas_dibekukan'] ?? 0 }}, 
                                {{ $chartData['lapinhar_selesai'] ?? 0 }}, 
                                {{ $chartData['wna_aman'] ?? 0 }},
                                {{ $chartData['pam_selesai'] ?? 0 }},
                                {{ $chartData['jms_terlaksana'] ?? 0 }}
                            ],
                            borderColor: '#34d399',
                            backgroundColor: gradient2,
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: moduleColors,
                            pointBorderColor: '#182a20',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                color: '#cbd5e1',
                                boxWidth: 10,
                                boxHeight: 10,
                                usePointStyle: true,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e2f25',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: true,
                            usePointStyle: true,
                            boxHeight: 6,
                            boxWidth: 6,
                            boxPadding: 4,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                drawBorder: false,
                            },
                            ticks: { 
                                precision: 0,
                                color: '#64748b',
                                font: { size: 10 },
                                padding: 10
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#64748b',
                                font: { size: 10 },
                                padding: 10
                            },
                            border: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>