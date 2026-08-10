<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="letter-spacing: 1px;"><i class="fas fa-chart-line mr-2 text-primary"></i> <?php echo $title ?></h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card shadow-lg mb-4" style="border-radius: 15px; border: none;">
                
                <div class="card-header py-4 bg-modern-blue d-flex flex-row align-items-center justify-content-between" style="border-radius: 15px 15px 0 0;">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-filter mr-2"></i> Filter Laporan Tahunan</h6>
                </div>
                
                <div class="card-body p-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <form method="POST" action="<?php echo base_url('admin/laporan_tahunan/cetak_laporan_tahunan') ?>" target="_blank">
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-800 mb-2">Tahun Laporan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white border-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-calendar-check"></i></span>
                                </div>
                                <select class="form-control form-control-lg bg-light border-0" name="tahun" required style="border-radius: 0 10px 10px 0; font-size: 0.95rem;">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php $tahun = date('Y');
                                    for($i = 2020; $i < $tahun + 5; $i++) { ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle"></i> Sistem akan merekap total gaji selama 1 tahun penuh.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" style="border-radius: 10px; font-weight: bold; letter-spacing: 1px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2);">
                            <i class="fas fa-print mr-2"></i> Cetak Laporan Tahunan
                        </button>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-modern-blue {
        background-color: #0c2b4d; 
        background-image: linear-gradient(180deg, #0c2b4d 10%, #1a4270 100%);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(78, 115, 223, 0.3) !important;
    }
</style>
