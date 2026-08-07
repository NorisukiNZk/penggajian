<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
    <a href="<?php echo base_url('admin/hari_libur/sync_api') ?>" class="btn btn-sm btn-info shadow-sm" onclick="return confirm('Proses ini membutuhkan koneksi internet. Lanjutkan?')">
      <i class="fas fa-sync fa-sm text-white-50"></i> Sync Data API Nasional
    </a>
  </div>

  <?php echo $this->session->flashdata('pesan') ?>

  <!-- Card Layout untuk Form Tambah dan Tabel Data -->
  <div class="row">
      <!-- Form Tambah Libur -->
      <div class="col-lg-4">
          <div class="card shadow mb-4">
              <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Tanggal Merah</h6>
              </div>
              <div class="card-body">
                  <form action="<?php echo base_url('admin/hari_libur/tambah_aksi') ?>" method="POST">
                                        <div class="form-group">
                          <label>Tanggal</label>
                          <input type="date" name="tanggal" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Keterangan (Momen/Hari Besar)</label>
                          <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Hari Kemerdekaan RI" required>
                      </div>
                      <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Data</button>
                  
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
              </div>
          </div>
      </div>

      <!-- Tabel Data Libur -->
      <div class="col-lg-8">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Tanggal Merah Tersimpan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Tanggal</th>
                      <th class="text-center">Keterangan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($libur as $l) : ?>
                    <tr>
                      <td class="text-center"><?php echo $no++ ?></td>
                      <td class="text-center font-weight-bold text-danger">
                          <?php echo date('d M Y', strtotime($l->tanggal)) ?>
                      </td>
                      <td><?php echo $l->keterangan ?></td>
                      <td class="text-center">
                          <a onclick="return confirm('Yakin ingin menghapus tanggal merah ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('admin/hari_libur/hapus/'.$l->id_libur) ?>">
                              <i class="fas fa-trash"></i>
                          </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
  </div>

</div>
<!-- /.container-fluid -->
