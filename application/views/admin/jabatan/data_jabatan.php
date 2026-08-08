<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
  </div>
  <a class="btn btn-sm btn-success mb-3" href="<?php echo base_url('admin/data_jabatan/tambah_data') ?>"><i class="fas fa-plus"></i> Tambah Jabatan</a>
  <a class="btn btn-sm btn-primary mb-3" href="<?php echo base_url('admin/data_jabatan/cetak_data_jabatan') ?>"><i class="fas fa-file-pdf"></i> Cetak Detail Jabatan</a>
  <?php echo $this->session->flashdata('pesan') ?>
</div>

<div class="container-fluid">
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
                    <a onclick="return confirm('Yakin ingin menghapus jabatan <?php echo $j->nama_jabatan ?>?')" class="btn btn-sm btn-danger shadow-sm" href="<?php echo base_url('admin/data_jabatan/delete_data/' . $j->id_jabatan) ?>" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>