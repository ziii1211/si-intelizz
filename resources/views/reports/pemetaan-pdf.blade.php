<!DOCTYPE html>
<html>

<head>
    <title>Laporan Grafik Pemetaan Intelijen</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }

        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
        }

        .content-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .content-subtitle {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 25px;
        }

        .chart-section {
            text-align: center;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .chart-box {
            border: 1px solid #000;
            padding: 10px;
            background-color: #fff;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }

        .chart-box img {
            max-width: 100%;
            height: auto;
            max-height: 320px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin-top: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            vertical-align: middle;
            font-size: 11pt;
        }

        th {
            background-color: #ffffff;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .analysis-box {
            border: 1px solid #000;
            padding: 12px;
            text-align: justify;
            background-color: #ffffff;
            line-height: 1.6;
        }

        .ttd-container {
            margin-top: 40px;
            width: 100%;
            page-break-inside: avoid;
        }

        .ttd {
            width: 40%;
            text-align: center;
            float: right;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img/logo-kejaksaan.png') }}" class="logo">
        <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
        <h3>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h3>
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <p>Jl. Brig Jend. H. Hasan Basri No.3, Kayu Tangi, Banjarmasin</p>
    </div>

    <div class="content-title">LAPORAN GRAFIK PEMETAAN INTELIJEN</div>
    <div class="content-subtitle">Periode Analisis: {{ $periode }}</div>

    <div class="chart-section">
        <div class="section-title" style="text-align: left;">I. VISUALISASI GRAFIK MULTI-MODUL INTELIJEN</div>
        <div class="chart-box">
            @if(isset($chartImage) && $chartImage)
                <img src="{{ $chartImage }}" alt="Grafik Pemetaan Intelijen">
            @else
                <div style="padding: 50px; color: #000; border: 1px dashed #000;">
                    [ Grafik Tidak Tersedia / Gagal Dimuat ]
                </div>
            @endif
        </div>
    </div>

    <div class="section-title">II. TABEL REKAPITULASI SEBARAN DATA OPERASIONAL</div>
    <table>
        <thead>
            <tr>
                <th width="7%">NO</th>
                <th class="text-left">JENIS DATA / MODUL INTELIJEN</th>
                <th width="23%">TOTAL RECORD</th>
                <th width="35%" class="text-left">KETERANGAN / STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPemetaan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-left">{{ $item['modul'] }}</td>
                <td class="text-center">{{ number_format($item['jumlah']) }} Dokumen</td>
                <td class="text-left">{{ $item['keterangan'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">III. KESIMPULAN & ANALISIS SITUASI INTELIJEN</div>
    <div class="analysis-box">
        {{ $analisis }}
    </div>

    <div class="ttd-container">
        <div class="ttd">
            <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
            <p>Jaksa Madya NIP. 198501012010121001</p>
        </div>
        <div class="clearfix"></div>
    </div>
</body>

</html>