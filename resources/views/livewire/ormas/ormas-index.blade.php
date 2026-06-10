<div class="-m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 bg-[#182a20] min-h-[calc(100vh-4rem)] relative text-slate-200">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-[#24382d] p-6 rounded-2xl shadow-lg border border-white/5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">Pengawasan Ormas & LSM</h2>
                    <p class="text-sm text-slate-400 font-medium tracking-wide">Database Organisasi Kemasyarakatan & Status Legalitas Terpadu</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.ormas') }}" target="_blank"
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
                        Input Ormas Baru
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
                placeholder="Cari nama organisasi, nama pimpinan, atau nomor SK..."
                class="block w-full pl-11 pr-4 py-3 bg-[#24382d] border border-white/5 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-lg placeholder-slate-500 font-medium">
        </div>

        <div class="bg-[#24382d] rounded-2xl shadow-lg border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-[#1e2f25]">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-400">LOGO</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">IDENTITAS ORGANISASI</th>
                            <th class="px-6 py-4 text-left font-black text-slate-400">LEGALITAS & MONITORING</th>
                            <th class="px-6 py-4 text-center font-black text-slate-400">VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-400">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($ormas as $item)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative inline-block group-hover:scale-105 transition-transform duration-300">
                                    @if($item->foto_lambang)
                                    <img class="h-14 w-14 rounded-xl object-contain bg-white border border-white/10 p-1 shadow-sm mx-auto" src="{{ asset('storage/' . $item->foto_lambang) }}">
                                    @else
                                    <div class="h-14 w-14 rounded-xl bg-[#1e2f25] flex items-center justify-center text-slate-500 border border-dashed border-white/10 mx-auto">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-200 text-sm tracking-normal normal-case">{{ strtoupper($item->nama_organisasi) }}</div>
                                <div class="text-emerald-400 font-bold tracking-normal normal-case flex items-center gap-1 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $item->nama_pimpinan }}
                                </div>
                                <div class="mt-2 flex flex-col gap-1">
                                    <span class="px-2 py-0.5 rounded-lg bg-[#1e2f25] text-slate-300 border border-white/5 font-black text-[9px] w-fit">{{ $item->bentuk_organisasi }}</span>
                                    <span class="text-[9px] text-slate-400 font-bold">{{ Str::limit($item->kegiatan_utama, 30) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-300 tracking-normal normal-case">{{ $item->status_legalitas }}</div>
                                <div class="text-slate-400 font-medium tracking-normal normal-case mb-2">SK: {{ $item->nomor_sk ?? 'DALAM PROSES' }}</div>
                                
                                @if($item->batas_waktu)
                                <div class="mb-2 text-[10px] font-bold text-rose-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Batas SK/Pantau: {{ \Carbon\Carbon::parse($item->batas_waktu)->format('d M Y') }}
                                </div>
                                @endif

                                @php
                                $pStatus = [
                                'aktif' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                'waspada' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                                'dibekukan' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full font-black border {{ $pStatus[$item->status_pengawasan] ?? 'bg-white/5 text-slate-400 border-white/10' }}">
                                    • {{ strtoupper($item->status_pengawasan) }}
                                </span>
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
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('reports.ormas.satuan', $item->id) }}" target="_blank" class="p-2 bg-sky-500/10 text-sky-400 hover:bg-sky-500/20 hover:text-sky-300 border border-sky-500/20 rounded-lg transition-all" title="Cetak PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-lg font-bold shadow-lg shadow-emerald-600/20 transition-all active:scale-95 text-[10px] tracking-widest border border-emerald-500/50">
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
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data ormas ini dari sistem?" class="p-2 bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 hover:text-rose-300 border border-rose-500/20 rounded-lg transition-all" title="Hapus Data">
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
                                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Database Ormas Masih Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-[#1e2f25] border-t border-white/5">
                {{ $ormas->links() }}
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
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">
                            {{ $is_edit ? 'Form Pembaruan Database Ormas' : 'Registrasi Ormas / LSM Baru' }}
                        </h3>
                        <p class="text-slate-400 text-xs mt-1">Sertakan data pimpinan dan SK yang masih berlaku sesuai Akta Notaris/AHU.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-8 py-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                    @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl">
                        <div class="flex items-center gap-2 mb-2 text-rose-400 font-bold text-xs uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Periksa Kembali Inputan
                        </div>
                        <ul class="list-disc list-inside text-[10px] text-rose-300 font-medium">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Organisasi *</label>
                                <input type="text" wire:model="nama_organisasi" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pimpinan / Ketua Umum *</label>
                                <input type="text" wire:model="nama_pimpinan" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Sekretariat Utama *</label>
                                <textarea wire:model="alamat_sekretariat" rows="3" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 resize-none transition-all"></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kegiatan Utama Organisasi *</label>
                                <textarea wire:model="kegiatan_utama" rows="3" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 resize-none transition-all" placeholder="Jelaskan fokus kegiatan organisasi..."></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Afiliasi / Induk Organisasi</label>
                                <input type="text" wire:model="afiliasi" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Jika ada (Contoh: GP Ansor Pusat)">
                            </div>

                            @if(auth()->user()->role === 'admin' && $is_edit)
                            <div class="p-5 bg-[#182a20] rounded-2xl border border-white/5 shadow-inner">
                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-4 text-center">Otoritas Validasi Intelijen</label>
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
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Bentuk Org. *</label>
                                    <select wire:model="bentuk_organisasi" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                        <option value="">-- PILIH --</option>
                                        <option value="Ormas">Ormas</option>
                                        <option value="LSM">LSM</option>
                                        <option value="Yayasan">Yayasan</option>
                                        <option value="Perkumpulan">Perkumpulan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jlh. Anggota</label>
                                    <input type="number" wire:model="jumlah_anggota" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Legalitas *</label>
                                    <input type="text" wire:model="status_legalitas" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Berbadan Hukum">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Pengawasan</label>
                                    <select wire:model="status_pengawasan" class="w-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold rounded-xl text-sm focus:ring-1 focus:ring-emerald-500 px-4 py-3 uppercase tracking-tighter transition-all">
                                        <option value="aktif">AKTIF OPERASIONAL</option>
                                        <option value="waspada">DALAM PANTAUAN</option>
                                        <option value="dibekukan">TIDAK AKTIF/DIBEKUKAN</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor SK / AHU</label>
                                    <input type="text" wire:model="nomor_sk" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-all" placeholder="Nomor AHU-XXXXX">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Masa Berlaku SK / Pantau</label>
                                    <input type="date" wire:model="batas_waktu" class="w-full bg-[#1e2f25] border border-white/10 rounded-xl text-sm text-emerald-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 font-bold transition-all [color-scheme:dark]">
                                </div>
                            </div>

                            <div class="p-5 bg-[#1e2f25] border-2 border-dashed border-white/10 rounded-2xl">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Identitas Visual (Lambang Ormas)</label>
                                <div class="flex items-center gap-6">
                                    <div class="h-20 w-20 rounded-xl bg-white shadow-md border border-white/10 flex items-center justify-center overflow-hidden p-1 shrink-0">
                                        @if ($foto_lambang)
                                        <img src="{{ $foto_lambang->temporaryUrl() }}" class="object-contain h-full w-full">
                                        @elseif ($old_foto)
                                        <img src="{{ asset('storage/' . $old_foto) }}" class="object-contain h-full w-full">
                                        @else
                                        <svg class="w-10 h-10 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" wire:model="foto_lambang" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer transition-all w-full">
                                        <div wire:loading wire:target="foto_lambang" class="text-[9px] text-emerald-400 font-black animate-pulse mt-2 uppercase">Uploading Emblem...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-[#1e2f25]/50 border-t border-white/5 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showModal', false)" class="px-6 py-2.5 text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-widest transition-colors">Batal</button>
                    <button type="button" wire:click="store" wire:loading.attr="disabled" class="px-10 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95 flex items-center gap-2 border border-transparent">
                        <span wire:loading.remove wire:target="store">ARSIPKAN DATA ORGANISASI</span>
                        <span wire:loading wire:target="store" class="animate-spin h-4 w-4 border-2 border-white/20 border-t-white rounded-full"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>