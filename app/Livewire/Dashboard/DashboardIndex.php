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

    // FUNGSI MEMBUKA MODAL (HANYA ADMIN)
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

    // FUNGSI MENYIMPAN PERIODE BUKA-TUTUP PORTAL
    public function simpanPeriode()
    {
        if (Auth::user()->role !== 'admin') return;

        // Validasi agar input tidak kosong dan tanggal tutup tidak mendahului tanggal buka
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

    // FUNGSI UNTUK MERESET / MENGHAPUS PERIODE
    public function resetPeriode()
    {
        if (Auth::user()->role !== 'admin') return;

        // Menghapus data pengaturan periode secara permanen
        PeriodePelaporan::truncate();

        // Reset variabel form input
        $this->tanggal_buka = null;
        $this->tanggal_tutup = null;
        $this->showPeriodeModal = false;

        session()->flash('message', 'Periode pelaporan berhasil direset, portal kini tertutup!');
    }

    public function render()
    {
        $totalLapinhar = Lapinhar::count();
        $totalDpo = Dpo::where('status_pencarian', 'buron')->count();
        $totalOrmas = Ormas::where('status_pengawasan', 'aktif')->count();
        $totalWna = Wna::count();
        $latestLapinhar = Lapinhar::latest()->take(5)->get();

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
            // Gunakan Carbon untuk pengecekan hari ini yang lebih akurat
            $now = Carbon::now()->startOfDay();
            $buka = Carbon::parse($periode->tanggal_buka)->startOfDay();
            $tutup = Carbon::parse($periode->tanggal_tutup)->endOfDay(); // Aktif sampai 23:59:59 pada tanggal tutup

            if ($now->between($buka, $tutup)) {
                $isPeriodeAktif = true;
            }
        }

        return view('livewire.dashboard.dashboard', [
            'totalLapinhar' => $totalLapinhar,
            'totalDpo' => $totalDpo,
            'totalOrmas' => $totalOrmas,
            'totalWna' => $totalWna,
            'latestLapinhar' => $latestLapinhar,
            'pending' => $pending,
            'totalPending' => $totalPending,
            'periode' => $periode,
            'isPeriodeAktif' => $isPeriodeAktif,
        ])->layout('layouts.app');
    }
}