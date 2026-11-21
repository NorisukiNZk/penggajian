<?php
  $nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
  $hari_list  = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
?>

<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Catatan jam masuk, jam pulang, dan status disiplin kehadiran Anda per periode.</p>
  </div>
  <a href="<?php echo base_url('pegawai/absensi'); ?>" class="btn btn-primary btn-sm">
    <i class="fas fa-fingerprint"></i> Absen Hari Ini
  </a>
</section>

<!-- Filter Periode -->
<div class="emp-card p-3 mb-4">
  <form method="GET" action="<?php echo base_url('pegawai/absensi/riwayat'); ?>" class="form-row align-items-end">
    <div class="col-sm-5 col-md-4 mb-2 mb-sm-0">
      <label for="filterBulan" class="small font-weight-bold mb-1">Bulan</label>
      <select id="filterBulan" class="form-control" name="bulan">
        <?php foreach ($nama_bulan as $key => $val) : ?>
          <option value="<?php echo $key; ?>" <?php echo ($bulan == $key) ? 'selected' : ''; ?>><?php echo $val; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-sm-4 col-md-3 mb-2 mb-sm-0">
      <label for="filterTahun" class="small font-weight-bold mb-1">Tahun</label>
      <select id="filterTahun" class="form-control" name="tahun">
        <?php $thn = (int)date('Y');
        for ($i = $thn + 1; $i >= 2020; $i--) : ?>
          <option value="<?php echo $i; ?>" <?php echo ((string)$tahun === (string)$i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="col-sm-3 col-md-3">
      <button type="submit" class="btn btn-primary btn-block">
        <i class="fas fa-filter"></i> Tampilkan
      </button>
    </div>
  </form>
</div>

<!-- Tabel Riwayat Absensi -->
<div class="emp-card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h2 class="h6 font-weight-bold m-0">
      Periode <?php echo (isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : $bulan) . ' ' . htmlspecialchars($tahun, ENT_QUOTES, 'UTF-8'); ?>
    </h2>
    <span class="small text-muted tabular-nums"><?php echo count($absensi); ?> catatan</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0" width="100%">
        <thead>
          <tr>
            <th class="text-center" style="width: 56px;">No</th>
            <th>Tanggal & Hari</th>
            <th class="text-center">Jam Masuk</th>
            <th class="text-center">Jam Pulang</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($absensi) > 0) : ?>
            <?php $no = 1; foreach ($absensi as $a) :
              $nama_hari = isset($hari_list[date('l', strtotime($a->tanggal))]) ? $hari_list[date('l', strtotime($a->tanggal))] : '';
            ?>
              <tr>
                <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                <td>
                  <div class="font-weight-bold tabular-nums"><?php echo date('d M Y', strtotime($a->tanggal)); ?></div>
                  <div class="small text-muted"><?php echo $nama_hari; ?></div>
                </td>
                <td class="text-center tabular-nums font-weight-bold">
                  <?php echo (!empty($a->jam_masuk) && $a->jam_masuk !== '00:00:00') ? date('H:i:s', strtotime($a->jam_masuk)) : '-'; ?>
                </td>
                <td class="text-center tabular-nums">
                  <?php echo (!empty($a->jam_pulang) && $a->jam_pulang !== '00:00:00') ? date('H:i:s', strtotime($a->jam_pulang)) : '-'; ?>
                </td>
                <td>
                  <?php
                    switch ($a->status) {
                      case 'tepat_waktu':
                        echo '<span class="emp-status emp-status-ok">Tepat Waktu</span>';
                        break;
                      case 'terlambat':
                        echo '<span class="emp-status emp-status-warn">Terlambat</span>';
                        break;
                      case 'sakit':
                        echo '<span class="emp-status emp-status-info">Sakit</span>';
                        break;
                      case 'izin':
                        echo '<span class="emp-status emp-status-info">Izin</span>';
                        break;
                      default:
                        echo '<span class="emp-status emp-status-danger">Alpha</span>';
                        break;
                    }
                  ?>
                </td>
                <td class="small text-muted"><?php echo !empty($a->keterangan) ? htmlspecialchars($a->keterangan, ENT_QUOTES, 'UTF-8') : '-'; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">
                Belum ada catatan kehadiran pada periode <?php echo (isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : $bulan) . ' ' . htmlspecialchars($tahun, ENT_QUOTES, 'UTF-8'); ?>.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
