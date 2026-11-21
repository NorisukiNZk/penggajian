<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  @page { margin: 16mm 18mm; }
  body { font-family: DejaVu Serif, Georgia, serif; font-size: 10.5px; color: #141D26; line-height: 1.5; }
  .kop { width: 100%; border-bottom: 2px solid #18293D; padding-bottom: 8px; margin-bottom: 3px; border-collapse: collapse; }
  .kop-rule { border-top: 1px solid #18293D; margin-bottom: 14px; }
  .doc-head { text-align: center; margin-bottom: 14px; }
  .doc-title { font-size: 13px; font-weight: bold; text-decoration: underline; letter-spacing: 0.4px; }
  .pasal { font-weight: bold; margin-top: 10px; margin-bottom: 4px; color: #18293D; border-bottom: 1px solid #E2DDD3; padding-bottom: 2px; }
  .detail { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
  .detail td { padding: 3px 4px; vertical-align: top; font-size: 10px; }
  .sign { width: 100%; border-collapse: collapse; margin-top: 22px; page-break-inside: avoid; }
  .sign td { width: 50%; text-align: center; vertical-align: top; font-size: 10px; }
</style>
</head>
<body>
<?php
$logo_uri = Pdf_exporter::localImageDataUri('assets/img/kpmh.png');
$bulanRomawi = array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
$tgl_ref = !empty($p->tgl_disetujui) ? $p->tgl_disetujui : $p->tgl_pengajuan;
$bln = (int)date('n', strtotime($tgl_ref));
$thn = date('Y', strtotime($tgl_ref));
$noSurat = sprintf('%04d', $p->id_pinjaman) . '/SPPK-HRD/' . $bulanRomawi[$bln] . '/' . $thn;
$cicilan = ceil($p->jumlah_pinjaman / max(1, (int)$p->tenor_bulan));
$bulanIndo = array(
  '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
  '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
  '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
);
?>
<table class="kop">
  <tr>
    <td style="width: 72px; text-align: center;"><?php if ($logo_uri !== '') : ?><img src="<?php echo $logo_uri; ?>" width="64" alt="Logo Klinik"><?php endif; ?></td>
    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
      <div style="font-size: 14px; font-weight: bold; color: #18293D;">KLINIK PRATAMA DR. H.M. HIDAYATULLAH</div>
      <div style="font-size: 9px; color: #374151;">Layanan Kesehatan Masyarakat Terpadu &amp; Manajemen SDM</div>
      <div style="font-size: 8.5px; color: #4B5563;">Jl. A. Yani KM 23 RT 01 RW 02, Banjarbaru, Kalsel 70724 | Telp: (0511) 4705000</div>
    </td>
    <td style="width: 72px;"></td>
  </tr>
</table>
<div class="kop-rule"></div>

<div class="doc-head">
  <div class="doc-title">SURAT PERJANJIAN PINJAMAN KARYAWAN (SPPK)</div>
  <div style="font-size: 10px; font-weight: bold;">&amp; SURAT KUASA PEMOTONGAN GAJI / PESANGON</div>
  <div style="font-size: 9.5px; color: #4B5563; margin-top: 3px;">Nomor: <?php echo htmlspecialchars($noSurat, ENT_QUOTES, 'UTF-8'); ?></div>
</div>

<p>Pada hari ini, <strong><?php echo date('d', strtotime($tgl_ref)) . ' ' . $bulanIndo[date('m', strtotime($tgl_ref))] . ' ' . date('Y', strtotime($tgl_ref)); ?></strong>, bertempat di Kantor Manajemen Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru, telah disepakati perjanjian pinjaman kasbon kerja antara:</p>

<table class="detail">
  <tr>
    <td style="width: 34%;">I. Pihak Pertama (Pemberi)</td>
    <td style="width: 3%;">:</td>
    <td><strong>KLINIK PRATAMA DR. H.M. HIDAYATULLAH</strong>, diwakili oleh <strong>Dr. H. Muhammad Hidayatullah</strong> selaku Pimpinan Klinik.</td>
  </tr>
  <tr>
    <td>II. Pihak Kedua (Peminjam)</td>
    <td>:</td>
    <td><strong><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong> (NIK: <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?>), Jabatan: <strong><?php echo htmlspecialchars((string)$p->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></strong>.</td>
  </tr>
</table>

<div class="pasal">Pasal 1 : Pokok Pinjaman &amp; Skema Angsuran</div>
<table class="detail">
  <tr><td style="width: 34%;">Total Nominal Pinjaman</td><td style="width: 3%;">:</td><td><strong>Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?></strong></td></tr>
  <tr><td>Jangka Waktu (Tenor)</td><td>:</td><td><strong><?php echo (int)$p->tenor_bulan; ?> Bulan</strong></td></tr>
  <tr><td>Angsuran per Bulan</td><td>:</td><td><strong>Rp <?php echo number_format($cicilan, 0, ',', '.'); ?> / bulan</strong></td></tr>
  <tr><td>Mekanisme Pembayaran</td><td>:</td><td>Pemotongan otomatis pada sistem payroll penggajian bulanan Pihak Kedua.</td></tr>
  <tr><td>Keperluan Kasbon</td><td>:</td><td><em>"<?php echo htmlspecialchars($p->alasan, ENT_QUOTES, 'UTF-8'); ?>"</em></td></tr>
</table>

<div class="pasal">Pasal 2 : Hak Kuasa Pemotongan Gaji &amp; Jaminan Hukum</div>
<p style="margin: 4px 0;">1. <strong>Kuasa Pemotongan Gaji Mutlak:</strong> Pihak Kedua memberikan kuasa penuh kepada Pihak Pertama untuk memotong penghasilan bulanan sebesar nilai angsuran sampai seluruh kewajiban lunas.</p>
<p style="margin: 4px 0;">2. <strong>Klausul Berhenti Bekerja:</strong> Apabila Pihak Kedua mengundurkan diri (<em>resign</em>), PHK, atau berhenti bekerja sebelum tenor berakhir, seluruh sisa pinjaman jatuh tempo seketika dan diperhitungkan terhadap hak keuangan terakhir pegawai.</p>

<div class="pasal">Pasal 3 : Data Kontak Penjamin / Darurat</div>
<p style="margin: 4px 0;">
  <strong>Nama Penjamin:</strong> <?php echo !empty($p->kontak_darurat_nama) ? htmlspecialchars($p->kontak_darurat_nama, ENT_QUOTES, 'UTF-8') : '-'; ?>
  (<?php echo !empty($p->kontak_darurat_hubungan) ? htmlspecialchars($p->kontak_darurat_hubungan, ENT_QUOTES, 'UTF-8') : '-'; ?>) |
  <strong>No. HP/WA:</strong> <?php echo !empty($p->kontak_darurat_hp) ? htmlspecialchars($p->kontak_darurat_hp, ENT_QUOTES, 'UTF-8') : '-'; ?>
</p>

<table class="sign">
  <tr>
    <td>
      <div>Pihak Kedua (Peminjam),</div>
      <div style="height: 82px;"></div>
      <div style="font-weight: bold; text-decoration: underline;"><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
      <div>NIK. <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></div>
    </td>
    <td>
      <div>Banjarbaru, <?php echo date('d', strtotime($tgl_ref)) . ' ' . $bulanIndo[date('m', strtotime($tgl_ref))] . ' ' . date('Y', strtotime($tgl_ref)); ?></div>
      <div>Pihak Pertama (Pemberi Pinjaman),</div>
      <?php echo render_qr_dokumen('sppk', $p->id_pinjaman, '', 72, true); ?>
      <div style="font-weight: bold; text-decoration: underline;">Dr. H. Muhammad Hidayatullah</div>
      <div>SIP: 445/098/Dinkes-Bjb/2022</div>
    </td>
  </tr>
</table>
</body>
</html>
