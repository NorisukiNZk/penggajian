<section class="exec-brief-head">
  <div>
    <h1 class="exec-brief-title">Meja Persetujuan Pimpinan</h1>
    <p class="exec-brief-sub">
      Tinjau dan berikan pengesahan akhir terhadap pengajuan cuti pegawai, jam lembur, serta fasilitas pinjaman kasbon.
    </p>
  </div>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- Domain Switch Tabs -->
<div class="exec-tabs" role="tablist" aria-label="Kategori persetujuan">
  <a href="<?php echo base_url('pimpinan/persetujuan?tab=cuti'); ?>" class="exec-tab-btn <?php echo ($active_tab === 'cuti') ? 'active' : ''; ?>" role="tab" aria-selected="<?php echo ($active_tab === 'cuti') ? 'true' : 'false'; ?>">
    <i class="fas fa-calendar-minus"></i> Cuti & Izin
    <span class="exec-pending-pill"><?php echo $pending_cuti; ?></span>
  </a>
  <a href="<?php echo base_url('pimpinan/persetujuan?tab=lembur'); ?>" class="exec-tab-btn <?php echo ($active_tab === 'lembur') ? 'active' : ''; ?>" role="tab" aria-selected="<?php echo ($active_tab === 'lembur') ? 'true' : 'false'; ?>">
    <i class="fas fa-business-time"></i> Lembur
    <span class="exec-pending-pill"><?php echo $pending_lembur; ?></span>
  </a>
  <a href="<?php echo base_url('pimpinan/persetujuan?tab=pinjaman'); ?>" class="exec-tab-btn <?php echo ($active_tab === 'pinjaman') ? 'active' : ''; ?>" role="tab" aria-selected="<?php echo ($active_tab === 'pinjaman') ? 'true' : 'false'; ?>">
    <i class="fas fa-hand-holding-dollar"></i> Pinjaman (Kasbon)
    <span class="exec-pending-pill"><?php echo $pending_pinjaman; ?></span>
  </a>
</div>

