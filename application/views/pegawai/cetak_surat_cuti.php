<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - <?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></title>
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
            margin: 0 0 20px 0;
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

        /* Nomor Surat & Judul Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .doc-title {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .doc-number {
            font-size: 13px;
            color: #374151;
            font-weight: bold;
        }

        /* Content Sections */
        .doc-intro {
            font-size: 14px;
            margin-bottom: 15px;
            text-align: justify;
        }

        /* Data Detail Table */
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            margin-bottom: 20px;
        }
        table.detail-table td {
            padding: 6px 8px;
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

        /* Status Badge Box */
        .status-box {
            display: inline-block;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 4px;
            border: 1px solid #10b981;
            background-color: #ecfdf5;
            color: #065f46;
        }
        .status-box.menunggu {
            border-color: #f59e0b;
            background-color: #fffbeb;
            color: #92400e;
        }
        .status-box.ditolak {
            border-color: #f43f5e;
            background-color: #fff1f2;
            color: #9f1239;
        }

        /* Note Box */
        .note-box {
            background-color: #f8fafc;
            border-left: 3px solid #0ea5e9;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
            font-style: italic;
        }

        /* Signature Container */
        .signature-container {
            width: 100%;
            margin-top: 40px;
        }
        .signature-col-left {
            float: left;
            width: 45%;
            text-align: center;
            font-size: 13.5px;
        }
        .signature-col-right {
            float: right;
            width: 45%;
            text-align: center;
            font-size: 13.5px;
        }
        .signature-space {
            height: 75px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }
        .qr-code {
            width: 70px;
            height: 70px;
            margin: 6px auto;
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
            font-size: 14px;
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

    <!-- Tombol Cetak Dokumen (Tidak tercetak saat diprint) -->
    <div class="no-print">
        <span style="font-size: 13px; color: #475569;">
            Dokumen resmi permohonan & surat keterangan cuti pegawai. Gunakan tombol di samping untuk mencetak dokumen.
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
            <td width="15%" style="text-align: center;">
                <!-- Ruang Simetris Kop -->
            </td>
        </tr>
    </table>
    <hr class="kop-line-2">

    <!-- Nomor Surat & Judul Dokumen -->
    <?php
        $bulanRomawi = array(1=>"I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
        $bln = (int)date('n', strtotime($cuti->tanggal_mulai));
        $thn = date('Y', strtotime($cuti->tanggal_mulai));
        $noSurat = sprintf("%03d", $cuti->id_cuti) . "/SKC-HRD/" . $bulanRomawi[$bln] . "/" . $thn;

        // Hitung Hari
        $start = new DateTime($cuti->tanggal_mulai);
        $end   = new DateTime($cuti->tanggal_akhir);
        $durasi = $start->diff($end)->days + 1;

        // Tanggal Masuk Kembali
        $kembali = clone $end;
        $kembali->modify('+1 day');

        $bulanIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    ?>

    <div class="doc-header">
        <div class="doc-title">SURAT KETERANGAN HAK CUTI & IZIN KERJA</div>
        <div class="doc-number">Nomor : <?php echo $noSurat; ?></div>
    </div>

    <!-- Pengantar -->
    <div class="doc-intro">
        Yang bertanda tangan di bawah ini Pimpinan / Manajemen HRD Klinik Pratama Hidayatullah menerangkan bahwa permohonan cuti / izin kerja dari pegawai berikut:
    </div>

    <!-- Rincian Pegawai & Cuti -->
    <table class="detail-table">
        <tr>
            <td class="label-col">Nomor Induk Karyawan (NIK)</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Nama Lengkap Pegawai</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Jabatan / Posisi Kerja</td>
            <td class="separator">:</td>
            <td class="value-col"><?php echo htmlspecialchars($cuti->jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="label-col">Jenis Cuti / Izin</td>
            <td class="separator">:</td>
            <td class="value-col"><strong>Cuti <?php echo htmlspecialchars($cuti->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Masa Berlaku Cuti</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong><?php echo date('d', strtotime($cuti->tanggal_mulai)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_mulai))] . ' ' . date('Y', strtotime($cuti->tanggal_mulai)); ?></strong>
                &nbsp;s/d&nbsp;
                <strong><?php echo date('d', strtotime($cuti->tanggal_akhir)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_akhir))] . ' ' . date('Y', strtotime($cuti->tanggal_akhir)); ?></strong>
            </td>
        </tr>
        <tr>
            <td class="label-col">Durasi Hari Cuti</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo $durasi; ?> (<?php echo $durasi; ?>) Hari Kalender</strong></td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Masuk Bekerja Kembali</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong><?php echo $kembali->format('d') . ' ' . $bulanIndo[$kembali->format('m')] . ' ' . $kembali->format('Y'); ?></strong>
            </td>
        </tr>
        <tr>
            <td class="label-col">Alasan / Keperluan</td>
            <td class="separator">:</td>
            <td class="value-col"><?php echo nl2br(htmlspecialchars($cuti->alasan, ENT_QUOTES, 'UTF-8')); ?></td>
        </tr>
        <tr>
            <td class="label-col">Status Pengajuan</td>
            <td class="separator">:</td>
            <td class="value-col">
                <?php if($cuti->status_cuti == 'Disetujui'): ?>
                    <span class="status-box">DISETUJUI &bull; HAK CUTI DIBERIKAN</span>
                <?php elseif($cuti->status_cuti == 'Menunggu'): ?>
                    <span class="status-box menunggu">MENUNGGU VERIFIKASI HRD</span>
                <?php else: ?>
                    <span class="status-box ditolak">TIDAK DISETUJUI / DITOLAK</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- Catatan Tambahan Jika Ada -->
    <?php if(!empty($cuti->pesan_admin)): ?>
    <div class="note-box">
        <strong>Catatan HRD / Pimpinan:</strong> "<?php echo htmlspecialchars($cuti->pesan_admin, ENT_QUOTES, 'UTF-8'); ?>"
    </div>
    <?php endif; ?>

    <!-- Pernyataan Penutup -->
    <div class="doc-intro" style="margin-top: 15px;">
        Demikian Surat Keterangan Cuti ini diterbitkan untuk dipergunakan sebagaimana mestinya. Pegawai yang bersangkutan diharapkan menjaga amanah dan kembali melaksanakan tugas pelayanan di Klinik Pratama Hidayatullah sesuai jadwal yang telah ditentukan.
    </div>

    <!-- Tanda Tangan Dua Kolom -->
    <div class="signature-container">
        <!-- Kolom Pegawai Pemohon -->
        <div class="signature-col-left">
            <p>Pegawai Pemohon,</p>
            <div class="signature-space"></div>
            <p class="signature-name"><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></p>
            <p style="margin: 2px 0; font-size: 12px; color: #4b5563;">NIK. <?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Kolom Pimpinan / HRD -->
        <div class="signature-col-right">
            <p>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></p>
            <p style="margin-top: -5px;">Mengetahui & Menyetujui,</p>
            <img src="<?php echo base_url('assets/img/qr-dummy.png'); ?>" class="qr-code" alt="Validasi Digital">
            <p style="font-size: 10px; margin-top: -3px; font-style: italic; color: #4b5563;">Tervalidasi Sistem HRIS Terpadu</p>
            <p class="signature-name">Dr. H. Muhammad Hidayatullah</p>
            <p style="margin: 2px 0; font-size: 12px; color: #4b5563;">Pimpinan Klinik Pratama Hidayatullah</p>
        </div>

        <div style="clear: both;"></div>
    </div>

</body>
</html>
