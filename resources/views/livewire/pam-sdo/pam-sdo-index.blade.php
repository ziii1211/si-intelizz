<div class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] relative text-slate-200">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#24382d] p-6 rounded-2xl shadow-lg border border-white/5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">PAM SDO</h2>
                    <p class="text-sm text-slate-400 font-medium tracking-wide">Pengamanan Sumber Daya Organisasi (Personil, Materiil, Informasi)</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.pam-sdo') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95 border border-transparent">
                    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                @if(\App\Models\PeriodePelaporan::isAktif())
                    <button wire:click="create"
                        class="inline-flex items-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95 border border-transparent">
                        <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Laporan Baru
                    </button>
                @else
                    <div class="inline-flex items-center px-4 py-2.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-xs font-black rounded-xl gap-2 shadow-sm">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        PORTAL INPUT DITUTUP
                    </div>
                @endif
            </div>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-[#24382d] border-l-4 border-emerald-500 text-slate-200 rounded-xl shadow-lg">
            <svg class="w-5 h-5 mr-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold uppercase tracking-widest">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari agenda kegiatan, lokasi PAM, atau personil pelaksana..."
                class="block w-full pl-11 pr-4 py-3 bg-[#24382d] border border-white/5 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-lg placeholder-slate-500 font-medium">
        </div>

        <div class="bg-[#24382d] rounded-2xl shadow-lg border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-[#1e2f25]">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-400">TANGGAL & KEGIATAN</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">KATEGORI & UNIT</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">LOKASI & KONDISI</th>
                            <th class="px-6 py-4 text-center font-black text-slate-400">VERIFIKASI</th>
                            <th class="px-6 py-4 text-center font-black text-slate-400">VISUAL</th>
                            <th class="px-6 py-4 text-right font-black text-slate-400">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($pam_sdos as $item)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-200 text-sm tracking-normal normal-case">{{ $item->nama_kegiatan }}</div>
                                <div class="text-slate-400 font-medium">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d M Y') }}</div>
                                
                                @if($item->batas_waktu)
                                <div class="mt-2 text-[10px] font-bold text-rose-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Batas Akhir: {{ \Carbon\Carbon::parse($item->batas_waktu)->format('d M Y') }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-[#1e2f25] text-emerald-400 rounded-lg font-bold border border-white/5">{{ $item->kategori_pam }}</span>
                                <div class="text-slate-400 mt-2 font-bold tracking-normal normal-case">PIC: <span class="text-slate-300">{{ $item->pelaksana }}</span></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-300 tracking-normal normal-case">{{ $item->lokasi }}</div>
                                <div class="mt-2">
                                    @if($item->status == 'Aman')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 italic">
                                        ● TERKENDALI
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-rose-500/10 text-rose-400 border border-rose-500/20 italic">
                                        ● {{ strtoupper($item->status) }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $vStatus = [
                                'disetujui' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                'ditolak' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
                                'pending' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-lg font-black text-[9px] border {{ $vStatus[$item->status_verifikasi] ?? 'bg-white/5 text-slate-400 border-white/10' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->foto_dokumentasi)
                                <img class="h-10 w-10 rounded-lg object-cover border border-white/10 shadow-sm mx-auto hover:scale-150 transition-transform cursor-pointer" src="{{ asset('storage/' . $item->foto_dokumentasi) }}">
                                @else
                                <span class="text-slate-500 font-bold italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('reports.pam-sdo.satuan', $item->id) }}" target="_blank" class="p-2 bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 hover:text-sky-300 rounded-lg transition-all border border-sky-500/20" title="Cetak PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-lg font-bold shadow-lg shadow-emerald-600/20 transition-all active:scale-95 text-[10px] tracking-widest border border-emerald-500/50">
                                        VERIFIKASI
                                    </button>
                                    @elseif(auth()->id() === $item->user_id)
                                    <button wire:click="edit({{ $item->id }})" class="p-2 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 hover:text-emerald-300 border border-emerald-500/20 rounded-lg transition-all" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus log pengamanan ini?" class="p-2 bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300 border border-rose-500/20 rounded-lg transition-all" title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-[#1e2f25] rounded-full flex items-center justify-center border-2 border-dashed border-white/10 mb-4">
                                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Log Pengamanan Belum Terinput</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-[#1e2f25] border-t border-white/5">
                {{ $pam_sdos->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto" x-data="{ open: true }">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0f1713]/80 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative bg-[#24382d] rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-white/10 animate-in fade-in zoom-in duration-200">
                <div class="bg-[#1e2f25] px-8 py-6 border-b border-white/5 flex justify-between items-center shadow-lg shadow-emerald-600/10">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">LOG AKTIVITAS PENGAMANAN</h3>
                        <p class="text-slate-400 text-xs mt-1">Laporan harian PAM SDO unit kerja intelijen.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Agenda Kegiatan</label>
                                <input type="text" wire:model="nama_kegiatan" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold uppercase tracking-tight transition-all">
                                @error('nama_kegiatan') <span class="text-rose-400 text-[10px] font-bold mt-1 uppercase block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Giat</label>
                                    <input type="date" wire:model="tanggal_kegiatan" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all [color-scheme:dark]">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori PAM</label>
                                    <select wire:model="kategori_pam" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                        <option value="">-- PILIH --</option>
                                        <option value="Pengamanan Personil">PERSONIL</option>
                                        <option value="Pengamanan Materiil">MATERIIL</option>
                                        <option value="Pengamanan Informasi">INFORMASI</option>
                                        <option value="Pengamanan Kegiatan">KEGIATAN</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Lokasi Koordinat/Giat</label>
                                <input type="text" wire:model="lokasi" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-[#182a20] rounded-2xl border border-white/5 shadow-inner">
                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-4 text-center">VERIFIKASI LOG</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'VALID', 'ditolak' => 'REJECT'] as $key => $label)
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" wire:model="status_verifikasi" value="{{ $key }}" class="hidden peer">
                                        <div class="text-center py-2 text-[10px] font-black rounded-lg border border-white/10 text-slate-400 peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 transition-all">
                                            {{ $label }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Personil Pelaksana (PIC)</label>
                                <input type="text" wire:model="pelaksana" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold transition-all" placeholder="Nama Petugas Lapangan">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Keterangan Hasil Monitoring</label>
                                <textarea wire:model="keterangan" rows="3" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 resize-none transition-all" placeholder="Uraikan detail hasil pengamanan..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Situasi</label>
                                    <select wire:model="status" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-black transition-all">
                                        <option value="Aman">AMAN / KONDUSIF</option>
                                        <option value="Ada Ancaman">TERINDIKASI ANCAMAN</option>
                                        <option value="Terkendali">DALAM PENGENDALIAN</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Batas Waktu (Deadline)
                                    </label>
                                    <input type="date" wire:model="batas_waktu" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-emerald-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold transition-all [color-scheme:dark]">
                                </div>
                            </div>

                            <div class="p-5 bg-[#1e2f25] border-2 border-dashed border-white/10 rounded-2xl">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 italic text-center">Dokumentasi Giat Lapangan</label>
                                <div class="flex items-center gap-6">
                                    <div class="h-20 w-24 rounded-xl bg-[#182a20] shadow-md border border-white/5 flex items-center justify-center overflow-hidden shrink-0">
                                        @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="object-cover h-full w-full">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="object-cover h-full w-full">
                                        @else
                                        <svg class="w-10 h-10 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" wire:model="foto" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer transition-all w-full">
                                        <div wire:loading wire:target="foto" class="text-[9px] text-emerald-400 font-black animate-pulse mt-2 uppercase tracking-widest">Uploading Document...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-[#1e2f25]/50 border-t border-white/5 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-widest transition-colors">BATAL</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-12 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2 border border-transparent">
                        <span wire:loading.remove wire:target="store">SIMPAN LOG PAM SDO</span>
                        <span wire:loading wire:target="store" class="animate-spin h-3 w-3 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>