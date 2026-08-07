<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

  <div class="card shadow mb-4" style="width: 60%;">
    <div class="card-body">
      <form method="POST" action="<?php echo base_url('pegawai/cuti/tambah_aksi') ?>">

        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jenis Cuti / Izin</label>
            <select name="jenis_cuti" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Tahunan">Cuti Tahunan</option>
                <option value="Sakit">Sakit</option>
                <option value="Melahirkan">Cuti Melahirkan</option>
                <option value="Izin Penting">Izin Penting</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alasan / Keterangan Lengkap</label>
            <textarea name="alasan" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Kirim Pengajuan</button>
        <a href="<?php echo base_url('pegawai/cuti')?>" class="btn btn-secondary">Kembali</a>

      
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
