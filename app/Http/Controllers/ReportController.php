<?php

namespace App\Http\Controllers;

use App\Models\Dpo;
use App\Models\Wna;
use App\Models\Ormas;
use App\Models\PamSdo;
use App\Models\Lapinhar;
use App\Models\JmsActivity;
use App\Models\Kerawanan; // <-- [DITAMBAHKAN] Import model Kerawanan
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * LAPINHAR (Laporan Informasi Harian)
     */
    public function cetakLapinhar()
    {
        $data = Lapinhar::latest()->get();
        $pdf = Pdf::loadView('reports.lapinhar-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Lapinhar.pdf');
    }

    public function cetakLapinharSatuan($id)
    {
        $item = Lapinhar::findOrFail($id);
        $pdf = Pdf::loadView('reports.lapinhar-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Informasi-' . $id . '.pdf');
    }

    /**
     * DPO (Daftar Pencarian Orang)
     */
    public function cetakDpo()
    {
        $data = Dpo::latest()->get();
        $pdf = Pdf::loadView('reports.dpo-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-DPO.pdf');
    }

    public function cetakDpoSatuan($id)
    {
        $item = Dpo::findOrFail($id);
        $pdf = Pdf::loadView('reports.dpo-tunggal-pdf', compact('item'))->setPaper('a4', 'portrait');
        return $pdf->stream('Lembar-DPO-' . $item->nama_lengkap . '.pdf');
    }

    /**
     * WNA (Pengawasan Orang Asing)
     */
    public function cetakWna()
    {
        $data = Wna::latest()->get();
        $pdf = Pdf::loadView('reports.wna-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-WNA.pdf');
    }

    public function cetakWnaSatuan($id)
    {
        $item = Wna::findOrFail($id);
        $pdf = Pdf::loadView('reports.wna-tunggal-pdf', compact('item'));
        return $pdf->stream('Biodata-WNA-' . $item->nama_lengkap . '.pdf');
    }

    /**
     * ORMAS & PAKEM
     */
    public function cetakOrmas()
    {
        $data = Ormas::latest()->get();
        $pdf = Pdf::loadView('reports.ormas-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-Ormas.pdf');
    }

    public function cetakOrmasSatuan($id)
    {
        $item = Ormas::findOrFail($id);
        $pdf = Pdf::loadView('reports.ormas-tunggal-pdf', compact('item'));
        return $pdf->stream('Profil-Ormas-' . $item->nama_organisasi . '.pdf');
    }

    /**
     * PAM SDO (Pengamanan Sumber Daya Organisasi)
     */
    public function cetakPamSdo()
    {
        $data = PamSdo::latest()->get();
        $pdf = Pdf::loadView('reports.pam-sdo-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Giat-PAM-SDO.pdf');
    }

    public function cetakPamSdoSatuan($id)
    {
        $item = PamSdo::findOrFail($id);
        $pdf = Pdf::loadView('reports.pam-sdo-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Giat-PAM-' . $id . '.pdf');
    }

    /**
     * JMS (Jaksa Masuk Sekolah)
     */
    public function cetakJms()
    {
        $data = JmsActivity::latest()->get();
        $pdf = Pdf::loadView('reports.jms-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Kegiatan-JMS.pdf');
    }

    public function cetakJmsSatuan($id)
    {
        $item = JmsActivity::findOrFail($id);
        $pdf = Pdf::loadView('reports.jms-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Kegiatan-JMS-' . $id . '.pdf');
    }

   /**
     * GRAFIK PEMETAAN INTELIJEN
     */
    public function cetakPemetaan(Request $request)
    {
        // 1. Ambil data gambar grafik Base64 dari dashboard
        $chartImage = $request->input('chart_image'); 

        // 2. Hitung jumlah data riil langsung dari semua model/menu aplikasi
        $countLapinhar = \App\Models\Lapinhar::count();
        $countDpo      = \App\Models\Dpo::count();
        $countWna      = \App\Models\Wna::count();
        $countOrmas    = \App\Models\Ormas::count();
        $countPamSdo   = \App\Models\PamSdo::count();
        $countJms      = \App\Models\JmsActivity::count();

        // 3. Susun data menjadi array terstruktur untuk tabel laporan skripsi
        $dataPemetaan = [
            [
                'modul' => 'Laporan Informasi Harian (LAPINHAR)', 
                'jumlah' => $countLapinhar, 
                'keterangan' => \App\Models\Lapinhar::where('status_verifikasi', 'pending')->count() . ' Menunggu Verifikasi'
            ],
            [
                'modul' => 'Daftar Pencarian Orang (DPO)', 
                'jumlah' => $countDpo, 
                'keterangan' => \App\Models\Dpo::where('status_pencarian', 'buron')->count() . ' Aktif Terpeta'
            ],
            [
                'modul' => 'Pengawasan Orang Asing (WNA)', 
                'jumlah' => $countWna, 
                'keterangan' => 'Dokumen & Izin Tinggal Terpantau'
            ],
            [
                'modul' => 'Organisasi Kemasyarakatan (ORMAS)', 
                'jumlah' => $countOrmas, 
                'keterangan' => 'Lembaga/Organisasi Terdaftar'
            ],
            [
                'modul' => 'Pengamanan Sumber Daya Organisasi (PAM SDO)', 
                'jumlah' => $countPamSdo, 
                'keterangan' => 'Kegiatan Pengamanan Internal/Eksternal'
            ],
            [
                'modul' => 'Jaksa Masuk Sekolah (JMS)', 
                'jumlah' => $countJms, 
                'keterangan' => 'Giat Sosialisasi Penerangan Hukum'
            ],
        ];

        // [PERBAIKAN 1] Mengganti periode analisis menjadi tanggal, bulan, dan tahun saat ini secara otomatis
        $periode = \Carbon\Carbon::now()->translatedFormat('d F Y');
        
        // [PERBAIKAN 3] Penguatan narasi analisis intelijen yang komprehensif dan detail untuk skripsi
        $analisis = "Berdasarkan kompilasi data kuantitatif serta visualisasi grafik sebaran operasional di atas, dapat dianalisis bahwa dinamika aktivitas intelijen di wilayah hukum Kejaksaan Negeri Banjarmasin berjalan secara fluktuatif namun terkendali. Tingginya volume record pada sektor Laporan Informasi Harian (LAPINHAR) mencerminkan optimalnya fungsi deteksi dini (early detection) dan cegah dini yang dilakukan oleh personel intelijen di lapangan dalam menjaring ambang gangguan. Secara korelatif, akumulasi data Daftar Pencarian Orang (DPO) yang masih aktif menuntut peningkatan intensitas koordinasi lintas sektoral bersama instansi penegak hukum lainnya. Pengawasan komprehensif pada klaster Orang Asing (WNA) serta pemantauan administratif terhadap Organisasi Kemasyarakatan (ORMAS) tetap diposisikan sebagai pilar preventif guna meminimalisir potensi destabilisasi di bidang Ideologi, Politik, Ekonomi, Sosial, Budaya, Pertahanan, dan Keamanan (IPOLEKSOSBUDHANKAM). Rekapitulasi multi-modul terintegrasi ini secara strategis berfungsi sebagai instrumen dukung keputusan (decision support system) bagi pimpinan dalam menentukan skala prioritas operasi taktis lapangan, memetakan indeks kerawanan wilayah secara berkala, serta merumuskan langkah penanganan preventif-korektif guna mengeliminasi hakikat ancaman sebelum berkembang menjadi gangguan nyata.";

        // 4. Masukkan data ke dalam view laporan
        $pdf = Pdf::loadView('reports.pemetaan-pdf', compact('chartImage', 'dataPemetaan', 'periode', 'analisis'));
        
        // 5. Set ukuran kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // 6. Stream / Download PDF
        return $pdf->stream('Laporan_Pemetaan_Intelijen_' . date('Ymd') . '.pdf');
    }
}