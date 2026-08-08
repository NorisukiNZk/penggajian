<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
  </div>

  <!-- Tombol Cetak -->
  <a class="btn btn-sm btn-primary mb-3" href="<?php echo base_url('admin/data_pegawai/cetak'); ?>">
    <i class="fas fa-print"></i> Cetak
  </a>

  <a class="btn btn-sm btn-success mb-3" href="<?php echo base_url('admin/data_pegawai/tambah_data') ?>">
    <i class="fas fa-plus"></i> Tambah Pegawai
  </a>

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
              <th class="text-center">NIK</th>
              <th class="text-center">Nama Pegawai</th>
              <th class="text-center">Jenis Kelamin</th>
              <th class="text-center">Jabatan</th>
              <th class="text-center">Tanggal Masuk</th>
              <th class="text-center">Status</th>
              <th class="text-center">Hak Akses</th>
              <th class="text-center">Photo</th>
              <th class="text-center" width="12%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($pegawai as $p) : ?>
              <tr>
                <td class="text-center font-weight-bold"><?php echo $no++ ?></td>
                <td class="text-center"><?php echo $p->nik ?></td>
                <td class="font-weight-bold text-dark"><?php echo $p->nama_pegawai ?></td>
                <td class="text-center"><?php echo $p->jenis_kelamin ?></td>
                <td class="text-center"><?php echo $p->jabatan ?></td>
                <td class="text-center"><?php echo date('d M Y', strtotime($p->tanggal_masuk)) ?></td>
                <td class="text-center">
                    <?php if($p->status == 'Karyawan Tetap'){ ?>
                        <span class="badge badge-success px-2 py-1"><?php echo $p->status ?></span>
                    <?php } else { ?>
                        <span class="badge badge-warning px-2 py-1"><?php echo $p->status ?></span>
                    <?php } ?>
                </td>
                <td class="text-center">
                  <?php if ($p->hak_akses == '1') { ?>
                    <span class="badge badge-primary px-2 py-1">Admin</span>
                  <?php } else { ?>
                    <span class="badge badge-info px-2 py-1">Pegawai</span>
                  <?php } ?>
                </td>
                <td class="text-center">
                    <img src="<?php echo base_url() . 'photo/' . $p->photo ?>" class="rounded-circle shadow-sm" width="50px" height="50px" style="object-fit: cover;">
                </td>

                <td class="text-center">
                    <a class="btn btn-sm btn-info shadow-sm" href="<?php echo base_url('admin/data_pegawai/update_data/' . $p->id_pegawai) ?>" data-toggle="tooltip" title="Edit Data"><i class="fas fa-edit"></i></a>
                    <a onclick="return confirm('Yakin ingin menghapus data pegawai <?php echo $p->nama_pegawai ?>?')" class="btn btn-sm btn-danger shadow-sm" href="<?php echo base_url('admin/data_pegawai/delete_data/' . $p->id_pegawai) ?>" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>