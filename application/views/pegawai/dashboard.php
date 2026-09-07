<!-- Begin Page Content -->
<div class="container-fluid py-2">

  <!-- Page Heading -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-2">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title ?></h1>
      <p class="text-muted small mb-0">Selamat datang kembali! Pantau presensi dan profil Anda di sini.</p>
    </div>
    <div class="px-3 py-2 bg-white rounded-pill border shadow-sm small font-weight-bold text-primary d-inline-flex align-items-center gap-2">
      <i class="fas fa-calendar-alt text-info"></i> <?php echo date('d F Y') ?>
    </div>
  </div>

  <div class="row">
    <!-- Profil Pegawai Modern Card -->
    <div class="col-lg-5 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span class="font-weight-bold text-primary"><i class="fas fa-id-card mr-2"></i> Profil Pegawai</span>
          <span class="badge badge-pill badge-primary"><i class="fas fa-check mr-1"></i> Aktif</span>
        </div>
        <?php foreach($pegawai as $p) : ?>
        <div class="card-body">
          <div class="d-flex flex-column align-items-center text-center pb-3 border-bottom mb-3">
            <div class="position-relative mb-2">
              <img style="width: 110px; height: 110px; object-fit: cover; border-radius: 50%;" class="border p-1 shadow-sm" src="<?php echo base_url('photo/'.$p->photo) ?>" alt="<?php echo $p->nama_pegawai ?>">
              <span class="position-absolute bottom-0 right-0 p-2 bg-success border border-white rounded-circle"></span>
            </div>
            <h5 class="font-weight-bold text-gray-800 mb-1"><?php echo $p->nama_pegawai ?></h5>
            <span class="badge badge-light border text-primary font-weight-bold mb-1"><?php echo $p->jabatan ?></span>
            <small class="text-muted"><i class="fas fa-fingerprint mr-1"></i> NIK: <?php echo $p->nik ?></small>
          </div>

          <div class="small">
            <div class="d-flex justify-content-between py-2 border-bottom">
              <span class="text-muted">Tanggal Bergabung</span>
              <span class="font-weight-bold text-gray-800"><?php echo date('d F Y', strtotime($p->tanggal_masuk)) ?></span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom">
              <span class="text-muted">Status Kepegawaian</span>
              <span class="badge badge-<?php echo ($p->status == 'Karyawan Tetap') ? 'success' : 'warning' ?>">
                <?php echo $p->status ?>
              </span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Quick Absensi Widget Modern -->
    <div class="col-lg-7 mb-4">
      <div class="card shadow-sm h-100 border-left-primary">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-stopwatch mr-2"></i> Presensi Hari Ini</h6>
          <span class="badge badge-light border text-dark"><i class="fas fa-clock mr-1"></i> Real-Time</span>
        </div>
        <div class="card-body d-flex flex-column justify-content-center">
          <?php if ($absensi_hari_ini) : ?>
            <div class="row text-center mb-3">
              <div class="col-6">
                <div class="p-3 bg-light rounded-lg border border-success-subtle h-100">
                  <span class="badge badge-success mb-2 px-3 py-1">JAM MASUK</span>
                  <div class="h3 font-weight-bold text-gray-800 my-1">
                    <?php echo date('H:i', strtotime($absensi_hari_ini->jam_masuk)) ?>
                  </div>
                  <span class="badge badge-<?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'success' : 'warning' ?>">
                    <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'Tepat Waktu' : 'Terlambat' ?>
                  </span>
                </div>
              </div>
              <div class="col-6">
                <div class="p-3 bg-light rounded-lg border border-info-subtle h-100">
                  <span class="badge badge-info mb-2 px-3 py-1">JAM PULANG</span>
                  <?php if ($absensi_hari_ini->jam_pulang) : ?>
                    <div class="h3 font-weight-bold text-gray-800 my-1">
                      <?php echo date('H:i', strtotime($absensi_hari_ini->jam_pulang)) ?>
                    </div>
                    <span class="badge badge-info">Selesai Kerja</span>
                  <?php else : ?>
                    <div class="h3 font-weight-bold text-muted my-1">--:--</div>
                    <a href="<?php echo base_url('pegawai/absensi/absen_pulang') ?>" class="btn btn-sm btn-info btn-konfirmasi shadow-sm" data-judul="Absen Pulang?" data-pesan="Apakah Anda yakin ingin melakukan Absen Pulang sekarang?" data-tipe="question" data-warna="#0ea5e9" data-btn-teks="<i class='fas fa-sign-out-alt'></i> Ya, Pulang!">
                      <i class="fas fa-sign-out-alt"></i> Absen Pulang
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="p-2 bg-light rounded text-center small text-success font-weight-bold">
              <i class="fas fa-shield-alt mr-1"></i> Presensi hari ini telah tercatat di server klinik.
            </div>
          <?php else : ?>
            <div class="text-center py-4">
              <div class="mb-3">
                <i class="fas fa-fingerprint fa-4x text-gray-300"></i>
              </div>
              <h5 class="font-weight-bold text-gray-800 mb-1">Anda Belum Presensi Hari Ini</h5>
              <p class="text-muted small mb-3">Silakan klik tombol di bawah untuk mencatat kehadiran masuk Anda.</p>
              <a href="<?php echo base_url('pegawai/absensi/absen_masuk') ?>" class="btn btn-success btn-lg px-4 shadow-sm btn-konfirmasi" data-judul="Absen Masuk?" data-pesan="Catat kehadiran kerja Anda hari ini?" data-tipe="question" data-warna="#10b981" data-btn-teks="<i class='fas fa-sign-in-alt'></i> Ya, Absen Masuk!">
                <i class="fas fa-sign-in-alt mr-1"></i> ABSEN MASUK SEKARANG
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Ringkasan Kehadiran Bulan Ini (Modern 4 KPI Cards) -->
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success h-100 py-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="letter-spacing: 0.05em;">Hadir (<?php echo date('F') ?>)</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['hadir'] ?> <span class="text-xs font-weight-normal text-muted">Hari</span></div>
              <span class="badge badge-light border text-success mt-2 small"><i class="fas fa-check mr-1"></i> Tepat Waktu</span>
            </div>
            <div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
              <i class="fas fa-check-circle fa-lg text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning h-100 py-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="letter-spacing: 0.05em;">Terlambat</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['terlambat'] ?> <span class="text-xs font-weight-normal text-muted">Kali</span></div>
              <span class="badge badge-light border text-warning mt-2 small"><i class="fas fa-clock mr-1"></i> Melewati Jam</span>
            </div>
            <div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
              <i class="fas fa-exclamation-triangle fa-lg text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info h-100 py-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="letter-spacing: 0.05em;">Sakit / Izin</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['sakit'] + $ringkasan['izin'] ?> <span class="text-xs font-weight-normal text-muted">Hari</span></div>
              <span class="badge badge-light border text-info mt-2 small"><i class="fas fa-file-medical mr-1"></i> Form Diajukan</span>
            </div>
            <div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
              <i class="fas fa-hospital fa-lg text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger h-100 py-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="letter-spacing: 0.05em;">Alpha / Tanpa Ket.</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['alpha'] ?> <span class="text-xs font-weight-normal text-muted">Hari</span></div>
              <span class="badge badge-light border text-danger mt-2 small"><i class="fas fa-times mr-1"></i> Tanpa Izin</span>
            </div>
            <div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
              <i class="fas fa-times-circle fa-lg text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row: Kalender Libur Widget -->
  <div class="row">
    <div class="col-xl-6 col-lg-6 mb-4">
      <div class="card shadow-sm h-100 border-left-danger">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-calendar-times mr-1"></i> Jadwal Libur & Cuti Bersama</h6>
          <span class="badge badge-light border text-danger">Klinik</span>
        </div>
        <div class="card-body">
          <?php if(empty($hari_libur)) { ?>
            <p class="text-center text-muted my-4">Tidak ada jadwal hari libur terdekat.</p>
          <?php } else { ?>
            <div class="list-group list-group-flush">
              <?php foreach($hari_libur as $hl): ?>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                <div>
                  <h6 class="my-0 font-weight-bold text-gray-800"><?php echo $hl->keterangan ?></h6>
                  <small class="text-danger font-weight-bold"><i class="fas fa-calendar-day mr-1"></i> <?php echo date('d F Y', strtotime($hl->tanggal)) ?></small>
                </div>
                <span class="badge badge-danger">Libur</span>
              </div>
              <?php endforeach; ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->