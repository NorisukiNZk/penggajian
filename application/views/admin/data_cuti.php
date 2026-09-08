<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-3">
    <div>
      <h1 class="h3 mb-1 text-gray-800 font-weight-bold"><?php echo $title; ?></h1>
      <p class="text-muted small mb-0">Verifikasi berkas, telaah pengganti shift, dan siapkan rekomendasi pengesahan Direktur Utama.</p>
    </div>
    <div class="mt-3 mt-sm-0">
      <a href="<?php echo base_url('admin/data_cuti/setting'); ?>" class="btn btn-sm btn-primary shadow-sm font-weight-bold">
        <i class="fas fa-sliders-h fa-sm text-white-50 mr-1"></i> Pengaturan Kuota Cuti
      </a>
    </div>
  </div>

  <?php if(isset($setting_cuti)): ?>
  <div class="alert alert-light border shadow-xs d-flex align-items-center justify-content-between p-3 mb-4" style="border-radius: 12px; background: #ffffff;">
    <div class="d-flex align-items-center">
      <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center mr-3" style="width: 38px; height: 38px; background: rgba(12, 43, 77, 0.1);">
        <i class="fas fa-shield-halved text-primary"></i>
      </div>
      <div>
        <span class="small text-muted font-weight-bold d-block">Kebijakan Kuota Cuti Aktif:</span>
        <span class="font-weight-bold text-dark">
          Mode <strong><?php echo $setting_cuti->mode_kuota_cuti; ?></strong> &bull; 
          Tahunan: <span class="badge badge-primary"><?php echo $setting_cuti->kuota_cuti_tahunan; ?> hari/thn</span> 
          <?php if($setting_cuti->mode_kuota_cuti != 'Tahunan'): ?>
            &bull; Batas Bulanan: <span class="badge badge-info">Maks. <?php echo $setting_cuti->kuota_cuti_bulanan; ?> hari/bln</span>
          <?php endif; ?>
        </span>
      </div>
    </div>
    <a href="<?php echo base_url('admin/data_cuti/setting'); ?>" class="btn btn-sm btn-outline-primary font-weight-bold px-3" style="border-radius: 8px;">
      Ubah Kebijakan
    </a>
  </div>
  <?php endif; ?>

  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Executive KPI Summary Cards -->
  <div class="row mb-4">
    
    <!-- Menunggu Review -->
    <div class="col-xl-3 col-md-6 mb-3">
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
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui Sah</div>
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
    <div class="col-xl-3 col-md-6 mb-3">
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
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengajuan Cuti</div>
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
        <i class="fas fa-list-check mr-2"></i>Daftar Pengajuan Cuti, Delegasi Tugas & Berkas SKD
      </h6>
      <span class="badge badge-light border text-muted small px-3 py-1">
        SOP Verifikasi 2 Tingkat (HRD & Direktur Utama)
      </span>
    </div>
    
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white">
            <tr>
              <th class="text-center align-middle" style="width: 3%;">No</th>
              <th class="align-middle" style="width: 18%;">Pegawai Pemohon</th>
              <th class="text-center align-middle" style="width: 14%;">Periode & Durasi</th>
              <th class="align-middle" style="width: 18%;">Rekan Pengganti Shift</th>
              <th class="align-middle" style="width: 18%;">Alasan & Bukti Berkas</th>
              <th class="text-center align-middle" style="width: 14%;">Status Approval</th>
              <th class="text-center align-middle" style="width: 15%;">Aksi HRD</th>
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
              if (stripos($c->jenis_cuti, 'Sakit') !== false) $badge_jenis = 'badge-warning';
              elseif (stripos($c->jenis_cuti, 'Melahirkan') !== false) $badge_jenis = 'badge-info';
              elseif (stripos($c->jenis_cuti, 'Penting') !== false) $badge_jenis = 'badge-secondary';

              // Status Approval
              $app_status = !empty($c->status_approval) ? $c->status_approval : ($c->status_cuti == 'Disetujui' ? 'Disetujui Direktur' : ($c->status_cuti == 'Ditolak' ? 'Ditolak' : 'Menunggu Review HRD'));
            ?>
            <tr>
              <!-- No -->
              <td class="text-center align-middle"><?php echo $no++; ?></td>
              
              <!-- Pegawai Pemohon -->
              <td class="align-middle">
                <div class="d-flex align-items-center">
                  <div class="mr-3">
                    <?php if (!empty($c->photo) && file_exists(FCPATH . 'photo/' . $c->photo)) : ?>
                      <img src="<?php echo base_url('photo/' . $c->photo); ?>" alt="Photo" style="width: 42px; height: 42px; object-fit: cover; border-radius: 50%;" class="border">
                    <?php else : ?>
                      <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center border" style="width: 42px; height: 42px; font-weight: bold;">
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
                <div class="font-weight-bold text-gray-800" style="font-size: 0.88rem;">
                  <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?>
                </div>
                <div class="text-muted small">s/d</div>
                <div class="font-weight-bold text-gray-800" style="font-size: 0.88rem;">
                  <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                </div>
                <div class="mt-1">
                  <span class="badge badge-pill badge-info px-2 py-1 font-weight-bold">
                    <i class="fas fa-calendar-day mr-1"></i><?php echo $durasi; ?> Hari
                  </span>
                  <span class="badge <?php echo $badge_jenis; ?> font-weight-bold px-2 py-1 ml-1">
                    <?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?>
                  </span>
                </div>
              </td>

              <!-- Rekan Pengganti Shift -->
              <td class="align-middle">
                <?php if (!empty($c->nama_pengganti)) : ?>
                  <div class="font-weight-bold text-dark small">
                    <i class="fas fa-user-check text-success mr-1"></i><?php echo htmlspecialchars($c->nama_pengganti, ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                  <span class="badge badge-light border text-muted small mb-1" style="font-size: 0.75rem;">
                    <?php echo htmlspecialchars($c->jabatan_pengganti, ENT_QUOTES, 'UTF-8'); ?>
                  </span>
                  <?php if (!empty($c->tugas_pengganti)) : ?>
                    <div class="small text-muted font-italic border-left pl-2 mt-1" style="font-size: 0.75rem; line-height: 1.3;">
                      "<?php echo htmlspecialchars(mb_strimwidth($c->tugas_pengganti, 0, 80, "..."), ENT_QUOTES, 'UTF-8'); ?>"
                    </div>
                  <?php endif; ?>
                <?php else : ?>
                  <span class="badge badge-light border text-muted small">Tanpa Delegasi</span>
                <?php endif; ?>
              </td>

              <!-- Alasan & Berkas SKD -->
              <td class="align-middle">
                <div class="text-gray-800 small mb-2" style="line-height: 1.4;">
                  <?php echo htmlspecialchars(mb_strimwidth($c->alasan, 0, 75, "..."), ENT_QUOTES, 'UTF-8'); ?>
                </div>

                <div class="d-flex flex-wrap gap-1 align-items-center">
                  <?php if (!empty($c->file_lampiran)) : ?>
                    <?php $ext = pathinfo($c->file_lampiran, PATHINFO_EXTENSION); ?>
                    <button type="button" 
                            class="btn btn-sm btn-outline-success font-weight-bold py-1 px-2 btn-preview-file shadow-sm"
                            data-file="<?php echo base_url('uploads/cuti/' . $c->file_lampiran); ?>"
                            data-ext="<?php echo strtolower($ext); ?>"
                            data-nama="<?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                            title="Lihat Berkas Lampiran / Surat Dokter">
                      <i class="fas fa-paperclip mr-1"></i> Lihat SKD/Berkas
                    </button>
                  <?php else : ?>
                    <span class="badge badge-light border text-muted small">Tanpa Lampiran</span>
                  <?php endif; ?>

                  <?php if (!empty($c->kontak_darurat)) : ?>
                    <div class="small text-muted mt-1 w-100">
                      <i class="fas fa-phone-alt text-warning mr-1"></i><?php echo htmlspecialchars($c->kontak_darurat, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                  <?php endif; ?>
                </div>
              </td>

              <!-- Status Approval -->
              <td class="text-center align-middle">
                <?php if($app_status == 'Menunggu Review HRD' || $c->status_cuti == 'Menunggu') : ?>
                  <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold d-block mb-1 shadow-sm" style="font-size: 0.8rem;">
                    <i class="fas fa-hourglass-half mr-1"></i>Menunggu Review HRD
                  </span>
                  <small class="text-muted">Perlu Telaah Berkas</small>
                <?php elseif($app_status == 'Diteruskan ke Direktur') : ?>
                  <span class="badge badge-info px-2 py-1 font-weight-bold d-block mb-1 shadow-sm" style="font-size: 0.8rem;">
                    <i class="fas fa-arrow-up-right-from-square mr-1"></i>Ke Direktur Utama
                  </span>
                  <small class="text-info font-weight-bold">Rekomendasi HRD Terkirim</small>
                <?php elseif($c->status_cuti == 'Disetujui') : ?>
                  <span class="badge badge-success px-2 py-1 font-weight-bold d-block mb-1 shadow-sm" style="font-size: 0.8rem;">
                    <i class="fas fa-check-circle mr-1"></i>Disetujui Sah
                  </span>
                  <small class="text-success font-weight-bold">Sinkron Absensi</small>
                <?php else : ?>
                  <span class="badge badge-danger px-2 py-1 font-weight-bold d-block mb-1 shadow-sm" style="font-size: 0.8rem;">
                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                  </span>
                <?php endif; ?>
              </td>

              <!-- Aksi HRD & Direktur -->
              <td class="text-center align-middle">
                <?php if($c->status_cuti == 'Menunggu') : ?>
                  <!-- Tombol Verifikasi Terpadu (Two-Tier Approval Modal) -->
                  <button type="button" 
                          class="btn btn-sm btn-primary btn-verifikasi-cuti btn-block font-weight-bold mb-1 shadow-sm"
                          data-id="<?php echo $c->id_cuti; ?>"
                          data-nama="<?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                          data-jenis="<?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?>"
                          data-durasi="<?php echo $durasi; ?> Hari (<?php echo date('d/m/Y', strtotime($c->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($c->tanggal_akhir)); ?>)"
                          data-pengganti="<?php echo !empty($c->nama_pengganti) ? htmlspecialchars($c->nama_pengganti . ' (' . $c->jabatan_pengganti . ')', ENT_QUOTES, 'UTF-8') : 'Tidak Ada'; ?>"
                          data-tugas="<?php echo !empty($c->tugas_pengganti) ? htmlspecialchars($c->tugas_pengganti, ENT_QUOTES, 'UTF-8') : '-'; ?>"
                          data-lampiran="<?php echo !empty($c->file_lampiran) ? base_url('uploads/cuti/' . $c->file_lampiran) : ''; ?>"
                          data-catatanhrd="<?php echo htmlspecialchars($c->catatan_hrd, ENT_QUOTES, 'UTF-8'); ?>"
                          data-appstatus="<?php echo $app_status; ?>">
                    <i class="fas fa-file-signature mr-1"></i> Review & Proses
                  </button>
                  <button type="button" 
                          class="btn btn-sm btn-outline-danger btn-reject-cuti btn-block font-weight-bold shadow-sm"
                          data-id="<?php echo $c->id_cuti; ?>"
                          data-nama="<?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>">
                    <i class="fas fa-times mr-1"></i> Tolak
                  </button>
                <?php else : ?>
                  <span class="badge badge-light border text-muted px-2 py-1 small d-block mb-1">
                    <i class="fas fa-lock mr-1"></i>Selesai Diproses
                  </span>
                  <div class="d-flex gap-1 justify-content-center">
                    <?php if($c->status_cuti == 'Disetujui') : ?>
                      <a href="<?php echo base_url('admin/data_cuti/cetak_surat/' . $c->id_cuti); ?>" 
                         target="_blank"
                         class="btn btn-sm btn-outline-primary py-1 px-2 shadow-sm mr-1 font-weight-bold"
                         title="Cetak Surat Keputusan Cuti Resmi">
                        <i class="fas fa-print mr-1"></i> Cetak SK
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

<!-- Modal Preview Berkas SKD -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title font-weight-bold">
          <i class="fas fa-file-medical mr-2"></i>Berkas Bukti / Surat Keterangan Dokter (SKD)
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center p-3" id="modalPreviewBody">
        <!-- Content injected dynamically -->
      </div>
      <div class="modal-footer bg-light py-2">
        <a id="btnDownloadBerkas" href="#" target="_blank" class="btn btn-primary btn-sm font-weight-bold">
          <i class="fas fa-download mr-1"></i> Buka File Asli
        </a>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Script SweetAlert2 & Preview for Admin Data Cuti -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const isDark = () => document.body.classList.contains('dark-mode');

  // Preview File Lampiran Modal
  $(document).on('click', '.btn-preview-file', function(e) {
    e.preventDefault();
    const fileUrl  = $(this).data('file');
    const ext      = $(this).data('ext');
    const nama     = $(this).data('nama');
    const modalBody = document.getElementById('modalPreviewBody');
    const btnDownload = document.getElementById('btnDownloadBerkas');

    btnDownload.href = fileUrl;

    if (ext === 'pdf') {
      modalBody.innerHTML = `
        <p class="text-muted small mb-2">Dokumen PDF untuk: <strong>${nama}</strong></p>
        <iframe src="${fileUrl}" style="width: 100%; height: 500px; border: 0; border-radius: 8px;"></iframe>
      `;
    } else {
      modalBody.innerHTML = `
        <p class="text-muted small mb-2">Foto / Scan Bukti untuk: <strong>${nama}</strong></p>
        <img src="${fileUrl}" class="img-fluid rounded border shadow-sm" style="max-height: 520px;" alt="Berkas Lampiran">
      `;
    }

    $('#modalPreviewBerkas').modal('show');
  });

  let activeReviewId = null;

  // Review & Verifikasi Modal Trigger
  $(document).on('click', '.btn-verifikasi-cuti', function(e) {
    e.preventDefault();
    activeReviewId = $(this).data('id');
    const nama       = $(this).data('nama');
    const jenis      = $(this).data('jenis');
    const durasi     = $(this).data('durasi');
    const pengganti  = $(this).data('pengganti');
    const tugas      = $(this).data('tugas');
    const lampiran   = $(this).data('lampiran');
    const catatanHrd = $(this).data('catatanhrd') || '';

    $('#review_nama').text(nama);
    $('#review_jenis').text(jenis);
    $('#review_durasi').text(durasi);
    $('#review_pengganti').text(pengganti);
    $('#review_tugas').text(tugas);
    $('#review_catatan_hrd').val(catatanHrd);

    if (lampiran) {
      $('#review_lampiran').html('<a href="' + lampiran + '" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold py-1 px-2"><i class="fas fa-paperclip mr-1"></i> Klik untuk Melihat Berkas SKD</a>');
    } else {
      $('#review_lampiran').html('<span class="text-muted small">Tidak ada berkas yang dilampirkan</span>');
    }

    $('#modalReviewCuti').modal('show');
  });

  // Action: Teruskan ke Direktur Utama
  $('#btnActionTeruskan').on('click', function() {
    if (!activeReviewId) return;
    const form = document.getElementById('formReviewCuti');
    form.action = '<?php echo base_url("admin/data_cuti/teruskan_direktur/"); ?>' + activeReviewId;
    form.submit();
  });

  // Action: Sahkan & Setujui Langsung
  $('#btnActionApprove').on('click', function() {
    if (!activeReviewId) return;
    const form = document.getElementById('formReviewCuti');
    form.action = '<?php echo base_url("admin/data_cuti/approve/"); ?>' + activeReviewId;
    form.submit();
  });

  // Reject Modal Trigger
  $(document).on('click', '.btn-reject-cuti', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const nama = $(this).data('nama');

    $('#reject_nama').text(nama);
    $('#reject_pesan').val('');
    document.getElementById('formRejectCuti').action = '<?php echo base_url("admin/data_cuti/reject/"); ?>' + id;
    $('#modalRejectCuti').modal('show');
  });
});
</script>
