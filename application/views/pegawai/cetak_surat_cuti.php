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
            margin: 20px 35px;
            background-color: #ffffff;
            line-height: 1.45;
        }

        /* Kop Surat Klinik */
        table.kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 4px;
        }
        table.kop-surat img {
            width: 95px;
            height: auto;
        }
        table.kop-surat h1 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
            color: #0c2b4d;
        }
        table.kop-surat h2 {
            font-size: 13px;
            font-weight: normal;
            margin: 3px 0 0 0;
            color: #374151;
        }
        table.kop-surat p {
            font-size: 11.5px;
            margin: 2px 0 0 0;
            color: #4b5563;
        }
        .kop-line-2 {
            border: 0;
            border-top: 1px solid #000;
            height: 1px;
            margin: 0 0 16px 0;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.06;
            z-index: -1;
            width: 400px;
            height: auto;
        }

        /* Nomor Surat & Judul Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 18px;
        }
        .doc-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .doc-number {
            font-size: 12.5px;
            color: #374151;
            font-weight: bold;
        }

        /* Content Sections */
        .doc-intro {
            font-size: 13px;
            margin-bottom: 12px;
            text-align: justify;
        }

        /* Section Headings */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f1f5f9;
            padding: 4px 8px;
            border-left: 3px solid #0c2b4d;
            margin: 12px 0 8px 0;
        }

        /* Data Detail Table */
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
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

        /* Status Badge Box */
        .status-box {
            display: inline-block;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            border: 1px solid #10b981;
            background-color: #ecfdf5;
            color: #065f46;
        }

        /* Note Box */
        .note-box {
            background-color: #f8fafc;
            border-left: 3px solid #0ea5e9;
            padding: 8px 12px;
            font-size: 12px;
            margin-bottom: 14px;
        }

        /* Signature Container (3 Kolom Sejajar) */
        .signature-container {
            width: 100%;
            margin-top: 25px;
        }
        .signature-col {
            float: left;
            width: 33.33%;
            text-align: center;
            font-size: 12px;
        }
        .signature-space {
            height: 60px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
            font-size: 12.5px;
        }
        .qr-code {
            width: 55px;
            height: 55px;
            margin: 3px auto;
            display: block;
        }

        /* Print Controls */
        .no-print {
            margin-bottom: 16px;
            padding: 10px 16px;
            background-color: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-print {
            background-color: #0284c7;
            color: #ffffff;
            padding: 6px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-print:hover {
            background-color: #0369a1;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 10mm 15mm;
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
            Surat Keterangan Cuti & Pendelegasian Tugas Resmi Klinik Pratama Hidayatullah.
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

    <!-- Nomor Surat & Judul Dokumen -->
    <?php
        $bulanRomawi = array(1=>"I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
        $bln = (int)date('n', strtotime($cuti->tanggal_mulai));
        $thn = date('Y', strtotime($cuti->tanggal_mulai));
        $noSurat = sprintf("%03d", $cuti->id_cuti) . "/SKC-DIR/" . $bulanRomawi[$bln] . "/" . $thn;

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
        <div class="doc-title">SURAT KEPUTUSAN IZIN CUTI & PENDELEGASIAN TUGAS</div>
        <div class="doc-number">Nomor : <?php echo $noSurat; ?></div>
    </div>

    <!-- Pengantar -->
    <div class="doc-intro">
        Berdasarkan permohonan hak cuti/izin kerja yang diajukan oleh pegawai serta telah melalui telaah kelayakan operasional oleh Manajemen HRD, Direktur Utama Klinik Pratama Hidayatullah menetapkan persetujuan cuti kepada:
    </div>

    <!-- Bagian I: Data Pegawai Pemohon -->
    <div class="section-title">I. IDENTITAS PEGAWAI PEMOHON</div>
    <table class="detail-table">
        <tr>
            <td class="label-col">Nomor Induk Pegawai (NIK)</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Nama Lengkap Pegawai</td>
            <td class="separator">:</td>
            <td class="value-col"><strong><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Jabatan / Unit Kerja</td>
            <td class="separator">:</td>
            <td class="value-col"><?php echo htmlspecialchars($cuti->jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="label-col">Kategori Cuti / Izin</td>
            <td class="separator">:</td>
            <td class="value-col"><strong>Cuti <?php echo htmlspecialchars($cuti->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        </tr>
        <tr>
            <td class="label-col">Periode Cuti</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong><?php echo date('d', strtotime($cuti->tanggal_mulai)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_mulai))] . ' ' . date('Y', strtotime($cuti->tanggal_mulai)); ?></strong>
                &nbsp;s/d&nbsp;
                <strong><?php echo date('d', strtotime($cuti->tanggal_akhir)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_akhir))] . ' ' . date('Y', strtotime($cuti->tanggal_akhir)); ?></strong>
                (<?php echo $durasi; ?> Hari Kalender)
            </td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Masuk Bekerja Kembali</td>
            <td class="separator">:</td>
            <td class="value-col">
                <strong><?php echo $kembali->format('d') . ' ' . $bulanIndo[$kembali->format('m')] . ' ' . $kembali->format('Y'); ?></strong>
            </td>
        </tr>
        <tr>
            <td class="label-col">Alasan / Kepentingan</td>
            <td class="separator">:</td>
            <td class="value-col"><?php echo nl2br(htmlspecialchars($cuti->alasan, ENT_QUOTES, 'UTF-8')); ?></td>
        </tr>
        <tr>
            <td class="label-col">Kontak Darurat / Domisili</td>
            <td class="separator">:</td>
            <td class="value-col">
                <?php echo !empty($cuti->kontak_darurat) ? htmlspecialchars($cuti->kontak_darurat, ENT_QUOTES, 'UTF-8') : '-'; ?>
                <?php if(!empty($cuti->alamat_cuti)): ?>
                    &bull; Domisili: <?php echo htmlspecialchars($cuti->alamat_cuti, ENT_QUOTES, 'UTF-8'); ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- Bagian II: Pendelegasian Tugas & Rekan Pengganti Shift -->
    <div class="section-title">II. PENDELEGASIAN TUGAS & OPERASIONAL SHIFT</div>
    <table class="detail-table">
        <tr>
            <td class="label-col">Petugas Pengganti (*Handover*)</td>
            <td class="separator">:</td>
            <td class="value-col">
                <?php if (!empty($cuti->nama_pengganti)) : ?>
                    <strong><?php echo htmlspecialchars($cuti->nama_pengganti, ENT_QUOTES, 'UTF-8'); ?></strong> 
                    (Jabatan: <?php echo htmlspecialchars($cuti->jabatan_pengganti, ENT_QUOTES, 'UTF-8'); ?>)
                <?php else: ?>
                    <span style="color: #64748b;">Tidak ditunjuk rekan pengganti spesifik</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="label-col">Ruang Lingkup Tugas Pengganti</td>
            <td class="separator">:</td>
            <td class="value-col">
                <?php echo !empty($cuti->tugas_pengganti) ? nl2br(htmlspecialchars($cuti->tugas_pengganti, ENT_QUOTES, 'UTF-8')) : 'Pelayanan rutin operasional poli/unit kerja.'; ?>
            </td>
        </tr>
    </table>

    <!-- Bagian III: Catatan Telaah HRD & Pengesahan Direksi -->
    <?php if(!empty($cuti->catatan_hrd) || !empty($cuti->pesan_admin)): ?>
    <div class="note-box">
        <?php if(!empty($cuti->catatan_hrd)): ?>
            <div><strong>Telaah Rekomendasi HRD:</strong> "<?php echo htmlspecialchars($cuti->catatan_hrd, ENT_QUOTES, 'UTF-8'); ?>"</div>
        <?php endif; ?>
        <?php if(!empty($cuti->pesan_admin)): ?>
            <div style="margin-top: 4px;"><strong>Catatan Keputusan Direksi:</strong> "<?php echo htmlspecialchars($cuti->pesan_admin, ENT_QUOTES, 'UTF-8'); ?>"</div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Pernyataan Penutup -->
    <div class="doc-intro">
        Demikian Surat Keputusan Cuti ini disahkan oleh Direktur Utama dan Manajemen Klinik Pratama Hidayatullah. Pegawai bersangkutan diwajibkan menyelesaikan serah terima tugas dengan baik sebelum hari cuti dan hadir kembali bekerja tepat waktu.
    </div>

    <!-- Tanda Tangan Tiga Kolom: Pemohon, Rekan Pengganti, Direktur Utama -->
    <div class="signature-container">
        <!-- Kolom 1: Pemohon Cuti -->
        <div class="signature-col">
            <p style="margin: 0;">Pegawai Pemohon,</p>
            <div class="signature-space"></div>
            <p class="signature-name"><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></p>
            <p style="margin: 2px 0; font-size: 11px; color: #4b5563;">NIK. <?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Kolom 2: Petugas Pengganti Shift -->
        <div class="signature-col">
            <p style="margin: 0;">Petugas Pengganti Shift,</p>
            <div class="signature-space"></div>
            <p class="signature-name">
                <?php echo !empty($cuti->nama_pengganti) ? htmlspecialchars($cuti->nama_pengganti, ENT_QUOTES, 'UTF-8') : '( Rekan Pengganti )'; ?>
            </p>
            <p style="margin: 2px 0; font-size: 11px; color: #4b5563;">
                <?php echo !empty($cuti->jabatan_pengganti) ? htmlspecialchars($cuti->jabatan_pengganti, ENT_QUOTES, 'UTF-8') : 'Petugas Pelaksana Shift'; ?>
            </p>
        </div>

        <!-- Kolom 3: Direktur Utama & HRD -->
        <div class="signature-col">
            <p style="margin: 0;">Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></p>
            <p style="margin: 2px 0;">Mengesahkan & Menyetujui,</p>
            <img src="<?php echo base_url('assets/img/qr-dummy.png'); ?>" class="qr-code" alt="Validasi Digital">
            <p style="font-size: 9.5px; margin: 0; font-style: italic; color: #4b5563;">Tervalidasi Digital HRIS</p>
            <p class="signature-name">Dr. H. Muhammad Hidayatullah</p>
            <p style="margin: 2px 0; font-size: 11px; color: #4b5563;">Direktur Utama Klinik Hidayatullah</p>
        </div>

        <div style="clear: both;"></div>
    </div>

</body>
</html>
