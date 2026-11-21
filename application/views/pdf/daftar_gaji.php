<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  @page { margin: 14mm 12mm; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 8.5px; color: #141D26; line-height: 1.35; }
  .kop { width: 100%; border-bottom: 2px solid #18293D; padding-bottom: 6px; margin-bottom: 3px; border-collapse: collapse; }
  .kop-rule { border-top: 1px solid #18293D; margin-bottom: 10px; }
  .doc-title { text-align: center; margin-bottom: 10px; }
  .doc-badge { display: inline-block; background: #18293D; color: #FFFFFF; padding: 4px 12px; font-weight: bold; font-size: 10.5px; }
  .tbl { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  .tbl th { background: #18293D; color: #FFFFFF; padding: 5px 4px; font-size: 7.5px; border: 1px solid #18293D; text-align: center; }
  .tbl td { padding: 4px; border: 1px solid #D9D2C5; font-size: 8px; }
  .tbl tfoot td { background: #F6F4EF; font-weight: bold; }
  .num { text-align: right; }
  .ctr { text-align: center; }
  .sign { width: 100%; border-collapse: collapse; margin-top: 10px; page-break-inside: avoid; }
</style>
</head>
<body>
<?php
$logo_uri = Pdf_exporter::localImageDataUri('assets/img/kpmh.png');
$alpha = Payroll_calculator::extractAlphaRate($potongan);
$bulanIndo = array(
  '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
  '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
  '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
);
$namaBulan = isset($bulanIndo[$bulan]) ? $bulanIndo[$bulan] : $bulan;
?>
<table class="kop">
  <tr>
    <td style="width: 68px; text-align: center;"><?php if ($logo_uri !== '') : ?><img src="<?php echo $logo_uri; ?>" width="54" alt="Logo"><?php endif; ?></td>
    <td style="text-align: center;">
      <div style="font-size: 13px; font-weight: bold; color: #18293D;">KLINIK PRATAMA DR. H.M. HIDAYATULLAH</div>
      <div style="font-size: 8.5px; color: #0F5132; font-weight: bold;">Rekapitulasi Penggajian Resmi Pegawai &amp; Tenaga Kesehatan</div>
      <div style="font-size: 8px; color: #525E6B;">Jl. A. Yani KM 23 RT 01 RW 02, Kota Banjarbaru, Kalsel 70724 | Telp: (0511) 4705000</div>
    </td>
    <td style="width: 68px;"></td>
  </tr>
</table>
<div class="kop-rule"></div>

<div class="doc-title">
  <div class="doc-badge">LAPORAN REKAPITULASI GAJI PEGAWAI</div>
  <div style="font-size: 9px; color: #525E6B; margin-top: 3px;">Periode Pembayaran: <strong><?php echo $namaBulan . ' ' . $tahun; ?></strong></div>
</div>

<table class="tbl">
  <thead>
    <tr>
      <th width="3%">No</th>
      <th width="8%">NIK</th>
      <th width="16%">Nama Pegawai</th>
      <th width="11%">Jabatan</th>
      <th width="9%">Gapok</th>
      <th width="8%">Transport</th>
      <th width="8%">Makan</th>
      <th width="8%">Lembur</th>
      <th width="7%">Tj. Lain</th>
      <th width="7%">Alpha</th>
      <th width="7%">Pot. Lain</th>
      <th width="8%">Kasbon</th>
      <th width="10%">Total Bersih</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $g_gapok = $g_tr = $g_mk = $g_lm = $g_tj = $g_al = $g_pt = $g_pj = $g_thp = 0;
    foreach ($cetak_gaji as $g) :
      $komp = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik] : array();
      $calc = Payroll_calculator::calculateSlip(array(
        'gaji_pokok'        => $g->gaji_pokok,
        'tj_transport'      => $g->tj_transport,
        'uang_makan'        => $g->uang_makan,
        'tunjangan_dinamis' => isset($komp['tunjangan']['total']) ? $komp['tunjangan']['total'] : 0,
        'uang_lembur'       => isset($komp['uang_lembur']) ? $komp['uang_lembur'] : 0,
        'alpha'             => $g->alpha,
        'alpha_rate'        => $alpha,
        'potongan_dinamis'  => isset($komp['potongan']['total']) ? $komp['potongan']['total'] : 0,
        'potongan_pinjaman' => isset($komp['pinjaman']['total']) ? $komp['pinjaman']['total'] : 0
      ));
      $g_gapok += $calc['gaji_pokok']; $g_tr += $calc['tj_transport']; $g_mk += $calc['uang_makan'];
      $g_lm += $calc['uang_lembur']; $g_tj += $calc['tunjangan_dinamis']; $g_al += $calc['pot_alpha'];
      $g_pt += $calc['potongan_dinamis']; $g_pj += $calc['potongan_pinjaman']; $g_thp += $calc['gaji_bersih_raw'];
    ?>
      <tr>
        <td class="ctr"><?php echo $no++; ?></td>
        <td class="ctr"><?php echo htmlspecialchars($g->nik, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><strong><?php echo htmlspecialchars($g->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        <td><?php echo htmlspecialchars($g->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="num"><?php echo number_format($calc['gaji_pokok'], 0, ',', '.'); ?></td>
        <td class="num"><?php echo number_format($calc['tj_transport'], 0, ',', '.'); ?></td>
        <td class="num"><?php echo number_format($calc['uang_makan'], 0, ',', '.'); ?></td>
        <td class="num"><?php echo number_format($calc['uang_lembur'], 0, ',', '.'); ?></td>
        <td class="num"><?php echo number_format($calc['tunjangan_dinamis'], 0, ',', '.'); ?></td>
        <td class="num" style="color:#991B1B;"><?php echo $calc['pot_alpha'] > 0 ? '-' . number_format($calc['pot_alpha'], 0, ',', '.') : '-'; ?></td>
        <td class="num" style="color:#991B1B;"><?php echo $calc['potongan_dinamis'] > 0 ? '-' . number_format($calc['potongan_dinamis'], 0, ',', '.') : '-'; ?></td>
        <td class="num" style="color:#991B1B;"><?php echo $calc['potongan_pinjaman'] > 0 ? '-' . number_format($calc['potongan_pinjaman'], 0, ',', '.') : '-'; ?></td>
        <td class="num"><strong><?php echo number_format($calc['gaji_bersih_raw'], 0, ',', '.'); ?></strong></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" class="ctr">TOTAL REKAPITULASI (RP)</td>
      <td class="num"><?php echo number_format($g_gapok, 0, ',', '.'); ?></td>
      <td class="num"><?php echo number_format($g_tr, 0, ',', '.'); ?></td>
      <td class="num"><?php echo number_format($g_mk, 0, ',', '.'); ?></td>
      <td class="num"><?php echo number_format($g_lm, 0, ',', '.'); ?></td>
      <td class="num"><?php echo number_format($g_tj, 0, ',', '.'); ?></td>
      <td class="num" style="color:#991B1B;">-<?php echo number_format($g_al, 0, ',', '.'); ?></td>
      <td class="num" style="color:#991B1B;">-<?php echo number_format($g_pt, 0, ',', '.'); ?></td>
      <td class="num" style="color:#991B1B;">-<?php echo number_format($g_pj, 0, ',', '.'); ?></td>
      <td class="num"><?php echo number_format($g_thp, 0, ',', '.'); ?></td>
    </tr>
  </tfoot>
</table>

<table class="sign">
  <tr>
    <td style="width: 65%;"></td>
    <td style="width: 35%; text-align: center;">
      <div>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></div>
      <div style="color:#525E6B;">Pimpinan Klinik Pratama</div>
      <?php echo render_qr_dokumen('lap_gaji', 'KLINIK', $bulan . $tahun, 70, true); ?>
      <div style="font-weight: bold; text-decoration: underline;">Dr. H. Muhammad Hidayatullah</div>
      <div style="color:#525E6B;">SIP: 445/098/Dinkes-Bjb/2022</div>
    </td>
  </tr>
</table>
</body>
</html>
