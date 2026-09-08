<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - <?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #111827;
            margin: 25px 40px;
            background-color: #ffffff;
            line-height: 1.5;
        }

        /* Kop Surat Klinik */
        table.kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 12px;
            margin-bottom: 5px;
        }
        table.kop-surat img {
            width: 105px;
            height: auto;
        }
        table.kop-surat h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
            color: #0c2b4d;
        }
        table.kop-surat h2 {
            font-size: 13px;
            font-weight: normal;
            margin: 4px 0 0 0;
            color: #374151;
        }
        table.kop-surat p {
            font-size: 12px;
            margin: 3px 0 0 0;
            color: #4b5563;
        }
        .kop-line-2 {
            border: 0;
            border-top: 1px solid #000;
            height: 1px;
            margin: 0 0 18px 0;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: -1;
            width: 420px;
            height: auto;
        }

        /* Judul Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .doc-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .doc-subtitle {
            font-size: 13px;
            font-weight: bold;
            color: #1f2937;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .doc-number {
            font-size: 12.5px;
            color: #374151;
            font-weight: bold;
        }

        /* Paragraf & Pasal */
        p.legal-text {
            font-size: 13px;
            text-align: justify;
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .pasal-title {
            text-align: center;
            font-weight: bold;
            font-size: 13.5px;
            margin: 14px 0 6px 0;
            text-transform: uppercase;
        }

        /* Tabel Identitas & Rincian */
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 12px;
        }
        table.detail-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        table.detail-table td.label-col {
            width: 28%;
            font-weight: bold;
            color: #1f2937;
        }
        table.detail-table td.separator {
            width: 3%;
            text-align: center;
        }
        table.detail-table td.value-col {
            width: 69%;
        }

        /* Kotak Status */
        .status-box {
            display: inline-block;
            padding: 3px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            border: 1px solid #10b981;
            background-color: #ecfdf5;
            color: #065f46;
        }

        /* Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 30px;
        }
        .signature-col-left {
            float: left;
            width: 45%;
            text-align: center;
            font-size: 13px;
        }
        .signature-col-right {
            float: right;
            width: 45%;
            text-align: center;
            font-size: 13px;
        }
        .signature-space {
            height: 65px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }
        .qr-code {
            width: 70px;
            height: 70px;
            margin: 5px auto;
            display: block;
        }

        /* Print Controls */
        .no-print {
            margin-bottom: 20px;
            padding: 12px 18px;
            background-color: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-print {
            background-color: #0284c7;
            color: #ffffff;
            padding: 8px 18px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13.5px;
        }
        .btn-print:hover {
            background-color: #0369a1;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 15mm 20mm;
                background-color: #ffffff;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak Dokumen -->
    <div class="no-print">
        <span style="font-size: 13px; color: #475569;">
            Dokumen sah Surat Perjanjian Pinjaman Karyawan (SPPK) & Surat Kuasa Potong Gaji. Gunakan tombol untuk mencetak.
        </span>
        <div>
            <button class="btn-print" onclick="window.print();">
                🖨️ Cetak / Simpan PDF
            </button>
            <button class="btn-print" style="background-color: #64748b; margin-left: 8px;" onclick="window.close();">
                Tutup
            </button>
        </div>
    </div>

    <!-- Watermark Logo Klinik -->
    <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" class="watermark" alt="Watermark">

    <!-- Kop Surat Resmi -->
    <table class="kop-surat">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik">
            </td>
            <td width="70%" style="text-align: center;">
                <h1>KLINIK PRATAMA HIDAYATULLAH</h1>
                <h2>Jl. A. Yani KM 23 RT 01 RW 02, Kel. Landasan Ulin, Kec. Liang Anggang, Banjarbaru</h2>
                <p><strong>Telp:</strong> (0511) 4705000 &bull; <strong>Email:</strong> hrd@klinikhidayatullah.com &bull; <strong>Web:</strong> klinikhidayatullah.com</p>
            </td>
            <td width="15%" style="text-align: center;"></td>
        </tr>
    </table>
    <hr class="kop-line-2">

    <!-- Judul & Penomoran Surat -->
    <?php
        $bulanRomawi = array(1=>"I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
        $tgl_ref = !empty($p->tgl_disetujui) ? $p->tgl_disetujui : $p->tgl_pengajuan;
        $bln = (int)date('n', strtotime($tgl_ref));
        $thn = date('Y', strtotime($tgl_ref));
        $noSurat = sprintf("%04d", $p->id_pinjaman) . "/SPPK-HRD/" . $bulanRomawi[$bln] . "/" . $thn;

        $cicilan = ceil($p->jumlah_pinjaman / $p->tenor_bulan);

        $bulanIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    ?>

    <div class="doc-header">
        <div class="doc-title">SURAT PERJANJIAN PINJAMAN KARYAWAN (SPPK)</div>
        <div class="doc-subtitle">& SURAT KUASA PEMOTONGAN GAJI / PESANGON</div>
        <div class="doc-number">Nomor : <?php echo $noSurat; ?></div>
    </div>

    <!-- Pembuka -->
    <p class="legal-text">
        Pada hari ini, <strong><?php echo date('d', strtotime($tgl_ref)) . ' ' . $bulanIndo[date('m', strtotime($tgl_ref))] . ' ' . date('Y', strtotime($tgl_ref)); ?></strong>, bertempat di Kantor Manajemen Klinik Pratama Hidayatullah Banjarbaru, telah dibuat dan disepakati perjanjian pinjaman fasilitas kasbon kerja oleh dan antara:
    </p>

    <!-- Pihak Pertama -->
    <table class="detail-table">
        <tr>
            <td class="label-col">I. Pihak Pertama (Pemberi Pinjaman)</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong>KLINIK PRATAMA HIDAYATULLAH</strong>, diwakili oleh <strong>Dr. H. Muhammad Hidayatullah</strong> selaku Pimpinan Klinik, berkedudukan di Banjarbaru, bertindak untuk dan atas nama Manajemen Klinik.
            </td>
        </tr>
        <tr>
            <td class="label-col">II. Pihak Kedua (Penerima Pinjaman)</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong> (NIK: <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?>), Jabatan: <strong><?php echo htmlspecialchars($p->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></strong>, Status Karyawan: <?php echo htmlspecialchars($p->status_karyawan, ENT_QUOTES, 'UTF-8'); ?>.
            </td>
        </tr>
    </table>

    <p class="legal-text">
        Kedua belah pihak secara sadar dan sukarela bersepakat mengikatkan diri dalam Perjanjian Pinjaman dengan ketentuan dan pasal-pasal berikut:
    </p>

    <!-- Pasal 1 -->
    <div class="pasal-title">Pasal 1 &mdash; Pokok Pinjaman & Skema Angsuran</div>
    <table class="detail-table">
        <tr>
            <td class="label-col">Total Nominal Pinjaman</td>
            <td class="separator">:</td>
            <td class="value-col"><strong>Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Jangka Waktu (Tenor)</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo $p->tenor_bulan; ?> (<?php echo $p->tenor_bulan; ?>) Bulan</strong></td>
        </tr>
        <tr>
            <td class="label-col">Angsuran per Bulan</td>
            <td class="separator">:</td>
            <td class="value-col"><strong>Rp <?php echo number_format($cicilan, 0, ',', '.'); ?> / bulan</strong></td>
        </tr>
        <tr>
            <td class="label-col">Mekanisme Pembayaran</td>
            <td class="separator">:</td>
            <td class="value-col">Pemotongan otomatis pada sistem payroll penggajian bulanan Pihak Kedua.</td>
        </tr>
        <tr>
            <td class="label-col">Keperluan / Alasan Kasbon</td>
            <td class="separator">:</td>
            <td class="value-col"><em>"<?php echo htmlspecialchars($p->alasan, ENT_QUOTES, 'UTF-8'); ?>"</em></td>
        </tr>
    </table>

    <!-- Pasal 2 (Klausul Mitigasi Risiko / Anti-Kabur) -->
    <div class="pasal-title">Pasal 2 &mdash; Hak Kuasa Pemotongan Gaji & Jaminan Hukum</div>
    <p class="legal-text">
        1. <strong>Kuasa Pemotongan Gaji Mutlak:</strong> Pihak Kedua dengan ini memberikan <strong>KUASA PENUH DAN TIDAK DAPAT DITARIK KEMBALI</strong> kepada Pihak Pertama untuk memotong langsung penghasilan bulanan Pihak Kedua sebesar nilai angsuran sampai seluruh kewajiban pinjaman lunas.
    </p>
    <p class="legal-text">
        2. <strong>Klausul Pengunduran Diri / Mangkir / Berhenti Sepihak:</strong> Apabila Pihak Kedua mengundurkan diri (*resign*), diputus hubungan kerjanya (PHK), diberhentikan karena pelanggaran disiplin, atau <strong>MANGKIR / KABUR / BERHENTI BEKERJA SECARA SEPIHAK</strong> sebelum masa angsuran berakhir, maka seluruh sisa kewajiban pinjaman dinyatakan <strong>JATUH TEMPO SEKETIKA DAN WAJIB DILUNASI</strong>.
    </p>
    <p class="legal-text">
        3. Pihak Pertama <strong>BERHAK PENUH MEMOTONG SELURUH HAK KEUANGAN TERAKHIR</strong> Pihak Kedua yang mencakup: sisa gaji bulan berjalan, kompensasi sisa cuti tahunan, Tunjangan Hari Raya (THR), uang pesangon/penghargaan masa kerja, serta menahan dokumen jaminan/ijazah hingga seluruh sisa pinjaman terlunasi seutuhnya.
    </p>

    <!-- Pasal 3 -->
    <div class="pasal-title">Pasal 3 &mdash; Data Kontak Penjamin / Darurat</div>
    <p class="legal-text">
        Pihak Kedua telah mencatatkan penjamin keluarga terdekat sebagai kontak darurat yang bertanggung jawab membantu penyelesaian apabila Pihak Kedua berhalangan atau mangkir dari kewajiban:
        <br>
        &bull; <strong>Nama Penjamin:</strong> <?php echo !empty($p->kontak_darurat_nama) ? htmlspecialchars($p->kontak_darurat_nama, ENT_QUOTES, 'UTF-8') : '-'; ?> 
        (Hubungan: <?php echo !empty($p->kontak_darurat_hubungan) ? htmlspecialchars($p->kontak_darurat_hubungan, ENT_QUOTES, 'UTF-8') : '-'; ?>)
        &bull; <strong>No. HP/WhatsApp:</strong> <?php echo !empty($p->kontak_darurat_hp) ? htmlspecialchars($p->kontak_darurat_hp, ENT_QUOTES, 'UTF-8') : '-'; ?>
    </p>

    <!-- Penutup & Tanda Tangan -->
    <p class="legal-text" style="margin-top: 15px;">
        Demikian Surat Perjanjian Pinjaman Karyawan (SPPK) ini dibuat dalam keadaan sadar tanpa paksaan dari pihak manapun, serta mempunyai kekuatan hukum yang mengikat bagi kedua belah pihak.
    </p>

    <div class="signature-container">
        <!-- Kolom Pihak Kedua (Pegawai Peminjam) -->
        <div class="signature-col-left">
            <p>Pihak Kedua (Peminjam),</p>
            <div class="signature-space"></div>
            <p class="signature-name"><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></p>
            <p style="margin: 2px 0; font-size: 11.5px; color: #4b5563;">NIK. <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Kolom Pihak Pertama (Pimpinan Klinik) -->
        <div class="signature-col-right">
            <p>Banjarbaru, <?php echo date('d', strtotime($tgl_ref)) . ' ' . $bulanIndo[date('m', strtotime($tgl_ref))] . ' ' . date('Y', strtotime($tgl_ref)); ?></p>
            <p style="margin-top: -5px;">Pihak Pertama (Pemberi Pinjaman),</p>
            <img src="<?php echo base_url('assets/img/qr-dummy.png'); ?>" class="qr-code" alt="Validasi Digital">
            <p style="font-size: 9.5px; margin-top: -3px; font-style: italic; color: #4b5563;">Tervalidasi Sistem HRIS Terpadu</p>
            <p class="signature-name">Dr. H. Muhammad Hidayatullah</p>
            <p style="margin: 2px 0; font-size: 11.5px; color: #4b5563;">Pimpinan Klinik Pratama Hidayatullah</p>
        </div>

        <div style="clear: both;"></div>
    </div>

</body>
</html>
