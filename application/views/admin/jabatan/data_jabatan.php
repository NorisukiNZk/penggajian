<div class="container-fluid">
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title ?></h1>
      <p class="text-muted small mb-0">Pengaturan struktur formasi jabatan, standar gaji pokok, dan tunjangan operasional.</p>
    </div>
    <div class="mt-3 mt-md-0">
      <a class="btn btn-sm btn-primary shadow-sm mr-2" href="<?php echo base_url('admin/data_jabatan/cetak_data_jabatan') ?>"><i class="fas fa-file-pdf mr-1"></i> Cetak Detail Jabatan</a>
      <a class="btn btn-sm btn-success shadow-sm" href="<?php echo base_url('admin/data_jabatan/tambah_data') ?>"><i class="fas fa-plus mr-1"></i> Tambah Jabatan</a>
    </div>
  </div>
  <?php echo $this->session->flashdata('pesan') ?>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white">
            <tr>
              <th class="text-center" width="5%">No</th>
              <th class="text-center">Nama Jabatan</th>
              <th class="text-center">Gaji Pokok</th>
              <th class="text-center">Tj. Transport</th>
              <th class="text-center">Uang Makan</th>
              <th class="text-center">Total</th>
              <th class="text-center" width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($jabatan as $j) : ?>

              <tr>
                <td class="text-center font-weight-bold"><?php echo $no++ ?></td>
                <td class="font-weight-bold"><?php echo $j->nama_jabatan ?></td>
                <td class="text-right">Rp <?php echo number_format($j->gaji_pokok, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?php echo number_format($j->tj_transport, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?php echo number_format($j->uang_makan, 0, ',', '.') ?></td>
                <td class="text-right font-weight-bold text-success">Rp <?php echo number_format($j->gaji_pokok + $j->tj_transport + $j->uang_makan, 0, ',', '.') ?></td>

                <td class="text-center">
                    <a class="btn btn-sm btn-info shadow-sm" href="<?php echo base_url('admin/data_jabatan/update_data/' . $j->id_jabatan) ?>" data-toggle="tooltip" title="Edit Data"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger shadow-sm btn-hapus" href="<?php echo base_url('admin/data_jabatan/delete_data/' . $j->id_jabatan) ?>" data-nama="<?php echo htmlspecialchars($j->nama_jabatan, ENT_QUOTES, 'UTF-8') ?>" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>