<?php
  $bulan_indo = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
?>

<section class="exec-brief-head">
  <div>
    <h1 class="exec-brief-title">Monitoring SDM & Kehadiran</h1>
    <p class="exec-brief-sub">
      Pemantauan presensi harian secara langsung, rekapitulasi disiplin bulanan, serta direktori kepegawaian dan paket remunerasi dasar.
    </p>
  </div>
</section>

<div class="exec-tabs" role="tablist" aria-label="Tampilan monitoring SDM">
  <a href="<?php echo base_url('pimpinan/monitoring?tab=hari_ini'); ?>" class="exec-tab-btn <?php echo ($active_tab === 'hari_ini') ? 'active' : ''; ?>">
    <i class="fas fa-clock"></i> Presensi Hari Ini
  </a>
  <a href="<?php echo base_url('pimpinan/monitoring?tab=rekap&bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="exec-tab-btn <?php echo ($active_tab === 'rekap') ? 'active' : ''; ?>">
    <i class="fas fa-chart-column"></i> Rekap Bulanan
  </a>
  <a href="<?php echo base_url('pimpinan/monitoring?tab=pegawai'); ?>" class="exec-tab-btn <?php echo ($active_tab === 'pegawai') ? 'active' : ''; ?>">
    <i class="fas fa-address-book"></i> Direktori Pegawai
  </a>
</div>

