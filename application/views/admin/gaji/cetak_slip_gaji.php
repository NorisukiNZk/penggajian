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
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        /* Info Pegawai */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-table td {
            padding: 3px 5px;
            vertical-align: top;
        }

        /* Tabel Data Akuntansi */
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
        .bg-pendapatan {
            background-color: #d4edda !important;
            font-weight: bold;
        }
        .bg-potongan {
            background-color: #f8d7da !important;
            font-weight: bold;
        }

        /* Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            width: 40%;
            text-align: center;
            font-size: 14px;
            float: right;
        }
        .signature-box.left {
            float: left;
        }
        .signature-box p {
            margin: 5px 0;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px !important;
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
            .bg-pendapatan { background-color: #d4edda !important; }
            .bg-potongan { background-color: #f8d7da !important; }
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


    <div class="report-title">SLIP GAJI PEGAWAI</div>

    <?php
    // Array nama bulan
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    
    $alpha_deduction = 0;
    foreach ($potongan as $p) {
        if (strtolower($p->potongan) == 'alpha') {
            $alpha_deduction = $p->jml_potongan;
        }
    } 
    ?>

    <?php foreach ($print_slip as $ps) : ?>
        <?php 
        $potongan_gaji = $ps->alpha * $alpha_deduction;
        $uang_lembur = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['uang_lembur'] : 0;
        $tj_detail = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['tunjangan'] : array('total' => 0, 'detail' => array());
        $pot_detail = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['potongan'] : array('total' => 0, 'detail' => array());
        $total_gaji = $ps->gaji_pokok + $ps->tj_transport + $ps->uang_makan + $uang_lembur + $tj_detail['total'] - $potongan_gaji - $pot_detail['total'];
        
        $bulanAngka = substr($ps->bulan, 0, 2);
        $tahunAngka = substr($ps->bulan, 2, 4);
        ?>

        <table class="info-table">
            <tr>
                <td width="15%"><strong>Nama Pegawai</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></td>
                <td width="15%"><strong>Bulan</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?php echo isset($bulanIndo[$bulanAngka]) ? $bulanIndo[$bulanAngka] : $bulanAngka; ?></td>
            </tr>
            <tr>
                <td><strong>NIK</strong></td>
                <td>:</td>
                <td><?php echo htmlspecialchars($ps->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><strong>Tahun</strong></td>
                <td>:</td>
                <td><?php echo htmlspecialchars($tahunAngka, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td><strong>Jabatan</strong></td>
                <td>:</td>
                <td><?php echo htmlspecialchars($ps->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                <td></td><td></td><td></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="65%">Keterangan</th>
                    <th width="30%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <!-- Pendapatan -->
                <tr>
                    <td colspan="3" class="bg-pendapatan">PENDAPATAN</td>
                </tr>
                <?php $no = 1; ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td>Gaji Pokok</td>
                    <td class="angka">Rp <?php echo number_format($ps->gaji_pokok, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td>Tunjangan Transportasi</td>
                    <td class="angka">Rp <?php echo number_format($ps->tj_transport, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td>Uang Makan</td>
                    <td class="angka">Rp <?php echo number_format($ps->uang_makan, 0, ',', '.'); ?></td>
                </tr>
                <?php 
                if ($uang_lembur > 0) : 
                    $jam_lembur = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['jam_lembur'] : 0;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td>Uang Lembur (<?php echo $jam_lembur; ?> Jam)</td>
                    <td class="angka">Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></td>
                </tr>
                <?php endif; ?>
                <?php foreach ($tj_detail['detail'] as $td) : ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($td['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?> <?php echo $td['is_persentase'] ? '(' . $td['nominal'] . '%)' : '' ?></td>
                    <td class="angka">Rp <?php echo number_format($td['nominal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>

                <!-- Potongan -->
                <tr>
                    <td colspan="3" class="bg-potongan">POTONGAN</td>
                </tr>
                <?php $no_pot = 1; ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no_pot++; ?></td>
                    <td>Potongan Alpha (<?php echo htmlspecialchars($ps->alpha, ENT_QUOTES, 'UTF-8'); ?> hari)</td>
                    <td class="angka">Rp <?php echo number_format($potongan_gaji, 0, ',', '.'); ?></td>
                </tr>
                <?php foreach ($pot_detail['detail'] as $pd) : ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no_pot++; ?></td>
                    <td><?php echo htmlspecialchars($pd['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="angka">Rp <?php echo number_format($pd['nominal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>

                <?php 
                $pinjaman = isset($komponen_per_pegawai[$ps->nik]['pinjaman']) ? $komponen_per_pegawai[$ps->nik]['pinjaman'] : array('total' => 0, 'detail' => []);
                if ($pinjaman['total'] > 0) : 
                    foreach ($pinjaman['detail'] as $pj) :
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no_pot++; ?></td>
                    <td style="color: #d9534f;"><strong><?php echo $pj['keterangan']; ?></strong></td>
                    <td class="angka" style="color: #d9534f;">Rp <?php echo number_format($pj['nominal'], 0, ',', '.'); ?></td>
                </tr>
                <?php 
                    endforeach;
                endif; 
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align: right; font-size: 16px;">Total Penerimaan Bersih :</th>
                    <th class="angka" style="font-size: 16px;">Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="signature-container">
            <div class="signature-box left">
                <p>Pegawai Yang Bersangkutan,</p>
                <p class="signature-name" style="margin-top: 80px !important;"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="signature-box">
                <p>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></p>
                <p>Mengetahui Pimpinan Klinik,</p>
                <p class="signature-name" style="margin-top: 60px !important;">Dr. H. Muhammad Hidayatullah</p>
            </div>
            <div style="clear: both;"></div>
        </div>

    <?php endforeach; ?>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>