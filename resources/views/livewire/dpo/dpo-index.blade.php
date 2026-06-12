<div class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] relative text-slate-200">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#24382d] p-6 rounded-2xl shadow-lg border border-white/5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-rose-500/10 rounded-xl text-rose-400 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">Daftar Pencarian Orang</h2>
                    <p class="text-sm text-slate-400 font-medium tracking-wide">Monitoring Buronan & Status Penegakan Hukum</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.dpo') }}" target="_blank"
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
                        Tambah Data
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
                placeholder="Cari nama buronan, kasus spesifik, atau ciri fisik..."
                class="block w-full pl-11 pr-4 py-3 bg-[#24382d] border border-white/5 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-lg placeholder-slate-500 font-medium">
        </div>

        <div class="bg-[#24382d] rounded-2xl shadow-lg border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-[#1e2f25]">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-400">PROFIL</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">IDENTITAS DETAIL</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">PERKARA & STATUS</th>
                            <th class="px-6 py-4 text-center font-black text-slate-400 uppercase">VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-400">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($dpos as $item)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative inline-block">
                                    @if($item->foto)
                                    <img class="h-16 w-16 rounded-xl object-cover border border-white/10 shadow-md group-hover:scale-105 transition-transform"
                                        src="{{ asset('storage/' . $item->foto) }}" alt="Foto DPO">
                                    @else
                                    <div class="h-16 w-16 rounded-xl bg-[#1e2f25] flex items-center justify-center text-slate-500 border border-dashed border-white/10">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-[#24382d] shadow-sm {{ $item->status_pencarian == 'buron' ? 'bg-rose-500 animate-pulse' : 'bg-emerald-500' }}"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-200 text-sm tracking-normal normal-case">{{ strtoupper($item->nama_lengkap) }}</div>
                                <div class="text-slate-400 font-medium tracking-normal normal-case">Lahir: {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '-' }}</div>
                                <div class="text-rose-400 font-bold mt-1 tracking-normal normal-case italic line-clamp-1">Ciri: {{ $item->ciri_fisik ?? 'Tidak ada data khusus' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-300 tracking-normal normal-case">{{ $item->kasus }}</div>
                                <div class="flex gap-2 mt-2 items-center">
                                    <span class="px-2 py-0.5 rounded bg-[#1e2f25] text-slate-300 border border-white/5 font-bold uppercase">{{ $item->status_hukum }}</span>
                                    <span class="px-2 py-0.5 rounded font-black border {{ $item->status_pencarian == 'buron' ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' }}">
                                        {{ strtoupper($item->status_pencarian) }}
                                    </span>
                                </div>
                                @if($item->batas_waktu)
                                <div class="mt-2 text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Target Selesai: <span class="text-rose-400">{{ \Carbon\Carbon::parse($item->batas_waktu)->format('d M Y') }}</span>
                                </div>
                                @endif
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
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('reports.dpo.satuan', $item->id) }}" target="_blank"
                                        class="p-2 bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 hover:text-sky-300 rounded-lg transition-all border border-sky-500/20" title="Download Profil DPO">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-lg font-bold transition-all shadow-lg shadow-emerald-600/20 border border-emerald-500/50">
                                        VERIFIKASI
                                    </button>
                                    @elseif(auth()->id() === $item->user_id)
                                    <button wire:click="edit({{ $item->id }})" class="bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 p-2 rounded-lg transition-all border border-indigo-500/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Data ini bersifat krusial. Hapus data buronan ini?" class="bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300 p-2 rounded-lg transition-all border border-rose-500/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-[#1e2f25] rounded-full flex items-center justify-center border-2 border-dashed border-white/10 mb-4">
                                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Arsip DPO Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-[#1e2f25] border-t border-white/5">
                {{ $dpos->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0f1713]/80 backdrop-blur-sm transition-opacity" wire:click="$set('showModal', false)"></div>

            <div class="relative bg-[#24382d] rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-white/10">
                <div class="bg-[#1e2f25] px-8 py-6 border-b border-white/5 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">
                            {{ $is_edit ? 'Form Pembaruan Profil DPO' : 'Input Data Buronan Baru' }}
                        </h3>
                        <p class="text-slate-400 text-xs mt-1">Lengkapi seluruh atribut identitas buronan secara akurat.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Sesuai KTP</label>
                                <input type="text" wire:model="nama_lengkap" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Masukkan nama tanpa gelar jika perlu">
                                @error('nama_lengkap') <span class="text-rose-400 text-[10px] font-bold mt-1 uppercase block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tempat Lahir</label>
                                    <input type="text" wire:model="tempat_lahir" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all px-4 py-3">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Lahir</label>
                                    <input type="date" wire:model="tanggal_lahir" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all px-4 py-3 [color-scheme:dark]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ciri-Ciri Fisik Menonjol</label>
                                <textarea wire:model="ciri_fisik" rows="4" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 resize-none transition-all" placeholder="Tato, luka parut, tinggi badan, logat bahasa..."></textarea>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-[#182a20] rounded-2xl border border-white/5 shadow-inner">
                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-4 text-center">Verifikasi Administrasi</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'SETUJUI', 'ditolak' => 'TOLAK'] as $key => $label)
                                    <label class="flex-1 cursor-pointer">
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
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Perkara Hukum</label>
                                <input type="text" wire:model="kasus" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Contoh: Korupsi Pengadaan Barang 2024">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori Hukum</label>
                                    <select wire:model="status_hukum" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                        <option value="">-- Pilih --</option>
                                        <option value="Tersangka">TERSANGKA</option>
                                        <option value="Terdakwa">TERDAKWA</option>
                                        <option value="Terpidana">TERPIDANA</option>
                                        <option value="Saksi">SAKSI</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Pencarian</label>
                                    <select wire:model="status_pencarian" class="w-full bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold rounded-xl text-sm focus:ring-1 focus:ring-rose-500 px-4 py-3 uppercase tracking-tighter transition-all">
                                        <option value="buron">BURONAN</option>
                                        <option value="tertangkap">SUDAH TERTANGKAP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="border-t border-white/5 pt-4">
                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Target Waktu Penyelesaian (Deadline)
                                </label>
                                <input type="date" wire:model="batas_waktu" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all [color-scheme:dark]">
                                @error('batas_waktu') <span class="text-rose-400 text-[10px] font-bold mt-1 uppercase block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Profil Visual (Foto Terbaru)</label>
                                <div class="p-4 bg-[#1e2f25] border-2 border-dashed border-white/10 rounded-2xl flex flex-col items-center">
                                    <div class="relative group h-32 w-32 mb-4">
                                        @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl border border-white/10 shadow-lg">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="h-full w-full object-cover rounded-xl border border-white/10 shadow-lg">
                                        @else
                                        <div class="h-full w-full bg-[#182a20] rounded-xl flex items-center justify-center text-slate-500 border border-white/5">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        @endif
                                        <div class="absolute inset-0 bg-[#0f1713]/60 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                            <p class="text-white text-[9px] font-black">GANTI FOTO</p>
                                        </div>
                                        <input type="file" wire:model="foto" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                    <div wire:loading wire:target="foto" class="text-[9px] text-emerald-400 font-black animate-pulse uppercase">Syncing to cloud...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-[#1e2f25]/50 border-t border-white/5 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-xs font-black text-slate-400 hover:text-white transition-colors uppercase tracking-widest">
                        Batal
                    </button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-10 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black rounded-xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95 flex items-center gap-2 border border-transparent">
                        <span wire:loading.remove wire:target="store">SIMPAN DATA DPO</span>
                        <span wire:loading wire:target="store" class="animate-spin h-4 w-4 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>