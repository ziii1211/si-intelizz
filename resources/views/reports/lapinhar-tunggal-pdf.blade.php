<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Informasi Harian - {{ $item->nomor_surat }}</title>
    <style>
        /* Pengaturan Dasar Dokumen */
        @page {
            margin: 1.5cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Header / Kop Surat */
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 5px;
            top: 5px;
            width: 75px; 
        }

        .header h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.3;
            letter-spacing: 1px; /* Memberi sedikit jarak antar huruf biar lebih tegas */
        }

        /* Teks Alamat di Kop Surat */
        .header p {
            margin: 4px 0 0 0;
            font-size: 9pt; /* Ukuran diperkecil agar pas dan rapi */
            line-height: 1.2;
            text-align: center; /* Rata tengah */
        }

        /* Box Informasi Nomor & Perihal */
        .ref-box {
            margin-bottom: 30px;
        }

        .ref-box table {
            width: 100%;
            border: none;
        }

        .ref-box td {
            vertical-align: top;
            padding: 2px 0;
        }

        /* Judul Dokumen */
        .title-doc {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        /* Struktur Konten I, II, III, IV */
        .section-container {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .section-content {
            text-align: justify;
            margin-left: 45px;
            display: block;
        }

        /* Bagian Tanda Tangan */
        .ttd-wrapper {
            margin-top: 40px;
            width: 100%;
            clear: both;
        }

        .ttd-box {
            float: right;
            width: 50%;
            text-align: center;
        }

        .ttd-box p {
            margin: 0;
            line-height: 1.4;
        }

        .space-ttd {
            height: 80px;
        }

        .nip-text {
            margin-top: 2px;
            font-size: 11pt;
        }

        /* Helper untuk cetak PDF */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h3>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <p>
            JALAN BRIG JEND H. HASAN BASRI NO. 3 RW.002 <br>
            KELURAHAN PANGERAN KECAMATAN BANJARMASIN UTARA
        </p>
    </div>

    <div class="ref-box">
        <table>
            <tr>
                <td width="15%">Nomor</td>
                <td width="2%">:</td>
                <td>{{ $item->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>{{ strtoupper($item->status ?? 'RAHASIA') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong>LAPORAN INFORMASI HARIAN (LAPINHAR) BIDANG {{ strtoupper($item->bidang) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="title-doc">LAPORAN INFORMASI</div>

    <div class="section-container">
        <div class="section-title">I. PERISTIWA / FAKTA-FAKTA :</div>
        <div class="section-content">
            {{ $item->peristiwa }}
        </div>
    </div>

    <div class="section-container">
        <div class="section-title">II. SUMBER INFORMASI :</div>
        <div class="section-content">
            Bahwa informasi tersebut diperoleh melalui : {{ $item->sumber_informasi }}
        </div>
    </div>

    <div class="section-container">
        <div class="section-title">III. PENDAPAT / ANALISA :</div>
        <div class="section-content">
            {{ $item->pendapat }}
        </div>
    </div>

    <div class="section-container">
        <div class="section-title">IV. SARAN / TINDAK LANJUT :</div>
        <div class="section-content">
            Diharapkan pimpinan dapat mempertimbangkan langkah-langkah strategis lebih lanjut guna mengantisipasi potensi kerawanan yang ada.
        </div>
    </div>

    <div class="ttd-wrapper">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <div class="space-ttd"></div>
            <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
            <p class="nip-text">Jaksa Madya NIP. 198501012010121001</p>
        </div>
    </div>

</body>

</html>