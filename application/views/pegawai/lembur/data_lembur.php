<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Ajukan jam kerja tambahan (lembur) dan pantau status persetujuannya dari HRD atau Pimpinan.</p>
  </div>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<div class="row">
  <!-- Formulir Pengajuan Lembur -->
  <div class="col-lg-4 mb-4">
    <div class="emp-card">
      <div class="card-header">
        <h2 class="h6 font-weight-bold m-0">Formulir Pengajuan Lembur</h2>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php echo base_url('pegawai/lembur/tambah_aksi'); ?>">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label for="tanggal_lembur" class="small font-weight-bold">Tanggal Lembur</label>
            <input type="date" id="tanggal_lembur" name="tanggal_lembur" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
          </div>

          <div class="form-row">
            <div class="col-6 form-group">
              <label for="jam_mulai" class="small font-weight-bold">Jam Mulai</label>
              <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" required>
            </div>
            <div class="col-6 form-group">
              <label for="jam_selesai" class="small font-weight-bold">Jam Selesai</label>
              <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <label for="keterangan_lembur" class="small font-weight-bold">Uraian Pekerjaan</label>
            <textarea id="keterangan_lembur" name="keterangan" class="form-control" rows="3" required placeholder="Tuliskan tugas yang dikerjakan saat lembur"></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-paper-plane"></i> Kirim Pengajuan Lembur
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Riwayat Lembur -->
  <div class="col-lg-8 mb-4">
    <div class="emp-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h6 font-weight-bold m-0">Riwayat Pengajuan Lembur Anda</h2>
        <span class="small text-muted tabular-nums"><?php echo count($lembur); ?> pengajuan</span>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover mb-0" id="dataTable" width="100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 48px;">No</th>
                <th>Tanggal & Jam</th>
                <th class="text-center">Durasi</th>
                <th>Keterangan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($lembur)) : ?>
                <?php $no = 1; foreach ($lembur as $l) : ?>
                  <tr>
                    <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                    <td class="tabular-nums">
                      <div class="font-weight-bold"><?php echo date('d M Y', strtotime($l->tanggal_lembur)); ?></div>
                      <div class="small text-muted"><?php echo date('H:i', strtotime($l->jam_mulai)); ?> s/d <?php echo date('H:i', strtotime($l->jam_selesai)); ?></div>
                    </td>
                    <td class="text-center font-weight-bold tabular-nums"><?php echo (int)$l->durasi_jam; ?> jam</td>
                    <td class="small"><?php echo htmlspecialchars($l->keterangan, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                      <?php if ($l->status == 'Disetujui') : ?>
                        <span class="emp-status emp-status-ok">Disetujui</span>
                      <?php elseif ($l->status == 'Ditolak') : ?>
                        <span class="emp-status emp-status-danger">Ditolak</span>
                      <?php else : ?>
                        <span class="emp-status emp-status-warn">Pending</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan lembur tercatat.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
