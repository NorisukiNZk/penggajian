<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card mx-auto" style="width: 35%">
        <div class="card-header bg-primary text-white text-center">
            Laporan Pegawai
        </div>

        <form method="POST" action="<?php echo base_url('admin/data_pegawai/proses_akumulasi') ?>">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputTahun" class="col-sm-3 col-form-label">Tahun</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="tahun" id="inputTahun" required>
                            <option value=""> Pilih Tahun </option>
                            <?php 
                            $tahun = date('Y');
                            for ($i = 2020; $i <= $tahun + 5; $i++) { ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
            </div>
        
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
    </div>
</div>