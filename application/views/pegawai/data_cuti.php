<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Kelola permohonan cuti, delegasi rekan pengganti shift, serta pantau status pengesahan Pimpinan.</p>
  </div>
  <a href="<?php echo base_url('pegawai/cuti/tambah'); ?>" class="btn btn-primary btn-sm">
    <i class="fas fa-plus"></i> Ajukan Cuti Baru
  </a>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- Saldo Cuti + Ringkasan Status -->
<div class="row mb-4">
  <div class="col-lg-5 mb-3 mb-lg-0">
    <div class="emp-attendance-hero h-100 d-flex flex-column justify-content-between">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="emp-hero-label">Saldo Cuti (<?php echo htmlspecialchars(isset($mode_kuota) ? $mode_kuota : 'Kombinasi', ENT_QUOTES, 'UTF-8'); ?>)</span>
        <span class="small" style="color: #CCFBF1;"><?php echo htmlspecialchars(isset($label_periode) ? $label_periode : '12 Hari/Th', ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
      <div class="row text-center my-2">
        <div class="col-6 pr-2">
          <div class="emp-time-slot">
            <div class="h3 font-weight-bold text-white mb-0 tabular-nums"><?php echo isset($sisa_cuti) ? (int)$sisa_cuti : 12; ?> <span class="small font-weight-normal">hari</span></div>
            <div class="small" style="color: #CCFBF1;">Sisa Kuota</div>
          </div>
        </div>
        <div class="col-6 pl-2">
          <div class="emp-time-slot">
            <div class="h3 font-weight-bold mb-0 tabular-nums" style="color: #FDE68A;"><?php echo isset($cuti_terpakai) ? (int)$cuti_terpakai : 0; ?> <span class="small font-weight-normal">hari</span></div>
            <div class="small" style="color: #CCFBF1;">Terpakai</div>
          </div>
        </div>
      </div>
      <?php if (isset($saldo_cuti) && $saldo_cuti['mode'] == 'Kombinasi') : ?>
        <div class="small mt-2" style="color: #CCFBF1;">
          Batas bulanan: maks. <?php echo (int)$saldo_cuti['kuota_bulanan']; ?> hari/bln (terpakai bulan ini: <?php echo (int)$saldo_cuti['cuti_terpakai_bulan']; ?> hari).
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="emp-metric-strip-3 h-100">
      <div class="emp-metric-tile d-flex flex-column justify-content-center">
        <div class="emp-metric-label">Total Diajukan</div>
        <div class="emp-metric-value"><?php echo isset($kpi_total) ? (int)$kpi_total : count($cuti); ?></div>
        <div class="emp-metric-note">Seluruh riwayat</div>
      </div>
      <div class="emp-metric-tile d-flex flex-column justify-content-center">
        <div class="emp-metric-label">Dalam Proses</div>
        <div class="emp-metric-value"><?php echo isset($kpi_menunggu) ? (int)$kpi_menunggu : 0; ?></div>
        <div class="emp-metric-note">Menunggu keputusan</div>
      </div>
      <div class="emp-metric-tile d-flex flex-column justify-content-center">
        <div class="emp-metric-label">Disetujui Sah</div>
        <div class="emp-metric-value text-primary"><?php echo isset($kpi_disetujui) ? (int)$kpi_disetujui : 0; ?></div>
        <div class="emp-metric-note">SK siap dicetak</div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Riwayat Cuti -->
<div class="emp-card">
  <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <h2 class="h6 font-weight-bold m-0">Daftar Riwayat Cuti & Pendelegasian Tugas</h2>
    <span class="small text-muted">SOP Akuntabilitas Shift Klinik</span>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="dataTable" width="100%">
        <thead>
          <tr>
            <th class="text-center" style="width: 44px;">No</th>
            <th>Periode & Kategori</th>
            <th>Rekan Pengganti</th>
            <th>Alasan & Berkas</th>
            <th>Status Approval</th>
            <th>Catatan HRD / Pimpinan</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($cuti)) : ?>
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                Belum ada riwayat permohonan cuti atau izin. Tekan tombol Ajukan Cuti Baru di kanan atas untuk membuat permohonan.
              </td>
            </tr>
          <?php else : ?>
            <?php $no = 1; foreach ($cuti as $c) :
              $dt_start   = new DateTime($c->tanggal_mulai);
              $dt_end     = new DateTime($c->tanggal_akhir);
              $durasi     = $dt_start->diff($dt_end)->days + 1;
              $app_status = !empty($c->status_approval) ? $c->status_approval : ($c->status_cuti == 'Disetujui' ? 'Disetujui Direktur' : ($c->status_cuti == 'Ditolak' ? 'Ditolak' : 'Menunggu Review HRD'));
            ?>
              <tr>
                <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                <td>
                  <div class="font-weight-bold tabular-nums">
                    <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?> s/d <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                  </div>
                  <div class="small text-muted mt-1">
                    <?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo $durasi; ?> hari
                  </div>
                  <div class="small text-muted tabular-nums" style="font-size: 0.76rem;">
                    Diajukan: <?php echo date('d/m/Y H:i', strtotime($c->created_at)); ?>
                  </div>
                </td>
                <td>
                  <?php if (!empty($c->nama_pengganti)) : ?>
                    <div class="font-weight-bold small"><?php echo htmlspecialchars($c->nama_pengganti, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted"><?php echo htmlspecialchars((string)$c->jabatan_pengganti, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php if (!empty($c->tugas_pengganti)) : ?>
                      <div class="small text-muted mt-1"><?php echo htmlspecialchars(mb_strimwidth($c->tugas_pengganti, 0, 65, '...'), ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                  <?php else : ?>
                    <span class="small text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="small mb-1"><?php echo htmlspecialchars(mb_strimwidth($c->alasan, 0, 70, '...'), ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php if (!empty($c->file_lampiran)) : ?>
                    <a href="<?php echo base_url('uploads/cuti/' . $c->file_lampiran); ?>" target="_blank" class="small font-weight-bold text-primary">
                      <i class="fas fa-paperclip"></i> Lihat Bukti
                    </a>
                  <?php else : ?>
                    <span class="small text-muted">Tanpa berkas</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($c->status_cuti == 'Disetujui') : ?>
                    <span class="emp-status emp-status-ok">Disetujui Sah</span>
                  <?php elseif ($c->status_cuti == 'Ditolak') : ?>
                    <span class="emp-status emp-status-danger">Ditolak</span>
                  <?php elseif ($app_status == 'Diteruskan ke Direktur') : ?>
                    <span class="emp-status emp-status-info">Ke Pimpinan</span>
                  <?php else : ?>
                    <span class="emp-status emp-status-warn">Menunggu Review</span>
                  <?php endif; ?>
                </td>
                <td class="small">
                  <?php if (!empty($c->catatan_hrd) || !empty($c->pesan_admin)) : ?>
                    <?php if (!empty($c->catatan_hrd)) : ?>
                      <div class="mb-1"><strong>HRD:</strong> <?php echo htmlspecialchars($c->catatan_hrd, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($c->pesan_admin)) : ?>
                      <div><strong>Keputusan:</strong> <?php echo htmlspecialchars($c->pesan_admin, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                  <?php else : ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($c->status_cuti == 'Menunggu') : ?>
                    <form method="POST" action="<?php echo base_url('pegawai/cuti/batal/' . $c->id_cuti); ?>" class="d-inline">
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                      <button type="submit"
                         class="btn btn-sm btn-outline-danger btn-batal-cuti"
                         data-info="<?php echo date('d/m/Y', strtotime($c->tanggal_mulai)) . ' s/d ' . date('d/m/Y', strtotime($c->tanggal_akhir)); ?>">
                        <i class="fas fa-trash-alt"></i> Batal
                      </button>
                    </form>
                  <?php elseif ($c->status_cuti == 'Disetujui') : ?>
                    <div class="d-inline-flex flex-wrap gap-1 justify-content-center">
                      <a href="<?php echo base_url('pegawai/cuti/cetak_surat/' . $c->id_cuti); ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-print"></i> Cetak SK
                      </a>
                      <a href="<?php echo base_url('pegawai/cuti/download_pdf/' . $c->id_cuti); ?>" class="btn btn-sm btn-light border">
                        <i class="fas fa-file-pdf"></i> PDF
                      </a>
                    </div>
                  <?php else : ?>
                    <span class="small text-muted">Selesai</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.btn-batal-cuti').forEach(function(button) {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      var form      = this.closest('form');
      var infoTgl   = this.getAttribute('data-info');
      var isDark    = document.documentElement.classList.contains('dark-mode');

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Batalkan Permohonan Cuti?',
          text: 'Permohonan cuti periode ' + infoTgl + ' akan dibatalkan dari antrean.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#991B1B',
          cancelButtonColor: '#495E54',
          confirmButtonText: 'Ya, Batalkan',
          cancelButtonText: 'Kembali',
          reverseButtons: true,
          background: isDark ? '#13201B' : '#FFFFFF',
          color: isDark ? '#ECF3EF' : '#11211A'
        }).then(function(result) {
          if (result.isConfirmed && form) {
            form.submit();
          }
        });
      } else if (confirm('Batalkan permohonan cuti periode ' + infoTgl + '?') && form) {
        form.submit();
      }
    });
  });
});
</script>
