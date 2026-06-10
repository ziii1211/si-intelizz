<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lapinhar;
use App\Models\Dpo;
use App\Models\PamSdo;
use App\Models\User;
use App\Notifications\PeringatanBatasWaktu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CekBatasWaktu extends Command
{
    protected $signature = 'app:cek-batas-waktu';
    protected $description = 'Mengecek batas waktu penanganan berkas intelijen (H-3) dan mengirim notifikasi';

    public function handle()
    {
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            $this->info('Tidak ada admin untuk dikirimi notifikasi.');
            return;
        }

        $targetDate = Carbon::now()->addDays(3)->toDateString();
        $hariIni = Carbon::now()->toDateString();

        // --- CEK LAPINHAR (Berdasarkan tanggal_ditutup dari Atur Periode) ---
        $lapinhars = Lapinhar::whereDate('tanggal_ditutup', '<=', $targetDate)
            ->whereDate('tanggal_ditutup', '>=', $hariIni)
            ->where('status_verifikasi', 'pending') // Hanya ingatkan jika status masih pending
            ->get();

        foreach ($lapinhars as $data) {
            $pesan = "Peringatan: Lapinhar No. {$data->nomor_surat} mendekati deadline ({$data->tanggal_ditutup})!";
            $url = '/lapinhar';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        // --- CEK DPO (Menggunakan batas_waktu) ---
        $dpos = Dpo::whereDate('batas_waktu', '<=', $targetDate)
            ->whereDate('batas_waktu', '>=', $hariIni)
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($dpos as $data) {
            $pesan = "Peringatan: Penanganan DPO {$data->nama_lengkap} mendekati deadline!";
            $url = '/dpo';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        // --- CEK PAM SDO (Menggunakan batas_waktu) ---
        $pamsdos = PamSdo::whereDate('batas_waktu', '<=', $targetDate)
            ->whereDate('batas_waktu', '>=', $hariIni)
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($pamsdos as $data) {
            $pesan = "Peringatan: Kegiatan PAM SDO {$data->nama_kegiatan} mendekati deadline!";
            $url = '/pam-sdo';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        $wnas = \App\Models\Wna::whereDate('masa_berlaku_izin', '<=', $targetDate)
            ->whereDate('masa_berlaku_izin', '>=', $hariIni)
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($wnas as $data) {
            $pesan = "Peringatan: Izin tinggal WNA an. {$data->nama_lengkap} segera habis!";
            $url = '/wna';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        // --- CEK ORMAS (Masa Berlaku SK / Pemantauan) ---
        $ormas = \App\Models\Ormas::whereDate('batas_waktu', '<=', $targetDate)
            ->whereDate('batas_waktu', '>=', $hariIni)
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($ormas as $data) {
            $pesan = "Peringatan: Masa berlaku SK / Pemantauan Ormas {$data->nama_organisasi} segera berakhir!";
            $url = '/ormas';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        // --- CEK JMS ---
        $jms = \App\Models\JmsActivity::whereDate('batas_waktu', '<=', $targetDate)
            ->whereDate('batas_waktu', '>=', $hariIni)
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($jms as $data) {
            $pesan = "Peringatan: Jadwal/Laporan JMS di {$data->nama_sekolah} mendekati deadline!";
            $url = '/jms';
            Notification::send($admins, new PeringatanBatasWaktu($pesan, $url));
        }

        $this->info('Pengecekan batas waktu selesai dijalankan!');
    }
}