<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>

    <div class="card shadow mb-4" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST" action="<?php echo base_url('pegawai/pinjaman/tambah_aksi') ?>">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                
                <div class="form-group">
                    <label class="font-weight-bold text-gray-800">Nominal Pinjaman (Rp)</label>
                    <input type="number" id="jumlah_pinjaman" name="jumlah_pinjaman" class="form-control" required placeholder="Contoh: 1000000" min="50000" step="10000">
                    <?php echo form_error('jumlah_pinjaman', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-gray-800">Tenor Cicilan (Bulan)</label>
                    <select id="tenor_bulan" name="tenor_bulan" class="form-control" required>
                        <option value="">-- Pilih Lama Cicilan --</option>
                        <option value="1">1 Bulan</option>
                        <option value="2">2 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="4">4 Bulan</option>
                        <option value="5">5 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                    <?php echo form_error('tenor_bulan', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <!-- Kotak Simulasi Live Cicilan Interaktif -->
                <div id="boxSimulasi" class="card border-left-success shadow-sm mb-4" style="display: none; background-color: #f8fdfa; transition: all 0.3s ease;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calculator text-success mr-2 fa-lg"></i>
                            <h6 class="m-0 font-weight-bold text-success">Estimasi Simulasi Pemotongan Gaji</h6>
                        </div>
                        <div class="row no-gutters small text-gray-800">
                            <div class="col-6 mb-1">Total Pinjaman:</div>
                            <div class="col-6 mb-1 font-weight-bold text-right" id="simTotalPinjaman">Rp 0</div>
                            <div class="col-6 mb-1">Lama Angsuran:</div>
                            <div class="col-6 mb-1 font-weight-bold text-right" id="simLamaTenor">0 Bulan</div>
                            <div class="col-12"><hr class="my-2"></div>
                            <div class="col-6 font-weight-bold text-success" style="font-size: 14px;">Potongan per Bulan:</div>
                            <div class="col-6 font-weight-bold text-success text-right" style="font-size: 15px;" id="simPotonganBulan">Rp 0 / bln</div>
                        </div>
                        <div class="mt-2 text-xs text-muted" style="line-height: 1.4;">
                            <i class="fas fa-info-circle text-info"></i> Potongan akan disuntikkan otomatis ke slip gaji bulanan Anda selama masa tenor aktif setelah disetujui HRD.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-gray-800">Alasan Peminjaman</label>
                    <textarea name="alasan" class="form-control" rows="3" required placeholder="Contoh: Biaya keperluan mendesak / berobat keluarga..."></textarea>
                    <?php echo form_error('alasan', '<div class="text-small text-danger">', '</div>') ?>
                </div>

                <div class="alert alert-info" style="font-size: 13px; border-radius: 8px;">
                    <i class="fas fa-shield-alt mr-1"></i> <strong>Informasi:</strong> Pengajuan kasbon akan ditinjau dan divalidasi terlebih dahulu oleh Pimpinan / HRD Klinik.
                </div>

                <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Ajukan Pinjaman</button>
                <a href="<?php echo base_url('pegawai/pinjaman') ?>" class="btn btn-secondary shadow-sm">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputNominal = document.getElementById("jumlah_pinjaman");
    const selectTenor = document.getElementById("tenor_bulan");
    const boxSimulasi = document.getElementById("boxSimulasi");
    const simTotalPinjaman = document.getElementById("simTotalPinjaman");
    const simLamaTenor = document.getElementById("simLamaTenor");
    const simPotonganBulan = document.getElementById("simPotonganBulan");

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(angka);
    }

    function hitungSimulasi() {
        const nominal = parseFloat(inputNominal.value) || 0;
        const tenor = parseInt(selectTenor.value) || 0;

        if (nominal > 0 && tenor > 0) {
            const potongan = Math.ceil(nominal / tenor);
            simTotalPinjaman.textContent = formatRupiah(nominal);
            simLamaTenor.textContent = tenor + " Bulan";
            simPotonganBulan.textContent = formatRupiah(potongan) + " / bln";
            boxSimulasi.style.display = "block";
        } else {
            boxSimulasi.style.display = "none";
        }
    }

    inputNominal.addEventListener("input", hitungSimulasi);
    inputNominal.addEventListener("keyup", hitungSimulasi);
    selectTenor.addEventListener("change", hitungSimulasi);
});
</script>
