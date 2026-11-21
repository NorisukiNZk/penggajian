<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  @page { margin: 16mm 16mm 14mm 16mm; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #141D26; line-height: 1.45; }
  .kop { width: 100%; border-bottom: 2px solid #18293D; padding-bottom: 8px; margin-bottom: 4px; border-collapse: collapse; }
  .kop-rule { border-top: 1px solid #18293D; margin-bottom: 12px; }
  .doc-title { text-align: center; margin-bottom: 12px; }
  .doc-badge { display: inline-block; background: #18293D; color: #FFFFFF; padding: 4px 12px; font-weight: bold; font-size: 11px; letter-spacing: 0.5px; }
  .doc-no { font-size: 9px; color: #525E6B; margin-top: 4px; }
  .meta-box { width: 100%; background: #F6F4EF; border: 1px solid #D9D2C5; border-collapse: collapse; margin-bottom: 12px; }
  .meta-box td { padding: 5px 8px; font-size: 9.5px; }
  .meta-label { color: #525E6B; width: 22%; }
  .meta-val { font-weight: bold; color: #141D26; width: 28%; }
  .slip-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  .slip-table th { background: #18293D; color: #FFFFFF; padding: 6px 8px; text-align: left; font-size: 9px; text-transform: uppercase; }
  .slip-table td { border-bottom: 1px solid #E2DDD3; padding: 5px 8px; font-size: 9.5px; }
  .sec-income td { background: #ECFDF5; color: #0F5132; font-weight: bold; font-size: 9px; }
  .sec-deduct td { background: #FEF2F2; color: #991B1B; font-weight: bold; font-size: 9px; }
  .total-row td { background: #18293D; color: #FFFFFF; font-weight: bold; font-size: 11px; padding: 8px; }
  .num { text-align: right; }
  .ctr { text-align: center; }
  .sign-table { width: 100%; border-collapse: collapse; margin-top: 18px; page-break-inside: avoid; }
  .sign-table td { width: 50%; text-align: center; vertical-align: top; font-size: 9.5px; padding: 4px 10px; }
  .page-break { page-break-after: always; }
</style>
</head>
<body>
<?php
$logo_uri = Pdf_exporter::localImageDataUri('assets/img/kpmh.png');
$alpha_deduction = Payroll_calculator::extractAlphaRate($potongan);
$bulanIndo = array(
  '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
  '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
  '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
);
$bulanRomawi = array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
$total_count = count($print_slip);
$idx = 0;

foreach ($print_slip as $ps) :
  $idx++;
  $komp        = isset($komponen_per_pegawai[$ps->nik]) ? $komponen_per_pegawai[$ps->nik] : array();
  $tj_detail   = isset($komp['tunjangan']) ? $komp['tunjangan'] : array('total' => 0, 'detail' => array());
  $pot_detail  = isset($komp['potongan']) ? $komp['potongan'] : array('total' => 0, 'detail' => array());
  $pinjaman    = isset($komp['pinjaman']) ? $komp['pinjaman'] : array('total' => 0, 'detail' => array());
  $uang_lembur = isset($komp['uang_lembur']) ? (float)$komp['uang_lembur'] : 0;
  $jam_lembur  = isset($komp['jam_lembur']) ? (float)$komp['jam_lembur'] : 0;

  $calc = Payroll_calculator::calculateSlip(array(
    'gaji_pokok'        => $ps->gaji_pokok,
    'tj_transport'      => $ps->tj_transport,
    'uang_makan'        => $ps->uang_makan,
    'tunjangan_dinamis' => $tj_detail['total'],
    'uang_lembur'       => $uang_lembur,
    'alpha'             => $ps->alpha,
    'alpha_rate'        => $alpha_deduction,
    'potongan_dinamis'  => $pot_detail['total'],
    'potongan_pinjaman' => $pinjaman['total']
  ));

  $bulanAngka = substr($ps->bulan, 0, 2);
  $tahunAngka = substr($ps->bulan, 2, 4);
  $bln_int    = (int)$bulanAngka;
  $romawi     = isset($bulanRomawi[$bln_int]) ? $bulanRomawi[$bln_int] : 'I';
  $noSurat    = $tahunAngka . sprintf('%02d', $bln_int) . '/SLIP-KPMH/' . $romawi . '/' . $tahunAngka;
?>
  <div class="<?php echo ($idx < $total_count) ? 'page-break' : ''; ?>">
    <table class="kop">
      <tr>
        <td style="width: 72px; text-align: center;">
          <?php if ($logo_uri !== '') : ?><img src="<?php echo $logo_uri; ?>" width="62" alt="Logo Klinik"><?php endif; ?>
        </td>
        <td style="text-align: center;">
          <div style="font-size: 14px; font-weight: bold; color: #18293D; letter-spacing: 0.6px;">KLINIK PRATAMA DR. H.M. HIDAYATULLAH</div>
          <div style="font-size: 9.5px; font-weight: bold; color: #0F5132; margin-top: 2px;">Pusat Layanan Medis, Rawat Jalan &amp; Penunjang Kesehatan Terpadu</div>
          <div style="font-size: 8.5px; color: #525E6B; margin-top: 2px;">
            Jl. A. Yani KM 23 RT 01 RW 02, Kel. Landasan Ulin Barat, Banjarbaru, Kalsel 70724<br>
            Izin Operasional Dinkes: No. 445/098/Dinkes-Bjb/2022 | Telp: (0511) 4705000
          </div>
        </td>
        <td style="width: 72px;"></td>
      </tr>
    </table>
    <div class="kop-rule"></div>

    <div class="doc-title">
      <div class="doc-badge">SLIP GAJI &amp; REMUNERASI PEGAWAI</div>
      <div class="doc-no">Nomor: <?php echo htmlspecialchars($noSurat, ENT_QUOTES, 'UTF-8'); ?> | Rahasia (Confidential)</div>
    </div>

    <table class="meta-box">
      <tr>
        <td class="meta-label">Nama Pegawai</td>
        <td class="meta-val"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="meta-label">Periode Gaji</td>
        <td class="meta-val"><?php echo (isset($bulanIndo[$bulanAngka]) ? $bulanIndo[$bulanAngka] : $bulanAngka) . ' ' . htmlspecialchars($tahunAngka, ENT_QUOTES, 'UTF-8'); ?></td>
      </tr>
      <tr>
        <td class="meta-label">NIK</td>
        <td class="meta-val"><?php echo htmlspecialchars($ps->nik, ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="meta-label">Jabatan</td>
        <td class="meta-val"><?php echo htmlspecialchars($ps->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
      </tr>
    </table>

    <table class="slip-table">
      <thead>
        <tr>
          <th class="ctr" style="width: 8%;">No</th>
          <th style="width: 62%;">Komponen Penerimaan / Potongan</th>
          <th class="num" style="width: 30%;">Nominal (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <tr class="sec-income"><td colspan="3">A. KOMPONEN PENDAPATAN &amp; TUNJANGAN</td></tr>
        <?php $no = 1; ?>
        <tr><td class="ctr"><?php echo $no++; ?></td><td>Gaji Pokok</td><td class="num">Rp <?php echo number_format($calc['gaji_pokok'], 0, ',', '.'); ?></td></tr>
        <tr><td class="ctr"><?php echo $no++; ?></td><td>Tunjangan Transportasi</td><td class="num">Rp <?php echo number_format($calc['tj_transport'], 0, ',', '.'); ?></td></tr>
        <tr><td class="ctr"><?php echo $no++; ?></td><td>Uang Makan</td><td class="num">Rp <?php echo number_format($calc['uang_makan'], 0, ',', '.'); ?></td></tr>
        <?php if ($uang_lembur > 0) : ?>
          <tr><td class="ctr"><?php echo $no++; ?></td><td>Uang Lembur Terverifikasi (<?php echo (int)$jam_lembur; ?> Jam)</td><td class="num">Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></td></tr>
        <?php endif; ?>
        <?php foreach ($tj_detail['detail'] as $td) : ?>
          <tr>
            <td class="ctr"><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($td['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?> <?php echo (!empty($td['is_persentase']) && !empty($td['persen_raw'])) ? '(' . $td['persen_raw'] . '%)' : ''; ?></td>
            <td class="num">Rp <?php echo number_format($td['nominal'], 0, ',', '.'); ?></td>
          </tr>
        <?php endforeach; ?>

        <tr class="sec-deduct"><td colspan="3">B. KOMPONEN POTONGAN &amp; KEWAJIBAN</td></tr>
        <?php $np = 1; ?>
        <tr>
          <td class="ctr"><?php echo $np++; ?></td>
          <td>Potongan Alpha (<?php echo (int)$ps->alpha; ?> hari x Rp <?php echo number_format($alpha_deduction, 0, ',', '.'); ?>)</td>
          <td class="num" style="color: #991B1B;">Rp <?php echo number_format($calc['pot_alpha'], 0, ',', '.'); ?></td>
        </tr>
        <?php foreach ($pot_detail['detail'] as $pd) : ?>
          <tr>
            <td class="ctr"><?php echo $np++; ?></td>
            <td><?php echo htmlspecialchars($pd['nama_komponen'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="num" style="color: #991B1B;">Rp <?php echo number_format($pd['nominal'], 0, ',', '.'); ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (!empty($pinjaman['detail'])) : foreach ($pinjaman['detail'] as $pj) : ?>
          <tr>
            <td class="ctr"><?php echo $np++; ?></td>
            <td style="color: #991B1B; font-weight: bold;"><?php echo htmlspecialchars($pj['keterangan'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="num" style="color: #991B1B; font-weight: bold;">Rp <?php echo number_format($pj['nominal'], 0, ',', '.'); ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
      <tfoot>
        <tr class="total-row">
          <td colspan="2" class="num">TOTAL GAJI BERSIH (TAKE HOME PAY)</td>
          <td class="num">Rp <?php echo number_format($calc['gaji_bersih_raw'], 0, ',', '.'); ?></td>
        </tr>
      </tfoot>
    </table>

    <table class="sign-table">
      <tr>
        <td>
          <div>Penerima Gaji,</div>
          <div style="color: #525E6B;">Pegawai Yang Bersangkutan</div>
          <div style="height: 78px;"></div>
          <div style="font-weight: bold; text-decoration: underline;"><?php echo htmlspecialchars($ps->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
          <div style="color: #525E6B;">NIK: <?php echo htmlspecialchars($ps->nik, ENT_QUOTES, 'UTF-8'); ?></div>
        </td>
        <td>
          <div>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></div>
          <div style="color: #525E6B;">Direktur Utama Klinik Pratama</div>
          <?php echo render_qr_dokumen('slip', $ps->nik, $ps->bulan, 72, true); ?>
          <div style="font-weight: bold; text-decoration: underline;">Dr. H. Muhammad Hidayatullah</div>
          <div style="color: #525E6B;">SIP: 445/098/Dinkes-Bjb/2022</div>
        </td>
      </tr>
    </table>
  </div>
<?php endforeach; ?>
</body>
</html>
