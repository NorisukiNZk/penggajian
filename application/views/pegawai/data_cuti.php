<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Header & Action Button -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800">
        <i class="fas fa-calendar-check text-primary mr-2"></i><?php echo $title; ?>
      </h1>
      <p class="text-muted small mb-0">Kelola dan pantau status seluruh permohonan cuti dan izin kerja Anda.</p>
    </div>
    <div class="mt-3 mt-sm-0">
      <a href="<?php echo base_url('pegawai/cuti/tambah'); ?>" class="btn btn-primary btn-sm px-3 py-2 font-weight-bold shadow-sm rounded-pill">
        <i class="fas fa-plus-circle mr-1"></i> Ajukan Cuti Baru
      </a>
    </div>
  </div>

  <!-- Flash Message Session -->
  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Executive KPI Summary Cards -->
  <div class="row mb-4">
    <!-- Total Pengajuan -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #0284c7 !important; background: var(--card-bg, #ffffff);">
        <div class="card-body py-3">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Permohonan</div>
              <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo isset($kpi_total) ? $kpi_total : count($cuti); ?></div>
            </div>
            <div class="col-auto">
              <div class="p-2 rounded-circle bg-light text-primary">
                <i class="fas fa-folder-open fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Menunggu Review -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #f59e0b !important; background: var(--card-bg, #ffffff);">
        <div class="card-body py-3">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Review</div>
              <div class="h4 mb-0 font-weight-bold text-warning"><?php echo isset($kpi_menunggu) ? $kpi_menunggu : 0; ?></div>
            </div>
            <div class="col-auto">
              <div class="p-2 rounded-circle bg-light text-warning">
                <i class="fas fa-hourglass-half fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Disetujui -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #10b981 !important; background: var(--card-bg, #ffffff);">
        <div class="card-body py-3">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui HRD</div>
              <div class="h4 mb-0 font-weight-bold text-success"><?php echo isset($kpi_disetujui) ? $kpi_disetujui : 0; ?></div>
            </div>
            <div class="col-auto">
              <div class="p-2 rounded-circle bg-light text-success">
                <i class="fas fa-circle-check fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ditolak -->
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #f43f5e !important; background: var(--card-bg, #ffffff);">
        <div class="card-body py-3">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tidak Disetujui</div>
              <div class="h4 mb-0 font-weight-bold text-danger"><?php echo isset($kpi_ditolak) ? $kpi_ditolak : 0; ?></div>
            </div>
            <div class="col-auto">
              <div class="p-2 rounded-circle bg-light text-danger">
                <i class="fas fa-circle-xmark fa-lg"></i>
              </div>
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
        <i class="fas fa-list-check mr-2"></i>Daftar Riwayat Cuti & Izin Kerja
      </h6>
      <span class="badge badge-light border text-muted px-2 py-1 small">
        Sinkronisasi Realtime
      </span>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width: 5%;">No</th>
              <th style="width: 22%;">Periode Cuti</th>
              <th style="width: 15%;">Jenis Cuti</th>
              <th style="width: 25%;">Alasan / Keterangan</th>
              <th class="text-center" style="width: 13%;">Status</th>
              <th style="width: 10%;">Catatan HRD</th>
              <th class="text-center" style="width: 10%;">Aksi</th>
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
              ?>
              <tr>
                <td class="text-center font-weight-bold text-muted"><?php echo $no++; ?></td>
                
                <!-- Periode Cuti -->
                <td>
                  <div class="font-weight-bold text-gray-800">
                    <i class="fas fa-calendar-day text-info mr-1"></i>
                    <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?> &mdash; <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                  </div>
                  <div class="mt-1">
                    <span class="badge badge-info badge-pill font-weight-normal px-2 py-1">
                      <i class="fas fa-business-time mr-1"></i><?php echo $durasi; ?> Hari Kerja/Kalender
                    </span>
                    <span class="text-muted small ml-1">
                      (Diajukan: <?php echo date('d/m/Y H:i', strtotime($c->created_at)); ?>)
                    </span>
                  </div>
                </td>

                <!-- Jenis Cuti -->
                <td>
                  <?php 
                    $badge_class = 'badge-primary';
                    $icon_jenis = 'fa-umbrella-beach';
                    if (stripos($c->jenis_cuti, 'Sakit') !== false) {
                      $badge_class = 'badge-warning';
                      $icon_jenis = 'fa-notes-medical';
                    } elseif (stripos($c->jenis_cuti, 'Melahirkan') !== false) {
                      $badge_class = 'badge-success';
                      $icon_jenis = 'fa-baby';
                    } elseif (stripos($c->jenis_cuti, 'Penting') !== false) {
                      $badge_class = 'badge-secondary';
                      $icon_jenis = 'fa-triangle-exclamation';
                    }
                  ?>
                  <span class="badge <?php echo $badge_class; ?> px-2 py-1" style="font-size: 0.85em;">
                    <i class="fas <?php echo $icon_jenis; ?> mr-1"></i><?php echo $c->jenis_cuti; ?>
                  </span>
                </td>

                <!-- Alasan -->
                <td>
                  <span class="text-dark small" style="line-height: 1.4;"><?php echo nl2br(htmlspecialchars($c->alasan)); ?></span>
                </td>

                <!-- Status Pengajuan -->
                <td class="text-center">
                  <?php if($c->status_cuti == 'Menunggu'): ?>
                    <span class="badge badge-warning px-2 py-1" style="font-size: 0.85em;">
                      <i class="fas fa-clock mr-1"></i>Menunggu
                    </span>
                  <?php elseif($c->status_cuti == 'Disetujui'): ?>
                    <span class="badge badge-success px-2 py-1" style="font-size: 0.85em;">
                      <i class="fas fa-check-circle mr-1"></i>Disetujui
                    </span>
                  <?php else: ?>
                    <span class="badge badge-danger px-2 py-1" style="font-size: 0.85em;">
                      <i class="fas fa-times-circle mr-1"></i>Ditolak
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Catatan Admin -->
                <td>
                  <?php if(!empty($c->pesan_admin)): ?>
                    <span class="text-dark small font-italic d-block bg-light p-2 rounded border">
                      "<?php echo htmlspecialchars($c->pesan_admin); ?>"
                    </span>
                  <?php else: ?>
                    <span class="text-muted small">-</span>
                  <?php endif; ?>
                </td>

                <!-- Aksi -->
                <td class="text-center">
                  <div class="d-inline-flex gap-1">
                    <?php if($c->status_cuti == 'Menunggu'): ?>
                      <a href="<?php echo base_url('pegawai/cuti/batal/' . $c->id_cuti); ?>" 
                         class="btn btn-sm btn-outline-danger btn-batal-cuti shadow-sm" 
                         title="Batalkan Pengajuan Ini"
                         data-info="<?php echo date('d/m/Y', strtotime($c->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($c->tanggal_akhir)); ?>">
                        <i class="fas fa-trash-alt mr-1"></i> Batal
                      </a>
                    <?php elseif($c->status_cuti == 'Disetujui'): ?>
                      <a href="<?php echo base_url('pegawai/cuti/cetak_surat/' . $c->id_cuti); ?>" 
                         target="_blank" 
                         class="btn btn-sm btn-outline-success shadow-sm" 
                         title="Cetak Surat Izin/Cuti Resmi">
                        <i class="fas fa-print mr-1"></i> Cetak
                      </a>
                    <?php else: ?>
                      <button class="btn btn-sm btn-light border text-muted" disabled title="Pengajuan Ditolak">
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
  // Tombol Batalkan Cuti Mandiri
  $(document).on('click', '.btn-batal-cuti', function(e) {
    e.preventDefault();
    const href = $(this).attr('href');
    const info = $(this).data('info') || 'periode terpilih';
    const isDark = document.body.classList.contains('dark-mode');

    Swal.fire({
      title: 'Batalkan Pengajuan Cuti?',
      html: `Apakah Anda yakin ingin membatalkan permohonan cuti untuk tanggal <span class="badge badge-light border text-danger font-weight-bold px-2 py-1 mx-1">${info}</span>? Tindakan ini akan menghapus data pengajuan yang masih menunggu.`,
      icon: 'warning',
      iconColor: '#f59e0b',
      showCancelButton: true,
      confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i> Ya, Batalkan!',
      cancelButtonText: '<i class="fas fa-times mr-2"></i> Tidak, Kembali',
      customClass: {
        popup: 'swal2-modern-popup',
        confirmButton: 'btn btn-danger px-4 py-2 font-weight-bold shadow-sm',
        cancelButton: 'btn btn-light border px-4 py-2 shadow-sm'
      },
      buttonsStyling: false,
      reverseButtons: true,
      background: isDark ? '#1e293b' : '#ffffff',
      color: isDark ? '#f8fafc' : '#0f172a',
      showClass: {
        popup: 'animate__animated animate__zoomIn animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__zoomOut animate__faster'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Membatalkan...',
          html: 'Sedang memproses pembatalan pengajuan',
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => { Swal.showLoading(); },
          background: isDark ? '#1e293b' : '#ffffff',
          color: isDark ? '#f8fafc' : '#0f172a'
        });
        window.location.href = href;
      }
    });
  });
});
</script>
