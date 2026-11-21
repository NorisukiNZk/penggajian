<?php
  $alpha_deduction = 0;
  if (!empty($potongan)) {
    foreach ($potongan as $p) {
      if (strtolower($p->potongan) == 'alpha') {
        $alpha_deduction = $p->jml_potongan;
      }
    }
  }

  $bulanIndo = array(
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
  );

  $latest_thp = 0;
  $latest_tunjangan = 0;
  $latest_potongan = 0;
  $latest_periode = '-';

  if (!empty($gaji) && isset($gaji[0])) {
    $g0 = $gaji[0];
    $m0 = substr($g0->bulan, 0, 2);
    $y0 = substr($g0->bulan, 2, 4);
    $latest_periode = (isset($bulanIndo[$m0]) ? $bulanIndo[$m0] : $m0) . ' ' . $y0;

    $tj_lain0  = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['tunjangan']['total'] : 0;
    $pot_lain0 = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['potongan']['total'] : 0;
    $pinjaman0 = isset($komponen_per_bulan[$g0->bulan]['pinjaman']) ? $komponen_per_bulan[$g0->bulan]['pinjaman']['total'] : 0;
    $lembur0   = isset($komponen_per_bulan[$g0->bulan]['uang_lembur']) ? $komponen_per_bulan[$g0->bulan]['uang_lembur'] : 0;
    $pot_gaji0 = $g0->alpha * $alpha_deduction;

    $latest_tunjangan = $g0->tj_transport + $g0->uang_makan + $tj_lain0 + $lembur0;
    $latest_potongan  = $pot_gaji0 + $pot_lain0 + $pinjaman0;
    $latest_thp       = $g0->gaji_pokok + $latest_tunjangan - $latest_potongan;
  }
?>

<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Riwayat penerimaan gaji pokok, tunjangan, lembur, potongan, dan cetak slip gaji resmi.</p>
  </div>
  <span class="emp-date-stamp">
    <i class="fas fa-receipt text-primary"></i>
    <span class="tabular-nums"><?php echo count($gaji); ?> Slip Tersedia</span>
  </span>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- Ringkasan Remunerasi Periode Terakhir -->
<section class="emp-metric-strip mb-4" aria-label="Ringkasan slip gaji terakhir">
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Gaji Bersih Terakhir</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_thp, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Periode <?php echo htmlspecialchars($latest_periode, ENT_QUOTES, 'UTF-8'); ?></div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Tunjangan & Lembur</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_tunjangan, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Transport, makan, komponen & lembur</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Total Potongan</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_potongan, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Alpha, cicilan kasbon & potongan lain</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Arsip Slip Digital</div>
    <div class="emp-metric-value"><?php echo count($gaji); ?> <span class="small font-weight-normal text-muted">dokumen</span></div>
    <div class="emp-metric-note">Siap dicetak dalam format resmi</div>
  </div>
</section>

<!-- Tabel Riwayat Slip Gaji -->
<div class="emp-card">
  <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <h2 class="h6 font-weight-bold m-0">Rincian Gaji Bulanan</h2>
    <span class="small text-muted">Klinik Pratama Dr. H.M. Hidayatullah</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0" width="100%">
        <thead>
          <tr>
            <th class="text-center" style="width: 52px;">No</th>
            <th>Periode</th>
            <th class="text-right">Gaji Pokok</th>
            <th class="text-right">Tunjangan</th>
            <th class="text-right">Lembur</th>
            <th class="text-right">Potongan</th>
            <th class="text-right">Gaji Bersih</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($gaji)) : ?>
            <?php $no = 1; foreach ($gaji as $g) :
              $pot_gaji    = $g->alpha * $alpha_deduction;
              $tj_lain     = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['tunjangan']['total'] : 0;
              $pot_lain    = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['potongan']['total'] : 0;
              $pinjaman    = isset($komponen_per_bulan[$g->bulan]['pinjaman']) ? $komponen_per_bulan[$g->bulan]['pinjaman']['total'] : 0;
              $uang_lembur = isset($komponen_per_bulan[$g->bulan]['uang_lembur']) ? $komponen_per_bulan[$g->bulan]['uang_lembur'] : 0;
              $jam_lembur  = isset($komponen_per_bulan[$g->bulan]['jam_lembur']) ? $komponen_per_bulan[$g->bulan]['jam_lembur'] : 0;

              $total_tunjangan = $g->tj_transport + $g->uang_makan + $tj_lain;
              $total_potongan  = $pot_gaji + $pot_lain + $pinjaman;
              $total_gaji      = $g->gaji_pokok + $total_tunjangan + $uang_lembur - $total_potongan;

              $m = substr($g->bulan, 0, 2);
              $y = substr($g->bulan, 2, 4);
              $namaBulan = isset($bulanIndo[$m]) ? $bulanIndo[$m] : $m;
            ?>
              <tr>
                <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                <td class="font-weight-bold"><?php echo $namaBulan . ' ' . $y; ?></td>
                <td class="text-right tabular-nums">Rp <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
                <td class="text-right tabular-nums">+Rp <?php echo number_format($total_tunjangan, 0, ',', '.'); ?></td>
                <td class="text-right tabular-nums">
                  <?php if ($uang_lembur > 0) : ?>
                    <div>+Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></div>
                    <div class="small text-muted"><?php echo (int)$jam_lembur; ?> jam</div>
                  <?php else : ?>
                    <span class="text-muted">Rp 0</span>
                  <?php endif; ?>
                </td>
                <td class="text-right tabular-nums">
                  <?php if ($total_potongan > 0) : ?>
                    <div style="color: var(--emp-danger);">-Rp <?php echo number_format($total_potongan, 0, ',', '.'); ?></div>
                    <?php if ($pinjaman > 0) : ?>
                      <div class="small text-muted">Kasbon Rp <?php echo number_format($pinjaman, 0, ',', '.'); ?></div>
                    <?php endif; ?>
                  <?php else : ?>
                    <span class="text-muted">Rp 0</span>
                  <?php endif; ?>
                </td>
                <td class="text-right font-weight-bold tabular-nums text-primary">
                  Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?>
                </td>
                <td class="text-center">
                  <a class="btn btn-sm btn-primary" target="_blank" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/' . $g->id_kehadiran); ?>">
                    <i class="fas fa-print"></i> Cetak Slip
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <div class="font-weight-bold mb-1">Belum ada data slip gaji tersedia</div>
                <p class="small mb-0">Slip gaji akan muncul otomatis setelah periode payroll diproses oleh HRD.</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
