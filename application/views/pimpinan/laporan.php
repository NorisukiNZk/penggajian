<?php
  $bulan_indo = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
  $bln_now = date('m');
  $thn_now = date('Y');
?>

<section class="exec-brief-head">
  <div>
    <h1 class="exec-brief-title">Pusat Laporan Resmi Klinik</h1>
    <p class="exec-brief-sub">
      Filter periode dan cetak seluruh dokumen audit kepegawaian serta penggajian Klinik Pratama Dr. H.M. Hidayatullah langsung dalam format cetak resmi.
    </p>
  </div>
</section>

<!-- KLUSTER 1: PENGGAJIAN & FINANSIAL -->
<div class="mb-5">
  <h2 class="exec-serif h5 font-weight-bold mb-3 pb-2 border-bottom">1. Laporan Penggajian & Keuangan</h2>
  <div class="exec-report-grid">
    <!-- Laporan Gaji Bulanan -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Bulanan</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Gaji Bulanan</h3>
        <p class="small text-muted mb-3">Rekap gaji pokok, tunjangan, uang lembur, potongan, dan take home pay seluruh pegawai.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_gaji'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="d-flex flex-column" style="gap: 0.45rem;">
          <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Laporan Gaji</button>
          <button type="submit" formaction="<?php echo base_url('pimpinan/laporan/export_gaji_csv'); ?>" formtarget="_self" class="btn btn-exec-outline btn-sm btn-block"><i class="fas fa-file-csv"></i> Unduh Excel (CSV)</button>
        </div>
      </form>
    </div>

    <!-- Laporan Gaji Tahunan -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Tahunan</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Rekap Gaji Tahunan</h3>
        <p class="small text-muted mb-3">Akumulasi pengeluaran gaji, lembur, dan potongan selama 12 bulan untuk evaluasi anggaran tahunan.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_tahunan'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-group mb-2">
          <select name="tahun" class="form-control form-control-sm">
            <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
              <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>>Tahun <?php echo $y; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Rekap Tahunan</button>
      </form>
    </div>

    <!-- Laporan Potongan Gaji -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Bulanan</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Potongan Gaji</h3>
        <p class="small text-muted mb-3">Rincian potongan ketidakhadiran (alpha) dan komponen potongan dinamis pegawai per periode.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_potongan'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Laporan Potongan</button>
      </form>
    </div>
  </div>
</div>

<!-- KLUSTER 2: KEHADIRAN, CUTI & LEMBUR -->
<div class="mb-5">
  <h2 class="exec-serif h5 font-weight-bold mb-3 pb-2 border-bottom">2. Laporan Kehadiran, Cuti & Lembur</h2>
  <div class="exec-report-grid">
    <!-- Laporan Absensi -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Presensi</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Absensi Bulanan</h3>
        <p class="small text-muted mb-3">Rekap hadir, sakit, dan alpha seluruh tenaga kesehatan serta staf administrasi klinik.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_absensi'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="d-flex flex-column" style="gap: 0.45rem;">
          <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Laporan Absensi</button>
          <button type="submit" formaction="<?php echo base_url('pimpinan/laporan/export_absensi_csv'); ?>" formtarget="_self" class="btn btn-exec-outline btn-sm btn-block"><i class="fas fa-file-csv"></i> Unduh Excel (CSV)</button>
        </div>
      </form>
    </div>

    <!-- Laporan Cuti -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Cuti & Izin</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Cuti Disetujui</h3>
        <p class="small text-muted mb-3">Daftar pengajuan cuti dan izin yang telah disahkan beserta rentang tanggal dan jenis cutinya.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_cuti'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="d-flex flex-column" style="gap: 0.45rem;">
          <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Laporan Cuti</button>
          <button type="submit" formaction="<?php echo base_url('pimpinan/laporan/export_cuti_csv'); ?>" formtarget="_self" class="btn btn-exec-outline btn-sm btn-block"><i class="fas fa-file-csv"></i> Unduh Excel (CSV)</button>
        </div>
      </form>
    </div>

    <!-- Laporan Lembur -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Jam Tambahan</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Lembur Karyawan</h3>
        <p class="small text-muted mb-3">Rekap jam lembur yang disetujui beserta nominal kompensasi lembur sesuai tarif klinik.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_lembur'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <div class="d-flex flex-column" style="gap: 0.45rem;">
          <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Laporan Lembur</button>
          <button type="submit" formaction="<?php echo base_url('pimpinan/laporan/export_lembur_csv'); ?>" formtarget="_self" class="btn btn-exec-outline btn-sm btn-block"><i class="fas fa-file-csv"></i> Unduh Excel (CSV)</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- KLUSTER 3: SLIP GAJI INDIVIDUAL & MASTER -->
