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

        /* Floating Action Bar (Hanya Tampil di Layar) */
        .print-action-bar {
            max-width: 1100px;
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
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        /* Kop Surat Resmi Klinik */
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

        /* Tabel Data Akuntansi */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11px;
        }
        table.data-table thead th {
            background-color: #0c2b4d;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            padding: 8px 6px;
            border: 1px solid #0c2b4d;
            font-size: 10.5px;
            letter-spacing: 0.2px;
        }
        table.data-table tbody td {
            border: 1px solid #cbd5e1;
            padding: 7px 6px;
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
            padding: 8px 6px;
            color: #0f172a;
        }

        /* Penanda Potongan Merah */
        .text-potongan {
            color: #dc2626;
            font-weight: 500;
        }
        .text-total {
            color: #0c2b4d;
            font-weight: 700;
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
            margin-bottom: 5px;
        }
        .signature-role {
            font-size: 12px;
            font-weight: 600;
            color: #0c2b4d;
            margin-bottom: 12px;
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

        /* Media Print Rules */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                font-size: 10pt;
            }
            .no-print {
                display: none !important;
            }
            .page-container {
                box-shadow: none !important;
                padding: 0 !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            table.data-table thead th {
                background-color: #0c2b4d !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            table.data-table tbody tr:nth-child(even) {
                background-color: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: landscape;
                margin: 10mm 12mm;
            }
        }
    </style>
