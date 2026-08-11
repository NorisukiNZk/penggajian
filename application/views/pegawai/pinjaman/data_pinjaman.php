<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?php echo base_url('pegawai/pinjaman/tambah') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Ajukan Pinjaman Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Pengajuan</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Tenor</th>
                            <th class="text-center">Cicilan/Bulan</th>
                            <th class="text-center">Alasan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($pinjaman as $p) : 
                            $cicilan = ceil($p->jumlah_pinjaman / $p->tenor_bulan);
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++ ?></td>
                            <td class="text-center"><?php echo date('d-M-Y', strtotime($p->tgl_pengajuan)) ?></td>
                            <td class="text-right">Rp <?php echo number_format($p->jumlah_pinjaman,0,',','.') ?></td>
                            <td class="text-center"><?php echo $p->tenor_bulan ?> Bln</td>
                            <td class="text-right text-danger">Rp <?php echo number_format($cicilan,0,',','.') ?></td>
                            <td><?php echo $p->alasan ?></td>
                            <td class="text-center">
                                <?php if($p->status == 'Pending') { ?>
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                <?php } else if($p->status == 'Disetujui') { ?>
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