<?php if ($active_tab === 'hari_ini') : ?>
  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Kehadiran Staf Hari Ini (<?php echo date('d M Y'); ?>)</h2>
      <span class="small text-muted tabular-nums"><?php echo count($absensi_hari_ini); ?> personel dipantau</span>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pegawai</th>
              <th>Jabatan</th>
              <th class="text-center">Jam Masuk</th>
              <th class="text-center">Jam Pulang</th>
              <th>Status</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($absensi_hari_ini)) : ?>
              <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pegawai terdaftar.</td></tr>
            <?php else : ?>
              <?php foreach ($absensi_hari_ini as $a) : ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($a->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted tabular-nums">NIK: <?php echo htmlspecialchars($a->nik, ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td><?php echo htmlspecialchars($a->jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="text-center tabular-nums"><?php echo (!empty($a->jam_masuk) && $a->jam_masuk !== '00:00:00') ? date('H:i', strtotime($a->jam_masuk)) : '-'; ?></td>
                  <td class="text-center tabular-nums"><?php echo (!empty($a->jam_pulang) && $a->jam_pulang !== '00:00:00') ? date('H:i', strtotime($a->jam_pulang)) : '-'; ?></td>
                  <td>
                    <?php if ($a->status === 'tepat_waktu') : ?>
                      <span class="exec-tag exec-tag-ok">Tepat Waktu</span>
                    <?php elseif ($a->status === 'terlambat') : ?>
                      <span class="exec-tag exec-tag-pending">Terlambat</span>
                    <?php elseif ($a->status === 'sakit' || $a->status === 'izin') : ?>
                      <span class="exec-tag exec-tag-info"><?php echo ucfirst($a->status); ?></span>
                    <?php else : ?>
                      <span class="exec-tag exec-tag-danger">Belum Absen</span>
                    <?php endif; ?>
                  </td>
                  <td class="small text-muted"><?php echo !empty($a->keterangan) ? htmlspecialchars($a->keterangan, ENT_QUOTES, 'UTF-8') : '-'; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php elseif ($active_tab === 'rekap') : ?>
  <div class="exec-panel mb-3">
    <div class="exec-panel-body py-3">
      <form method="GET" action="<?php echo base_url('pimpinan/monitoring'); ?>" class="form-row align-items-end">
        <input type="hidden" name="tab" value="rekap">
        <div class="col-sm-4 col-md-3 mb-2 mb-sm-0">
          <label class="small font-weight-bold">Bulan</label>
          <select name="bulan" class="form-control">
            <?php foreach ($bulan_indo as $k => $v) : ?>
              <option value="<?php echo $k; ?>" <?php echo ($bulan === $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-4 col-md-3 mb-2 mb-sm-0">
          <label class="small font-weight-bold">Tahun</label>
          <select name="tahun" class="form-control">
            <?php for ($y = date('Y') + 1; $y >= 2021; $y--) : ?>
              <option value="<?php echo $y; ?>" <?php echo ((string)$tahun === (string)$y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-sm-4 col-md-3">
          <button type="submit" class="btn btn-exec-primary btn-block">Tampilkan Periode</button>
        </div>
      </form>
    </div>
  </div>

  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Rekap Disiplin <?php echo (isset($bulan_indo[$bulan]) ? $bulan_indo[$bulan] : $bulan) . ' ' . htmlspecialchars($tahun, ENT_QUOTES, 'UTF-8'); ?></h2>
      <a href="<?php echo base_url('pimpinan/laporan/cetak_absensi?bulan=' . urlencode($bulan) . '&tahun=' . urlencode($tahun)); ?>" target="_blank" class="btn btn-sm btn-exec-outline">
        <i class="fas fa-print"></i> Cetak Rekap Absensi
      </a>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pegawai</th>
              <th>Jabatan</th>
              <th class="text-center">Hadir</th>
              <th class="text-center">Terlambat</th>
              <th class="text-center">Sakit</th>
              <th class="text-center">Izin</th>
              <th class="text-center">Total Alpha</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($rekap_bulanan)) : ?>
              <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data rekap untuk periode ini.</td></tr>
            <?php else : ?>
              <?php foreach ($rekap_bulanan as $r) : ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($r['nama_pegawai'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted tabular-nums"><?php echo htmlspecialchars($r['nik'], ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td><?php echo htmlspecialchars($r['jabatan'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="text-center font-weight-bold tabular-nums"><?php echo (int)$r['hadir']; ?></td>
                  <td class="text-center tabular-nums"><?php echo (int)$r['terlambat']; ?></td>
                  <td class="text-center tabular-nums"><?php echo (int)$r['sakit']; ?></td>
                  <td class="text-center tabular-nums"><?php echo (int)$r['izin']; ?></td>
                  <td class="text-center font-weight-bold tabular-nums <?php echo ((int)$r['total_alpha'] > 0) ? 'text-danger' : ''; ?>"><?php echo (int)$r['total_alpha']; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php else : ?>
  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Direktori Personel & Paket Remunerasi Dasar</h2>
      <a href="<?php echo base_url('pimpinan/laporan/cetak_pegawai?jabatan=semua'); ?>" target="_blank" class="btn btn-sm btn-exec-outline">
        <i class="fas fa-print"></i> Cetak Daftar Pegawai
      </a>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pegawai</th>
              <th>Jabatan</th>
              <th>Status & Bergabung</th>
              <th class="text-right">Gaji Pokok</th>
              <th class="text-right">Transport + Makan</th>
              <th class="text-center">Peran Sistem</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($pegawai_list)) : ?>
              <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pegawai terdaftar.</td></tr>
            <?php else : ?>
              <?php foreach ($pegawai_list as $p) : ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted tabular-nums">NIK: <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td><?php echo htmlspecialchars($p->jabatan, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>
                    <div class="small font-weight-bold"><?php echo htmlspecialchars($p->status, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted tabular-nums">Sejak <?php echo date('d M Y', strtotime($p->tanggal_masuk)); ?></div>
                  </td>
                  <td class="text-right tabular-nums">Rp <?php echo number_format((float)$p->gaji_pokok, 0, ',', '.'); ?></td>
                  <td class="text-right tabular-nums">Rp <?php echo number_format((float)$p->tj_transport + (float)$p->uang_makan, 0, ',', '.'); ?></td>
                  <td class="text-center">
                    <?php if ($p->hak_akses == '1') : ?>
                      <span class="exec-tag exec-tag-info">Admin</span>
                    <?php elseif ($p->hak_akses == '3') : ?>
                      <span class="exec-tag exec-tag-pending">Pimpinan</span>
                    <?php else : ?>
                      <span class="exec-tag exec-tag-ok">Pegawai</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>
