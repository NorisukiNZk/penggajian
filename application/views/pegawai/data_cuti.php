<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Header & Action Button -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800">
        <i class="fas fa-calendar-check text-primary mr-2"></i><?php echo $title; ?>
      </h1>
      <p class="text-muted small mb-0">Kelola dan pantau status permohonan cuti, delegasi tugas rekan pengganti, dan nota persetujuan Direktur Utama.</p>
    </div>
    <div class="mt-3 mt-sm-0">
      <a href="<?php echo base_url('pegawai/cuti/tambah'); ?>" class="btn btn-primary btn-sm px-3 py-2 font-weight-bold shadow-sm rounded-pill">
        <i class="fas fa-plus-circle mr-1"></i> Ajukan Cuti & Delegasi Baru
      </a>
    </div>
  </div>

  <!-- Flash Message Session -->
  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Top Overview: Saldo Cuti Card + Executive KPI Summary Cards -->
  <div class="row mb-4">
    
    <!-- Saldo Cuti Banner -->
    <div class="col-xl-4 col-lg-5 mb-3">
      <div class="card border-0 shadow-sm rounded-lg text-white" style="background: linear-gradient(135deg, #0c2b4d 0%, #1e3a8a 100%);">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge badge-light text-primary font-weight-bold px-2 py-1 small rounded-pill">
              <i class="fas fa-wallet mr-1"></i> Saldo Cuti (<?php echo isset($mode_kuota) ? $mode_kuota : 'Kombinasi'; ?>)
            </span>
            <span class="text-white small opacity-90 font-weight-bold">
              <?php echo isset($label_periode) ? $label_periode : '12 Hari/Th'; ?>
            </span>
          </div>
          <div class="row align-items-center text-center mt-2">
            <div class="col-6 border-right">
              <div class="h3 mb-0 font-weight-bold text-white"><?php echo isset($sisa_cuti) ? $sisa_cuti : 12; ?> <span class="small font-weight-normal" style="font-size: 0.9rem;">Hari</span></div>
              <span class="small opacity-80">Sisa Kuota Tersedia</span>
            </div>
            <div class="col-6">
              <div class="h3 mb-0 font-weight-bold text-warning"><?php echo isset($cuti_terpakai) ? $cuti_terpakai : 0; ?> <span class="small font-weight-normal" style="font-size: 0.9rem;">Hari</span></div>
              <span class="small opacity-80">Hari Terpakai</span>
            </div>
          </div>
          <?php if(isset($saldo_cuti) && $saldo_cuti['mode'] == 'Kombinasi'): ?>
            <div class="mt-2 pt-2 border-top text-center" style="border-color: rgba(255,255,255,0.15) !important;">
              <small class="text-light opacity-80">
                <i class="fas fa-info-circle mr-1 text-info"></i> Batas bulanan: <strong>Maks. <?php echo $saldo_cuti['kuota_bulanan']; ?> hari/bln</strong> (Bulan ini terpakai: <?php echo $saldo_cuti['cuti_terpakai_bulan']; ?> hr)
              </small>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="col-xl-8 col-lg-7">
      <div class="row">
        <!-- Total Pengajuan -->
        <div class="col-sm-4 mb-3">
          <div class="card border-0 shadow-sm rounded-lg h-100" style="border-left: 4px solid #0284c7 !important; background: var(--card-bg, #ffffff);">
            <div class="card-body p-3">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Diajukan</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo isset($kpi_total) ? $kpi_total : count($cuti); ?></div>
            </div>
          </div>
        </div>

        <!-- Menunggu Review -->
        <div class="col-sm-4 mb-3">
          <div class="card border-0 shadow-sm rounded-lg h-100" style="border-left: 4px solid #f59e0b !important; background: var(--card-bg, #ffffff);">
            <div class="card-body p-3">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dalam Proses</div>
              <div class="h4 mb-0 font-weight-bold text-warning"><?php echo isset($kpi_menunggu) ? $kpi_menunggu : 0; ?></div>
            </div>
          </div>
        </div>

        <!-- Disetujui -->
        <div class="col-sm-4 mb-3">
          <div class="card border-0 shadow-sm rounded-lg h-100" style="border-left: 4px solid #10b981 !important; background: var(--card-bg, #ffffff);">
            <div class="card-body p-3">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui Sah</div>
              <div class="h4 mb-0 font-weight-bold text-success"><?php echo isset($kpi_disetujui) ? $kpi_disetujui : 0; ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Data Cuti Table Card -->
  <div class="card border-0 shadow-sm rounded-lg mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-transparent border-bottom">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-list-check mr-2"></i>Daftar Riwayat Cuti & Pendelegasian Tugas
      </h6>
      <span class="badge badge-light border text-muted px-2 py-1 small">
        SOP 3 Pilar Akuntabilitas
      </span>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width: 4%;">No</th>
              <th style="width: 20%;">Periode & Kategori</th>
              <th style="width: 22%;">Rekan Pengganti & Shift</th>
              <th style="width: 18%;">Alasan & Bukti</th>
              <th class="text-center" style="width: 16%;">Status Approval</th>
              <th style="width: 12%;">Catatan HRD / Direksi</th>
              <th class="text-center" style="width: 8%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($cuti)): ?>
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                  <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                  Belum ada riwayat permohonan cuti atau izin.
                </td>
              </tr>
            <?php else: ?>
              <?php $no = 1; foreach($cuti as $c) : 
                $dt_start = new DateTime($c->tanggal_mulai);
                $dt_end   = new DateTime($c->tanggal_akhir);
                $durasi   = $dt_start->diff($dt_end)->days + 1;

                // Status Approval Labeling
                $app_status = !empty($c->status_approval) ? $c->status_approval : ($c->status_cuti == 'Disetujui' ? 'Disetujui Direktur' : ($c->status_cuti == 'Ditolak' ? 'Ditolak' : 'Menunggu Review HRD'));
              ?>
              <tr>
                <td class="text-center font-weight-bold text-muted"><?php echo $no++; ?></td>
                
                <!-- Periode & Kategori -->
                <td>
                  <div class="font-weight-bold text-gray-800">
                    <i class="fas fa-calendar-day text-info mr-1"></i>
                    <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?> &mdash; <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                  </div>
                  <div class="mt-1 d-flex flex-wrap gap-1 align-items-center">
                    <span class="badge badge-info font-weight-normal px-2 py-1">
                      <i class="fas fa-business-time mr-1"></i><?php echo $durasi; ?> Hari
                    </span>
                    <?php 
                      $badge_jenis = 'badge-primary';
                      if (stripos($c->jenis_cuti, 'Sakit') !== false) $badge_jenis = 'badge-warning';
                      elseif (stripos($c->jenis_cuti, 'Melahirkan') !== false) $badge_jenis = 'badge-success';
                      elseif (stripos($c->jenis_cuti, 'Penting') !== false) $badge_jenis = 'badge-secondary';
                    ?>
                    <span class="badge <?php echo $badge_jenis; ?> font-weight-normal px-2 py-1 ml-1">
                      <?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                  </div>
                  <small class="text-muted d-block mt-1">
                    Diajukan: <?php echo date('d/m/Y H:i', strtotime($c->created_at)); ?>
                  </small>
                </td>

                <!-- Rekan Pengganti Shift -->
                <td>
                  <?php if (!empty($c->nama_pengganti)) : ?>
                    <div class="font-weight-bold text-dark small">
                      <i class="fas fa-user-check text-success mr-1"></i><?php echo htmlspecialchars($c->nama_pengganti, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <span class="badge badge-light border text-muted small" style="font-size: 0.75rem;">
                      <?php echo htmlspecialchars($c->jabatan_pengganti, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <?php if (!empty($c->tugas_pengganti)) : ?>
                      <div class="small text-muted mt-1 font-italic border-left pl-2" style="font-size: 0.75rem; line-height: 1.3;">
                        "<?php echo htmlspecialchars(mb_strimwidth($c->tugas_pengganti, 0, 70, "..."), ENT_QUOTES, 'UTF-8'); ?>"
                      </div>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="badge badge-light border text-muted">-</span>
                  <?php endif; ?>
                </td>

                <!-- Alasan & Bukti SKD -->
                <td>
                  <div class="text-dark small mb-1" style="line-height: 1.4;">
                    <?php echo htmlspecialchars(mb_strimwidth($c->alasan, 0, 70, "..."), ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                  
                  <?php if (!empty($c->file_lampiran)) : ?>
                    <a href="<?php echo base_url('uploads/cuti/' . $c->file_lampiran); ?>" target="_blank" class="badge badge-success px-2 py-1 shadow-sm text-decoration-none">
                      <i class="fas fa-paperclip mr-1"></i> Bukti Terlampir
                    </a>
                  <?php else : ?>
                    <span class="badge badge-light border text-muted small">Tanpa Berkas</span>
                  <?php endif; ?>

                  <?php if (!empty($c->kontak_darurat)) : ?>
                    <div class="small text-muted mt-1" style="font-size: 0.75rem;">
                      <i class="fas fa-phone-alt text-warning mr-1"></i><?php echo htmlspecialchars($c->kontak_darurat, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                  <?php endif; ?>
                </td>

                <!-- Status Approval 2 Tingkat -->
                <td class="text-center">
                  <?php if($app_status == 'Menunggu Review HRD' || $c->status_cuti == 'Menunggu'): ?>
                    <span class="badge badge-warning px-2 py-1 font-weight-bold d-block mb-1" style="font-size: 0.8em;">
                      <i class="fas fa-hourglass-half mr-1"></i>Review HRD
                    </span>
                    <small class="text-muted" style="font-size: 0.7rem;">Menunggu verifikasi berkas</small>
                  <?php elseif($app_status == 'Diteruskan ke Direktur'): ?>
                    <span class="badge badge-info px-2 py-1 font-weight-bold d-block mb-1" style="font-size: 0.8em;">
                      <i class="fas fa-arrow-up-right-from-square mr-1"></i>Ke Direktur Utama
                    </span>
                    <small class="text-info font-weight-bold" style="font-size: 0.7rem;">Rekomendasi HRD Terkirim</small>
                  <?php elseif($c->status_cuti == 'Disetujui'): ?>
                    <span class="badge badge-success px-2 py-1 font-weight-bold d-block mb-1" style="font-size: 0.8em;">
                      <i class="fas fa-circle-check mr-1"></i>Disetujui Sah
                    </span>
                    <small class="text-success font-weight-bold" style="font-size: 0.7rem;">SK Cuti Diterbitkan</small>
                  <?php else: ?>
                    <span class="badge badge-danger px-2 py-1 font-weight-bold d-block mb-1" style="font-size: 0.8em;">
                      <i class="fas fa-circle-xmark mr-1"></i>Ditolak
                    </span>
                    <small class="text-danger" style="font-size: 0.7rem;">Tidak Memenuhi Syarat</small>
                  <?php endif; ?>
                </td>

                <!-- Catatan HRD / Direksi -->
                <td>
                  <?php if(!empty($c->pesan_admin) || !empty($c->catatan_hrd)): ?>
                    <div class="small bg-light p-2 rounded border" style="font-size: 0.75rem;">
                      <?php if (!empty($c->catatan_hrd)): ?>
                        <span class="font-weight-bold text-primary d-block">Telaah HR:</span>
                        <span class="text-muted d-block mb-1 font-italic">"<?php echo htmlspecialchars($c->catatan_hrd); ?>"</span>
                      <?php endif; ?>
                      <?php if (!empty($c->pesan_admin)): ?>
                        <span class="font-weight-bold text-dark d-block">Keputusan:</span>
                        <span class="text-muted d-block font-italic">"<?php echo htmlspecialchars($c->pesan_admin); ?>"</span>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <span class="text-muted small">-</span>
                  <?php endif; ?>
                </td>

                <!-- Aksi -->
                <td class="text-center">
                  <div class="d-inline-flex gap-1">
                    <?php if($c->status_cuti == 'Menunggu'): ?>
                      <a href="<?php echo base_url('pegawai/cuti/batal/' . $c->id_cuti); ?>" 
                         class="btn btn-sm btn-outline-danger btn-batal-cuti shadow-sm rounded-pill px-3" 
                         title="Batalkan Pengajuan Ini"
                         data-info="<?php echo date('d/m/Y', strtotime($c->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($c->tanggal_akhir)); ?>">
                        <i class="fas fa-trash-alt mr-1"></i> Batal
                      </a>
                    <?php elseif($c->status_cuti == 'Disetujui'): ?>
                      <a href="<?php echo base_url('pegawai/cuti/cetak_surat/' . $c->id_cuti); ?>" 
                         target="_blank" 
                         class="btn btn-sm btn-outline-success shadow-sm rounded-pill px-3 font-weight-bold" 
                         title="Cetak Surat Izin/Cuti Resmi">
                        <i class="fas fa-print mr-1"></i> Cetak SK
                      </a>
                    <?php else: ?>
                      <button class="btn btn-sm btn-light border text-muted rounded-pill px-3" disabled title="Pengajuan Ditolak">
                        <i class="fas fa-ban mr-1"></i> Tutup
                      </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<!-- Interactive SweetAlert2 Script for Employee Actions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const cancelButtons = document.querySelectorAll('.btn-batal-cuti');
  cancelButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const targetUrl = this.getAttribute('href');
      const infoTgl   = this.getAttribute('data-info');

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Batalkan Permohonan Cuti?',
          text: 'Apakah Anda yakin ingin membatalkan permohonan cuti periode ' + infoTgl + '?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Batalkan',
          cancelButtonText: 'Kembali',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = targetUrl;
          }
        });
      } else {
        if (confirm('Apakah Anda yakin ingin membatalkan permohonan cuti periode ' + infoTgl + '?')) {
          window.location.href = targetUrl;
        }
      }
    });
  });
});
</script>
