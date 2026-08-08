<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title; ?></title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            color: black;
            margin: 20px;
            background-color: #f9f9f9; /* Warna latar belakang */
        }

        hr {
            border: 0;
            height: 2px;
            background-color: black; /* Warna hitam untuk garis */
            margin: 10px 0; /* Margin atas dan bawah */
        }

        @media print {
            hr {
                display: block; /* Ensure the line is displayed */
                height: 2px; /* Maintain height */
                background-color: black; /* Keep the color */
                margin: 10px 0; /* Maintain margins */
            }
        }

        h1, h2 {
            margin: 0;
            padding: 5px; /* Mengurangi padding untuk mengurangi celah */
        }

        h1 {
            font-size: 28px;
            color: black; /* Warna hitam */
            font-weight: bold; /* Bold */
            text-align: center; /* Rata tengah */
        }

        h2 {
            font-size: 16px; /* Ukuran font lebih kecil untuk alamat */
            color: black; /* Warna hitam */
            font-weight: normal; /* Normal */
            text-align: center; /* Rata tengah */
        }

        .header {
            text-align: center;
            margin-bottom: 10px; /* Mengurangi margin bawah */
        }

        .report-title {
            text-align: center; /* Rata tengah */
            font-weight: bold; /* Bold */
            text-decoration: underline; /* Garis bawah */
            margin-top: 20px; /* Margin atas */
            font-size: 24px; /* Ukuran font */
        }

        .date {
            text-align: right; /* Rata kanan */
            margin-bottom: 20px; /* Margin bawah */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 2px solid #000; /* Border hitam yang lebih tebal untuk tabel */
            padding: 10px; /* Padding untuk sel */
            text-align: left;
        }

        th {
            background-color: #007bff; /* Warna biru untuk header */
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Warna abu-abu muda untuk baris genap */
        }

        .signature-container {
            display: flex; /* Menggunakan flexbox untuk layout */
            justify-content: space-between; /* Menyebar konten ke kiri dan kanan */
            margin-top: 40px; /* Margin atas untuk tanda tangan */
        }

        .signature {
            text-align: center; /* Rata tengah untuk tanda tangan */
        }

        .signature p {
            margin: 0; /* Menghilangkan margin untuk p */
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>KLINIK PRATAMA</h1>
        <h1>dr. H.M.HIDAYATULLAH</h1>
        <h2>Jl A. Yani KM 23 RT 01 RW 02, Kel Landasan Ulin, Kec Liang Anggang Banjarbaru</h2>
        <hr> <!-- Garis bawah header -->
    </div>

    <div class="report-title">SLIP GAJI</div>
    <div class="date">
        <strong>Tanggal: </strong>
        <?php
        // Array nama bulan dalam bahasa Indonesia
        $bulanIndo = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Ambil tanggal, bulan, dan tahun
        $tanggal = date('d');
        $bulan = date('m');
        $tahun = date('Y');

        // Tampilkan tanggal dengan nama bulan dalam bahasa Indonesia
        echo $tanggal . ' ' . $bulanIndo[$bulan] . ' ' . $tahun;
        ?>
    </div>

    <?php 
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
        // Komponen dinamis
        $tj_detail = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['tunjangan'] : array('total' => 0, 'detail' => array());
        $pot_detail = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['potongan'] : array('total' => 0, 'detail' => array());
        $total_gaji = $ps->gaji_pokok + $ps->tj_transport + $ps->uang_makan + $tj_detail['total'] - $potongan_gaji - $pot_detail['total'];
        ?>

        <table>
            <tr>
                <td width="20%">Nama Pegawai</td>
                <td width="2%">:</td>
                <td><?php echo $ps->nama_pegawai ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?php echo $ps->nik ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?php echo $ps->nama_jabatan ?></td>
            </tr>
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td>
                    <?php
                    // Array nama bulan dalam bahasa Indonesia
                    $bulanIndo = [
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
                    ];

                    // Ambil bulan dari $ps->bulan
                    $bulanAngka = substr($ps->bulan, 0, 2);
                    echo $bulanIndo[$bulanAngka]; // Tampilkan nama bulan
                    ?>
                </td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>:</td>
                <td><?php echo substr($ps->bulan, 2, 4); ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Jumlah</th>
            </tr>

            <!-- Komponen Gaji Tetap -->
            <tr>
                <td colspan="3" style="background-color:#d4edda; font-weight:bold;">PENDAPATAN</td>
            </tr>
            <?php $no = 1; ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td>Gaji Pokok</td>
                <td>Rp. <?php echo number_format($ps->gaji_pokok, 0, ',', '.') ?></td>
            </tr>

            <tr>
                <td><?php echo $no++ ?></td>
                <td>Tunjangan Transportasi</td>
                <td>Rp. <?php echo number_format($ps->tj_transport, 0, ',', '.') ?></td>
            </tr>

            <tr>
                <td><?php echo $no++ ?></td>
                <td>Uang Makan</td>
                <td>Rp. <?php echo number_format($ps->uang_makan, 0, ',', '.') ?></td>
            </tr>

            <!-- Tunjangan Dinamis -->
            <?php foreach ($tj_detail['detail'] as $td) : ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $td['nama_komponen'] ?> <?php echo $td['is_persentase'] ? '(' . $td['nominal'] . '%)' : '' ?></td>
                <td>Rp. <?php echo number_format($td['nominal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>

            <!-- Potongan -->
            <tr>
                <td colspan="3" style="background-color:#f8d7da; font-weight:bold;">POTONGAN</td>
            </tr>
            <?php $no_pot = 1; ?>
            <tr>
                <td><?php echo $no_pot++ ?></td>
                <td>Potongan Alpha (<?php echo $ps->alpha ?> hari)</td>
                <td>Rp. <?php echo number_format($potongan_gaji, 0, ',', '.') ?></td>
            </tr>

            <!-- Potongan Dinamis -->
            <?php foreach ($pot_detail['detail'] as $pd) : ?>
            <tr>
                <td><?php echo $no_pot++ ?></td>
                <td><?php echo $pd['nama_komponen'] ?></td>
                <td>Rp. <?php echo number_format($pd['nominal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <th colspan="2" style="text-align: right;">Total Gaji : </th>
                <th>Rp. <?php echo number_format($total_gaji, 0, ',', '.') ?></th>
            </tr>
        </table>

        <div class="signature-container">
            <div class="signature">
                <p>Pegawai</p>
                <br><br>
                <br>
                <br>
                <p class="font-weight-bold"><?php echo $ps->nama_pegawai ?></p>
            </div>
            <div class="signature">
                <p>Mengetahui,</p>
                <p>dr. H.M.HIDAYATULLAH</p>
                <br><br>
                <br>
                <br>
                <p>( Dr. H. Muhammad Hidayatullah )</p>
            </div>
        </div>

    <?php endforeach; ?>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>