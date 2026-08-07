<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <?php echo $this->session->flashdata('pesan') ?>

  <a class="btn btn-sm btn-success mb-3" href="<?php echo base_url('pegawai/cuti/tambah') ?>"><i class="fas fa-plus"></i> Buat Pengajuan Cuti / Izin</a>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Tanggal Mulai</th>
              <th class="text-center">Tanggal Akhir</th>
              <th class="text-center">Jenis Cuti</th>
              <th class="text-center">Alasan</th>
              <th class="text-center">Status</th>
              <th class="text-center">Catatan Admin</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($cuti as $c) : ?>
            <tr>
              <td class="text-center"><?php echo $no++ ?></td>
              <td class="text-center"><?php echo date('d M Y', strtotime($c->tanggal_mulai)) ?></td>
              <td class="text-center"><?php echo date('d M Y', strtotime($c->tanggal_akhir)) ?></td>
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
              <td>
                  <?php if(!empty($c->pesan_admin)): ?>
                      <span class="text-info small"><em>"<?php echo $c->pesan_admin; ?>"</em></span>
                  <?php else: ?>
                      <span class="text-muted small">-</span>
                  <?php endif; ?>
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
