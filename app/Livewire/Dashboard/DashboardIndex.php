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

        $periode = PeriodePelaporan::first() ?? new PeriodePelaporan();
        $periode->tanggal_buka = $this->tanggal_buka;
        $periode->tanggal_tutup = $this->tanggal_tutup;
        $periode->save();

        $this->showPeriodeModal = false;
        session()->flash('message', 'Periode Pelaporan berhasil diatur!');
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
            $now = Carbon::now()->format('Y-m-d');
            if ($now >= $periode->tanggal_buka && $now <= $periode->tanggal_tutup) {
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