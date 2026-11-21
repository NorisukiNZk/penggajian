<?php
  $jam_sekarang = date('H:i:s');
?>

<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Catat kehadiran masuk dan pulang shift kerja Anda serta pantau ringkasan bulan berjalan.</p>
  </div>
  <a href="<?php echo base_url('pegawai/absensi/riwayat'); ?>" class="btn btn-light btn-sm">
    <i class="fas fa-calendar-check"></i> Riwayat Absensi
  </a>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<div class="row mb-4">
  <!-- Jam Real-Time & Jadwal Shift -->
  <div class="col-lg-5 mb-3 mb-lg-0">
    <div class="emp-attendance-hero h-100 d-flex flex-column justify-content-between">
      <div>
        <div class="emp-hero-label">Waktu Server Lokal (WITA)</div>
        <div id="jam-realtime" class="emp-attendance-clock mt-2">--:--:--</div>
        <div id="tanggal-realtime" class="small mt-1" style="color: #CCFBF1;">Memuat tanggal...</div>
      </div>

      <div class="row text-center mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
        <div class="col-4">
          <div class="small" style="color: #CCFBF1;">Jam Masuk</div>
          <div class="font-weight-bold tabular-nums text-white mt-1"><?php echo date('H:i', strtotime($setting->jam_masuk)); ?></div>
        </div>
        <div class="col-4">
          <div class="small" style="color: #CCFBF1;">Toleransi</div>
          <div class="font-weight-bold tabular-nums text-white mt-1"><?php echo (int)$setting->toleransi_menit; ?> mnt</div>
        </div>
        <div class="col-4">
          <div class="small" style="color: #CCFBF1;">Jam Pulang</div>
          <div class="font-weight-bold tabular-nums text-white mt-1"><?php echo date('H:i', strtotime($setting->jam_pulang)); ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status & Tombol Presensi Hari Ini -->
  <div class="col-lg-7">
    <div class="emp-card h-100 p-4 d-flex flex-column justify-content-between">
      <div>
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pb-3 mb-3 border-bottom">
          <h2 class="h6 font-weight-bold m-0">Status Presensi Hari Ini</h2>
          <span class="small text-muted tabular-nums"><?php echo date('d M Y'); ?></span>
        </div>

        <?php if ($absensi_hari_ini) : ?>
          <div class="row mb-3">
            <div class="col-6 pr-2">
              <div class="p-3 rounded border h-100" style="background: var(--emp-surface-alt);">
                <div class="small text-muted font-weight-bold mb-1">Jam Masuk</div>
                <div class="h4 font-weight-bold mb-2 tabular-nums">
                  <?php echo date('H:i:s', strtotime($absensi_hari_ini->jam_masuk)); ?>
                </div>
                <span class="emp-status <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'emp-status-ok' : 'emp-status-warn'; ?>">
                  <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'Tepat Waktu' : 'Terlambat'; ?>
                </span>
              </div>
            </div>
            <div class="col-6 pl-2">
              <div class="p-3 rounded border h-100" style="background: var(--emp-surface-alt);">
                <div class="small text-muted font-weight-bold mb-1">Jam Pulang</div>
                <?php if ($absensi_hari_ini->jam_pulang) : ?>
                  <div class="h4 font-weight-bold mb-2 tabular-nums">
                    <?php echo date('H:i:s', strtotime($absensi_hari_ini->jam_pulang)); ?>
                  </div>
                  <span class="emp-status emp-status-info">Sudah Pulang</span>
                <?php else : ?>
                  <div class="h4 font-weight-bold text-muted mb-2 tabular-nums">--:--:--</div>
                  <span class="emp-status emp-status-warn">Belum Pulang</span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <?php if (!empty($absensi_hari_ini->keterangan)) : ?>
            <div class="small p-2 px-3 rounded mb-3 border" style="background: var(--emp-surface-alt);">
              <i class="fas fa-circle-info text-primary mr-1"></i>
              <?php echo htmlspecialchars($absensi_hari_ini->keterangan, ENT_QUOTES, 'UTF-8'); ?>
            </div>
          <?php endif; ?>
        <?php else : ?>
          <div class="py-3 text-center">
            <div class="font-weight-bold mb-1">Belum ada catatan absen masuk hari ini</div>
            <p class="small text-muted mb-0">
              Gerbang absen masuk aktif mulai pukul <?php echo date('H:i', strtotime($setting->mulai_absen_masuk)); ?> s/d <?php echo date('H:i', strtotime($setting->batas_terlambat_berat)); ?> WITA.
            </p>
          </div>
        <?php endif; ?>
      </div>

      <div class="pt-2">
        <?php if ($absensi_hari_ini) : ?>
          <?php if (!$absensi_hari_ini->jam_pulang) : ?>
            <?php if ($jam_sekarang >= $setting->mulai_absen_pulang) : ?>
              <a href="<?php echo base_url('pegawai/absensi/absen_pulang'); ?>"
                 class="btn btn-primary btn-block btn-konfirmasi"
                 data-judul="Absen Pulang Sekarang?"
                 data-pesan="Pastikan shift kerja Anda hari ini sudah selesai sebelum mencatat absen pulang."
                 data-tipe="question">
                <i class="fas fa-right-from-bracket"></i> Catat Absen Pulang
              </a>
            <?php else : ?>
              <button type="button" class="btn btn-light btn-block" disabled>
                <i class="fas fa-lock"></i> Absen pulang dibuka jam <?php echo date('H:i', strtotime($setting->mulai_absen_pulang)); ?> WITA
              </button>
            <?php endif; ?>
          <?php else : ?>
            <div class="p-3 rounded text-center small font-weight-bold" style="background: var(--emp-success-bg); color: var(--emp-success);">
              <i class="fas fa-circle-check mr-1"></i> Absensi hari ini sudah lengkap tercatat.
            </div>
          <?php endif; ?>
        <?php else : ?>
          <?php if ($jam_sekarang >= $setting->mulai_absen_masuk && $jam_sekarang <= $setting->batas_terlambat_berat) : ?>
            <a href="<?php echo base_url('pegawai/absensi/absen_masuk'); ?>"
               class="btn btn-primary btn-block btn-konfirmasi"
               data-judul="Absen Masuk Sekarang?"
               data-pesan="Catat kehadiran masuk kerja Anda hari ini?"
               data-tipe="question">
              <i class="fas fa-right-to-bracket"></i> Catat Absen Masuk
            </a>
          <?php elseif ($jam_sekarang < $setting->mulai_absen_masuk) : ?>
            <button type="button" class="btn btn-light btn-block" disabled>
              <i class="fas fa-lock"></i> Belum waktunya masuk (dibuka jam <?php echo date('H:i', strtotime($setting->mulai_absen_masuk)); ?> WITA)
            </button>
          <?php else : ?>
            <button type="button" class="btn btn-light btn-block" disabled>
              <i class="fas fa-circle-xmark"></i> Gerbang absen ditutup (batas <?php echo date('H:i', strtotime($setting->batas_terlambat_berat)); ?> WITA)
            </button>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Ringkasan Kehadiran Bulan Ini -->
