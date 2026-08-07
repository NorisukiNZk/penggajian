<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <div class="alert alert-success font-weight-bold mb-4">Selamat datang, Anda login sebagai pegawai</div>

  <div class="row">
    <!-- Profil Pegawai -->
    <div class="col-lg-5">
      <div class="card mb-4">
        <div class="card-header font-weight-bold bg-primary text-white">
          <i class="fas fa-user"></i> Data Pegawai
        </div>
        <?php foreach($pegawai as $p) : ?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-5 text-center mb-3">
              <img style="width: 150px; border-radius: 10px;" src="<?php echo base_url('photo/'.$p->photo) ?>">
            </div>
            <div class="col-md-7">
              <table class="table table-sm">
                <tr>
                  <td><strong>Nama</strong></td>
                  <td>:</td>
                  <td><?php echo $p->nama_pegawai?></td>
                </tr>
                <tr>
                  <td><strong>NIK</strong></td>
                  <td>:</td>
                  <td><?php echo $p->nik?></td>
                </tr>
                <tr>
                  <td><strong>Jabatan</strong></td>
                  <td>:</td>
                  <td><?php echo $p->jabatan?></td>
                </tr>
                <tr>
                  <td><strong>Masuk</strong></td>
                  <td>:</td>
                  <td><?php echo $p->tanggal_masuk?></td>
                </tr>
                <tr>
                  <td><strong>Status</strong></td>
                  <td>:</td>
                  <td>
                    <span class="badge badge-<?php echo ($p->status == 'Karyawan Tetap') ? 'success' : 'warning' ?>">
                      <?php echo $p->status?>
                    </span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Quick Absensi -->
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark text-white">
          <h6 class="m-0 font-weight-bold"><i class="fas fa-clock"></i> Absensi Hari Ini — <?php echo date('d F Y') ?></h6>
        </div>
        <div class="card-body">
          <?php if ($absensi_hari_ini) : ?>
            <div class="row text-center">
              <div class="col-6">
                <div class="card border-left-success mb-2">
                  <div class="card-body py-2">
                    <small class="text-success font-weight-bold">MASUK</small><br>
                    <span class="h4 font-weight-bold"><?php echo date('H:i', strtotime($absensi_hari_ini->jam_masuk)) ?></span><br>
                    <span class="badge badge-<?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'success' : 'warning' ?>">
                      <?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'Tepat Waktu' : 'Terlambat' ?>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card border-left-info mb-2">
                  <div class="card-body py-2">
                    <small class="text-info font-weight-bold">PULANG</small><br>
                    <?php if ($absensi_hari_ini->jam_pulang) : ?>
                      <span class="h4 font-weight-bold"><?php echo date('H:i', strtotime($absensi_hari_ini->jam_pulang)) ?></span><br>
                      <span class="badge badge-info">Sudah Pulang</span>
                    <?php else : ?>
                      <span class="h4 font-weight-bold text-muted">--:--</span><br>
                      <a href="<?php echo base_url('pegawai/absensi/absen_pulang') ?>" class="btn btn-sm btn-info mt-1"
                         onclick="return confirm('Absen Pulang sekarang?')">
                        <i class="fas fa-sign-out-alt"></i> Absen Pulang
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php else : ?>
            <div class="text-center">
              <p class="text-muted mb-3">Anda belum absen hari ini.</p>
              <a href="<?php echo base_url('pegawai/absensi/absen_masuk') ?>" class="btn btn-success btn-lg px-5"
                 onclick="return confirm('Absen Masuk sekarang?')">
                <i class="fas fa-sign-in-alt"></i> ABSEN MASUK
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Ringkasan Kehadiran Bulan Ini -->
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir (<?php echo date('F') ?>)</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['hadir'] ?> hari</div>
            </div>
            <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['terlambat'] ?> kali</div>
            </div>
            <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sakit / Izin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['sakit'] + $ringkasan['izin'] ?> hari</div>
            </div>
            <div class="col-auto"><i class="fas fa-hospital fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alpha</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['alpha'] ?> hari</div>
            </div>
            <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row: Widget Tambahan -->
  <div class="row">
    <!-- Kalender Libur Widget -->
    <div class="col-xl-6 col-lg-6 mb-4">
      <div class="card shadow h-100 border-left-danger">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-calendar-times"></i> Kalender Libur Nasional & Cuti Bersama</h6>
        </div>
        <div class="card-body">
          <?php if(empty($hari_libur)) { ?>
            <p class="text-center text-muted my-4">Tidak ada jadwal hari libur terdekat.</p>
          <?php } else { ?>
            <div class="list-group list-group-flush">
              <?php foreach($hari_libur as $hl): ?>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                <div>
                  <h6 class="my-0 font-weight-bold text-gray-800"><?php echo $hl->keterangan ?></h6>
                  <small class="text-danger font-weight-bold"><i class="fas fa-calendar-day"></i> <?php echo date('d F Y', strtotime($hl->tanggal)) ?></small>
                </div>
                <span class="badge badge-danger badge-pill">Libur</span>
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