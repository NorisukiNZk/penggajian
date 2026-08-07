<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card mx-auto" style="width: 35%">
        <div class="card-header bg-primary text-white text-center">
            Cetak Rekapitulasi Pegawai
        </div>

        <form method="POST" action="<?php echo base_url('admin/pegawai/cetak_rekapitulasi') ?>">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputPegawai" class="col-sm-3 col-form-label">Nama Pegawai</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="nama_pegawai" id="inputPegawai">
                            <option value="">Pilih Pegawai</option>
                            <?php foreach ($pegawai as $p) : ?>
                                <option value="<?php echo $p->id_pegawai ?>"><?php echo $p->nama_pegawai ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button style="width: 100%" type="submit" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak Rekapitulasi
                </button>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->