<div>
  <h2 class="exec-serif h5 font-weight-bold mb-3 pb-2 border-bottom">3. Slip Gaji Individual & Dokumen Master</h2>
  <div class="exec-report-grid">
    <!-- Slip Gaji Individual -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Per Pegawai</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Cetak Slip Gaji Pegawai</h3>
        <p class="small text-muted mb-3">Terbitkan salinan slip gaji resmi untuk satu pegawai pada bulan dan tahun tertentu.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_slip'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-group mb-2">
          <select name="nik" class="form-control form-control-sm" required>
            <option value="">-- Pilih Pegawai --</option>
            <?php foreach ($pegawai as $pg) : ?>
              <option value="<?php echo htmlspecialchars($pg->nik, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($pg->nama_pegawai . ' (' . $pg->jabatan . ')', ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-row mb-2">
          <div class="col-7">
            <select name="bulan" class="form-control form-control-sm">
              <?php foreach ($bulan_indo as $k => $v) : ?>
                <option value="<?php echo $k; ?>" <?php echo ($bln_now === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5">
            <select name="tahun" class="form-control form-control-sm">
              <?php for ($y = $thn_now + 1; $y >= 2021; $y--) : ?>
                <option value="<?php echo $y; ?>" <?php echo ((int)$thn_now === $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Slip Gaji</button>
      </form>
    </div>

    <!-- Laporan Master Pegawai -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Master SDM</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Laporan Data Pegawai</h3>
        <p class="small text-muted mb-3">Daftar lengkap personel klinik yang dapat disaring menurut jabatan tertentu.</p>
      </div>
      <form method="POST" action="<?php echo base_url('pimpinan/laporan/cetak_pegawai'); ?>" target="_blank">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="form-group mb-2">
          <select name="jabatan" class="form-control form-control-sm">
            <option value="semua">Semua Jabatan</option>
            <?php foreach ($jabatan as $jb) : ?>
              <option value="<?php echo htmlspecialchars($jb->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($jb->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="d-flex flex-column" style="gap: 0.45rem;">
          <button type="submit" class="btn btn-exec-primary btn-sm btn-block"><i class="fas fa-print"></i> Cetak Daftar Pegawai</button>
          <button type="submit" formaction="<?php echo base_url('pimpinan/laporan/export_pegawai_csv'); ?>" formtarget="_self" class="btn btn-exec-outline btn-sm btn-block"><i class="fas fa-file-csv"></i> Unduh Excel (CSV)</button>
        </div>
      </form>
    </div>

    <!-- Laporan Standar Jabatan -->
    <div class="exec-panel p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="small font-weight-bold text-muted text-uppercase mb-1">Struktur Remunerasi</div>
        <h3 class="exec-serif h5 font-weight-bold mb-2">Standar Jabatan & Tunjangan</h3>
        <p class="small text-muted mb-3">Matriks standar gaji pokok, tunjangan transport, dan uang makan per jabatan di klinik.</p>
      </div>
      <div>
        <a href="<?php echo base_url('pimpinan/laporan/cetak_jabatan'); ?>" target="_blank" class="btn btn-exec-primary btn-sm btn-block">
          <i class="fas fa-print"></i> Cetak Standar Jabatan
        </a>
      </div>
    </div>
  </div>
</div>