</head>
<body>

    <img src="<?php echo base_url('assets/img/kpmh.png') ?>" class="watermark" alt="Watermark">

    <!-- Floating Action Bar (Hanya Layar) -->
    <div class="print-action-bar no-print">
        <div class="d-flex align-items-center">
            <span style="font-weight: 600; color: #0c2b4d; font-size: 14px;">
                <i class="fas fa-file-invoice-dollar text-primary mr-2"></i> Dokumen Rekap Gaji Bulanan
            </span>
            <span style="margin-left: 15px; font-size: 12px; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 6px;">
                Orientasi: Landscape
            </span>
        </div>
        <div>
            <button onclick="window.close()" class="btn-close-doc mr-2">
                <i class="fas fa-times"></i> Tutup
            </button>
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Cetak Dokumen / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Halaman Dokumen -->
    <div class="page-container">
        
        <!-- Kop Surat Resmi Klinik -->
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik">
                </td>
                <td class="kop-text">
                    <div class="kop-title">Klinik Pratama Dr. H.M. Hidayatullah</div>
                    <div class="kop-subtitle">Pusat Layanan Kesehatan Terpadu, Gigi, Poli Umum & Penunjang Medis</div>
                    <div class="kop-address">
                        Jl. Pemuda No. 45, Banjarmasin, Kalimantan Selatan 70114 | Telp: (0511) 7654321<br>
                        Izin Operasional Dinas Kesehatan: No. 445/098/Dinkes-Bjm/2022 &bull; Email: hrd@klinikhidayatullah.com
                    </div>
                </td>
            </tr>
        </table>
        <div class="kop-double-line"></div>

        <?php
            $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
            $namaBulan = isset($bulanIndo[$bulan]) ? $bulanIndo[$bulan] : $bulan;
            $bulanRomawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
            $noSurat = "No: " . date('ymd') . "/LAP-GAJI/KPH/" . $bulanRomawi[date('n')] . "/" . $tahun;
        ?>

        <!-- Header Laporan -->
        <div class="report-header">
            <div><span class="report-title-badge">Laporan Rekapitulasi Gaji Pegawai</span></div>
            <div class="report-meta-text">
                Periode Pembayaran: <strong><?php echo $namaBulan . ' ' . $tahun; ?></strong> &bull; <?php echo $noSurat; ?>
            </div>
        </div>

        <!-- Tabel Data Akuntansi -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="3%">NO</th>
                    <th width="8%">NIK</th>
                    <th width="14%">NAMA PEGAWAI</th>
                    <th width="11%">JABATAN</th>
                    <th width="9%">GAJI POKOK</th>
                    <th width="8%">TJ. TRANSPORT</th>
                    <th width="8%">UANG MAKAN</th>
                    <th width="8%">LEMBUR</th>
                    <th width="7%">TJ. LAIN</th>
                    <th width="7%">POT. ALPHA</th>
                    <th width="7%">POT. LAIN</th>
                    <th width="8%">POT. KASBON</th>
                    <th width="10%">TOTAL BERSIH</th>
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

            $grand_gapok = 0;
            $grand_transport = 0;
            $grand_makan = 0;
            $grand_lembur = 0;
            $grand_tj_lain = 0;
            $grand_pot_alpha = 0;
            $grand_pot_lain = 0;
            $grand_pot_pinjaman = 0;
            $grand_total = 0;

            foreach ($cetak_gaji as $g): 
                $potongan_alpha = $g->alpha * $alpha;
                $uang_lembur = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['uang_lembur'] : 0;
                $tj_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['tunjangan']['total'] : 0;
                $pot_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['potongan']['total'] : 0;
                $pot_pinjaman = isset($komponen_per_pegawai[$g->nik]['pinjaman']) ? $komponen_per_pegawai[$g->nik]['pinjaman']['total'] : 0;
                
                $total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $uang_lembur + $tj_lain - $potongan_alpha - $pot_lain - $pot_pinjaman;

                $grand_gapok += $g->gaji_pokok;
                $grand_transport += $g->tj_transport;
                $grand_makan += $g->uang_makan;
                $grand_lembur += $uang_lembur;
                $grand_tj_lain += $tj_lain;
                $grand_pot_alpha += $potongan_alpha;
                $grand_pot_lain += $pot_lain;
                $grand_pot_pinjaman += $pot_pinjaman;
                $grand_total += $total_gaji;
            ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center font-weight-bold"><?php echo htmlspecialchars($g->nik, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><strong><?php echo htmlspecialchars($g->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                    <td><?php echo htmlspecialchars($g->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($g->tj_transport, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($g->uang_makan, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($tj_lain, 0, ',', '.'); ?></td>
                    <td class="text-right text-potongan"><?php echo ($potongan_alpha > 0) ? '-Rp ' . number_format($potongan_alpha, 0, ',', '.') : '-'; ?></td>
                    <td class="text-right text-potongan"><?php echo ($pot_lain > 0) ? '-Rp ' . number_format($pot_lain, 0, ',', '.') : '-'; ?></td>
                    <td class="text-right text-potongan"><?php echo ($pot_pinjaman > 0) ? '-Rp ' . number_format($pot_pinjaman, 0, ',', '.') : '-'; ?></td>
                    <td class="text-right text-total">Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center">TOTAL REKAPITULASI</td>
                    <td class="text-right">Rp <?php echo number_format($grand_gapok, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($grand_transport, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($grand_makan, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($grand_lembur, 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($grand_tj_lain, 0, ',', '.'); ?></td>
                    <td class="text-right text-potongan">-Rp <?php echo number_format($grand_pot_alpha, 0, ',', '.'); ?></td>
                    <td class="text-right text-potongan">-Rp <?php echo number_format($grand_pot_lain, 0, ',', '.'); ?></td>
                    <td class="text-right text-potongan">-Rp <?php echo number_format($grand_pot_pinjaman, 0, ',', '.'); ?></td>
                    <td class="text-right text-total" style="background: #e2e8f0;">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Lembar Tanda Tangan & Validasi -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-title">Dibuat & Diverifikasi oleh,</div>
                        <div class="signature-role">Staff Administrasi & Payroll</div>
                        <div class="qr-wrapper">
                            <img src="<?php echo base_url('assets/img/qr-dummy.png?v=' . time()) ?>" alt="Validasi Digital">
                        </div>
                        <div class="signature-name"><?php echo $this->session->userdata('nama_pegawai') ?? 'Staff Payroll'; ?></div>
                        <div class="signature-nip">Bagian Keuangan & SDM Klinik</div>
                    </td>
                    <td>
                        <div class="signature-title">Banjarmasin, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></div>
                        <div class="signature-role">Direktur Utama Klinik Pratama</div>
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