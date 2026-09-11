<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Flash Message -->
  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Page Heading Header -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><?php echo $title; ?></h1>
      <p class="text-muted small mb-0">Riwayat penerimaan remunerasi, tunjangan, lembur, potongan dan slip gaji resmi Anda.</p>
    </div>
    <div class="mt-3 mt-sm-0">
      <span class="badge badge-primary px-3 py-2 shadow-sm" style="font-size: 12px; border-radius: 8px;">
        <i class="fas fa-shield-alt mr-1"></i> Data Remunerasi Terverifikasi
      </span>
    </div>
  </div>

  <?php 
  // Nilai potongan khusus Alpha
  $alpha_deduction = 0;
  if (!empty($potongan)) {
      foreach ($potongan as $p) {
          if (strtolower($p->potongan) == 'alpha') {
              $alpha_deduction = $p->jml_potongan;
          }
      }
  }

  $bulanIndo = [
      '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
      '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
      '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
  ];

  // Hitung summary dari data pertama (terbaru) jika ada
  $latest_thp = 0;
  $latest_tunjangan = 0;
  $latest_potongan = 0;
  $latest_periode = '-';

  if (!empty($gaji) && isset($gaji[0])) {
      $g0 = $gaji[0];
      $m0 = substr($g0->bulan, 0, 2);
      $y0 = substr($g0->bulan, 2, 4);
      $latest_periode = (isset($bulanIndo[$m0]) ? $bulanIndo[$m0] : $m0) . ' ' . $y0;

      $tj_lain0 = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['tunjangan']['total'] : 0;
      $pot_lain0 = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['potongan']['total'] : 0;
      $pinjaman0 = isset($komponen_per_bulan[$g0->bulan]['pinjaman']) ? $komponen_per_bulan[$g0->bulan]['pinjaman']['total'] : 0;
      $lembur0 = isset($komponen_per_bulan[$g0->bulan]['uang_lembur']) ? $komponen_per_bulan[$g0->bulan]['uang_lembur'] : 0;
      $pot_gaji0 = $g0->alpha * $alpha_deduction;

      $latest_tunjangan = $g0->tj_transport + $g0->uang_makan + $tj_lain0 + $lembur0;
      $latest_potongan = $pot_gaji0 + $pot_lain0 + $pinjaman0;
      $latest_thp = $g0->gaji_pokok + $latest_tunjangan - $latest_potongan;
  }
  ?>

  <!-- Executive Summary Stats Cards -->
  <div class="row mb-4">
    <!-- Gaji Bersih Terakhir -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-success shadow-sm h-100 py-2 border-0" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body py-2">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Gaji Bersih Terakhir</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($latest_thp, 0, ',', '.'); ?></div>
              <div class="small text-muted mt-1 font-weight-500"><i class="far fa-calendar-alt mr-1"></i> <?php echo $latest_periode; ?></div>
            </div>
            <div class="col-auto">
              <div class="p-3 bg-light rounded-circle text-success">
                <i class="fas fa-wallet fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tunjangan & Lembur Terakhir -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-info shadow-sm h-100 py-2 border-0" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body py-2">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tunjangan & Lembur</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($latest_tunjangan, 0, ',', '.'); ?></div>
              <div class="small text-muted mt-1 font-weight-500"><i class="fas fa-arrow-up text-success mr-1"></i> Termasuk Transport & Makan</div>
            </div>
            <div class="col-auto">
              <div class="p-3 bg-light rounded-circle text-info">
                <i class="fas fa-hand-holding-usd fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Potongan Terakhir -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-danger shadow-sm h-100 py-2 border-0" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body py-2">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Potongan & Kasbon</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($latest_potongan, 0, ',', '.'); ?></div>
              <div class="small text-muted mt-1 font-weight-500"><i class="fas fa-arrow-down text-danger mr-1"></i> Alpha, Pinjaman & Lainnya</div>
            </div>
            <div class="col-auto">
              <div class="p-3 bg-light rounded-circle text-danger">
                <i class="fas fa-file-invoice-dollar fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Slip Gaji Tersedia -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-primary shadow-sm h-100 py-2 border-0" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body py-2">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Slip Gaji Digital</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($gaji); ?> Dokumen</div>
              <div class="small text-muted mt-1 font-weight-500"><i class="fas fa-qrcode text-primary mr-1"></i> Siap Dicetak & PDF</div>
            </div>
            <div class="col-auto">
              <div class="p-3 bg-light rounded-circle text-primary">
                <i class="fas fa-receipt fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Tabel Gaji Bulanan -->
  <div class="card shadow mb-4 border-0" style="border-radius: 14px; overflow: hidden;">
    <div class="card-header bg-modern-blue text-white d-flex flex-row align-items-center justify-content-between py-3">
      <h6 class="m-0 font-weight-bold" style="letter-spacing: 0.3px;">
        <i class="fas fa-money-check-alt mr-2"></i> Rincian Riwayat Gaji & Remunerasi Bulanan
      </h6>
      <span class="badge badge-light text-primary font-weight-bold px-3 py-1" style="font-size: 11.5px; border-radius: 6px;">
        <i class="fas fa-check-circle text-success mr-1"></i> Standar Laporan HRIS
      </span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" width="100%" cellspacing="0">
          <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
            <tr>
              <th class="text-center py-3 text-secondary font-weight-bold" width="5%" style="font-size: 12px;">No</th>
              <th class="text-left py-3 text-secondary font-weight-bold" width="16%" style="font-size: 12px;">Bulan & Tahun</th>
              <th class="text-right py-3 text-secondary font-weight-bold" width="12%" style="font-size: 12px;">Gaji Pokok</th>
              <th class="text-right py-3 text-secondary font-weight-bold" width="14%" style="font-size: 12px;">Tunjangan</th>
              <th class="text-right py-3 text-secondary font-weight-bold" width="12%" style="font-size: 12px;">Uang Lembur</th>
              <th class="text-right py-3 text-secondary font-weight-bold" width="13%" style="font-size: 12px;">Total Potongan</th>
              <th class="text-right py-3 text-secondary font-weight-bold" width="16%" style="font-size: 12px;">Take Home Pay</th>
              <th class="text-center py-3 text-secondary font-weight-bold" width="12%" style="font-size: 12px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($gaji)) : ?>
              <?php $no = 1; ?>
              <?php foreach ($gaji as $g) : ?>
                <?php 
                $pot_gaji = $g->alpha * $alpha_deduction;
                $tj_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['tunjangan']['total'] : 0;
                $pot_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['potongan']['total'] : 0;
                $pinjaman = isset($komponen_per_bulan[$g->bulan]['pinjaman']) ? $komponen_per_bulan[$g->bulan]['pinjaman']['total'] : 0;
                $uang_lembur = isset($komponen_per_bulan[$g->bulan]['uang_lembur']) ? $komponen_per_bulan[$g->bulan]['uang_lembur'] : 0;
                $jam_lembur = isset($komponen_per_bulan[$g->bulan]['jam_lembur']) ? $komponen_per_bulan[$g->bulan]['jam_lembur'] : 0;

                $total_tunjangan = $g->tj_transport + $g->uang_makan + $tj_lain;
                $total_potongan = $pot_gaji + $pot_lain + $pinjaman;
                $total_gaji = $g->gaji_pokok + $total_tunjangan + $uang_lembur - $total_potongan;

                $m = substr($g->bulan, 0, 2);
                $y = substr($g->bulan, 2, 4);
                $namaBulan = isset($bulanIndo[$m]) ? $bulanIndo[$m] : $m;
                ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                  <td class="text-center align-middle text-muted" style="font-size: 12.5px;"><?php echo $no++; ?></td>
                  <td class="text-left align-middle">
                    <span class="badge badge-light border text-dark font-weight-bold px-2 py-1" style="font-size: 12px;">
                      <i class="far fa-calendar-alt text-primary mr-1"></i> <?php echo $namaBulan . ' ' . $y; ?>
                    </span>
                  </td>
                  <td class="text-right align-middle text-dark font-weight-600" style="font-size: 12.5px;">
                    Rp <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?>
                  </td>
                  <td class="text-right align-middle" style="font-size: 12.5px;">
                    <span class="text-success font-weight-600">+Rp <?php echo number_format($total_tunjangan, 0, ',', '.'); ?></span>
                    <div class="small text-muted" style="font-size: 10.5px;">Trp, Mkn & Komp</div>
                  </td>
                  <td class="text-right align-middle" style="font-size: 12.5px;">
                    <?php if ($uang_lembur > 0) : ?>
                      <span class="text-success font-weight-bold">+Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></span>
                      <div class="small text-info font-weight-600" style="font-size: 10.5px;"><i class="fas fa-clock mr-1"></i><?php echo $jam_lembur; ?> Jam</div>
                    <?php else : ?>
                      <span class="text-muted">Rp 0</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right align-middle" style="font-size: 12.5px;">
                    <?php if ($total_potongan > 0) : ?>
                      <span class="text-danger font-weight-600">-Rp <?php echo number_format($total_potongan, 0, ',', '.'); ?></span>
                      <?php if ($pinjaman > 0) : ?>
                        <div class="small text-danger" style="font-size: 10px;"><i class="fas fa-hand-holding-usd mr-1"></i>Kasbon Rp <?php echo number_format($pinjaman, 0, ',', '.'); ?></div>
                      <?php endif; ?>
                    <?php else : ?>
                      <span class="text-muted">Rp 0</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right align-middle">
                    <span class="text-success font-weight-bold" style="font-size: 13.5px;">
                      Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?>
                    </span>
                  </td>
                  <td class="text-center align-middle">
                    <a class="btn btn-sm btn-primary shadow-sm font-weight-600 px-3" target="_blank" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/'.$g->id_kehadiran); ?>" style="border-radius: 8px;" title="Cetak Slip Gaji Resmi">
                      <i class="fas fa-print mr-1"></i> Cetak Slip
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="8" class="text-center py-5">
                  <div class="py-4">
                    <i class="fas fa-folder-open text-muted fa-3x mb-3"></i>
                    <h6 class="text-gray-800 font-weight-bold">Belum Ada Data Gaji Tersedia</h6>
                    <p class="text-muted small mb-0">Data remunerasi dan slip gaji Anda akan otomatis muncul setelah periode payroll diproses oleh bagian HRD.</p>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-light py-2 text-right text-muted small" style="border-top: 1px solid #e2e8f0;">
      <i class="fas fa-info-circle mr-1 text-primary"></i> Dokumen slip gaji dilengkapi validasi digital dan nomor pengarsipan resmi Klinik Pratama Hidayatullah.
    </div>
  </div>

</div>
<!-- /.container-fluid -->