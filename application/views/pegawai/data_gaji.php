<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <table class="table table-striped table-bordered">
  	<tr>
  		<th>Bulan/Tahun</th>
  		<th>Gaji Pokok</th>
  		<th>Tunjangan Transportasi</th>
  		<th>Uang Makan</th>
  		<th>Tunjangan Lain</th>
  		<th>Potongan (Alpha)</th>
  		<th>Potongan Lain</th>
  		<th>Total Gaji</th>
  		<th>Cetak Slip</th>
  	</tr>

  	<?php foreach($potongan as $p) : ?>
  		<?php $potongan = $p->jml_potongan; ?>
  	<?php endforeach; ?>

  	<?php foreach ($gaji as $g) : ?>
  	<?php 
  	$pot_gaji = $g->alpha * $potongan;
  	// Komponen dinamis
  	$tj_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['tunjangan']['total'] : 0;
  	$pot_lain = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['potongan']['total'] : 0;
  	$total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $tj_lain - $pot_gaji - $pot_lain;
  	?>
  	<tr>
  		<td><?php echo date('F Y', strtotime($g->bulan)); ?></td> <!-- Format tanggal menjadi "Bulan Tahun" -->
  		<td>Rp. <?php echo number_format($g->gaji_pokok,0,',','.') ?></td>
  		<td>Rp. <?php echo number_format($g->tj_transport,0,',','.') ?></td>
  		<td>Rp. <?php echo number_format($g->uang_makan,0,',','.') ?></td>
  		<td>
  			<?php if ($tj_lain > 0) : ?>
  				<span class="text-success">+Rp. <?php echo number_format($tj_lain,0,',','.') ?></span>
  			<?php else : ?>
  				<span class="text-muted">Rp. 0</span>
  			<?php endif; ?>
  		</td>
  		<td>Rp. <?php echo number_format($pot_gaji,0,',','.') ?></td>
  		<td>
  			<?php if ($pot_lain > 0) : ?>
  				<span class="text-danger">-Rp. <?php echo number_format($pot_lain,0,',','.') ?></span>
  			<?php else : ?>
  				<span class="text-muted">Rp. 0</span>
  			<?php endif; ?>
  		</td>
  		<td class="font-weight-bold">Rp. <?php echo number_format($total_gaji,0,',','.') ?></td>
  		<td>
  			<center>
  				<a class="btn btn-sm btn-primary" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/'.$g->id_kehadiran)?>"><i class="fas fa-print"></i></a>
  			</center>
  		</td>
  	</tr>
  <?php endforeach; ?>
  </table>

</div>
<!-- /.container-fluid --> 