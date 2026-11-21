<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Pantau fasilitas kasbon, cicilan bulanan, dan cetak Surat Perjanjian Pinjaman Karyawan (SPPK).</p>
  </div>
  <a href="<?php echo base_url('pegawai/pinjaman/tambah'); ?>" class="btn btn-primary btn-sm">
    <i class="fas fa-plus"></i> Ajukan Pinjaman Baru
  </a>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<section class="emp-metric-strip mb-4" aria-label="Ringkasan pinjaman pegawai">
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Total Riwayat</div>
    <div class="emp-metric-value"><?php echo isset($kpi_total) ? (int)$kpi_total : count($pinjaman); ?></div>
    <div class="emp-metric-note">Seluruh pengajuan</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Menunggu Review</div>
    <div class="emp-metric-value"><?php echo isset($kpi_pending) ? (int)$kpi_pending : 0; ?></div>
    <div class="emp-metric-note">Dalam antrean evaluasi</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Pinjaman Aktif</div>
    <div class="emp-metric-value text-primary"><?php echo isset($kpi_aktif) ? (int)$kpi_aktif : 0; ?></div>
    <div class="emp-metric-note">Dipotong melalui payroll</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Pinjaman Lunas</div>
    <div class="emp-metric-value"><?php echo isset($kpi_lunas) ? (int)$kpi_lunas : 0; ?></div>
    <div class="emp-metric-note">Kewajiban selesai</div>
  </div>
</section>

<div class="emp-card">
  <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <h2 class="h6 font-weight-bold m-0">Daftar Pengajuan Pinjaman & Kasbon</h2>
    <span class="small text-muted">Sistem Pemotongan Payroll</span>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="dataTable" width="100%">
        <thead>
          <tr>
            <th class="text-center" style="width: 44px;">No</th>
            <th>Tanggal & Kode</th>
            <th>Nominal & Tenor</th>
            <th>Cicilan / Bulan</th>
            <th>Keperluan & Penjamin</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($pinjaman)) : ?>
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                Belum ada riwayat pengajuan pinjaman kasbon.
              </td>
            </tr>
          <?php else : ?>
            <?php $no = 1; foreach ($pinjaman as $p) :
              $cicilan = ceil($p->jumlah_pinjaman / max(1, (int)$p->tenor_bulan));
            ?>
              <tr>
                <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                <td class="tabular-nums">
                  <div class="font-weight-bold"><?php echo date('d M Y', strtotime($p->tgl_pengajuan)); ?></div>
                  <div class="small text-muted">#PINJ-<?php echo sprintf('%04d', $p->id_pinjaman); ?></div>
                </td>
                <td class="tabular-nums">
                  <div class="font-weight-bold text-primary">Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?></div>
                  <div class="small text-muted">Tenor <?php echo (int)$p->tenor_bulan; ?> bulan</div>
                </td>
                <td class="tabular-nums">
                  <div class="font-weight-bold">Rp <?php echo number_format($cicilan, 0, ',', '.'); ?>/bln</div>
                  <?php if ($p->status == 'Disetujui') : ?>
                    <div class="small text-muted">Sisa tenor: <?php echo isset($p->sisa_tenor) ? (int)$p->sisa_tenor : (int)$p->tenor_bulan; ?> bln</div>
                  <?php elseif ($p->status == 'Lunas') : ?>
                    <div class="small text-primary font-weight-bold">Lunas penuh</div>
                  <?php else : ?>
                    <div class="small text-muted">Belum berjalan</div>
                  <?php endif; ?>
                </td>
                <td class="small">
                  <div class="mb-1"><?php echo htmlspecialchars($p->alasan, ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php if (!empty($p->kontak_darurat_nama)) : ?>
                    <div class="text-muted">Penjamin: <?php echo htmlspecialchars($p->kontak_darurat_nama . ' (' . $p->kontak_darurat_hubungan . ')', ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($p->status == 'Disetujui') : ?>
                    <span class="emp-status emp-status-ok">Aktif / Disetujui</span>
                  <?php elseif ($p->status == 'Lunas') : ?>
                    <span class="emp-status emp-status-info">Lunas</span>
                  <?php elseif ($p->status == 'Ditolak') : ?>
                    <span class="emp-status emp-status-danger">Ditolak</span>
                  <?php else : ?>
                    <span class="emp-status emp-status-warn">Pending Review</span>
                  <?php endif; ?>
                  <?php if (!empty($p->pesan_admin)) : ?>
                    <div class="small text-muted mt-1"><?php echo htmlspecialchars($p->pesan_admin, ENT_QUOTES, 'UTF-8'); ?></div>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($p->status == 'Pending') : ?>
                    <form method="POST" action="<?php echo base_url('pegawai/pinjaman/batal/' . $p->id_pinjaman); ?>" class="d-inline">
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                      <button type="submit"
                         class="btn btn-sm btn-outline-danger btn-batal-pinjaman"
                         data-nominal="Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?>">
                        <i class="fas fa-trash-alt"></i> Batalkan
                      </button>
                    </form>
                  <?php elseif ($p->status == 'Disetujui' || $p->status == 'Lunas') : ?>
                    <div class="d-inline-flex flex-wrap gap-1 justify-content-center">
                      <a href="<?php echo base_url('pegawai/pinjaman/cetak_sppk/' . $p->id_pinjaman); ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-print"></i> Cetak SPPK
                      </a>
                      <a href="<?php echo base_url('pegawai/pinjaman/download_pdf/' . $p->id_pinjaman); ?>" class="btn btn-sm btn-light border">
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
  $(document).on('click', '.btn-batal-pinjaman', function(e) {
    e.preventDefault();
    var form    = $(this).closest('form');
    var nominal = $(this).data('nominal') || 'pinjaman ini';
    var isDark  = document.documentElement.classList.contains('dark-mode');

    Swal.fire({
      title: 'Batalkan Pengajuan Pinjaman?',
      text: 'Pengajuan pinjaman sebesar ' + nominal + ' akan ditarik dari antrean verifikasi.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Batalkan',
      cancelButtonText: 'Kembali',
      confirmButtonColor: '#991B1B',
      cancelButtonColor: '#495E54',
      reverseButtons: true,
      background: isDark ? '#13201B' : '#FFFFFF',
      color: isDark ? '#ECF3EF' : '#11211A'
    }).then(function(result) {
      if (result.isConfirmed && form.length) {
        form[0].submit();
      }
    });
  });
});
</script>
