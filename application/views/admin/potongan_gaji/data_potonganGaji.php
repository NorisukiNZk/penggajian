<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title?></h1>
            <p class="text-muted small mb-0">Kelola master parameter potongan gaji tetap dan ketidakhadiran pegawai.</p>
        </div>
        <button class="btn btn-sm btn-success shadow-sm mt-3 mt-md-0" data-toggle="modal" data-target="#tambahModal">
            <i class="fas fa-plus fa-sm mr-1"></i> Tambah Data
        </button>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Potongan</th>
                            <th class="text-center">Jumlah Potongan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($pot_gaji as $p) : ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td><?php echo $p->potongan ?></td>
                                <td>Rp. <?php echo number_format($p->jml_potongan,0,',','.') ?></td>
                                <td>
                                    <center>
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal<?php echo $p->id ?>" title="Edit Data"><i class="fas fa-edit"></i></button>
                                        <a class="btn btn-sm btn-danger btn-hapus" href="<?php echo base_url('admin/potongan_gaji/delete_data/'.$p->id) ?>" data-nama="<?php echo htmlspecialchars($p->potongan, ENT_QUOTES, 'UTF-8') ?>" title="Hapus Data"><i class="fas fa-trash"></i></a>
                                    </center>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?php echo $p->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Potongan Gaji</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="<?php echo base_url('admin/potongan_gaji/update_data_aksi') ?>" method="POST">
                                      <div class="modal-body">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="id" value="<?php echo $p->id ?>">

                                            <div class="form-group">
                                                <label>Nama Potongan</label>
                                                <input type="text" name="potongan" class="form-control" value="<?php echo htmlspecialchars($p->potongan) ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Jumlah Potongan (Rp)</label>
                                                <input type="number" name="jml_potongan" class="form-control" value="<?php echo htmlspecialchars($p->jml_potongan) ?>" required>
                                            </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                      </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Potongan Gaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo base_url('admin/potongan_gaji/tambah_data_aksi') ?>" method="POST">
          <div class="modal-body">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Nama Potongan</label>
                    <input type="text" name="potongan" class="form-control" placeholder="Contoh: Alpha / Koperasi / dll" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Potongan (Rp)</label>
                    <input type="number" name="jml_potongan" class="form-control" placeholder="Contoh: 50000" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Data</button>
          </div>
      </form>
    </div>
  </div>
</div>
