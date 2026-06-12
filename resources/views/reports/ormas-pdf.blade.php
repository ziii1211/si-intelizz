<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Data Ormas & PAKEM</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
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
            font-size: 12pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .status-aktif {
            color: green;
            font-weight: bold;
        }

        .status-waspada {
            color: orange;
            font-weight: bold;
        }

        .status-terlarang {
            color: red;
            font-weight: bold;
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
    <div class="title-doc">DATA ORGANISASI KEMASYARAKATAN & ALIRAN KEPERCAYAAN (PAKEM)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="25%">NAMA ORGANISASI</th>
                <th width="20%">PIMPINAN / ALAMAT</th>
                <th width="20%">LEGALITAS / NO. SK</th>
                <th width="15%">KEGIATAN</th>
                <th width="15%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ strtoupper($item->nama_organisasi) }}</strong><br>
                    <small>Bentuk: {{ $item->bentuk_organisasi }}</small>
                </td>
                <td>
                    {{ $item->nama_pimpinan }}<br>
                    <small>{{ $item->alamat_sekretariat }}</small>
                </td>
                <td>
                    {{ $item->status_legalitas }}<br>
                    <small>{{ $item->nomor_sk ?? '-' }}</small>
                </td>
                <td>{{ $item->kegiatan_utama }}</td>
                <td align="center">
                    <span class="status-{{ $item->status_pengawasan }}">
                        {{ strtoupper($item->status_pengawasan) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>Banjarmasin, {{ now()->translatedFormat('d F Y') }}</p>
        <p><strong>KEPALA SEKSI INTELIJEN</strong></p>
        <br><br><br><br>
        <p><u><strong>BUDI SANTOSO, S.H., M.H.</strong></u></p>
        <p>Jaksa Madya NIP. 198501012010121001</p>
    </div>
</body>

</html>