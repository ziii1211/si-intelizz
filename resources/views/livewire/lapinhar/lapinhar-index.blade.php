<div class="py-8 bg-slate-50 min-h-screen relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">LAPINHAR</h2>
                <p class="text-sm text-slate-500 font-medium">Laporan Informasi Harian & Analisa Intelijen</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reports.lapinhar') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all border border-slate-300">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>

                @if(\App\Models\PeriodePelaporan::isAktif())
                    <button wire:click="create"
                        class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-600/20 transition-all active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Laporan Baru
                    </button>
                @else
                    <div class="inline-flex items-center px-4 py-2.5 bg-rose-50 text-rose-700 border border-rose-200 text-xs font-black rounded-xl gap-2 shadow-sm">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        PORTAL INPUT DITUTUP
                    </div>
                @endif
            </div>
        </div>

        @if (session()->has('message'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl animate-pulse">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold">{{ session('message') }}</span>
        </div>
        @endif

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                placeholder="Cari nomor surat, peristiwa, atau bidang intelijen..."
                class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl leading-5 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all shadow-sm">
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 uppercase tracking-tighter text-[11px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-black text-slate-500">IDENTITAS SURAT</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500">BIDANG</th>
                            <th class="px-6 py-4 text-left font-black text-slate-500 w-1/3">ISI PERISTIWA</th>
                            <th class="px-6 py-4 text-center font-black text-slate-500">STATUS VERIFIKASI</th>
                            <th class="px-6 py-4 text-right font-black text-slate-500">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($lapinhars as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-black text-slate-800">{{ $item->tanggal_surat->format('d/m/Y') }}</div>
                                <div class="text-slate-400 font-medium">{{ $item->nomor_surat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold border border-slate-200">
                                    {{ $item->bidang }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700 font-semibold line-clamp-2 italic tracking-normal normal-case">{{ $item->peristiwa }}</div>
                                <div class="text-green-600 font-bold mt-1 tracking-widest">SUMBER: {{ $item->sumber_informasi }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $statusClasses = [
                                'disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'ditolak' => 'bg-rose-50 text-rose-600 border-rose-200',
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full font-black border {{ $statusClasses[$item->status_verifikasi] ?? 'bg-slate-50' }}">
                                    {{ strtoupper($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('reports.lapinhar.satuan', $item->id) }}" target="_blank"
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Download PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit({{ $item->id }})" class="bg-slate-800 hover:bg-black text-white px-3 py-1.5 rounded-lg font-bold transition-all">
                                        VERIFIKASI
                                    </button>
                                    @elseif(auth()->id() === $item->user_id)
                                    <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif

                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus dokumen intelijen ini?" class="text-rose-400 hover:text-rose-600 p-2 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-slate-400 font-medium">Belum ada arsip LAPINHAR yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $lapinhars->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed z-[100] inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200">
                <div class="bg-green-50 px-6 py-4 border-b border-green-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-green-800 uppercase tracking-tight">
                        {{ $is_edit ? 'Edit Laporan' : 'Laporan Baru' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-green-500 hover:text-green-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="store">
                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Nomor Surat</label>
                                <input type="text" wire:model="nomor_surat" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                @error('nomor_surat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Tanggal Surat</label>
                                <input type="date" wire:model="tanggal_surat" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                @error('tanggal_surat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Sumber Informasi</label>
                                <input type="text" wire:model="sumber_informasi" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                @error('sumber_informasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Bidang</label>
                                <input type="text" wire:model="bidang" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                @error('bidang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Peristiwa</label>
                            <textarea wire:model="peristiwa" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5"></textarea>
                            @error('peristiwa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Pendapat</label>
                            <textarea wire:model="pendapat" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5"></textarea>
                            @error('pendapat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Status Keamanan</label>
                            <select wire:model="status" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-green-500 px-4 py-2.5">
                                <option value="rahasia">RAHASIA</option>
                                <option value="biasa">BIASA</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        @if(auth()->user()->role === 'admin' && $is_edit)
                        <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
                            <label class="block text-xs font-black text-amber-800 uppercase tracking-widest mb-1">Status Verifikasi (Khusus Admin)</label>
                            <select wire:model="status_verifikasi" class="w-full bg-white border-amber-300 rounded-xl text-sm focus:ring-amber-500 px-4 py-2.5">
                                <option value="pending">PENDING</option>
                                <option value="disetujui">DISETUJUI</option>
                                <option value="ditolak">DITOLAK</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2 text-sm font-bold text-slate-500 hover:text-slate-700">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-black rounded-xl shadow-lg transition-all">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>