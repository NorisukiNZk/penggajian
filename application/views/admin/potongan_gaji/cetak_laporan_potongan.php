<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Periode <?php echo $bulan . '/' . $tahun; ?></title>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style type="text/css">
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Floating Action Bar */
        .print-action-bar {
            max-width: 1050px;
            margin: 0 auto 20px auto;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3);
            transition: all 0.2s;
        }
        .btn-print:hover { background: #0369a1; }
        .btn-close-doc {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-close-doc:hover { background: #e2e8f0; }

        /* Kertas Dokumen Cetak */
        .page-container {
            max-width: 1050px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .kop-logo {
            width: 90px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 76px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding: 0 10px;
        }
        .kop-title {
            font-size: 20px;
            font-weight: 800;
            color: #0c2b4d;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 0 0 3px 0;
        }
        .kop-subtitle {
            font-size: 12px;
            font-weight: 600;
            color: #0284c7;
            margin: 0 0 3px 0;
        }
        .kop-address {
            font-size: 11px;
            color: #475569;
            margin: 0;
            line-height: 1.4;
        }
        .kop-double-line {
            height: 3px;
            background: #0c2b4d;
            border-bottom: 1px solid #0c2b4d;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* Header Judul Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title-badge {
            display: inline-block;
            font-size: 15px;
            font-weight: 700;
            color: #0c2b4d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .report-meta-text {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        /* Info Meta Box */
        .info-meta-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 20px;
            font-size: 11.5px;
        }

        /* Tabel Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11.5px;
        }
        table.data-table thead th {
            background-color: #0c2b4d;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            padding: 9px 8px;
            border: 1px solid #0c2b4d;
            font-size: 11px;
            letter-spacing: 0.3px;
        }
        table.data-table tbody td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            vertical-align: middle;
            color: #1e293b;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.data-table tbody td.text-right {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }
        table.data-table tbody td.text-center {
            text-align: center;
        }
        table.data-table tfoot td {
            background-color: #f1f5f9;
            border: 1px solid #94a3b8;
            font-weight: 700;
            padding: 9px 10px;
            color: #0f172a;
        }

        /* Tanda Tangan */
        .signature-section {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 30px;
        }
        .signature-title {
            font-size: 11.5px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .signature-role {
            font-size: 12px;
            font-weight: 600;
            color: #0c2b4d;
            margin-bottom: 10px;
        }
        .qr-wrapper {
            margin: 6px auto;
            width: 70px;
            height: 70px;
        }
        .qr-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .signature-name {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-decoration: underline;
            margin-top: 4px;
            margin-bottom: 2px;
        }
        .signature-nip {
            font-size: 10.5px;
            color: #64748b;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.04;
            z-index: 0;
            width: 380px;
            pointer-events: none;
        }

        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-action-bar { display: none !important; }
            .page-container {
                max-width: 100%;
                box-shadow: none;
                border-radius: 0;
                padding: 15px 25px;
            }
        }
    </style>
</head>
<body>

    <img src="<?php echo base_url('assets/img/kpmh.png') ?>" class="watermark" alt="Watermark">

    <!-- Floating Action Bar -->
    <div class="print-action-bar">
        <div>
            <span style="font-weight: 700; color: #0c2b4d; font-size: 14px;"><i class="fas fa-file-invoice-dollar text-danger mr-2"></i> Pratinjau Rekapitulasi Potongan Gaji</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print();" class="btn-print"><i class="fas fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close();" class="btn-close-doc"><i class="fas fa-times"></i> Tutup</button>
        </div>
    </div>

    <?php
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    $bulanRomawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    $noSurat = "Nomor : " . date('ymd') . "/POT-KPMH/" . $bulanRomawi[date('n')] . "/" . date('Y');
    
    // Cari nilai potongan alpha
    $alpha_deduction = 0;
    foreach ($potongan_master as $pm) {
        if (strtolower($pm->potongan) == 'alpha') {
            $alpha_deduction = $pm->jml_potongan;
        }
    } 
    ?>

    <div class="page-container">
        <!-- Kop Surat -->
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="<?php echo base_url('assets/img/kpmh.png') ?>" alt="Logo Klinik">
                </td>
                <td class="kop-text">
                    <h1 class="kop-title">KLINIK PRATAMA DR. H.M. HIDAYATULLAH</h1>
                    <div class="kop-subtitle">Pusat Layanan Medis, Rawat Jalan & Penunjang Kesehatan Terpadu</div>
                    <div class="kop-address">
                        Jl. Pemuda No. 45, Banjarmasin, Kalimantan Selatan 70114 | Telp: (0511) 7654321<br>
                        Izin Operasional Dinkes: No. 445/098/Dinkes-Bjm/2022 • Email: hrd@klinikhidayatullah.com
                    </div>
                </td>
                <td style="width: 90px;"></td>
            </tr>
        </table>
        
        <div class="kop-double-line"></div>

        <!-- Judul Laporan -->
        <div class="report-header">
            <div class="report-title-badge">LAPORAN REKAPITULASI POTONGAN GAJI KARYAWAN</div>
            <div class="report-meta-text">
                Periode Bulan: <strong><?php echo isset($bulanIndo[$bulan]) ? $bulanIndo[$bulan] : $bulan; ?> <?php echo $tahun; ?></strong>
            </div>
        </div>

        <!-- Meta Bar -->
        <div class="info-meta-box">
            <div><strong><?php echo $noSurat; ?></strong></div>
            <div>Tarif Potongan Alpha: <strong>Rp <?php echo number_format($alpha_deduction, 0, ',', '.'); ?> / hari</strong></div>
            <div>Dicetak: <strong><?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></strong></div>
        </div>

        <!-- Tabel Data -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="28%">Nama Karyawan</th>
                    <th width="15%">NIK</th>
                    <th width="18%">Potongan Alpha (Absensi)</th>
                    <th width="17%">Potongan Lainnya</th>
                    <th width="17%">Total Potongan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $grand_total = 0;
                $total_alpha_nominal = 0;
                $total_lainnya = 0;
                if(!empty($potongan_gaji)) :
                    foreach($potongan_gaji as $p) : 
                        $pot_alpha = $p->alpha * $alpha_deduction;
                        $pot_lainnya = isset($komponen_per_pegawai[$p->nik]) ? $komponen_per_pegawai[$p->nik]['total'] : 0;
                        $total_potongan = $pot_alpha + $pot_lainnya;
                        
                        $grand_total += $total_potongan;
                        $total_alpha_nominal += $pot_alpha;
                        $total_lainnya += $pot_lainnya;
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td><strong><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                    <td class="text-center font-monospace" style="font-family: monospace;"><?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-right">
                        Rp <?php echo number_format($pot_alpha, 0, ',', '.'); ?>
                        <?php if($p->alpha > 0) : ?>
                            <small class="text-danger" style="display: block; font-size: 10.5px;">(<?php echo $p->alpha ?> hari absen)</small>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">Rp <?php echo number_format($pot_lainnya, 0, ',', '.'); ?></td>
                    <td class="text-right" style="color: #dc2626; font-weight: 700;">Rp <?php echo number_format($total_potongan, 0, ',', '.'); ?></td>
                </tr>
                <?php 
                    endforeach; 
                else :
                ?>
                <tr>
                    <td colspan="6" class="text-center" style="padding: 25px; color: #64748b; font-style: italic;">
                        <i class="fas fa-info-circle mr-1"></i> Tidak ada data potongan kehadiran pada periode bulan ini.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
            <?php if(!empty($potongan_gaji)) : ?>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">TOTAL KESELURUHAN POTONGAN :</td>
                    <td class="text-right">Rp <?php echo number_format($total_alpha_nominal, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($total_lainnya, 0, ',', '.'); ?></td>
                    <td class="text-right" style="background: #fee2e2; color: #b91c1c; font-size: 12.5px;"><strong>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>

        <!-- Blok Tanda Tangan -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-title">Mengetahui & Memeriksa,</div>
                        <div class="signature-role">Kepala Bagian SDM & Personalia</div>
                        <div class="qr-wrapper">
                            <img src="<?php echo base_url('assets/img/qr-dummy.png?v=' . time()) ?>" alt="Validasi Digital">
                        </div>
                        <div class="signature-name">Ahmad Fauzi, S.E.</div>
                        <div class="signature-nip">NIK: 201901004</div>
                    </td>
                    <td>
                        <div class="signature-title">Banjarmasin, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></div>
                        <div class="signature-role">Direktur Utama Klinik</div>
                        <div class="qr-wrapper">
                            <img src="<?php echo base_url('assets/img/qr-dummy.png?v=' . time()) ?>" alt="Validasi Digital">
                        </div>
                        <div class="signature-name">Dr. H. Muhammad Hidayatullah</div>
                        <div class="signature-nip">SIP: 445/098/Dinkes-Bjm/2022</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
