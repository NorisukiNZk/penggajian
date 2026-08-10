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

        /* Tabel Data Akuntansi */
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
        table.data-table td.angka {
            text-align: right; /* Rata kanan untuk nominal uang */
            white-space: nowrap;
        }
        table.data-table td.bold {
            font-weight: bold;
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

    <div class="report-title">Laporan Gaji Pegawai</div>

    <?php
        // Array nama bulan
        $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    ?>

    <div class="info-filter">
        <table>
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td><strong><?php echo isset($bulanIndo[$bulan]) ? $bulanIndo[$bulan] : $bulan; ?></strong></td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>:</td>
                <td><strong><?php echo htmlspecialchars($tahun, ENT_QUOTES, 'UTF-8'); ?></strong></td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">NIK</th>
                <th width="15%">Nama Pegawai</th>
                <th width="12%">Jabatan</th>
                <th width="10%">Gaji Pokok</th>
                <th width="9%">Tj. Transport</th>
                <th width="9%">Uang Makan</th>
                <th width="9%">Uang Lembur</th>
                <th width="9%">Tj. Lain</th>
                <th width="8%">Pot. Alpha</th>
                <th width="8%">Pot. Lain</th>
                <th width="9%">Total Gaji</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1; 
        $alpha = 0;
        foreach ($potongan as $p) {
            if (strtolower($p->potongan) == 'alpha') {
                $alpha = $p->jml_potongan;
            }
        }

        foreach ($cetak_gaji as $g): 
            $potongan_alpha = $g->alpha * $alpha;
            $uang_lembur = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['uang_lembur'] : 0;
            $tj_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['tunjangan']['total'] : 0;
            $pot_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['potongan']['total'] : 0;
            $total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $uang_lembur + $tj_lain - $potongan_alpha - $pot_lain;
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td style="text-align: center;"><?php echo htmlspecialchars($g->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($g->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($g->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="angka">Rp <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
                <td class="angka">Rp <?php echo number_format($g->tj_transport, 0, ',', '.'); ?></td>
                <td class="angka">Rp <?php echo number_format($g->uang_makan, 0, ',', '.'); ?></td>
                <td class="angka">Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></td>
                <td class="angka">Rp <?php echo number_format($tj_lain, 0, ',', '.'); ?></td>
                <td class="angka" style="color: red;">-Rp <?php echo number_format($potongan_alpha, 0, ',', '.'); ?></td>
                <td class="angka" style="color: red;">-Rp <?php echo number_format($pot_lain, 0, ',', '.'); ?></td>
                <td class="angka bold" style="background-color: #f8f9fa;">Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></td>
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