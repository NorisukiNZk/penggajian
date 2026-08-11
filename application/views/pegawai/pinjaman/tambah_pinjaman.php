<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>

    <div class="card shadow mb-4" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST" action="<?php echo base_url('pegawai/pinjaman/tambah_aksi') ?>">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                
                <div class="form-group">
                    <label>Nominal Pinjaman (Rp)</label>
                    <input type="number" name="jumlah_pinjaman" class="form-control" required placeholder="Contoh: 1000000">
                    <?php echo form_error('jumlah_pinjaman', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <div class="form-group">
                    <label>Tenor Cicilan (Bulan)</label>
                    <select name="tenor_bulan" class="form-control" required>
                        <option value="">-- Pilih Lama Cicilan --</option>
                        <option value="1">1 Bulan</option>
                        <option value="2">2 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="4">4 Bulan</option>
                        <option value="5">5 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                    <?php echo form_error('tenor_bulan', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <div class="form-group">
                    <label>Alasan Peminjaman</label>
                    <textarea name="alasan" class="form-control" rows="3" required placeholder="Contoh: Biaya berobat keluarga..."></textarea>
                    <?php echo form_error('alasan', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <div class="alert alert-info" style="font-size: 13px;">
                    <i class="fas fa-info-circle"></i> <strong>Peringatan:</strong> Pinjaman yang disetujui akan dipotong secara otomatis dari slip gaji Anda setiap bulannya selama masa tenor.
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Ajukan Pinjaman</button>
                <a href="<?php echo base_url('pegawai/pinjaman') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
