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
    </style>
    </style>
</head>
<body>
<div class="header">
        <h1>KLINIK PRATAMA</h1>
        <h1>dr. H.M.HIDAYATULLAH</h1>
        <h2>Jl A. Yani KM 23 RT 01 RW 02, Kel Landasan Ulin, Kec Liang Anggang Banjarbaru</h2>
        <hr> <!-- Garis pembatas di bawah header -->
        <div class="report-title">DATA PEGAWAI</div><!-- Judul untuk tabel pegawai -->
    </div>

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

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Jabatan</th>
                <th class="text-center">Gaji Pokok</th>
                <th class="text-center">Tunjangan Transport</th>
                <th class="text-center">Uang Makan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($jabatan as $j): ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo $j->nama_jabatan; ?></td>
                <td><?php echo "Rp " . number_format($j->gaji_pokok, 0, ',', '.'); ?></td>
                <td><?php echo "Rp " . number_format($j->tj_transport, 0, ',', '.'); ?></td>
                <td><?php echo "Rp " . number_format($j->uang_makan, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



    <script type="text/javascript">
        window.print(); // Memanggil dialog cetak
    </script>
</body>
</html>