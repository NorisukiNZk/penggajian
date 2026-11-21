<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  @page { margin: 16mm 18mm; }
  body { font-family: DejaVu Serif, Georgia, serif; font-size: 10.5px; color: #141D26; line-height: 1.48; }
  .kop { width: 100%; border-bottom: 2px solid #18293D; padding-bottom: 8px; margin-bottom: 3px; border-collapse: collapse; }
  .kop-rule { border-top: 1px solid #18293D; margin-bottom: 14px; }
  .doc-head { text-align: center; margin-bottom: 14px; }
  .doc-title { font-size: 13px; font-weight: bold; text-decoration: underline; }
  .sec-title { font-weight: bold; font-size: 10px; background: #F6F4EF; border-left: 3px solid #18293D; padding: 4px 8px; margin: 10px 0 6px 0; font-family: DejaVu Sans, sans-serif; }
  .detail { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
  .detail td { padding: 3px 4px; vertical-align: top; font-size: 10px; }
  .note-box { background: #F6F4EF; border: 1px solid #D9D2C5; padding: 8px 10px; margin: 10px 0; font-size: 9.5px; }
  .sign { width: 100%; border-collapse: collapse; margin-top: 20px; page-break-inside: avoid; }
  .sign td { width: 33.3%; text-align: center; vertical-align: top; font-size: 9.5px; padding: 0 6px; }
</style>
</head>
<body>
<?php
$logo_uri = Pdf_exporter::localImageDataUri('assets/img/kpmh.png');
$bulanRomawi = array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
$bln = (int)date('n', strtotime($cuti->created_at));
$thn = date('Y', strtotime($cuti->created_at));
$noSurat = sprintf('%04d', $cuti->id_cuti) . '/SK-CUTI/' . $bulanRomawi[$bln] . '/' . $thn;
$durasi  = (new DateTime($cuti->tanggal_mulai))->diff(new DateTime($cuti->tanggal_akhir))->days + 1;
$kembali = (new DateTime($cuti->tanggal_akhir))->modify('+1 day');
$bulanIndo = array(
  '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
  '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
  '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
);
?>
<table class="kop">
  <tr>
    <td style="width: 70px; text-align: center;"><?php if ($logo_uri !== '') : ?><img src="<?php echo $logo_uri; ?>" width="60" alt="Logo Klinik"><?php endif; ?></td>
    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
      <div style="font-size: 14px; font-weight: bold; color: #18293D;">KLINIK PRATAMA DR. H.M. HIDAYATULLAH</div>
      <div style="font-size: 9px; color: #374151;">Layanan Kesehatan Masyarakat Terpadu &amp; Manajemen SDM</div>
      <div style="font-size: 8.5px; color: #4B5563;">Jl. A. Yani KM 23 RT 01 RW 02, Banjarbaru, Kalsel 70724 | Telp: (0511) 4705000</div>
    </td>
    <td style="width: 70px;"></td>
  </tr>
</table>
<div class="kop-rule"></div>

<div class="doc-head">
  <div class="doc-title">SURAT KEPUTUSAN IZIN CUTI &amp; PENDELEGASIAN TUGAS</div>
  <div style="font-size: 9.5px; color: #4B5563; margin-top: 3px;">Nomor: <?php echo htmlspecialchars($noSurat, ENT_QUOTES, 'UTF-8'); ?></div>
</div>

<p>Berdasarkan permohonan hak cuti/izin kerja yang telah melalui telaah operasional Manajemen HRD, Direktur Utama Klinik Pratama Hidayatullah menetapkan persetujuan cuti kepada:</p>

<div class="sec-title">I. IDENTITAS PEGAWAI PEMOHON</div>
<table class="detail">
  <tr><td style="width: 34%;">NIK</td><td style="width: 3%;">:</td><td><strong><?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></strong></td></tr>
  <tr><td>Nama Lengkap</td><td>:</td><td><strong><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong></td></tr>
  <tr><td>Jabatan / Unit</td><td>:</td><td><?php echo htmlspecialchars($cuti->jabatan, ENT_QUOTES, 'UTF-8'); ?></td></tr>
  <tr><td>Kategori Cuti</td><td>:</td><td><strong>Cuti <?php echo htmlspecialchars($cuti->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></strong></td></tr>
  <tr><td>Periode Cuti</td><td>:</td><td><strong><?php echo date('d', strtotime($cuti->tanggal_mulai)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_mulai))] . ' ' . date('Y', strtotime($cuti->tanggal_mulai)); ?></strong> s/d <strong><?php echo date('d', strtotime($cuti->tanggal_akhir)) . ' ' . $bulanIndo[date('m', strtotime($cuti->tanggal_akhir))] . ' ' . date('Y', strtotime($cuti->tanggal_akhir)); ?></strong> (<?php echo $durasi; ?> hari)</td></tr>
  <tr><td>Kembali Bekerja</td><td>:</td><td><strong><?php echo $kembali->format('d') . ' ' . $bulanIndo[$kembali->format('m')] . ' ' . $kembali->format('Y'); ?></strong></td></tr>
  <tr><td>Alasan</td><td>:</td><td><?php echo nl2br(htmlspecialchars($cuti->alasan, ENT_QUOTES, 'UTF-8')); ?></td></tr>
</table>

<div class="sec-title">II. PENDELEGASIAN TUGAS SHIFT</div>
<table class="detail">
  <tr><td style="width: 34%;">Petugas Pengganti</td><td style="width: 3%;">:</td><td><?php echo !empty($cuti->nama_pengganti) ? '<strong>' . htmlspecialchars($cuti->nama_pengganti, ENT_QUOTES, 'UTF-8') . '</strong> (' . htmlspecialchars((string)$cuti->jabatan_pengganti, ENT_QUOTES, 'UTF-8') . ')' : 'Tidak ditunjuk khusus'; ?></td></tr>
  <tr><td>Lingkup Tugas</td><td>:</td><td><?php echo !empty($cuti->tugas_pengganti) ? nl2br(htmlspecialchars($cuti->tugas_pengganti, ENT_QUOTES, 'UTF-8')) : 'Pelayanan rutin unit kerja.'; ?></td></tr>
</table>

<?php if (!empty($cuti->catatan_hrd) || !empty($cuti->pesan_admin)) : ?>
<div class="note-box">
  <?php if (!empty($cuti->catatan_hrd)) : ?><div><strong>Telaah HRD:</strong> "<?php echo htmlspecialchars($cuti->catatan_hrd, ENT_QUOTES, 'UTF-8'); ?>"</div><?php endif; ?>
  <?php if (!empty($cuti->pesan_admin)) : ?><div style="margin-top: 3px;"><strong>Keputusan Direksi:</strong> "<?php echo htmlspecialchars($cuti->pesan_admin, ENT_QUOTES, 'UTF-8'); ?>"</div><?php endif; ?>
</div>
<?php endif; ?>

<table class="sign">
  <tr>
    <td>
      <div>Pegawai Pemohon,</div>
      <div style="height: 82px;"></div>
      <div style="font-weight: bold; text-decoration: underline;"><?php echo htmlspecialchars($cuti->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
      <div>NIK. <?php echo htmlspecialchars($cuti->nik, ENT_QUOTES, 'UTF-8'); ?></div>
    </td>
    <td>
      <div>Petugas Pengganti Shift,</div>
      <div style="height: 82px;"></div>
      <div style="font-weight: bold; text-decoration: underline;"><?php echo !empty($cuti->nama_pengganti) ? htmlspecialchars($cuti->nama_pengganti, ENT_QUOTES, 'UTF-8') : '( Rekan Pengganti )'; ?></div>
      <div><?php echo !empty($cuti->jabatan_pengganti) ? htmlspecialchars($cuti->jabatan_pengganti, ENT_QUOTES, 'UTF-8') : 'Petugas Shift'; ?></div>
    </td>
    <td>
      <div>Banjarbaru, <?php echo date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y'); ?></div>
      <div>Mengesahkan &amp; Menyetujui,</div>
      <?php echo render_qr_dokumen('cuti', $cuti->id_cuti, '', 68, true); ?>
      <div style="font-weight: bold; text-decoration: underline;">Dr. H. Muhammad Hidayatullah</div>
      <div>SIP: 445/098/Dinkes-Bjb/2022</div>
    </td>
  </tr>
</table>
</body>
</html>
