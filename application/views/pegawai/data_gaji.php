<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-header bg-modern-blue text-white d-flex flex-row align-items-center justify-content-between" style="border-radius: 10px 10px 0 0;">
      <h6 class="m-0 font-weight-bold"><i class="fas fa-money-check-alt mr-2"></i> Rincian Gaji Bulanan Anda</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th class="text-center align-middle">Bulan/Tahun</th>
              <th class="text-center align-middle">Gaji Pokok</th>
              <th class="text-center align-middle">Tj. Transportasi</th>
              <th class="text-center align-middle">Uang Makan</th>
              <th class="text-center align-middle">Tunjangan Lain</th>
              <th class="text-center align-middle">Potongan (Alpha)</th>
              <th class="text-center align-middle">Potongan Lain</th>
              <th class="text-center align-middle">Total Gaji Bersih</th>
              <th class="text-center align-middle">Cetak Slip</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            // Mengambil nilai potongan khusus Alpha
            $alpha_deduction = 0;
            foreach($potongan as $p) {
                if (strtolower($p->potongan) == 'alpha') {
                    $alpha_deduction = $p->jml_potongan;
                }
            }
            ?>
            <?php foreach ($gaji as $g) : ?>
            <?php 
            $pot_gaji = $g->alpha * $alpha_deduction;
            // Komponen dinamis
            $tj_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['tunjangan']['total'] : 0;
            $pot_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['potongan']['total'] : 0;
            $total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $tj_lain - $pot_gaji - $pot_lain;
            ?>
            <tr>
              <td class="text-center align-middle font-weight-bold">
                <?php 
                  // Fix date formatting for "MMYYYY" e.g. "082026"
                  $m = substr($g->bulan, 0, 2);
                  $y = substr($g->bulan, 2, 4);
                  $dateObj = DateTime::createFromFormat('!m', $m);
                  echo $dateObj->format('F') . ' ' . $y;
                ?>
              </td>
              <td class="text-right align-middle">Rp. <?php echo number_format($g->gaji_pokok,0,',','.') ?></td>
              <td class="text-right align-middle">Rp. <?php echo number_format($g->tj_transport,0,',','.') ?></td>
              <td class="text-right align-middle">Rp. <?php echo number_format($g->uang_makan,0,',','.') ?></td>
              <td class="text-right align-middle">
                <?php if ($tj_lain > 0) : ?>
                  <span class="text-success">+Rp. <?php echo number_format($tj_lain,0,',','.') ?></span>
                <?php else : ?>
                  <span class="text-muted">Rp. 0</span>
                <?php endif; ?>
              </td>
              <td class="text-right align-middle">
                <?php if ($pot_gaji > 0) : ?>
                  <span class="text-danger">-Rp. <?php echo number_format($pot_gaji,0,',','.') ?></span>
                <?php else : ?>
                  <span class="text-muted">Rp. 0</span>
                <?php endif; ?>
              </td>
              <td class="text-right align-middle">
                <?php if ($pot_lain > 0) : ?>
                  <span class="text-danger">-Rp. <?php echo number_format($pot_lain,0,',','.') ?></span>
                <?php else : ?>
                  <span class="text-muted">Rp. 0</span>
                <?php endif; ?>
              </td>
              <td class="text-right align-middle font-weight-bold text-primary">Rp. <?php echo number_format($total_gaji,0,',','.') ?></td>
              <td class="text-center align-middle">
                  <a class="btn btn-sm btn-primary shadow-sm" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/'.$g->id_kehadiran)?>"><i class="fas fa-print mr-1"></i> Cetak</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid --> 