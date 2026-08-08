<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="letter-spacing: 1px;"><i class="fas fa-users mr-2 text-primary"></i> <?php echo $title ?></h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card shadow-lg mb-4" style="border-radius: 15px; border: none;">
                
                <!-- Card Header -->
                <div class="card-header py-4 bg-modern-blue d-flex flex-row align-items-center justify-content-between" style="border-radius: 15px 15px 0 0;">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-filter mr-2"></i> Filter Laporan Pegawai</h6>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <form method="POST" action="<?php echo base_url('admin/laporan_pegawai/cetak_laporan_pegawai') ?>" target="_blank">
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-800 mb-2">Berdasarkan Jabatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white border-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-user-tie"></i></span>
                                </div>
                                <select class="form-control form-control-lg bg-light border-0" name="jabatan" required style="border-radius: 0 10px 10px 0; font-size: 0.95rem;">
                                    <option value="semua">Semua Jabatan</option>
                                    <?php foreach($jabatan as $j) : ?>
                                        <option value="<?php echo $j->nama_jabatan ?>"><?php echo $j->nama_jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <small class="form-text text-muted mt-2"><i class="fas fa-info-circle mr-1"></i> Pilih jabatan tertentu atau biarkan "Semua Jabatan".</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" style="border-radius: 10px; font-weight: bold; letter-spacing: 1px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2);">
                            <i class="fas fa-print mr-2"></i> Cetak Laporan Pegawai
                        </button>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<style>
    /* Styling khusus untuk form ini */
    .bg-modern-blue {
        background-color: #0c2b4d; 
        background-image: linear-gradient(180deg, #0c2b4d 10%, #1a4270 100%);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(78, 115, 223, 0.3) !important;
    }
</style>
