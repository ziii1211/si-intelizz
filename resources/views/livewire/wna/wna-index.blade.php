<div class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] relative text-slate-200">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#24382d] p-6 rounded-2xl shadow-lg border border-white/5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">Pengawasan WNA</h2>
                    <p class="text-sm text-slate-400 font-medium tracking-wide">Monitoring Aktivitas & Legalitas Orang Asing</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.wna') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95 border border-transparent">
                    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                @if(\App\Models\PeriodePelaporan::isAktif())
                    <button wire:click="create"
                        class="inline-flex items-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95 border border-transparent">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Input Data
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
                placeholder="Cari nama WNA, negara asal, atau nomor paspor..."
                class="block w-full pl-11 pr-4 py-3 bg-[#24382d] border border-white/5 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-lg placeholder-slate-500 font-medium">
        </div>

        <div class="bg-[#24382d] rounded-2xl shadow-lg border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-[#1e2f25]">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-400">PROFIL</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">IDENTITAS PASPOR</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">KUNJUNGAN & SPONSOR</th>
                            <th class="px-6 py-4 text-center font-black text-slate-400">STATUS VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-400">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($wnas as $item)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($item->foto)
                                    <img class="h-12 w-12 rounded-full object-cover border border-white/10 shadow-md" src="{{ asset('storage/' . $item->foto) }}">
                                    @else
                                    <div class="h-12 w-12 rounded-full bg-[#1e2f25] flex items-center justify-center text-slate-500 border border-white/10">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-black text-slate-200 text-sm tracking-normal normal-case">{{ strtoupper($item->nama_lengkap) }}</div>
                                        <div class="text-emerald-400 font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                            </svg>
                                            {{ $item->negara_asal }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-200">{{ $item->nomor_paspor }}</div>
                                <div class="text-slate-400 font-medium tracking-normal normal-case">Lahir: {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-300 tracking-normal normal-case">{{ $item->tujuan_kunjungan }}</div>
                                <div class="mt-1 flex flex-col gap-0.5">
                                    <span class="text-emerald-400 font-black">IZIN S.D: {{ \Carbon\Carbon::parse($item->masa_berlaku_izin)->format('d M Y') }}</span>
                                    <span class="text-slate-400 italic tracking-normal normal-case">Sponsor: {{ $item->sponsor ?? 'Mandiri' }}</span>
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
                                <span class="px-3 py-1 rounded-lg font-black border {{ $vStatus[$item->status_verifikasi] ?? 'bg-white/5 text-slate-400 border-white/10' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('reports.wna.satuan', $item->id) }}" target="_blank" class="p-2 bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 hover:text-sky-300 rounded-lg transition-all border border-sky-500/20" title="Cetak PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-all active:scale-95 text-[10px] tracking-widest border border-emerald-500/50 shadow-emerald-600/20">
                                        VERIFIKASI
                                    </button>
                                    @else
                                    <button wire:click="edit({{ $item->id }})" class="p-2 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 hover:text-emerald-300 border border-emerald-500/20 rounded-lg transition-all" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    @if(auth()->user()->role === 'admin' || auth()->id() === $item->user_id)
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data pengawasan WNA ini?" class="p-2 bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300 border border-rose-500/20 rounded-lg transition-all" title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-[#1e2f25] rounded-full flex items-center justify-center border-2 border-dashed border-white/10 mb-4">
                                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Basis Data WNA Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-[#1e2f25] border-t border-white/5">
                {{ $wnas->links() }}
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
                            {{ $is_edit ? 'Form Pembaruan Data WNA' : 'Registrasi Orang Asing Baru' }}
                        </h3>
                        <p class="text-slate-400 text-xs mt-1">Gunakan data Paspor/KITAS yang valid untuk input identitas.</p>
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
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Sesuai Paspor</label>
                                <input type="text" wire:model="nama_lengkap" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                @error('nama_lengkap') <span class="text-rose-400 text-[10px] font-bold mt-1 uppercase block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Negara Asal</label>
                                    <input type="text" wire:model="negara_asal" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Contoh: Amerika Serikat">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Paspor</label>
                                    <input type="text" wire:model="nomor_paspor" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tempat Lahir</label>
                                    <input type="text" wire:model="tempat_lahir" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Lahir</label>
                                    <input type="date" wire:model="tanggal_lahir" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all [color-scheme:dark]">
                                </div>
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-[#182a20] rounded-2xl border border-white/5 shadow-inner">
                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-4 text-center">Otoritas Verifikasi</label>
                                <div class="flex gap-2">
                                    @foreach(['pending' => 'PENDING', 'disetujui' => 'SETUJUI', 'ditolak' => 'TOLAK'] as $key => $label)
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
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tujuan Kunjungan</label>
                                <input type="text" wire:model="tujuan_kunjungan" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Contoh: Tenaga Kerja Asing, Wisata, Pendidikan">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sponsor/Penjamin</label>
                                    <input type="text" wire:model="sponsor" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="PT. Nama Perusahaan">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Masa Berlaku Izin</label>
                                    <input type="date" wire:model="masa_berlaku_izin" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-emerald-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold transition-all [color-scheme:dark]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Tinggal di Indonesia</label>
                                <textarea wire:model="tempat_tinggal" rows="3" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 resize-none transition-all" placeholder="Alamat lengkap hotel atau rumah tinggal..."></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Dokumentasi Wajah/Paspor</label>
                                <div class="p-4 bg-[#1e2f25] border-2 border-dashed border-white/10 rounded-2xl flex items-center gap-6">
                                    <div class="h-16 w-16 rounded-xl bg-[#182a20] border border-white/5 flex items-center justify-center overflow-hidden shrink-0">
                                        @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="object-cover h-full w-full">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="object-cover h-full w-full">
                                        @else
                                        <svg class="w-8 h-8 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" wire:model="foto" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer transition-all w-full">
                                        <div wire:loading wire:target="foto" class="text-[9px] text-emerald-400 font-black animate-pulse mt-2 uppercase">Syncing...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-[#1e2f25]/50 border-t border-white/5 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-widest transition-colors">Batal</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-10 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2 border border-transparent">
                        <span wire:loading.remove wire:target="store">SIMPAN DATA PENGAWASAN</span>
                        <span wire:loading wire:target="store" class="animate-spin h-3 w-3 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>