<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <?php echo $this->session->flashdata('pesan') ?>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Cuti & Izin Pegawai</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Nama Pegawai</th>
              <th class="text-center">Tanggal Cuti</th>
              <th class="text-center">Jenis</th>
              <th class="text-center">Alasan</th>
              <th class="text-center">Status</th>
              <th class="text-center">Aksi (HRD)</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($cuti as $c) : ?>
            <tr>
              <td class="text-center"><?php echo $no++ ?></td>
              <td>
                  <strong><?php echo $c->nama_pegawai ?></strong><br>
                  <small class="text-muted"><?php echo $c->jabatan ?></small>
              </td>
              <td class="text-center">
                  <?php echo date('d M Y', strtotime($c->tanggal_mulai)) ?> <br> s/d <br> <?php echo date('d M Y', strtotime($c->tanggal_akhir)) ?>
              </td>
              <td class="text-center"><?php echo $c->jenis_cuti ?></td>
              <td><?php echo $c->alasan ?></td>
              <td class="text-center">
                  <?php if($c->status_cuti == 'Menunggu') { ?>
                      <span class="badge badge-warning">Menunggu</span>
                  <?php } else if($c->status_cuti == 'Disetujui') { ?>
                      <span class="badge badge-success">Disetujui</span>
                  <?php } else { ?>
                      <span class="badge badge-danger">Ditolak</span>
                  <?php } ?>
              </td>
              <td class="text-center">
                  <?php if($c->status_cuti == 'Menunggu') { ?>
                      <button class="btn btn-sm btn-success mb-1" data-toggle="modal" data-target="#approveModal<?php echo $c->id_cuti ?>"><i class="fas fa-check"></i> Setujui</button>
                      <br>
                      <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal<?php echo $c->id_cuti ?>"><i class="fas fa-times"></i> Tolak</button>
                  <?php } else { ?>
                      <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                  <?php } ?>
              </td>
            </tr>

            <!-- Modal Setujui -->
            <div class="modal fade" id="approveModal<?php echo $c->id_cuti ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Konfirmasi Persetujuan</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form method="POST" action="<?php echo base_url('admin/data_cuti/approve/'.$c->id_cuti) ?>">
                      <div class="modal-body">
                          <p>Anda akan menyetujui pengajuan cuti <strong><?php echo $c->nama_pegawai ?></strong>.</p>
                          <p class="text-info small">Data cuti yang disetujui akan otomatis masuk ke tabel Absensi Harian.</p>
                          <div class="form-group">
                              <label>Catatan / Pesan untuk Pegawai (Opsional):</label>
                              <textarea name="pesan_admin" class="form-control" rows="3" placeholder="Misal: Harap selesaikan tugas sebelum cuti."></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-success">Setujui Pengajuan</button>
                      </div>
                  
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
                </div>
              </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal fade" id="rejectModal<?php echo $c->id_cuti ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Penolakan</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form method="POST" action="<?php echo base_url('admin/data_cuti/reject/'.$c->id_cuti) ?>">
                      <div class="modal-body">
                          <p>Anda akan menolak pengajuan cuti <strong><?php echo $c->nama_pegawai ?></strong>.</p>
                          <div class="form-group">
                              <label>Alasan Penolakan / Pesan <span class="text-danger">*</span></label>
                              <textarea name="pesan_admin" class="form-control" rows="3" placeholder="Misal: Ditolak karena kuota cuti tahunan habis." required></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                      </div>
                  
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
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
<!-- /.container-fluid -->
