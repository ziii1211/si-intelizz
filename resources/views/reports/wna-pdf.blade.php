<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Pengawasan Orang Asing</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.5;
        }

        /* --- CSS KOP SURAT RESMI --- */
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
            letter-spacing: 1px;
        }

        .header p {
            margin: 4px 0 0 0;
            font-size: 9pt; 
            line-height: 1.2;
            text-align: center; 
        }
        /* --------------------------- */

        .title-doc {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            font-size: 13pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }

        td {
            font-size: 10pt;
        }

        .ttd {
            float: right;
            width: 40%;
            text-align: center;
            margin-top: 30px;
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
    <div class="title-doc">REKAPITULASI PENGAWASAN ORANG ASING (WNA)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">NAMA LENGKAP</th>
                <th width="15%">NEGARA ASAL</th>
                <th width="15%">NO. PASPOR</th>
                <th width="25%">TUJUAN & SPONSOR</th>
                <th width="20%">IZIN TINGGAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td><strong>{{ $item->nama_lengkap }}</strong></td>
                <td align="center">{{ $item->negara_asal }}</td>
                <td align="center">{{ $item->nomor_paspor }}</td>
                <td>
                    Giat: {{ $item->tujuan_kunjungan }}<br>
                    Sponsor: {{ $item->sponsor ?? '-' }}
                </td>
                <td align="center">
                    s/d {{ \Carbon\Carbon::parse($item->masa_berlaku_izin)->format('d-m-Y') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
            <br><br><br><br>
            <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
            <p>Jaksa Madya NIP. 198501012010121001</p>
        </div>
    </div>
</body>

</html>