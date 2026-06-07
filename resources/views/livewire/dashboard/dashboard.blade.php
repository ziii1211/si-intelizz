<div class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] text-slate-200 font-sans relative">
    
    <!-- Subtle background pattern mimicking the image -->
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 15% 50%, rgba(255,255,255,0.08), transparent 25%), radial-gradient(circle at 85% 30%, rgba(255,255,255,0.08), transparent 25%);"></div>

    <div class="max-w-7xl mx-auto space-y-6 relative z-10">

        <!-- Notifikasi & Status Periode -->
        <div class="space-y-4">
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

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
            <div>
                <h2 class="text-[15px] font-medium text-white flex items-center gap-2">
                    <span class="font-bold">Hey {{ Auth::user()->name }}</span> - here's what's happening with your intelligence data today
                </h2>
                @if(Auth::user()->role === 'admin')
                <p class="text-xs text-yellow-400 mt-1">Anda memiliki {{ $totalPending ?? 0 }} item yang menunggu verifikasi.</p>
                @endif
            </div>
            
            <div class="flex gap-2">
                @if(Auth::user()->role === 'admin')
                <button wire:click="aturPeriode" class="bg-[#24382d] hover:bg-[#2d4638] border border-white/10 text-white text-xs font-medium py-2 px-4 rounded-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Atur Periode
                </button>
                @endif
                <a href="{{ route('reports.lapinhar') }}" wire:navigate class="bg-[#5e61ff] hover:bg-[#4b4ee6] text-white text-xs font-medium py-2 px-4 rounded-lg transition flex items-center gap-2 shadow-lg shadow-[#5e61ff]/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Lapinhar
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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

        <!-- Middle Section: Chart & Traffic Sources -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Chart -->
            <div class="lg:col-span-2 bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[15px] font-medium text-white">Grafik Pemetaan Intelijen</h3>
                    <div class="hidden sm:flex items-center gap-1 bg-[#1e2f25] p-1 rounded-lg border border-white/5">
                        <button class="text-[10px] text-white bg-[#374c40] px-3 py-1.5 rounded-md font-medium shadow-sm transition">All Data</button>
                        <button class="text-[10px] text-slate-400 hover:text-white px-3 py-1.5 rounded-md font-medium transition">DPO</button>
                        <button class="text-[10px] text-slate-400 hover:text-white px-3 py-1.5 rounded-md font-medium transition">Ormas</button>
                    </div>
                    <button class="text-xs text-slate-300 hover:text-white flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5 transition" onclick="window.print()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Export PDF
                    </button>
                </div>
                <div class="flex-1 relative min-h-[260px] w-full">
                    <canvas id="intelChart"></canvas>
                </div>
            </div>

            <!-- Menunggu Verifikasi (Mapped to Traffic Sources style) -->
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
                            // Calculate max for progress bars
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
                            ['label' => 'Lapinhar', 'route' => 'reports.lapinhar', 'count' => $pending['lapinhar'] ?? 0, 'color' => '#5e61ff'],
                            ['label' => 'Data DPO', 'route' => 'dpo.index', 'count' => $pending['dpo'] ?? 0, 'color' => '#34d399'],
                            ['label' => 'Data Ormas', 'route' => 'ormas.index', 'count' => $pending['ormas'] ?? 0, 'color' => '#f43f5e'],
                            ['label' => 'Data WNA', 'route' => 'wna.index', 'count' => $pending['wna'] ?? 0, 'color' => '#eab308'],
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

        <!-- Bottom Section: Transactions & Recent Customers -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- 5 Lapinhar Terakhir (Mapped to Transactions style) -->
            <div class="lg:col-span-2 bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-[15px] font-medium text-white">Daftar Lapinhar Terbaru</h3>
                        <p class="text-[11px] text-slate-400 mt-1">Laporan harian intelijen yang baru saja masuk sistem.</p>
                    </div>
                    <a href="{{ route('reports.lapinhar') }}" wire:navigate class="text-[10px] font-medium text-slate-300 bg-white/5 hover:bg-white/10 px-3 py-2 rounded-lg transition flex items-center gap-1">
                        See All <span class="hidden sm:inline">Reports</span> <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="space-y-2">
                    @if(isset($latestLapinhar) && count($latestLapinhar) > 0)
                        @foreach($latestLapinhar as $item)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:p-4 hover:bg-white/5 rounded-xl transition cursor-pointer gap-4">
                            <div class="flex items-center gap-4 w-full sm:w-1/3">
                                <!-- Status Pill -->
                                <div class="flex items-center w-24 shrink-0">
                                    @if($item->status_verifikasi == 'disetujui')
                                        <div class="flex items-center gap-2 bg-emerald-500/10 px-2 py-1 rounded-full border border-emerald-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                                            <span class="text-[10px] text-emerald-300 font-medium">Disetujui</span>
                                        </div>
                                    @elseif($item->status_verifikasi == 'ditolak')
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
                                    <p class="text-[13px] font-medium text-slate-200 truncate w-32 sm:w-auto">{{ $item->bidang }}</p>
                                    <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex-1 w-full sm:w-auto">
                                <p class="text-[12px] font-medium text-slate-300 truncate">{{ Str::limit($item->peristiwa, 50) }}</p>
                                <p class="text-[10px] text-slate-500 mt-0.5">Dokumen Informasi Intelijen</p>
                            </div>
                            
                            <div class="flex justify-between w-full sm:w-auto sm:justify-end items-center gap-4 shrink-0">
                                <span class="text-[11px] text-slate-400 hidden sm:block">Intelijen</span>
                                <button class="text-slate-500 hover:text-white transition p-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 12a2 2 0 110-4 2 2 0 010 4zm7 0a2 2 0 110-4 2 2 0 010 4zm7 0a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <p class="text-[12px] text-slate-400">Belum ada data Lapinhar terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Early Warning WNA (Mapped to Recent Customers style) -->
            <div class="bg-[#24382d] rounded-[1.25rem] p-6 shadow-lg border border-white/5 flex flex-col">
                <div class="mb-6">
                    <h3 class="text-[15px] font-medium text-white">Early Warning WNA</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Peringatan kedaluwarsa dokumen izin tinggal WNA.</p>
                </div>
                
                <div class="space-y-2 flex-1">
                    @if(isset($wnaWarnings) && $wnaWarnings->count() > 0)
                        @foreach($wnaWarnings as $wna)
                        @php
                            $sisaHari = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($wna->masa_berlaku_izin), false);
                            $isExpired = $sisaHari < 0;
                            // Generate random subtle background color for avatar based on name
                            $colors = ['bg-indigo-500/20 text-indigo-300 border-indigo-500/30', 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30', 'bg-rose-500/20 text-rose-300 border-rose-500/30', 'bg-amber-500/20 text-amber-300 border-amber-500/30', 'bg-blue-500/20 text-blue-300 border-blue-500/30'];
                            $colorClass = $colors[crc32($wna->nama_lengkap) % count($colors)];
                        @endphp
                        <div class="flex items-center justify-between p-2 hover:bg-white/5 rounded-xl transition">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $colorClass }} flex items-center justify-center text-[13px] font-bold border shrink-0">
                                    {{ strtoupper(substr($wna->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-[13px] font-medium text-slate-200 truncate max-w-[120px] sm:max-w-[150px]">{{ $wna->nama_lengkap }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ $wna->nomor_paspor }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($isExpired)
                                    <p class="text-[12px] font-semibold text-rose-400">Expired</p>
                                @else
                                    <p class="text-[12px] font-semibold text-emerald-400">{{ intval($sisaHari) }} Hari</p>
                                @endif
                                <p class="text-[10px] text-slate-400">{{ Str::limit($wna->negara_asal, 10) }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-500 space-y-2 pb-6">
                            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[11px]">Semua izin WNA aman.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-white/5">
                    <a href="{{ route('wna.index') }}" wire:navigate class="text-[10px] font-semibold text-slate-400 hover:text-white uppercase tracking-wider flex items-center gap-1 transition">
                        SEE ALL WNA <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal Atur Periode (Dark Theme) -->
    @if(isset($showPeriodeModal) && $showPeriodeModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0f1713]/80 backdrop-blur-sm transition-opacity" wire:click="$set('showPeriodeModal', false)"></div>
            <div class="relative bg-[#24382d] rounded-[1.25rem] shadow-2xl w-full max-w-md overflow-hidden border border-white/10">
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
                        <button wire:click="simpanPeriode" class="px-5 py-2 bg-[#5e61ff] hover:bg-[#4b4ee6] text-white text-[11px] font-medium rounded-lg shadow-lg shadow-[#5e61ff]/20 transition">Simpan Aturan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Script Chart.js dengan desain Curve Area mirip gambar -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const ctx = document.getElementById('intelChart');
        if(ctx) {
            // Create gradient for the area chart
            const chartCtx = ctx.getContext('2d');
            let gradient1 = chartCtx.createLinearGradient(0, 0, 0, 300);
            gradient1.addColorStop(0, 'rgba(94, 97, 255, 0.4)');   // Blue-ish top
            gradient1.addColorStop(1, 'rgba(94, 97, 255, 0.01)');  // Transparent bottom

            let gradient2 = chartCtx.createLinearGradient(0, 0, 0, 300);
            gradient2.addColorStop(0, 'rgba(52, 211, 153, 0.4)');  // Emerald top
            gradient2.addColorStop(1, 'rgba(52, 211, 153, 0.01)'); // Transparent bottom

            // Mimicking the curved dual-line area chart from the screenshot
            // Since we only have 4 data points statically, we interpolate them 
            // slightly to make it look like a smooth timeline if we want, 
            // but for accuracy we map our 4 categories to a line format.
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Buronan', 'Tertangkap', 'Ormas Pantau', 'Ormas Beku'],
                    datasets: [
                        {
                            label: 'Data Utama',
                            data: [
                                {{ $chartData['dpo_buron'] ?? 10 }}, 
                                {{ $chartData['dpo_tertangkap'] ?? 25 }}, 
                                {{ $chartData['ormas_waspada'] ?? 15 }}, 
                                {{ $chartData['ormas_dibekukan'] ?? 30 }}
                            ],
                            borderColor: '#5e61ff', // Blue line
                            backgroundColor: gradient1,
                            borderWidth: 2,
                            tension: 0.4, // Smooth curve
                            fill: true,
                            pointBackgroundColor: '#182a20',
                            pointBorderColor: '#5e61ff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Data Sekunder',
                            // Just a subtle offset data to mimic the 2 lines in the image
                            data: [
                                {{ ($chartData['dpo_buron'] ?? 10) * 0.6 }}, 
                                {{ ($chartData['dpo_tertangkap'] ?? 25) * 0.8 }}, 
                                {{ ($chartData['ormas_waspada'] ?? 15) * 0.5 }}, 
                                {{ ($chartData['ormas_dibekukan'] ?? 30) * 0.7 }}
                            ],
                            borderColor: '#34d399', // Emerald line
                            backgroundColor: gradient2,
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 0
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
                        legend: { display: false },
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