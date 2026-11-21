<?php
  $hari_indo = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
  $bulan_indo = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
  $tgl_lengkap = $hari_indo[date('l')] . ', ' . date('d') . ' ' . $bulan_indo[date('m')] . ' ' . date('Y');
  $profil = !empty($pegawai) ? $pegawai[0] : null;
  $jam_sekarang = date('H:i:s');
?>

<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title">
      Halo, <?php echo htmlspecialchars($profil ? $profil->nama_pegawai : ($this->session->userdata('nama_pegawai') ?: 'Pegawai'), ENT_QUOTES, 'UTF-8'); ?>
    </h1>
    <p class="emp-page-sub">Catat presensi shift hari ini dan pantau layanan kepegawaian Anda dari satu tempat.</p>
  </div>
  <div class="emp-date-stamp">
    <i class="fas fa-calendar-day text-primary"></i>
    <span><?php echo $tgl_lengkap; ?></span>
  </div>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- Asymmetric Primary Row: Presensi Hari Ini (Focal Point) + Profil Singkat -->
<div class="row mb-4">
  <div class="col-lg-7 mb-3 mb-lg-0">
    <div class="emp-attendance-hero h-100 d-flex flex-column justify-content-between">
      <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3">
        <div>
          <div class="emp-hero-label">Presensi Hari Ini</div>
          <div class="emp-attendance-clock mt-1" id="hero-clock">--:--:--</div>
          <?php if (!empty($setting)) : ?>
            <div class="small mt-1" style="color: #CCFBF1;">
              Jam kerja: <?php echo date('H:i', strtotime($setting->jam_masuk)); ?> s/d <?php echo date('H:i', strtotime($setting->jam_pulang)); ?> WITA
            </div>
          <?php endif; ?>
        </div>
        <a href="<?php echo base_url('pegawai/absensi'); ?>" class="btn btn-sm" style="background: rgba(255,255,255,0.16); color: #FFFFFF; border: 1px solid rgba(255,255,255,0.28);">
          <i class="fas fa-arrow-up-right-from-square"></i> Detail Absensi
        </a>
      </div>

      <?php if ($absensi_hari_ini) : ?>
        <div class="row mb-3">
          <div class="col-6 pr-2">
            <div class="emp-time-slot">
              <div class="small" style="color: #CCFBF1;">Jam Masuk</div>
              <div class="h4 font-weight-bold mb-1 tabular-nums text-white">
                <?php echo date('H:i', strtotime($absensi_hari_ini->jam_masuk)); ?>
              </div>
              <span class="small font-weight-bold" style="color: <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? '#A7F3D0' : '#FDE68A'; ?>;">
                <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'Tepat Waktu' : 'Terlambat'; ?>
              </span>
            </div>
          </div>
          <div class="col-6 pl-2">
            <div class="emp-time-slot">
              <div class="small" style="color: #CCFBF1;">Jam Pulang</div>
              <?php if ($absensi_hari_ini->jam_pulang) : ?>
                <div class="h4 font-weight-bold mb-1 tabular-nums text-white">
                  <?php echo date('H:i', strtotime($absensi_hari_ini->jam_pulang)); ?>
                </div>
                <span class="small font-weight-bold" style="color: #A7F3D0;">Selesai Shift</span>
              <?php else : ?>
                <div class="h4 font-weight-bold mb-1 tabular-nums" style="color: #99F6E4;">--:--</div>
                <span class="small" style="color: #CCFBF1;">Belum dicatat</span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php if (!$absensi_hari_ini->jam_pulang) : ?>
          <?php if (empty($setting) || $jam_sekarang >= $setting->mulai_absen_pulang) : ?>
            <a href="<?php echo base_url('pegawai/absensi/absen_pulang'); ?>"
               class="btn btn-block font-weight-bold btn-konfirmasi"
               style="background: #FFFFFF; color: #0F5132; border: none;"
               data-judul="Catat Absen Pulang?"
               data-pesan="Pastikan shift kerja Anda hari ini telah selesai sebelum melakukan absen pulang."
               data-tipe="question">
              <i class="fas fa-right-from-bracket"></i> Catat Absen Pulang Sekarang
            </a>
          <?php else : ?>
            <div class="small px-3 py-2 rounded" style="background: rgba(255,255,255,0.12); color: #CCFBF1;">
              <i class="fas fa-lock mr-1"></i> Absen pulang dibuka mulai pukul <?php echo date('H:i', strtotime($setting->mulai_absen_pulang)); ?> WITA.
            </div>
          <?php endif; ?>
        <?php else : ?>
          <div class="small px-3 py-2 rounded" style="background: rgba(255,255,255,0.12); color: #D1FAE5;">
            <i class="fas fa-circle-check mr-1"></i> Kehadiran hari ini sudah tercatat lengkap di sistem klinik.
          </div>
        <?php endif; ?>
      <?php else : ?>
        <div class="emp-time-slot mb-3">
          <div class="font-weight-bold text-white mb-1">Belum ada catatan masuk hari ini</div>
          <div class="small" style="color: #CCFBF1;">Tekan tombol di bawah saat tiba di klinik untuk mencatat waktu kehadiran Anda.</div>
        </div>
        <a href="<?php echo base_url('pegawai/absensi/absen_masuk'); ?>"
           class="btn btn-block font-weight-bold btn-konfirmasi"
           style="background: #FFFFFF; color: #0F5132; border: none;"
           data-judul="Catat Absen Masuk?"
           data-pesan="Catat kehadiran masuk kerja Anda untuk shift hari ini?"
           data-tipe="question">
          <i class="fas fa-right-to-bracket"></i> Catat Absen Masuk Sekarang
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Compact Employee Identity Card -->
  <div class="col-lg-5">
    <div class="emp-card h-100 p-4 d-flex flex-column justify-content-between">
      <?php if ($profil) : ?>
        <div>
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="small font-weight-bold text-muted text-uppercase" style="letter-spacing: 0.05em;">Kartu Pegawai</span>
            <span class="emp-status emp-status-ok">Aktif</span>
          </div>

          <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
            <img src="<?php echo base_url('photo/' . $profil->photo); ?>"
                 alt="<?php echo htmlspecialchars($profil->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                 style="width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 2px solid var(--emp-border-strong);"
                 class="mr-3 flex-shrink-0">
            <div style="min-width: 0;">
              <h2 class="h5 font-weight-bold mb-1 text-truncate"><?php echo htmlspecialchars($profil->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></h2>
              <div class="small font-weight-bold text-primary"><?php echo htmlspecialchars($profil->jabatan, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small text-muted tabular-nums">NIK: <?php echo htmlspecialchars($profil->nik, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
          </div>

          <div class="small">
            <div class="d-flex justify-content-between py-2 border-bottom">
              <span class="text-muted">Status Kepegawaian</span>
              <span class="font-weight-bold"><?php echo htmlspecialchars($profil->status, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="d-flex justify-content-between py-2">
              <span class="text-muted">Tanggal Bergabung</span>
              <span class="font-weight-bold tabular-nums"><?php echo date('d M Y', strtotime($profil->tanggal_masuk)); ?></span>
            </div>
          </div>
        </div>

        <div class="pt-3 mt-2 border-top">
          <a href="<?php echo base_url('pegawai/ganti_password'); ?>" class="btn btn-light btn-sm btn-block">
            <i class="fas fa-shield-halved"></i> Perbarui Kata Sandi Akun
          </a>
        </div>
      <?php else : ?>
        <div class="text-center py-4 text-muted small">
          Data profil pegawai tidak ditemukan. Hubungi admin HRD untuk pembaruan akun.
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Quick Service Access -->
<section class="mb-4" aria-label="Akses layanan cepat">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="h6 font-weight-bold m-0">Layanan Mandiri</h2>
  </div>
  <div class="emp-quick-grid">
    <a class="emp-quick-tile" href="<?php echo base_url('pegawai/data_gaji'); ?>">
      <span class="emp-quick-icon"><i class="fas fa-receipt"></i></span>
      <div>
        <div class="font-weight-bold small">Slip Gaji</div>
        <div class="small text-muted">Rincian & cetak PDF</div>
      </div>
    </a>
    <a class="emp-quick-tile" href="<?php echo base_url('pegawai/cuti/tambah'); ?>">
      <span class="emp-quick-icon"><i class="fas fa-calendar-plus"></i></span>
      <div>
        <div class="font-weight-bold small">Ajukan Cuti</div>
        <div class="small text-muted">Cuti & serah terima shift</div>
      </div>
    </a>
    <a class="emp-quick-tile" href="<?php echo base_url('pegawai/lembur'); ?>">
      <span class="emp-quick-icon"><i class="fas fa-business-time"></i></span>
      <div>
        <div class="font-weight-bold small">Pengajuan Lembur</div>
        <div class="small text-muted">Catat jam kerja tambahan</div>
      </div>
    </a>
    <a class="emp-quick-tile" href="<?php echo base_url('pegawai/pinjaman'); ?>">
      <span class="emp-quick-icon"><i class="fas fa-hand-holding-dollar"></i></span>
      <div>
        <div class="font-weight-bold small">Kasbon & Pinjaman</div>
        <div class="small text-muted">Status & simulasi cicilan</div>
      </div>
    </a>
  </div>
</section>

<!-- Monthly Attendance Summary -->
<section class="mb-4" aria-label="Ringkasan kehadiran bulan ini">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="h6 font-weight-bold m-0">Kehadiran Bulan <?php echo $bulan_indo[date('m')] . ' ' . date('Y'); ?></h2>
    <a href="<?php echo base_url('pegawai/absensi/riwayat'); ?>" class="small font-weight-bold text-primary">Lihat Riwayat Lengkap</a>
  </div>
  <div class="emp-metric-strip">
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Hadir</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['hadir']; ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Tercatat masuk kerja</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Terlambat</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['terlambat']; ?> <span class="small font-weight-normal text-muted">kali</span></div>
      <div class="emp-metric-note">Melewati batas toleransi</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Sakit / Izin</div>
      <div class="emp-metric-value"><?php echo (int)($ringkasan['sakit'] + $ringkasan['izin']); ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Disetujui melalui cuti/izin</div>
    </div>
    <div class="emp-metric-tile">
      <div class="emp-metric-label">Tanpa Keterangan</div>
      <div class="emp-metric-value"><?php echo (int)$ringkasan['alpha']; ?> <span class="small font-weight-normal text-muted">hari</span></div>
      <div class="emp-metric-note">Tercatat alpha</div>
    </div>
  </div>
</section>

<!-- Upcoming Clinic Holidays -->
<section aria-label="Jadwal hari libur terdekat">
  <div class="emp-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h2 class="h6 font-weight-bold m-0">Jadwal Hari Libur & Cuti Bersama Terdekat</h2>
      <span class="small text-muted">Kalender Klinik</span>
    </div>
    <?php if (empty($hari_libur)) : ?>
      <p class="text-muted small mb-0">Tidak ada jadwal hari libur nasional terdekat yang tercatat oleh HRD.</p>
    <?php else : ?>
      <div class="list-group list-group-flush">
        <?php foreach ($hari_libur as $hl) : ?>
          <div class="d-flex flex-wrap justify-content-between align-items-center py-2 border-top">
            <div>
              <div class="font-weight-bold small"><?php echo htmlspecialchars($hl->keterangan, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small text-muted tabular-nums"><?php echo date('d M Y', strtotime($hl->tanggal)); ?></div>
            </div>
            <span class="emp-status emp-status-warn">Hari Libur</span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
(function() {
  function syncHeroClock() {
    var el = document.getElementById('hero-clock');
    if (!el) return;
    var now = new Date();
    var h = String(now.getHours()).padStart(2, '0');
    var m = String(now.getMinutes()).padStart(2, '0');
    var s = String(now.getSeconds()).padStart(2, '0');
    el.textContent = h + ':' + m + ':' + s;
  }
  syncHeroClock();
  setInterval(syncHeroClock, 1000);
})();
</script>