<section aria-label="Ringkasan absensi bulan ini">
  <h2 class="h6 font-weight-bold mb-2">Ringkasan Bulan Ini</h2>
  <div class="emp-metric-strip">
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Hadir</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['hadir']; ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Total masuk kerja</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Terlambat</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['terlambat']; ?> <span class="small font-weight-normal text-muted">kali</span></div>
      <div class="emp-metric-note">Melewati batas toleransi</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Sakit / Izin</div>
      <div class="emp-metric-value"><?php echo (int)($ringkasan['sakit'] + $ringkasan['izin']); ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Cuti atau izin tercatat</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Alpha</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['alpha']; ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Tanpa keterangan</div>
    </div>
  </div>
</section>

<script>
(function() {
  function updateClock() {
    var now = new Date();
    var h = String(now.getHours()).padStart(2, '0');
    var m = String(now.getMinutes()).padStart(2, '0');
    var s = String(now.getSeconds()).padStart(2, '0');
    var jamEl = document.getElementById('jam-realtime');
    if (jamEl) jamEl.textContent = h + ':' + m + ':' + s;

    var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var tglEl = document.getElementById('tanggal-realtime');
    if (tglEl) tglEl.textContent = hari[now.getDay()] + ', ' + now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear();
  }
  updateClock();
  setInterval(updateClock, 1000);
})();
</script>
