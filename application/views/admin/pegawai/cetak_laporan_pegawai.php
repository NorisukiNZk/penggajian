<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif;
            color: black;
            margin: 20px;
            background-color: #ffffff;
        }

        /* Tampilan Header Klinik */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
        }
        .header h2 {
            font-size: 14px;
            font-weight: normal;
            margin: 5px 0 0 0;
        }
        .kop-line {
            border: 0;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            height: 2px;
            margin: 15px 0;
        }

        /* Judul Laporan */
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: underline;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        /* Info Filter */
        .info-filter {
            margin-bottom: 15px;
            font-size: 14px;
        }
        .info-filter table {
            width: auto;
            border: none;
            margin: 0;
        }
        .info-filter td {
            border: none;
            padding: 3px 5px;
            background-color: transparent !important;
        }

        /* Tabel Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid black;
            padding: 8px 5px;
        }
        table.data-table th {
            background-color: #e9ecef !important;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        /* Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            float: right;
            width: 300px;
            text-align: center;
            font-size: 14px;
        }
        .signature-box p {
            margin: 5px 0;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 60px !important;
        }

        /* Aturan Print Khusus */
        @media print {
            body {
                margin: 0;
                background-color: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .kop-line {
                border-top: 3px solid black !important;
                border-bottom: 1px solid black !important;
            }
            table.data-table th {
                background-color: #e9ecef !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KLINIK PRATAMA HIDAYATULLAH</h1>
        <h2>Jl A. Yani KM 23 RT 01 RW 02, Kel Landasan Ulin, Kec Liang Anggang Banjarbaru</h2>
        <hr class="kop-line">
    </div>

    <div class="report-title">Laporan Data Pegawai</div>

    <?php
        // Array nama bulan
        $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    ?>

    <div class="info-filter">
        <table>
            <tr>
                <td>Jabatan Filter</td>
                <td>:</td>
                <td><strong><?php echo htmlspecialchars($filter_jabatan, ENT_QUOTES, 'UTF-8'); ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal Dicetak</td>
                <td>:</td>
                <td><strong><?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></strong></td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="25%">Nama Pegawai</th>
                <th width="15%">Jenis Kelamin</th>
                <th width="20%">Jabatan</th>
                <th width="20%">Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($pegawai as $p) : 
            $tgl_masuk = date('d-m-Y', strtotime($p->tanggal_masuk));
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td style="text-align: center;"><?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></td>
                <td style="text-align: center;"><?php echo htmlspecialchars($p->jenis_kelamin, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($p->jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                <td style="text-align: center;"><?php echo $tgl_masuk; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <p>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></p>
            <p>Mengetahui,</p>
            <p>Pimpinan Klinik</p>
            <p class="signature-name">Dr. H. Muhammad Hidayatullah</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
