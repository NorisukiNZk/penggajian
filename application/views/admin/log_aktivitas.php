<div class="container-fluid">
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
      <p class="text-muted small mb-0">Jejak audit persetujuan, autentikasi, dan perubahan parameter penggajian klinik.</p>
    </div>
    <span class="badge badge-light border px-3 py-2 text-primary font-weight-bold mt-2 mt-md-0">
      <i class="fas fa-shield-halved mr-1"></i> Menampilkan maks. 200 log terbaru
    </span>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body py-3">
      <form method="GET" action="<?php echo base_url('admin/log_aktivitas'); ?>" class="form-row align-items-end">
        <div class="col-md-4 mb-2 mb-md-0">
          <label for="filterModul" class="small font-weight-bold text-muted">Filter Modul</label>
          <select id="filterModul" name="modul" class="form-control form-control-sm">
            <option value="">Semua Modul</option>
            <?php foreach ($modules as $m) : ?>
              <option value="<?php echo htmlspecialchars($m->modul, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($modul === $m->modul) ? 'selected' : ''; ?>>
                <?php echo ucfirst(htmlspecialchars($m->modul, ENT_QUOTES, 'UTF-8')); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-5 mb-2 mb-md-0">
          <label for="filterQuery" class="small font-weight-bold text-muted">Kata Kunci (Aktor / Ringkasan / IP)</label>
          <input type="text" id="filterQuery" name="q" class="form-control form-control-sm" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Cari nama staf, aksi, atau IP...">
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-filter mr-1"></i> Saring</button>
          <?php if ($modul !== '' || $search !== '') : ?>
            <a href="<?php echo base_url('admin/log_aktivitas'); ?>" class="btn btn-light border btn-sm">Reset</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <?php if (empty($logs)) : ?>
        <div class="text-center py-5 text-muted">
          <div class="font-weight-bold mb-1">Belum ada catatan aktivitas yang cocok</div>
          <p class="small mb-0">Setiap login, persetujuan cuti/pinjaman, dan perubahan master data akan terekam di sini secara otomatis.</p>
        </div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Waktu</th>
                <th>Aktor</th>
                <th>Modul</th>
                <th>Aksi</th>
                <th>Ringkasan Perubahan</th>
                <th>IP</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log) : ?>
                <tr>
                  <td class="text-nowrap small tabular-nums"><?php echo date('d M Y H:i:s', strtotime($log->created_at)); ?></td>
                  <td>
                    <div class="font-weight-bold small"><?php echo htmlspecialchars($log->aktor_nama, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="text-muted" style="font-size: 0.72rem;">Peran: <?php echo htmlspecialchars($log->hak_akses, ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td><span class="badge badge-light border"><?php echo htmlspecialchars($log->modul, ENT_QUOTES, 'UTF-8'); ?></span></td>
                  <td class="small font-weight-bold"><?php echo htmlspecialchars($log->aksi, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="small"><?php echo htmlspecialchars($log->ringkasan, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td class="small text-muted tabular-nums"><?php echo htmlspecialchars($log->ip_address, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
