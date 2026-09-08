<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 font-weight-bold text-gray-800">
                <i class="fas fa-file-invoice-dollar text-primary mr-2"></i><?php echo $title; ?>
            </h1>
            <p class="text-muted small mb-0">Isi formulir dengan data yang valid dan lengkap untuk verifikasi kelayakan pinjaman kasbon.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="<?php echo base_url('pegawai/pinjaman'); ?>" class="btn btn-secondary btn-sm px-3 py-2 font-weight-bold shadow-sm rounded-pill">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Flash Message Session -->
    <?php echo $this->session->flashdata('pesan'); ?>

    <!-- Check Existing Active Loan Alert -->
    <?php if (!empty($has_active_loan)) : ?>
        <div class="alert alert-warning border-0 shadow-sm p-4 mb-4 rounded-lg">
            <div class="d-flex align-items-center">
                <div class="mr-3 text-warning">
                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold text-gray-800 mb-1">Anda Masih Memiliki Pinjaman Aktif / Dalam Review!</h5>
                    <p class="mb-0 text-muted small" style="line-height: 1.5;">
                        Sistem mendeteksi bahwa Anda saat ini memiliki permohonan pinjaman dengan status <strong>"<?php echo $has_active_loan->status; ?>"</strong> sebesar <strong>Rp <?php echo number_format($has_active_loan->jumlah_pinjaman, 0, ',', '.'); ?></strong>. 
                        Sesuai kebijakan tata kelola keuangan (*One Active Loan Rule*), pengajuan baru hanya dapat diproses setelah pinjaman aktif sebelumnya berstatus lunas.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Check Tenure Eligibility Alert -->
    <?php if (!$is_eligible_tenure) : ?>
        <div class="alert alert-danger border-0 shadow-sm p-4 mb-4 rounded-lg">
            <div class="d-flex align-items-center">
                <div class="mr-3 text-danger">
                    <i class="fas fa-shield-halved fa-3x"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold text-gray-800 mb-1">Masa Kerja Belum Memenuhi Syarat Minimal!</h5>
                    <p class="mb-0 text-muted small" style="line-height: 1.5;">
                        Masa kerja Anda saat ini tercatat <strong><?php echo $masa_kerja_tahun; ?> tahun <?php echo $masa_kerja_bulan; ?> bulan</strong> (total <?php echo $total_bulan_kerja; ?> bulan). Syarat minimal pengajuan fasilitas pinjaman kasbon adalah <strong>6 bulan masa kerja aktif</strong> sejak tanggal masuk.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Two-Column Layout -->
    <div class="row">
        
        <!-- Kolom Kiri: Formulir Pengajuan & Upload Berkas -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header py-3 bg-transparent border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-pen-to-square mr-2"></i>Formulir Data Pinjaman & Dokumen Penjamin
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form id="formPinjaman" method="POST" action="<?php echo base_url('pegawai/pinjaman/tambah_aksi'); ?>" enctype="multipart/form-data">
                        
                        <!-- CSRF Token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <!-- Nominal & Tenor -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-800 small">
                                        <i class="fas fa-money-bill-wave text-success mr-1"></i> Nominal Pinjaman (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="jumlah_pinjaman" 
                                           name="jumlah_pinjaman" 
                                           class="form-control" 
                                           required 
                                           placeholder="Contoh: 1500000" 
                                           min="100000" 
                                           max="<?php echo $plafon_maksimal; ?>" 
                                           step="50000"
                                           <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                    <small class="form-text text-muted">Maksimal: Rp <?php echo number_format($plafon_maksimal, 0, ',', '.'); ?> (2x Gaji Pokok)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-800 small">
                                        <i class="fas fa-calendar-alt text-info mr-1"></i> Tenor Angsuran <span class="text-danger">*</span>
                                    </label>
                                    <select id="tenor_bulan" 
                                            name="tenor_bulan" 
                                            class="form-control" 
                                            required
                                            <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                        <option value="">-- Pilih Lama Tenor --</option>
                                        <option value="1">1 Bulan (Potong gaji 1x)</option>
                                        <option value="2">2 Bulan</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="4">4 Bulan</option>
                                        <option value="5">5 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="10">10 Bulan</option>
                                        <option value="12">12 Bulan (1 Tahun)</option>
                                    </select>
                                    <small class="form-text text-muted">Dicicil bulanan via payroll.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan Keperluan Pinjaman -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-gray-800 small">
                                <i class="fas fa-align-left text-info mr-1"></i> Alasan / Keperluan Kasbon <span class="text-danger">*</span>
                            </label>
                            <textarea name="alasan" 
                                      id="alasan" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Tuliskan alasan keperluan kasbon secara jujur dan transparan (misal: Biaya berobat keluarga / renovasi mendesak)..." 
                                      required
                                      <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>></textarea>
                        </div>

                        <hr class="my-3">

                        <!-- Kontak Darurat / Keluarga Penjamin -->
                        <h6 class="font-weight-bold text-gray-800 small mb-2 text-uppercase" style="letter-spacing: 0.05em;">
                            <i class="fas fa-users-viewfinder text-primary mr-1"></i> Data Kontak Darurat / Penjamin
                        </h6>
                        <p class="text-muted small mb-3">Data keluarga terdekat yang dapat dihubungi oleh pihak klinik jika terjadi situasi darurat.</p>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-800 small">Nama Lengkap Penjamin <span class="text-danger">*</span></label>
                                    <input type="text" name="kontak_darurat_nama" class="form-control" placeholder="Nama keluarga" required <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-800 small">No. HP / WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" name="kontak_darurat_hp" class="form-control" placeholder="08xxxxxxxxxx" required <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-800 small">Hubungan <span class="text-danger">*</span></label>
                                    <select name="kontak_darurat_hubungan" class="form-control" required <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Suami / Istri">Suami/Istri</option>
                                        <option value="Saudara Kandung">Saudara</option>
                                        <option value="Keluarga Lain">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Upload Berkas Verifikasi -->
                        <h6 class="font-weight-bold text-gray-800 small mb-2 text-uppercase" style="letter-spacing: 0.05em;">
                            <i class="fas fa-file-shield text-primary mr-1"></i> Berkas Identitas & Jaminan
                        </h6>

                        <!-- Foto KTP (Wajib) -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-gray-800 small">
                                <i class="fas fa-id-card text-primary mr-1"></i> Foto KTP Asli Pemohon <span class="text-danger">* (Wajib)</span>
                            </label>
                            <input type="file" 
                                   name="file_ktp" 
                                   id="file_ktp" 
                                   class="form-control-file border p-2 rounded" 
                                   accept="image/jpeg,image/png,image/jpg,application/pdf" 
                                   required
                                   <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                            <small class="form-text text-muted">Format JPG, PNG, atau PDF (Maks. 3 MB). Foto jelas dan tidak buram.</small>
                        </div>

                        <!-- Dokumen Jaminan / Ijazah (Opsional) -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-800 small">
                                <i class="fas fa-award text-warning mr-1"></i> Dokumen Jaminan / Ijazah / Bukti Kebutuhan <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" 
                                   name="file_jaminan" 
                                   id="file_jaminan" 
                                   class="form-control-file border p-2 rounded" 
                                   accept="image/jpeg,image/png,image/jpg,application/pdf"
                                   <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                            <small class="form-text text-muted">Dianjurkan untuk pinjaman bernilai besar: Foto Ijazah Terakhir / Kwitansi Medis / BPKB (Maks. 5 MB).</small>
                        </div>

                        <!-- Klausul Kuasa Potong Gaji Legal -->
                        <div class="custom-control custom-checkbox mb-4 p-3 bg-light rounded border">
                            <input type="checkbox" class="custom-control-input" id="checkLegalConsent" required <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                            <label class="custom-control-label small font-weight-bold text-gray-800" for="checkLegalConsent">
                                Saya menyatakan data di atas benar, serta memberi kuasa penuh kepada Manajemen Klinik untuk memotong gaji bulanan saya guna pelunasan kasbon ini. Jika saya mengundurkan diri / berhenti sebelum lunas, klinik berhak memotong dari sisa gaji dan hak terakhir saya.
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="<?php echo base_url('pegawai/pinjaman'); ?>" class="btn btn-light border px-4 py-2 font-weight-bold shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Batal
                            </a>
                            <button type="submit" 
                                    id="btnSubmitPinjaman" 
                                    class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm"
                                    <?php echo (!empty($has_active_loan) || !$is_eligible_tenure) ? 'disabled' : ''; ?>>
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Permohonan Pinjaman
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Live Calculator, Status Kelayakan & Risk Meter -->
        <div class="col-lg-5 mb-4">

            <!-- Live Calculation & Risk Meter Card -->
            <div class="card border-0 shadow-sm rounded-lg mb-4" style="background: linear-gradient(135deg, #0c2b4d 0%, #1e3a8a 100%); color: #ffffff;">
                <div class="card-body p-4 text-center position-relative overflow-hidden">
                    <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.08; pointer-events: none;">
                        <i class="fas fa-calculator"></i>
                    </div>

                    <span class="badge badge-light text-primary font-weight-bold px-3 py-1 mb-3 rounded-pill text-uppercase" style="letter-spacing: 0.05em; font-size: 0.75rem;">
                        <i class="fas fa-chart-pie mr-1"></i> Live Simulasi Cicilan & DSR
                    </span>

                    <h5 class="text-light opacity-80 mb-1" style="font-size: 0.95rem;">Estimasi Potongan Gaji per Bulan:</h5>
                    <div class="display-4 font-weight-bold text-white my-2" id="display-cicilan">
                        Rp 0 <span style="font-size: 1.2rem; font-weight: normal;">/bln</span>
                    </div>

                    <!-- Risk Meter Indicator -->
                    <div class="mt-3 p-2 rounded" id="boxRiskMeter" style="background: rgba(255,255,255,0.12);">
                        <div class="d-flex justify-content-between small text-light mb-1">
                            <span>Beban Cicilan Terhadap Gaji:</span>
                            <span class="font-weight-bold" id="textDsrPercent">0%</span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 6px;">
                            <div id="barDsr" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                        </div>
                        <small class="d-block mt-2 text-light opacity-85" id="textRiskDesc">
                            Batas aman cicilan maksimal 40% dari total penghasilan.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Kartu Status Profil & Plafon Kredit -->
            <div class="card border-0 shadow-sm rounded-lg mb-4">
                <div class="card-header py-3 bg-transparent border-bottom">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-id-card-clip text-info mr-2"></i>Status Kelayakan Finansial Pegawai
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                <i class="fas fa-user-tie fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="font-weight-bold text-gray-800 mb-0"><?php echo htmlspecialchars($pegawai->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></h6>
                            <span class="badge badge-light border text-muted">NIK: <?php echo $pegawai->nik; ?></span>
                            <span class="badge badge-info ml-1"><?php echo $pegawai->nama_jabatan; ?></span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-borderless small mb-0">
                            <tr>
                                <td class="text-muted" style="width: 45%;">Masa Kerja:</td>
                                <td class="font-weight-bold">
                                    <?php echo $masa_kerja_tahun; ?> Thn <?php echo $masa_kerja_bulan; ?> Bln
                                    <?php if ($is_eligible_tenure) : ?>
                                        <span class="badge badge-success ml-1"><i class="fas fa-check"></i> Memenuhi</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger ml-1"><i class="fas fa-times"></i> Belum Memenuhi</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Gaji Pokok:</td>
                                <td class="font-weight-bold text-gray-800">Rp <?php echo number_format($gaji_pokok, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Plafon Maksimal:</td>
                                <td class="font-weight-bold text-primary">Rp <?php echo number_format($plafon_maksimal, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Batas Maks. Cicilan:</td>
                                <td class="font-weight-bold text-danger">Rp <?php echo number_format($cicilan_maksimal, 0, ',', '.'); ?> /bln</td>
                            </tr>
                        </table>
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <h6 class="font-weight-bold text-gray-800 small mb-2">
                            <i class="fas fa-circle-info text-info mr-1"></i> Kebijakan Kasbon Klinik:
                        </h6>
                        <ul class="pl-3 small text-muted mb-0" style="line-height: 1.5;">
                            <li>Plafon maksimal pinjaman adalah <strong>2x Gaji Pokok</strong>.</li>
                            <li>Beban cicilan bulanan dibatasi maksimal <strong>40% dari total gaji</strong>.</li>
                            <li>Pengajuan wajib menyertakan foto KTP asli dan kontak darurat keluarga.</li>
                            <li>Persetujuan diproses langsung oleh Pimpinan / HRD Klinik via sistem.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->

<!-- Interactive Credit Simulator & DSR Risk Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputNominal = document.getElementById("jumlah_pinjaman");
    const selectTenor  = document.getElementById("tenor_bulan");
    const dispCicilan  = document.getElementById("display-cicilan");
    const textDsr      = document.getElementById("textDsrPercent");
    const barDsr       = document.getElementById("barDsr");
    const textRisk     = document.getElementById("textRiskDesc");
    const btnSubmit    = document.getElementById("btnSubmitPinjaman");

    const totalGaji    = <?php echo $total_gaji; ?>;
    const maxCicilan   = <?php echo $cicilan_maksimal; ?>;
    const maxPlafon    = <?php echo $plafon_maksimal; ?>;

    function formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(num);
    }

    function calculateFinance() {
        const nominal = parseFloat(inputNominal.value) || 0;
        const tenor   = parseInt(selectTenor.value) || 0;

        if (nominal > 0 && tenor > 0) {
            const cicilan = Math.ceil(nominal / tenor);
            dispCicilan.innerHTML = formatRupiah(cicilan) + ' <span style="font-size: 1.2rem; font-weight: normal;">/bln</span>';

            // Hitung Debt Service Ratio (DSR)
            const dsr = totalGaji > 0 ? ((cicilan / totalGaji) * 100).toFixed(1) : 0;
            textDsr.textContent = dsr + '%';
            barDsr.style.width = Math.min(dsr, 100) + '%';

            if (nominal > maxPlafon) {
                barDsr.className = 'progress-bar bg-danger';
                textRisk.innerHTML = '<span class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Nominal melebihi batas plafon 2x Gaji Pokok!</span>';
                if (btnSubmit) btnSubmit.disabled = true;
            } else if (cicilan > maxCicilan || dsr > 40) {
                barDsr.className = 'progress-bar bg-danger';
                textRisk.innerHTML = '<span class="text-warning font-weight-bold"><i class="fas fa-times-circle"></i> Cicilan melebihi 40% total gaji! Silakan perpanjang tenor.</span>';
                if (btnSubmit) btnSubmit.disabled = true;
            } else if (dsr > 25) {
                barDsr.className = 'progress-bar bg-warning';
                textRisk.innerHTML = '<span class="text-light"><i class="fas fa-info-circle"></i> Rasio cicilan wajar (' + dsr + '% dari gaji). Beban finansial terkontrol.</span>';
                if (btnSubmit && !btnSubmit.dataset.blocked) btnSubmit.disabled = false;
            } else {
                barDsr.className = 'progress-bar bg-success';
                textRisk.innerHTML = '<span class="text-light"><i class="fas fa-check-circle"></i> Sangat Aman! Rasio cicilan ringan (' + dsr + '% dari gaji).</span>';
                if (btnSubmit && !btnSubmit.dataset.blocked) btnSubmit.disabled = false;
            }
        } else {
            dispCicilan.innerHTML = 'Rp 0 <span style="font-size: 1.2rem; font-weight: normal;">/bln</span>';
            textDsr.textContent = '0%';
            barDsr.style.width = '0%';
            barDsr.className = 'progress-bar bg-success';
            textRisk.textContent = 'Batas aman cicilan maksimal 40% dari total penghasilan.';
        }
    }

    if (inputNominal && selectTenor) {
        inputNominal.addEventListener("input", calculateFinance);
        selectTenor.addEventListener("change", calculateFinance);
        calculateFinance();
    }
});
</script>
