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
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: underline;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .report-subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid black;
            padding: 8px 10px;
        }
        table.data-table th {
            background-color: #e9ecef !important;
            font-weight: bold;
            text-align: center;
        }
        table.data-table td.angka {
            text-align: right;
        }
        .signature-container {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            width: 30%;
            text-align: center;
            font-size: 14px;
            float: right;
        }
        .signature-box p {
            margin: 5px 0;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px !important;
        }
        @media print {
            body { margin: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .kop-line { border-top: 3px solid black !important; border-bottom: 1px solid black !important; }
            table.data-table th { background-color: #e9ecef !important; }
        }
    
        /* Tampilan Header Klinik Baru */
        table.kop-surat {
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 5px;
        }
        table.kop-surat img {
            width: 110px;
            height: auto;
        }
        table.kop-surat h1 {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
            color: #000;
        }
        table.kop-surat h2 {
            font-size: 14px;
            font-weight: normal;
            margin: 5px 0 0 0;
            color: #333;
        }
        table.kop-surat p {
            font-size: 13px;
            margin: 5px 0 0 0;
        }
        .kop-line-2 {
            border: 0;
            border-top: 1px solid black;
            height: 1px;
            margin: 0 0 20px 0;
        }
    
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            width: 400px;
            height: auto;
        }
        /* Nomor Surat */
        .nomor-surat {
            text-align: left;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        /* QR Code */
        .qr-code {
            width: 70px;
            height: 70px;
            margin: 10px auto;
            display: block;
        }
    </style>
</head>
<body>
    <img src="<?php echo base_url('assets/img/kpmh.png') ?>" class="watermark">

        <table class="kop-surat">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="<?php echo base_url('assets/img/kpmh.png') ?>" alt="Logo Klinik">
            </td>
            <td width="70%" style="text-align: center;">
                <h1>KLINIK PRATAMA HIDAYATULLAH</h1>
                <h2>Jl. A. Yani KM 23 RT 01 RW 02, Kel. Landasan Ulin, Kec. Liang Anggang Banjarbaru</h2>
                <p><strong>Telp:</strong> (0511) XXXXXXX | <strong>Email:</strong> klinik.kpmh@gmail.com</p>
            </td>
            <td width="15%" style="text-align: center;">
                <!-- Ruang kosong atau logo kedua jika ada -->
            </td>
        </tr>
    </table>
    <hr class="kop-line-2">
    <?php
    $bulanRomawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    $noSurat = "Nomor : " . date('ymd') . "/HRD-KPMH/" . $bulanRomawi[date('n')] . "/" . date('Y');
    ?>
    <div class="nomor-surat"><?php echo $noSurat; ?></div>


    <?php
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    
    // Cari nilai potongan alpha
    $alpha_deduction = 0;
    foreach ($potongan_master as $pm) {
        if (strtolower($pm->potongan) == 'alpha') {
            $alpha_deduction = $pm->jml_potongan;
        }
    } 
    ?>

    <div class="report-title">LAPORAN REKAPITULASI POTONGAN GAJI</div>
    <div class="report-subtitle">Bulan: <?php echo isset($bulanIndo[$bulan]) ? $bulanIndo[$bulan] : $bulan; ?> Tahun: <?php echo $tahun; ?></div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Pegawai</th>
                <th width="15%">NIK</th>
                <th width="15%">Potongan Alpha</th>
                <th width="20%">Potongan Lainnya</th>
                <th width="20%">Total Potongan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grand_total = 0;
            if(!empty($potongan_gaji)) :
                foreach($potongan_gaji as $p) : 
                    $pot_alpha = $p->alpha * $alpha_deduction;
                    $pot_lainnya = isset($komponen_per_pegawai[$p->nik]) ? $komponen_per_pegawai[$p->nik]['total'] : 0;
                    $total_potongan = $pot_alpha + $pot_lainnya;
                    
                    $grand_total += $total_potongan;
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></td>
                <td style="text-align: center;"><?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="angka">Rp <?php echo number_format($pot_alpha, 0, ',', '.'); ?> <br><small>(<?php echo $p->alpha ?> hari)</small></td>
                <td class="angka">Rp <?php echo number_format($pot_lainnya, 0, ',', '.'); ?></td>
                <td class="angka" style="font-weight: bold;">Rp <?php echo number_format($total_potongan, 0, ',', '.'); ?></td>
            </tr>
            <?php 
                endforeach; 
            else :
            ?>
            <tr>
                <td colspan="6" style="text-align: center; font-style: italic;">Tidak ada data kehadiran pada bulan ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <?php if(!empty($potongan_gaji)) : ?>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right; font-size: 15px;">Grand Total Potongan :</th>
                <th class="angka" style="font-size: 15px;">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <p>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></p>
            <p>Mengetahui,</p>
            <p style="margin-bottom: 5px;">Pimpinan Klinik</p>

            <img src="<?php echo base_url('assets/img/qr-dummy.png') ?>" class="qr-code" alt="Validasi Digital">
            <p style="font-size:10px; margin-top:-5px; font-style:italic;">Validasi Digital</p>

            <p class="signature-name">Dr. H. Muhammad Hidayatullah</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
