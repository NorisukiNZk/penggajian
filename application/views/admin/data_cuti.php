<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><?php echo $title; ?></h1>
      <p class="text-muted small mb-0">Kelola persetujuan, verifikasi alasan, dan pantau rekapitulasi izin/cuti pegawai.</p>
    </div>
  </div>

  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Executive KPI Summary Cards -->
  <div class="row mb-4">
    
    <!-- Menunggu Review -->
    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Review HRD</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo $count_menunggu; ?>
                <?php if($count_menunggu > 0): ?>
                  <span class="badge badge-warning badge-pill ml-2 small" style="font-size: 0.75rem;">Perlu Tindakan</span>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-auto">
              <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning-light" style="width: 45px; height: 45px; background: rgba(246, 194, 62, 0.15);">
                <i class="fas fa-clock text-warning fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Disetujui -->
    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_disetujui; ?></div>
            </div>
            <div class="col-auto">
              <div class="rounded-circle d-flex align-items-center justify-content-center bg-success-light" style="width: 45px; height: 45px; background: rgba(28, 200, 138, 0.15);">
                <i class="fas fa-check-circle text-success fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ditolak -->
    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_ditolak; ?></div>
            </div>
            <div class="col-auto">
              <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-light" style="width: 45px; height: 45px; background: rgba(231, 74, 59, 0.15);">
                <i class="fas fa-times-circle text-danger fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Pengajuan -->
    <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Riwayat Pengajuan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_total; ?></div>
            </div>
            <div class="col-auto">
              <div class="rounded-circle d-flex align-items-center justify-content-center bg-info-light" style="width: 45px; height: 45px; background: rgba(54, 185, 204, 0.15);">
                <i class="fas fa-file-signature text-info fa-lg"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Data Table Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-list-check mr-2"></i>Daftar Pengajuan Cuti & Izin Pegawai
      </h6>
      <span class="badge badge-light border text-muted small px-3 py-1">
        Sinkronisasi Otomatis Absensi
      </span>
    </div>
    
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white">
            <tr>
              <th class="text-center align-middle" style="width: 4%;">No</th>
              <th class="align-middle" style="width: 22%;">Pegawai</th>
              <th class="text-center align-middle" style="width: 18%;">Periode & Durasi</th>
              <th class="text-center align-middle" style="width: 12%;">Jenis Cuti</th>
              <th class="align-middle" style="width: 20%;">Alasan & Feedback HRD</th>
              <th class="text-center align-middle" style="width: 11%;">Status</th>
              <th class="text-center align-middle" style="width: 13%;">Aksi (HRD)</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1; 
            foreach($cuti as $c) : 
              // Hitung durasi hari
              $tgl1 = strtotime($c->tanggal_mulai);
              $tgl2 = strtotime($c->tanggal_akhir);
              $durasi = round(($tgl2 - $tgl1) / 86400) + 1;
              if ($durasi < 1) $durasi = 1;

              // Warna badge jenis cuti
              $badge_jenis = 'badge-primary';
              if (strtolower($c->jenis_cuti) == 'sakit') $badge_jenis = 'badge-warning';
              elseif (strtolower($c->jenis_cuti) == 'melahirkan') $badge_jenis = 'badge-info';
              elseif (strtolower($c->jenis_cuti) == 'izin penting') $badge_jenis = 'badge-secondary';
            ?>
            <tr>
              <!-- No -->
              <td class="text-center align-middle"><?php echo $no++; ?></td>
              
              <!-- Pegawai -->
              <td class="align-middle">
                <div class="d-flex align-items-center">
                  <div class="mr-3">
                    <?php if (!empty($c->photo) && file_exists(FCPATH . 'photo/' . $c->photo)) : ?>
                      <img src="<?php echo base_url('photo/' . $c->photo); ?>" alt="Photo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" class="border">
                    <?php else : ?>
                      <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center border" style="width: 40px; height: 40px; font-weight: bold;">
                        <?php echo strtoupper(substr($c->nama_pegawai, 0, 1)); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div>
                    <strong class="text-gray-900 d-block" style="font-size: 0.95rem;"><?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span class="badge badge-light border text-primary small">NIK: <?php echo htmlspecialchars($c->nik, ENT_QUOTES, 'UTF-8'); ?></span>
                    <small class="text-muted d-block"><?php echo htmlspecialchars($c->jabatan, ENT_QUOTES, 'UTF-8'); ?></small>
                  </div>
                </div>
              </td>

              <!-- Periode & Durasi -->
              <td class="text-center align-middle">
                <div class="font-weight-bold text-gray-800" style="font-size: 0.9rem;">
                  <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?>
                </div>
                <div class="text-muted small mb-1">s/d</div>
                <div class="font-weight-bold text-gray-800" style="font-size: 0.9rem;">
                  <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                </div>
                <span class="badge badge-pill badge-info px-2 py-1 mt-1 font-weight-bold">
                  <i class="fas fa-calendar-day mr-1"></i><?php echo $durasi; ?> Hari
                </span>
              </td>

              <!-- Jenis Cuti -->
              <td class="text-center align-middle">
                <span class="badge <?php echo $badge_jenis; ?> px-3 py-1 font-weight-bold" style="font-size: 0.825rem;">
                  <?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?>
                </span>
              </td>

              <!-- Alasan & Catatan -->
              <td class="align-middle">
                <div class="text-gray-800 small mb-1">
                  <strong>Alasan:</strong> <?php echo htmlspecialchars($c->alasan, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php if(!empty($c->pesan_admin)): ?>
                  <div class="p-2 rounded bg-light border text-muted small mt-1">
                    <i class="fas fa-comment-dots mr-1 text-info"></i>
                    <strong>Catatan HRD:</strong> "<?php echo htmlspecialchars($c->pesan_admin, ENT_QUOTES, 'UTF-8'); ?>"
                  </div>
                <?php endif; ?>
              </td>

              <!-- Status -->
              <td class="text-center align-middle">
                <?php if($c->status_cuti == 'Menunggu') : ?>
                  <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.825rem;">
                    <i class="fas fa-clock mr-1"></i>Menunggu
                  </span>
                <?php elseif($c->status_cuti == 'Disetujui') : ?>
                  <span class="badge badge-success px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.825rem;">
                    <i class="fas fa-check-circle mr-1"></i>Disetujui
                  </span>
                <?php else : ?>
                  <span class="badge badge-danger px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.825rem;">
                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                  </span>
                <?php endif; ?>
              </td>

              <!-- Aksi HRD (SweetAlert2 Dynamic Modals) -->
              <td class="text-center align-middle">
                <?php if($c->status_cuti == 'Menunggu') : ?>
                  <button type="button" 
                          class="btn btn-sm btn-success btn-approve-cuti btn-block font-weight-bold mb-1 shadow-sm"
                          data-id="<?php echo $c->id_cuti; ?>"
                          data-nama="<?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                          data-jenis="<?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?>"
                          data-durasi="<?php echo $durasi; ?> Hari">
                    <i class="fas fa-check mr-1"></i> Setujui
                  </button>
                  <button type="button" 
                          class="btn btn-sm btn-danger btn-reject-cuti btn-block font-weight-bold shadow-sm"
                          data-id="<?php echo $c->id_cuti; ?>"
                          data-nama="<?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>">
                    <i class="fas fa-times mr-1"></i> Tolak
                  </button>
                <?php else : ?>
                  <span class="badge badge-light border text-muted px-2 py-1 small d-block mb-1">
                    <i class="fas fa-lock mr-1"></i>Telah Diproses
                  </span>
                  <div class="d-flex gap-1 justify-content-center">
                    <?php if($c->status_cuti == 'Disetujui') : ?>
                      <a href="<?php echo base_url('admin/data_cuti/cetak_surat/' . $c->id_cuti); ?>" 
                         target="_blank"
                         class="btn btn-sm btn-outline-primary py-1 px-2 shadow-sm mr-1"
                         title="Cetak Surat Cuti Resmi">
                        <i class="fas fa-print mr-1"></i> Cetak
                      </a>
                    <?php endif; ?>
                    <a href="<?php echo base_url('admin/data_cuti/hapus/' . $c->id_cuti); ?>" 
                       class="btn btn-sm btn-outline-danger btn-hapus py-1 px-2 shadow-sm"
                       data-nama="Riwayat cuti <?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                       title="Hapus Rekap Cuti">
                      <i class="fas fa-trash-can mr-1"></i> Hapus
                    </a>
                  </div>
                <?php endif; ?>
              </td>

            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<!-- Script SweetAlert2 Dynamic Actions for Cuti -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const isDark = () => document.body.classList.contains('dark-mode');
  
  // 1. Interactive Approval Dialog
  $(document).on('click', '.btn-approve-cuti', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const nama = $(this).data('nama');
    const jenis = $(this).data('jenis');
    const durasi = $(this).data('durasi');

    Swal.fire({
      title: 'Setujui Pengajuan Cuti?',
      html: `
        <div class="text-left mb-2">
          <div class="alert alert-info py-2 px-3 mb-3" style="font-size: 0.88rem; border-radius: 12px;">
            <i class="fas fa-info-circle mr-1"></i> Pengajuan ini akan otomatis disinkronkan ke <strong>Absensi Harian</strong> pegawai.
          </div>
          <p class="mb-1 font-weight-bold" style="font-size: 1rem;">Pegawai: ${nama}</p>
          <p class="small mb-3 opacity-75">Jenis: <span class="badge badge-primary">${jenis}</span> &bull; Durasi: <b>${durasi}</b></p>
          <label class="font-weight-bold small mb-1">Pesan / Catatan HRD (Opsional):</label>
          <textarea id="swal_pesan_admin" class="form-control" rows="3" placeholder="Misal: Disetujui, harap selesaikan serah terima tugas sebelum libur."></textarea>
        </div>
      `,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      cancelButtonColor: '#64748b',
      confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Setujui Sekarang!',
      cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
      background: isDark() ? '#1e293b' : '#ffffff',
      color: isDark() ? '#f8fafc' : '#0f172a',
      preConfirm: () => {
        return document.getElementById('swal_pesan_admin').value;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Buat dynamic form POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo base_url("admin/data_cuti/approve/"); ?>' + id;
        
        const inputPesan = document.createElement('input');
        inputPesan.type = 'hidden';
        inputPesan.name = 'pesan_admin';
        inputPesan.value = result.value || '';
        form.appendChild(inputPesan);

        const inputCsrf = document.createElement('input');
        inputCsrf.type = 'hidden';
        inputCsrf.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        inputCsrf.value = '<?php echo $this->security->get_csrf_hash(); ?>';
        form.appendChild(inputCsrf);

        document.body.appendChild(form);
        form.submit();
      }
    });
  });

  // 2. Interactive Rejection Dialog
  $(document).on('click', '.btn-reject-cuti', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const nama = $(this).data('nama');

    Swal.fire({
      title: 'Tolak Pengajuan Cuti?',
      html: `
        <div class="text-left mb-2">
          <p class="mb-2">Anda akan menolak pengajuan cuti pegawai: <b>${nama}</b>.</p>
          <label class="font-weight-bold small mb-1">Alasan Penolakan <span class="text-danger">*</span>:</label>
          <textarea id="swal_alasan_tolak" class="form-control" rows="3" placeholder="Tuliskan alasan penolakan secara jelas..."></textarea>
        </div>
      `,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#64748b',
      confirmButtonText: '<i class="fas fa-times mr-1"></i> Ya, Tolak Pengajuan',
      cancelButtonText: '<i class="fas fa-ban mr-1"></i> Batal',
      background: isDark() ? '#1e293b' : '#ffffff',
      color: isDark() ? '#f8fafc' : '#0f172a',
      preConfirm: () => {
        const alasan = document.getElementById('swal_alasan_tolak').value;
        if (!alasan || !alasan.trim()) {
          Swal.showValidationMessage('Alasan penolakan wajib diisi!');
          return false;
        }
        return alasan.trim();
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo base_url("admin/data_cuti/reject/"); ?>' + id;
        
        const inputPesan = document.createElement('input');
        inputPesan.type = 'hidden';
        inputPesan.name = 'pesan_admin';
        inputPesan.value = result.value;
        form.appendChild(inputPesan);

        const inputCsrf = document.createElement('input');
        inputCsrf.type = 'hidden';
        inputCsrf.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        inputCsrf.value = '<?php echo $this->security->get_csrf_hash(); ?>';
        form.appendChild(inputCsrf);

        document.body.appendChild(form);
        form.submit();
      }
    });
  });

});
</script>
