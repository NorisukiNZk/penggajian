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
            background-color: #007bff; /* Warna biru */
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Warna abu-abu muda untuk baris genap */
        }
        tr:hover {
            background-color: #e9ecef; /* Warna abu-abu saat hover */
        }
        hr {
            border: 0;
            height: 2px;
            background-color: black; /* Warna hitam untuk garis */
            margin: 10px 0; /* Margin atas dan bawah */
        }
        .signature-container {
            display: flex; /* Menggunakan flexbox untuk layout */
            justify-content: right; /* Menyebar konten ke kiri dan kanan */
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
        <hr> <!-- Garis pembatas di bawah header -->
    </div>
    <div class="report-title">LAPORAN GAJI PEGAWAI</div>
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
// Mengambil bulan dan tahun dari POST
$bulan = $this->input->post('bulan');
$tahun = $this->input->post('tahun');

// Validasi input
if (empty($bulan) || empty($tahun)) {
    // Jika tidak ada input, gunakan bulan dan tahun saat ini
    $bulan = date('m');
    $tahun = date('Y');
}
?>


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

            // Tampilkan nama bulan berdasarkan nilai bulan
            echo $bulanIndo[$bulan]; // Pastikan $bulan adalah format dua digit
            ?>
        </td>
    </tr>
    <br>
    <tr>
        <td>Tahun</td>
        <td>:</td>
        <td><?php echo $tahun; ?></td>
    </tr>


    <table>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">NIK</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Gaji Pokok</th>
            <th class="text-center">Tj. Transport</th>
            <th class="text-center">Uang Makan</th>
            <th class="text-center">Tunjangan Lain</th>
            <th class="text-center">Potongan</th>
            <th class="text-center">Potongan Lain</th>
            <th class="text-center">Total Gaji</th>
        </tr>
        <?php 
        $no = 1; 
        $alpha = 0; // Inisialisasi potongan
        foreach ($potongan as $p) {
            $alpha = $p->jml_potongan; // Ambil potongan dari data potongan
        }
        $bulantahun_cetak = $bulan . $tahun;
        foreach ($cetak_gaji as $g): 
            $potongan_alpha = $g->alpha * $alpha; // Hitung potongan alpha
            // Komponen dinamis
            $tj_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['tunjangan']['total'] : 0;
            $pot_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['potongan']['total'] : 0;
            $total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $tj_lain - $potongan_alpha - $pot_lain;
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo $g->nik; ?></td>
                <td class="text-center"><?php echo $g->nama_pegawai; ?></td>
                <td class="text-center"><?php echo $g->jenis_kelamin; ?></td>
                <td class="text-center"><?php echo $g->nama_jabatan; ?></td>
                <td class="text-center">Rp. <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
                <td class="text-center">Rp. <?php echo number_format($g->tj_transport, 0, ',', '.'); ?></td>
                <td class="text-center">Rp. <?php echo number_format($g->uang_makan, 0, ',', '.'); ?></td>
                <td class="text-center">Rp. <?php echo number_format($tj_lain, 0, ',', '.'); ?></td>
                <td class="text-center">Rp. <?php echo number_format($potongan_alpha, 0, ',', '.'); ?></td>
                <td class="text-center">Rp. <?php echo number_format($pot_lain, 0, ',', '.'); ?></td>
                <td class="text-center" style="font-weight:bold">Rp. <?php echo number_format($total_gaji, 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="signature-container">
            <div class="signature">
                <p>Mengetahui,</p>
                <p>dr. H.M.HIDAYATULLAH</p>
                <br><br>
                <br>
                <br>
                <p>( Dr. H. Muhammad Hidayatullah )</p>
            </div>
        </div>

    <script type="text/javascript">
        window.print(); // Memanggil dialog cetak
    </script>
</body>
</html>