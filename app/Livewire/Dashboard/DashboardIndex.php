<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Lapinhar;
use App\Models\Dpo;
use App\Models\Ormas;
use App\Models\Wna;
use App\Models\JmsActivity;
use App\Models\PamSdo;
use App\Models\PeriodePelaporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    public $showPeriodeModal = false;
    public $tanggal_buka;
    public $tanggal_tutup;

    public function aturPeriode()
    {
        if (Auth::user()->role !== 'admin') return;

        $periode = PeriodePelaporan::first();
        if ($periode) {
            $this->tanggal_buka = $periode->tanggal_buka;
            $this->tanggal_tutup = $periode->tanggal_tutup;
        }

        $this->showPeriodeModal = true;
    }

    public function simpanPeriode()
    {
        if (Auth::user()->role !== 'admin') return;

        $this->validate([
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
        ]);

        $periode = PeriodePelaporan::first() ?? new PeriodePelaporan();
        $periode->tanggal_buka = $this->tanggal_buka;
        $periode->tanggal_tutup = $this->tanggal_tutup;
        $periode->save();

        $this->showPeriodeModal = false;
        session()->flash('message', 'Periode Pelaporan berhasil diatur!');
    }

    public function resetPeriode()
    {
        if (Auth::user()->role !== 'admin') return;

        PeriodePelaporan::truncate();

        $this->tanggal_buka = null;
        $this->tanggal_tutup = null;
        $this->showPeriodeModal = false;

        session()->flash('message', 'Periode pelaporan berhasil direset, portal kini tertutup!');
    }

    public function getApproachingDeadlines()
    {
        $deadlines = collect();

        // 1. Cek Deadline Lapinhar
        $lapinhar = Lapinhar::where('status_verifikasi', 'pending')
            ->whereNotNull('tanggal_ditutup')
            ->whereBetween('tanggal_ditutup', [Carbon::now(), Carbon::now()->addDays(3)])
            ->get()
            ->map(function ($item) {
                return [
                    'modul' => 'Lapinhar',
                    'judul' => 'No. Surat: ' . $item->nomor_surat,
                    'batas_waktu' => $item->tanggal_ditutup,
                    'sisa_hari' => Carbon::parse($item->tanggal_ditutup)->diffInDays(Carbon::now()),
                    'url' => route('lapinhar.index')
                ];
            });
        $deadlines = $deadlines->merge($lapinhar);

        // 2. Cek Deadline DPO
        $dpo = Dpo::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereBetween('batas_waktu', [Carbon::now(), Carbon::now()->addDays(3)])
            ->get()
            ->map(function ($item) {
                return [
                    'modul' => 'DPO',
                    'judul' => 'Tersangka: ' . ($item->nama_lengkap ?? 'Anonim'),
                    'batas_waktu' => $item->batas_waktu,
                    'sisa_hari' => Carbon::parse($item->batas_waktu)->diffInDays(Carbon::now()),
                    'url' => route('dpo.index')
                ];
            });
        $deadlines = $deadlines->merge($dpo);

        return $deadlines->sortBy('batas_waktu')->values();
    }

    public function getLatestActivities()
    {
        $activities = collect();

        Lapinhar::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'LAPINHAR',
                'judul' => 'Bidang: ' . $item->bidang,
                'deskripsi' => Str::limit($item->peristiwa, 50),
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('lapinhar.index'),
                'warna' => 'text-blue-400'
            ]);
        });

        Dpo::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'DPO',
                'judul' => $item->nama_lengkap,
                'deskripsi' => 'Kasus: ' . Str::limit($item->kasus, 50),
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('dpo.index'),
                'warna' => 'text-rose-400'
            ]);
        });

        Ormas::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'ORMAS',
                'judul' => $item->nama_organisasi,
                'deskripsi' => 'Pimpinan: ' . $item->nama_pimpinan,
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('ormas.index'),
                'warna' => 'text-indigo-400'
            ]);
        });

        Wna::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'WNA',
                'judul' => $item->nama_lengkap,
                'deskripsi' => 'Asal: ' . $item->negara_asal,
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('wna.index'),
                'warna' => 'text-amber-400'
            ]);
        });

        PamSdo::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'PAM SDO',
                'judul' => $item->nama_kegiatan,
                'deskripsi' => 'Lokasi: ' . $item->lokasi,
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('pam-sdo.index'),
                'warna' => 'text-emerald-400'
            ]);
        });

        JmsActivity::latest()->take(5)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'modul' => 'JMS',
                'judul' => $item->nama_sekolah,
                'deskripsi' => 'Materi: ' . Str::limit($item->materi, 40),
                'tanggal' => $item->created_at,
                'status' => $item->status_verifikasi,
                'url' => route('jms.index'),
                'warna' => 'text-purple-400'
            ]);
        });

        return $activities->sortByDesc('tanggal')->take(6)->values();
    }

    // --- FUNGSI BARU: INTEGRATED EARLY WARNING SYSTEM ---
    public function getEarlyWarnings()
    {
        $warnings = collect();
        $threshold = Carbon::now()->addDays(30)->format('Y-m-d');

        // 1. Lapinhar (Filter berdasarkan tanggal_ditutup)
        Lapinhar::where('status_verifikasi', 'pending')
            ->whereNotNull('tanggal_ditutup')
            ->whereDate('tanggal_ditutup', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'LAPINHAR',
                    'nama' => 'No. Surat: ' . $item->nomor_surat,
                    'sub_text' => Str::limit($item->peristiwa, 35),
                    'deadline' => $item->tanggal_ditutup,
                    'url' => route('lapinhar.index'),
                    'badge' => 'bg-blue-500/20 text-blue-300 border-blue-500/30'
                ]);
            });

        // 2. DPO
        Dpo::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereDate('batas_waktu', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'DPO',
                    'nama' => $item->nama_lengkap,
                    'sub_text' => 'Kasus: ' . Str::limit($item->kasus, 35),
                    'deadline' => $item->batas_waktu,
                    'url' => route('dpo.index'),
                    'badge' => 'bg-rose-500/20 text-rose-300 border-rose-500/30'
                ]);
            });

        // 3. WNA
        Wna::where('status_verifikasi', 'pending')
            ->whereNotNull('masa_berlaku_izin')
            ->whereDate('masa_berlaku_izin', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'WNA',
                    'nama' => $item->nama_lengkap,
                    'sub_text' => 'Paspor: ' . $item->nomor_paspor,
                    'deadline' => $item->masa_berlaku_izin,
                    'url' => route('wna.index'),
                    'badge' => 'bg-amber-500/20 text-amber-300 border-amber-500/30'
                ]);
            });

        // 4. Ormas
        Ormas::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereDate('batas_waktu', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'ORMAS',
                    'nama' => $item->nama_organisasi,
                    'sub_text' => 'SK: ' . $item->nomor_sk,
                    'deadline' => $item->batas_waktu,
                    'url' => route('ormas.index'),
                    'badge' => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/30'
                ]);
            });

        // 5. PAM SDO
        PamSdo::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereDate('batas_waktu', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'PAM SDO',
                    'nama' => $item->nama_kegiatan,
                    'sub_text' => 'PIC: ' . $item->pelaksana,
                    'deadline' => $item->batas_waktu,
                    'url' => route('pam-sdo.index'),
                    'badge' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
                ]);
            });

        // 6. JMS
        JmsActivity::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereDate('batas_waktu', '<=', $threshold)
            ->get()->each(function($item) use ($warnings) {
                $warnings->push((object)[
                    'modul' => 'JMS',
                    'nama' => $item->nama_sekolah,
                    'sub_text' => 'Materi: ' . Str::limit($item->materi, 35),
                    'deadline' => $item->batas_waktu,
                    'url' => route('jms.index'),
                    'badge' => 'bg-purple-500/20 text-purple-300 border-purple-500/30'
                ]);
            });

        // Diurutkan dari deadline terdekat lalu ambil top 5 saja agar seimbang dengan UI
        return $warnings->sortBy('deadline')->take(5)->values();
    }

    public function render()
    {
        $totalLapinhar = Lapinhar::count();
        $totalDpo = Dpo::where('status_pencarian', 'buron')->count();
        $totalOrmas = Ormas::where('status_pengawasan', 'aktif')->count();
        $totalWna = Wna::count();
        $lapinharAktif = Lapinhar::where('status_verifikasi', 'pending')->take(3)->get();

        $pending = [
            'lapinhar' => Lapinhar::where('status_verifikasi', 'pending')->count(),
            'dpo'      => Dpo::where('status_verifikasi', 'pending')->count(),
            'wna'      => Wna::where('status_verifikasi', 'pending')->count(),
            'ormas'    => Ormas::where('status_verifikasi', 'pending')->count(),
            'jms'      => JmsActivity::where('status_verifikasi', 'pending')->count(),
            'pam'      => PamSdo::where('status_verifikasi', 'pending')->count(),
        ];
        $totalPending = array_sum($pending);

        $periode = PeriodePelaporan::first();
        $isPeriodeAktif = false;

        if ($periode && $periode->tanggal_buka && $periode->tanggal_tutup) {
            $now = Carbon::now()->startOfDay();
            $buka = Carbon::parse($periode->tanggal_buka)->startOfDay();
            $tutup = Carbon::parse($periode->tanggal_tutup)->endOfDay();

            if ($now->between($buka, $tutup)) {
                $isPeriodeAktif = true;
            }
        }

        $chartData = [
            'dpo_buron' => Dpo::where('status_pencarian', 'buron')->count(),
            'dpo_tertangkap' => Dpo::where('status_pencarian', 'tertangkap')->count(),
            'ormas_waspada' => Ormas::where('status_pengawasan', 'waspada')->count(),
            'ormas_dibekukan' => Ormas::where('status_pengawasan', 'dibekukan')->count(), 
            'lapinhar_pending' => Lapinhar::where('status_verifikasi', 'pending')->count(),
            'lapinhar_selesai' => Lapinhar::where('status_verifikasi', 'disetujui')->count(),
            'wna_warning' => Wna::where('masa_berlaku_izin', '<=', Carbon::now()->addDays(30))->count(),
            'wna_aman' => Wna::where('masa_berlaku_izin', '>', Carbon::now()->addDays(30))->count(),
            'pam_berjalan' => PamSdo::where('status_verifikasi', 'pending')->count(),
            'pam_selesai' => PamSdo::where('status_verifikasi', 'disetujui')->count(),
            'jms_terjadwal' => JmsActivity::where('status_verifikasi', 'pending')->count(),
            'jms_terlaksana' => JmsActivity::where('status_verifikasi', 'disetujui')->count(),
        ];

        $notifikasiDeadline = $this->getApproachingDeadlines();
        $latestActivities = $this->getLatestActivities();
        
        // Panggil fungsi gabungan Early Warning System
        $earlyWarnings = $this->getEarlyWarnings();

        return view('livewire.dashboard.dashboard', [
            'totalLapinhar' => $totalLapinhar,
            'totalDpo' => $totalDpo,
            'totalOrmas' => $totalOrmas,
            'totalWna' => $totalWna,
            'latestActivities' => $latestActivities,
            'lapinharAktif' => $lapinharAktif,
            'pending' => $pending,
            'totalPending' => $totalPending,
            'periode' => $periode,
            'isPeriodeAktif' => $isPeriodeAktif,
            'earlyWarnings' => $earlyWarnings, // Dioper ke view
            'chartData' => $chartData,
            'notifikasiDeadline' => $notifikasiDeadline 
        ])->layout('layouts.app', [
            'notifikasiDeadline' => $notifikasiDeadline 
        ]);
    }
}