<?php if ($active_tab === 'cuti') : ?>
  <!-- TAB 1: PERSETUJUAN CUTI -->
  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Daftar Pengajuan Cuti & Pendelegasian Shift</h2>
      <span class="small text-muted">Pengajuan yang diteruskan HRD dan menunggu ditampilkan paling atas</span>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pemohon</th>
              <th>Periode & Kategori</th>
              <th>Pengganti Shift</th>
              <th>Alasan & Telaah HRD</th>
              <th>Status</th>
              <th class="text-center">Keputusan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($cuti)) : ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada pengajuan cuti yang masuk.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($cuti as $c) :
                $durasi = (new DateTime($c->tanggal_mulai))->diff(new DateTime($c->tanggal_akhir))->days + 1;
                $is_pending = in_array($c->status_cuti, array('Menunggu', 'Pending'));
              ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted"><?php echo htmlspecialchars($c->jabatan, ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo htmlspecialchars($c->nik, ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td>
                    <div class="font-weight-bold tabular-nums">
                      <?php echo date('d M Y', strtotime($c->tanggal_mulai)); ?> s/d <?php echo date('d M Y', strtotime($c->tanggal_akhir)); ?>
                    </div>
                    <div class="small text-muted"><?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo $durasi; ?> hari</div>
                  </td>
                  <td>
                    <?php if (!empty($c->nama_pengganti)) : ?>
                      <div class="font-weight-bold small"><?php echo htmlspecialchars($c->nama_pengganti, ENT_QUOTES, 'UTF-8'); ?></div>
                      <div class="small text-muted"><?php echo htmlspecialchars((string)$c->jabatan_pengganti, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php else : ?>
                      <span class="small text-muted">Tidak ditentukan</span>
                    <?php endif; ?>
                  </td>
                  <td style="max-width: 260px;">
                    <div class="small"><?php echo htmlspecialchars($c->alasan, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php if (!empty($c->catatan_hrd)) : ?>
                      <div class="small text-muted mt-1"><strong>Telaah HRD:</strong> <?php echo htmlspecialchars($c->catatan_hrd, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($c->file_lampiran)) : ?>
                      <a href="<?php echo base_url('uploads/cuti/' . $c->file_lampiran); ?>" target="_blank" class="small font-weight-bold d-inline-block mt-1" style="color: var(--exec-accent);">
                        <i class="fas fa-paperclip"></i> Lihat Lampiran
                      </a>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($c->status_cuti === 'Disetujui') : ?>
                      <span class="exec-tag exec-tag-ok">Disetujui</span>
                    <?php elseif ($c->status_cuti === 'Ditolak') : ?>
                      <span class="exec-tag exec-tag-danger">Ditolak</span>
                    <?php elseif (!empty($c->status_approval) && $c->status_approval === 'Diteruskan ke Direktur') : ?>
                      <span class="exec-tag exec-tag-info">Rekomendasi HRD</span>
                    <?php else : ?>
                      <span class="exec-tag exec-tag-pending">Menunggu</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($is_pending) : ?>
                      <div class="d-inline-flex flex-wrap justify-content-center" style="gap: 0.35rem;">
                        <button type="button" class="btn btn-sm btn-exec-primary" data-toggle="modal" data-target="#modalApproveCuti<?php echo $c->id_cuti; ?>">
                          <i class="fas fa-check"></i> Setujui
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modalRejectCuti<?php echo $c->id_cuti; ?>">
                          <i class="fas fa-times"></i> Tolak
                        </button>
                      </div>

                      <!-- Modal Setujui Cuti -->
                      <div class="modal fade text-left" id="modalApproveCuti<?php echo $c->id_cuti; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/approve_cuti/' . $c->id_cuti); ?>">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title exec-serif font-weight-bold">Sahkan Pengajuan Cuti</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                <p class="small text-muted">
                                  Setujui cuti <strong><?php echo htmlspecialchars($c->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></strong> atas nama <strong><?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong> (<?php echo $durasi; ?> hari). Tanggal cuti akan otomatis tercatat di absensi harian.
                                </p>
                                <div class="form-group mb-0">
                                  <label class="small font-weight-bold">Catatan Pengesahan Pimpinan (Opsional)</label>
                                  <textarea name="pesan_admin" class="form-control" rows="3" placeholder="Tuliskan arahan atau catatan pengesahan..."></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-exec-outline btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-exec-primary btn-sm">Sahkan & Setujui</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>

                      <!-- Modal Tolak Cuti -->
                      <div class="modal fade text-left" id="modalRejectCuti<?php echo $c->id_cuti; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/reject_cuti/' . $c->id_cuti); ?>">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title exec-serif font-weight-bold">Tolak Pengajuan Cuti</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                <p class="small text-muted">
                                  Berikan alasan penolakan untuk permohonan atas nama <strong><?php echo htmlspecialchars($c->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong>.
                                </p>
                                <div class="form-group mb-0">
                                  <label class="small font-weight-bold">Alasan Penolakan</label>
                                  <textarea name="pesan_admin" class="form-control" rows="3" required placeholder="Misal: Jadwal shift poli belum memiliki pengganti..."></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-exec-outline btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger btn-sm">Tolak Pengajuan</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    <?php elseif ($c->status_cuti === 'Disetujui') : ?>
                      <a href="<?php echo base_url('pimpinan/persetujuan/cetak_surat_cuti/' . $c->id_cuti); ?>" target="_blank" class="btn btn-sm btn-exec-outline">
                        <i class="fas fa-print"></i> Cetak SK
                      </a>
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

<?php elseif ($active_tab === 'lembur') : ?>
  <!-- TAB 2: PERSETUJUAN LEMBUR -->
  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Daftar Pengajuan Jam Lembur</h2>
      <span class="small text-muted">Jam lembur disetujui akan otomatis dihitung pada slip gaji bulan berjalan</span>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pegawai</th>
              <th>Tanggal & Rentang Jam</th>
              <th class="text-center">Durasi</th>
              <th>Uraian Pekerjaan</th>
              <th>Status</th>
              <th class="text-center">Keputusan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($lembur)) : ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengajuan lembur.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($lembur as $l) :
                $is_pending = in_array($l->status, array('Pending', 'Menunggu'));
              ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($l->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted"><?php echo htmlspecialchars($l->jabatan, ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td class="tabular-nums">
                    <div class="font-weight-bold"><?php echo date('d M Y', strtotime($l->tanggal_lembur)); ?></div>
                    <div class="small text-muted"><?php echo date('H:i', strtotime($l->jam_mulai)); ?> s/d <?php echo date('H:i', strtotime($l->jam_selesai)); ?></div>
                  </td>
                  <td class="text-center font-weight-bold tabular-nums"><?php echo (int)$l->durasi_jam; ?> jam</td>
                  <td><?php echo htmlspecialchars($l->keterangan, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>
                    <?php if ($l->status === 'Disetujui') : ?>
                      <span class="exec-tag exec-tag-ok">Disetujui</span>
                    <?php elseif ($l->status === 'Ditolak') : ?>
                      <span class="exec-tag exec-tag-danger">Ditolak</span>
                    <?php else : ?>
                      <span class="exec-tag exec-tag-pending">Pending</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($is_pending) : ?>
                      <div class="d-inline-flex" style="gap: 0.35rem;">
                        <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/aksi_lembur'); ?>">
                          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                          <input type="hidden" name="id_lembur" value="<?php echo $l->id_lembur; ?>">
                          <input type="hidden" name="status" value="Disetujui">
                          <button type="submit" class="btn btn-sm btn-exec-primary"><i class="fas fa-check"></i> Setujui</button>
                        </form>
                        <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/aksi_lembur'); ?>">
                          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                          <input type="hidden" name="id_lembur" value="<?php echo $l->id_lembur; ?>">
                          <input type="hidden" name="status" value="Ditolak">
                          <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Tolak</button>
                        </form>
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

<?php else : ?>
  <!-- TAB 3: PERSETUJUAN PINJAMAN / KASBON -->
  <div class="exec-panel">
    <div class="exec-panel-header">
      <h2 class="exec-panel-title">Daftar Pengajuan Pinjaman & Kasbon Pegawai</h2>
      <span class="small text-muted">Tinjau rasio angsuran terhadap penghasilan bulanan (DSR maks. 40%)</span>
    </div>
    <div class="exec-panel-body p-0">
      <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%">
          <thead>
            <tr>
              <th>Pemohon</th>
              <th>Nominal & Tenor</th>
              <th>Cicilan & DSR</th>
              <th>Keperluan & Berkas</th>
              <th>Status</th>
              <th class="text-center">Keputusan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($pinjaman)) : ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada pengajuan pinjaman tercatat.</td>
              </tr>
            <?php else : ?>
              <?php foreach ($pinjaman as $p) :
                $tenor      = max(1, (int)$p->tenor_bulan);
                $cicilan    = ceil($p->jumlah_pinjaman / $tenor);
                $total_gaji = (float)$p->gaji_pokok + (float)$p->tj_transport + (float)$p->uang_makan;
                $dsr        = $total_gaji > 0 ? round(($cicilan / $total_gaji) * 100, 1) : 0;
                $is_pending = in_array($p->status, array('Pending', 'Menunggu'));
              ?>
                <tr>
                  <td>
                    <div class="font-weight-bold"><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="small text-muted"><?php echo htmlspecialchars((string)$p->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo date('d M Y', strtotime($p->tgl_pengajuan)); ?></div>
                  </td>
                  <td class="tabular-nums">
                    <div class="font-weight-bold">Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?></div>
                    <div class="small text-muted">Tenor <?php echo $tenor; ?> bulan</div>
                  </td>
                  <td class="tabular-nums">
                    <div class="font-weight-bold">Rp <?php echo number_format($cicilan, 0, ',', '.'); ?>/bln</div>
                    <div class="small <?php echo ($dsr > 40) ? 'text-danger font-weight-bold' : 'text-muted'; ?>">Rasio DSR: <?php echo $dsr; ?>%</div>
                  </td>
                  <td style="max-width: 240px;">
                    <div class="small"><?php echo htmlspecialchars($p->alasan, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php if (!empty($p->file_ktp)) : ?>
                      <a href="<?php echo base_url('uploads/pinjaman/' . $p->file_ktp); ?>" target="_blank" class="small font-weight-bold mr-2" style="color: var(--exec-accent);">KTP</a>
                    <?php endif; ?>
                    <?php if (!empty($p->file_jaminan)) : ?>
                      <a href="<?php echo base_url('uploads/pinjaman/' . $p->file_jaminan); ?>" target="_blank" class="small font-weight-bold" style="color: var(--exec-accent);">Jaminan</a>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($p->status === 'Disetujui' || $p->status === 'Lunas') : ?>
                      <span class="exec-tag exec-tag-ok"><?php echo htmlspecialchars($p->status, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php elseif ($p->status === 'Ditolak') : ?>
                      <span class="exec-tag exec-tag-danger">Ditolak</span>
                    <?php else : ?>
                      <span class="exec-tag exec-tag-pending">Pending</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($is_pending) : ?>
                      <div class="d-inline-flex flex-wrap justify-content-center" style="gap: 0.35rem;">
                        <button type="button" class="btn btn-sm btn-exec-primary" data-toggle="modal" data-target="#modalSetujuiPinj<?php echo $p->id_pinjaman; ?>">
                          <i class="fas fa-check"></i> Setujui
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modalTolakPinj<?php echo $p->id_pinjaman; ?>">
                          <i class="fas fa-times"></i> Tolak
                        </button>
                      </div>

                      <!-- Modal Setujui Pinjaman -->
                      <div class="modal fade text-left" id="modalSetujuiPinj<?php echo $p->id_pinjaman; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/setujui_pinjaman/' . $p->id_pinjaman); ?>">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title exec-serif font-weight-bold">Setujui Fasilitas Pinjaman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                <p class="small text-muted">
                                  Setujui kasbon <strong>Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?></strong> untuk <strong><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong> (cicilan Rp <?php echo number_format($cicilan, 0, ',', '.'); ?>/bln selama <?php echo $tenor; ?> bulan).
                                </p>
                                <div class="form-group mb-0">
                                  <label class="small font-weight-bold">Catatan Pengesahan Pimpinan</label>
                                  <textarea name="pesan_admin" class="form-control" rows="3" placeholder="Opsional: catatan persetujuan pencairan kasbon..."></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-exec-outline btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-exec-primary btn-sm">Sahkan & Terbitkan SPPK</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>

                      <!-- Modal Tolak Pinjaman -->
                      <div class="modal fade text-left" id="modalTolakPinj<?php echo $p->id_pinjaman; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form method="POST" action="<?php echo base_url('pimpinan/persetujuan/tolak_pinjaman/' . $p->id_pinjaman); ?>">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title exec-serif font-weight-bold">Tolak Permohonan Pinjaman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group mb-0">
                                  <label class="small font-weight-bold">Alasan Penolakan</label>
                                  <textarea name="pesan_admin" class="form-control" rows="3" required placeholder="Tuliskan alasan penolakan evaluasi kredit..."></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-exec-outline btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger btn-sm">Tolak Pinjaman</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    <?php elseif ($p->status === 'Disetujui' || $p->status === 'Lunas') : ?>
                      <a href="<?php echo base_url('pimpinan/persetujuan/cetak_sppk/' . $p->id_pinjaman); ?>" target="_blank" class="btn btn-sm btn-exec-outline">
                        <i class="fas fa-print"></i> Cetak SPPK
                      </a>
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
<?php endif; ?>
