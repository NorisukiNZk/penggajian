<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
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
            max-width: 860px;
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
            max-width: 860px;
            margin: 0 auto 30px auto;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            position: relative;
            page-break-after: always;
        }
        .page-container:last-child {
            page-break-after: auto;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .kop-logo {
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 70px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding: 0 10px;
        }
        .kop-title {
            font-size: 18px;
            font-weight: 800;
            color: #0c2b4d;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin: 0 0 2px 0;
        }
        .kop-subtitle {
            font-size: 11px;
            font-weight: 600;
            color: #0284c7;
            margin: 0 0 2px 0;
        }
        .kop-address {
            font-size: 10.5px;
            color: #475569;
            margin: 0;
            line-height: 1.35;
        }
        .kop-double-line {
            height: 3px;
            background: #0c2b4d;
            border-bottom: 1px solid #0c2b4d;
            margin-top: 10px;
            margin-bottom: 16px;
        }

        /* Header Judul Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 16px;
        }
        .report-title-badge {
            display: inline-block;
            font-size: 14px;
            font-weight: 700;
            color: #0c2b4d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 3px;
            margin-bottom: 4px;
        }

        /* Info Pegawai Grid */
        .pegawai-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 24px;
            font-size: 11.5px;
        }
        .pegawai-item {
            display: flex;
            justify-content: space-between;
        }
        .pegawai-label {
            color: #64748b;
            font-weight: 500;
        }
        .pegawai-val {
            color: #0f172a;
            font-weight: 700;
        }

        /* Tabel Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 11.5px;
        }
        table.data-table thead th {
            background-color: #0c2b4d;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            padding: 8px;
            border: 1px solid #0c2b4d;
            font-size: 11px;
        }
        table.data-table tbody td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            vertical-align: middle;
            color: #1e293b;
        }
        table.data-table tbody tr.section-header td {
            font-weight: 700;
            letter-spacing: 0.4px;
            font-size: 11px;
            padding: 7px 12px;
        }
        table.data-table tbody tr.section-header.income td {
            background-color: #f0fdf4;
            color: #166534;
            border-left: 3px solid #16a34a;
        }
        table.data-table tbody tr.section-header.deduct td {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 3px solid #dc2626;
        }
        table.data-table tbody td.text-right {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }
        table.data-table tbody td.text-center {
            text-align: center;
        }
        table.data-table tfoot td {
            background-color: #0c2b4d;
            color: #ffffff;
            font-weight: 700;
            padding: 10px 14px;
            font-size: 13px;
        }

        /* Tanda Tangan */
        .signature-section {
            width: 100%;
            margin-top: 25px;
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
            padding: 0 20px;
        }
        .signature-title {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .signature-role {
            font-size: 11.5px;
            font-weight: 600;
            color: #0c2b4d;
            margin-bottom: 10px;
        }
        .qr-wrapper {
            margin: 4px auto;
            width: 65px;
            height: 65px;
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
            font-size: 10px;
            color: #64748b;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.04;
            z-index: 0;
            width: 320px;
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
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>

    <img src="<?php echo base_url('assets/img/kpmh.png') ?>" class="watermark" alt="Watermark">

    <!-- Floating Action Bar -->
    <div class="print-action-bar">
        <div>
            <span style="font-weight: 700; color: #0c2b4d; font-size: 14px;"><i class="fas fa-receipt text-success mr-2"></i> Pratinjau Slip Gaji Resmi Pegawai</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print();" class="btn-print"><i class="fas fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close();" class="btn-close-doc"><i class="fas fa-times"></i> Tutup</button>
        </div>
    </div>

    <?php
    $bulanIndo = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    $bulanRomawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    
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
        $pinjaman = isset($komponen_per_pegawai[$ps->nik]['pinjaman']) ? $komponen_per_pegawai[$ps->nik]['pinjaman'] : array('total' => 0, 'detail' => []);
        
        $total_gaji = $ps->gaji_pokok + $ps->tj_transport + $ps->uang_makan + $uang_lembur + $tj_detail['total'] - $potongan_gaji - $pot_detail['total'] - (isset($pinjaman['total']) ? $pinjaman['total'] : 0);
        
        $bulanAngka = substr($ps->bulan, 0, 2);
        $tahunAngka = substr($ps->bulan, 2, 4);
        $noSurat = "Nomor : " . date('ymd') . "/SLIP-KPMH/" . $bulanRomawi[date('n')] . "/" . date('Y');
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
                    <td style="width: 80px;"></td>
                </tr>
            </table>
            
            <div class="kop-double-line"></div>

            <!-- Judul Slip -->
            <div class="report-header">
                <div class="report-title-badge">SLIP GAJI & REMUNERASI PEGAWAI</div>
                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                    <?php echo $noSurat; ?> • Bersifat Rahasia (Confidential)
                </div>
            </div>

            <!-- Kartu Info Pegawai -->
            <div class="pegawai-card">
                <div class="pegawai-item">
                    <span class="pegawai-label">Nama Pegawai</span>
                    <span class="pegawai-val"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="pegawai-item">
                    <span class="pegawai-label">Bulan Penggajian</span>
                    <span class="pegawai-val"><?php echo isset($bulanIndo[$bulanAngka]) ? $bulanIndo[$bulanAngka] : $bulanAngka; ?> <?php echo htmlspecialchars($tahunAngka, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="pegawai-item">
                    <span class="pegawai-label">Nomor Induk Karyawan (NIK)</span>
                    <span class="pegawai-val font-monospace"><?php echo htmlspecialchars($ps->nik, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="pegawai-item">
                    <span class="pegawai-label">Jabatan / Posisi</span>
                    <span class="pegawai-val"><?php echo htmlspecialchars($ps->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>

            <!-- Tabel Komponen Gaji -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="8%">No</th>
                        <th width="62%">Deskripsi Komponen Penerimaan / Potongan</th>
                        <th width="30%">Jumlah Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Bagian Pendapatan -->
                    <tr class="section-header income">
                        <td colspan="3"><i class="fas fa-plus-circle mr-1"></i> A. KOMPONEN PENDAPATAN & TUNJANGAN</td>
                    </tr>
                    <?php $no = 1; ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>Gaji Pokok</td>
                        <td class="text-right">Rp <?php echo number_format($ps->gaji_pokok, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>Tunjangan Transportasi</td>
                        <td class="text-right">Rp <?php echo number_format($ps->tj_transport, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>Uang Makan</td>
                        <td class="text-right">Rp <?php echo number_format($ps->uang_makan, 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                    if ($uang_lembur > 0) : 
                        $jam_lembur = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik]['jam_lembur'] : 0;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>Uang Lembur Terverifikasi (<?php echo $jam_lembur; ?> Jam)</td>
                        <td class="text-right">Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($tj_detail['detail'] as $td) : ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($td['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?> <?php echo $td['is_persentase'] ? '(' . $td['nominal'] . '%)' : '' ?></td>
                        <td class="text-right">Rp <?php echo number_format($td['nominal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- Bagian Potongan -->
                    <tr class="section-header deduct">
                        <td colspan="3"><i class="fas fa-minus-circle mr-1"></i> B. KOMPONEN POTONGAN & KEWAJIBAN</td>
                    </tr>
                    <?php $no_pot = 1; ?>
                    <tr>
                        <td class="text-center"><?php echo $no_pot++; ?></td>
                        <td>Potongan Kehadiran Alpha (<?php echo htmlspecialchars($ps->alpha, ENT_QUOTES, 'UTF-8'); ?> hari @ Rp <?php echo number_format($alpha_deduction, 0, ',', '.'); ?>)</td>
                        <td class="text-right" style="color: #dc2626;">Rp <?php echo number_format($potongan_gaji, 0, ',', '.'); ?></td>
                    </tr>
                    <?php foreach ($pot_detail['detail'] as $pd) : ?>
                    <tr>
                        <td class="text-center"><?php echo $no_pot++; ?></td>
                        <td><?php echo htmlspecialchars($pd['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-right" style="color: #dc2626;">Rp <?php echo number_format($pd['nominal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php 
                    if (!empty($pinjaman['detail'])) : 
                        foreach ($pinjaman['detail'] as $pj) :
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no_pot++; ?></td>
                        <td><span style="color: #b91c1c; font-weight: 600;"><i class="fas fa-hand-holding-usd mr-1"></i> <?php echo htmlspecialchars($pj['keterangan'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td class="text-right" style="color: #b91c1c; font-weight: 600;">Rp <?php echo number_format($pj['nominal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">TOTAL GAJI BERSIH (TAKE HOME PAY) :</td>
                        <td class="text-right" style="font-size: 14px; letter-spacing: 0.5px;">Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Blok Tanda Tangan -->
            <div class="signature-section">
                <table class="signature-table">
                    <tr>
                        <td>
                            <div class="signature-title">Tanda Tangan Penerima,</div>
                            <div class="signature-role">Pegawai Yang Bersangkutan</div>
                            <div style="height: 65px; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 24px;">
                                <i class="fas fa-signature"></i>
                            </div>
                            <div class="signature-name"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="signature-nip">NIK: <?php echo htmlspecialchars($ps->nik, ENT_QUOTES, 'UTF-8'); ?></div>
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

    <?php endforeach; ?>

</body>
</html>