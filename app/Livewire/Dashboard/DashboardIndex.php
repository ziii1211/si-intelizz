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

    /// --- FITUR BARU: LOGIC PENGECEKAN DEADLINE ---
    public function getApproachingDeadlines()
    {
        // Siapkan penampung kosong
        $deadlines = collect();

        // 1. Cek Deadline Lapinhar (Aman, sudah ada batas_waktu)
        $lapinhar = Lapinhar::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereBetween('batas_waktu', [Carbon::now(), Carbon::now()->addDays(3)])
            ->get()
            ->map(function ($item) {
                return [
                    'modul' => 'Lapinhar',
                    'judul' => $item->perihal ?? 'Laporan Harian Baru',
                    'batas_waktu' => $item->batas_waktu,
                    'sisa_hari' => Carbon::parse($item->batas_waktu)->diffInDays(Carbon::now()),
                    'url' => route('lapinhar.index')
                ];
            });
        $deadlines = $deadlines->merge($lapinhar);

        // 2. Cek Deadline DPO (Aman, sudah ada batas_waktu)
        $dpo = Dpo::where('status_verifikasi', 'pending')
            ->whereNotNull('batas_waktu')
            ->whereBetween('batas_waktu', [Carbon::now(), Carbon::now()->addDays(3)])
            ->get()
            ->map(function ($item) {
                return [
                    'modul' => 'DPO',
                    'judul' => 'Tersangka: ' . ($item->nama_tersangka ?? 'Anonim'),
                    'batas_waktu' => $item->batas_waktu,
                    'sisa_hari' => Carbon::parse($item->batas_waktu)->diffInDays(Carbon::now()),
                    'url' => route('dpo.index')
                ];
            });
        $deadlines = $deadlines->merge($dpo);

        // NOTE: Pengecekan WNA, Ormas, dan PAM SDO dinonaktifkan sementara 
        // karena tabel di database belum memiliki kolom 'batas_waktu'.
        // Jika nanti dosen meminta, tinggal tambahkan kolom tersebut via migration.

        // Urutkan dari yang paling mendesak (paling dekat dengan hari ini)
        return $deadlines->sortBy('batas_waktu')->values();
    }

    public function render()
    {
        $totalLapinhar = Lapinhar::count();
        $totalDpo = Dpo::where('status_pencarian', 'buron')->count();
        $totalOrmas = Ormas::where('status_pengawasan', 'aktif')->count();
        $totalWna = Wna::count();
        $latestLapinhar = Lapinhar::latest()->take(5)->get();
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

        // CEK STATUS PERIODE (Buka / Tutup)
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

        // --- FITUR BARU 1: EARLY WARNING SYSTEM WNA ---
        $wnaWarnings = Wna::whereNotNull('masa_berlaku_izin')
            ->where('masa_berlaku_izin', '<=', Carbon::now()->addDays(30)->format('Y-m-d'))
            ->orderBy('masa_berlaku_izin', 'asc')
            ->take(5)
            ->get();

        // --- FITUR BARU 2: DATA GRAFIK ANALITIK KOMPREHENSIF ---
$chartData = [
    // 1. DPO
    'dpo_buron' => Dpo::where('status_pencarian', 'buron')->count(),
    'dpo_tertangkap' => Dpo::where('status_pencarian', 'tertangkap')->count(),

    // 2. ORMAS
    'ormas_waspada' => Ormas::where('status_pengawasan', 'waspada')->count(),
    'ormas_dibekukan' => Ormas::where('status_pengawasan', 'dibekukan')->count(), // Atau 'aman' tergantung status di DB lo

    // 3. LAPINHAR
    'lapinhar_pending' => Lapinhar::where('status_verifikasi', 'pending')->count(),
    'lapinhar_selesai' => Lapinhar::where('status_verifikasi', 'disetujui')->count(),

    // 4. WNA (Logic: Warning jika masa berlaku < 30 hari)
    'wna_warning' => Wna::where('masa_berlaku_izin', '<=', Carbon::now()->addDays(30))->count(),
    'wna_aman' => Wna::where('masa_berlaku_izin', '>', Carbon::now()->addDays(30))->count(),

    // 5. PAM SDO
    'pam_berjalan' => PamSdo::where('status_verifikasi', 'pending')->count(),
    'pam_selesai' => PamSdo::where('status_verifikasi', 'disetujui')->count(),

    // 6. JAKSA MASUK SEKOLAH (JMS)
    'jms_terjadwal' => JmsActivity::where('status_verifikasi', 'pending')->count(),
    'jms_terlaksana' => JmsActivity::where('status_verifikasi', 'disetujui')->count(),
];

        // --- PANGGIL FUNGSI DEADLINE NOTIFIKASI ---
        $notifikasiDeadline = $this->getApproachingDeadlines();

        // Pass data ke View Dashboard, DAN pass Notifikasi ke Layout Utama (Header)
        return view('livewire.dashboard.dashboard', [
            'totalLapinhar' => $totalLapinhar,
            'totalDpo' => $totalDpo,
            'totalOrmas' => $totalOrmas,
            'totalWna' => $totalWna,
            'latestLapinhar' => $latestLapinhar,
            'lapinharAktif' => $lapinharAktif,
            'pending' => $pending,
            'totalPending' => $totalPending,
            'periode' => $periode,
            'isPeriodeAktif' => $isPeriodeAktif,
            'wnaWarnings' => $wnaWarnings,
            'chartData' => $chartData,
            'notifikasiDeadline' => $notifikasiDeadline // Data list notifikasi ini yang akan kita looping
        ])->layout('layouts.app', [
            'notifikasiDeadline' => $notifikasiDeadline // Pastikan Layout Header bisa membacanya
        ]);
    }
}