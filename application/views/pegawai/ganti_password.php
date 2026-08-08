<!-- Begin Page Content -->
<div class="container-fluid mb-5">

  <div class="row justify-content-center mt-4">
    <div class="col-lg-5 col-md-7">
      
      <?php echo $this->session->flashdata('pesan'); ?>

      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-modern-blue text-white text-center py-4" style="border-radius: 10px 10px 0 0;">
          <div class="icon-circle bg-white mx-auto mb-2 shadow-sm" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
            <i class="fas fa-lock text-primary" style="font-size: 1.8rem;"></i>
          </div>
          <h5 class="m-0 font-weight-bold" style="letter-spacing: 1px;">Ganti Password Keamanan</h5>
          <small class="text-white-50">Pastikan akun Anda selalu aman</small>
        </div>
        
        <div class="card-body p-4 p-md-5">
          <form method="POST" action="<?php echo base_url('pegawai/ganti_password/ganti_password_aksi')?>">
            
            <div class="form-group mb-4">
              <label class="font-weight-bold text-gray-700 small mb-2"><i class="fas fa-key mr-2"></i> Password Lama</label>
              <div class="input-group">
                <input type="password" name="passLama" id="passLama" class="form-control form-control-user" placeholder="Masukkan password saat ini..." required>
                <div class="input-group-append">
                  <span class="input-group-text bg-white cursor-pointer toggle-password" data-target="#passLama"><i class="fas fa-eye"></i></span>
                </div>
              </div>
              <?php echo form_error('passLama', '<div class="text-small text-danger mt-1">', '</div>')?>
            </div>

            <hr class="mb-4">

            <div class="form-group mb-3">
              <label class="font-weight-bold text-gray-700 small mb-2"><i class="fas fa-lock mr-2"></i> Password Baru</label>
              <div class="input-group">
                <input type="password" name="passBaru" id="passBaru" class="form-control form-control-user" placeholder="Buat password baru yang kuat..." required>
                <div class="input-group-append">
                  <span class="input-group-text bg-white cursor-pointer toggle-password" data-target="#passBaru"><i class="fas fa-eye"></i></span>
                </div>
              </div>
              <?php echo form_error('passBaru', '<div class="text-small text-danger mt-1">', '</div>')?>
              
              <!-- Password Strength Meter -->
              <div class="progress mt-2" style="height: 5px; display: none;" id="strengthMeterContainer">
                <div class="progress-bar" id="strengthMeter" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <small id="strengthText" class="form-text text-muted mt-1" style="display: none;"></small>
            </div>

            <div class="form-group mb-4">
              <label class="font-weight-bold text-gray-700 small mb-2"><i class="fas fa-check-double mr-2"></i> Konfirmasi Password Baru</label>
              <div class="input-group">
                <input type="password" name="ulangPass" id="ulangPass" class="form-control form-control-user" placeholder="Ulangi password baru..." required>
                <div class="input-group-append">
                  <span class="input-group-text bg-white cursor-pointer toggle-password" data-target="#ulangPass"><i class="fas fa-eye"></i></span>
                </div>
              </div>
              <small id="matchMessage" class="form-text mt-1"></small>
              <?php echo form_error('ulangPass', '<div class="text-small text-danger mt-1">', '</div>')?>
            </div>
            
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
            
            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm font-weight-bold mt-4" id="btnSubmit">
              <i class="fas fa-save mr-2"></i> Simpan Password Baru
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<style>
  .cursor-pointer { cursor: pointer; transition: background-color 0.2s; }
  .cursor-pointer:hover { background-color: #f8f9fc !important; }
  .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15); border-color: #4e73df; }
  .input-group-text { border-left: none; }
  .input-group .form-control { border-right: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/Hide Password Toggle
    const toggles = document.querySelectorAll('.toggle-password');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.querySelector(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Password Strength Checker
    const passBaru = document.getElementById('passBaru');
    const strengthContainer = document.getElementById('strengthMeterContainer');
    const strengthMeter = document.getElementById('strengthMeter');
    const strengthText = document.getElementById('strengthText');
    const ulangPass = document.getElementById('ulangPass');
    const matchMessage = document.getElementById('matchMessage');
    
    passBaru.addEventListener('input', function() {
        const val = passBaru.value;
        if(val.length > 0) {
            strengthContainer.style.display = 'flex';
            strengthText.style.display = 'block';
            
            let strength = 0;
            if (val.length > 5) strength += 20; // Length
            if (val.length > 7) strength += 20; // Length longer
            if (val.match(/[A-Z]/)) strength += 20; // Uppercase
            if (val.match(/[0-9]/)) strength += 20; // Number
            if (val.match(/[^a-zA-Z0-9]/)) strength += 20; // Special char
            
            strengthMeter.style.width = strength + '%';
            
            if (strength <= 40) {
                strengthMeter.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Lemah: Tambahkan kombinasi angka dan huruf besar.';
                strengthText.className = 'form-text text-danger mt-1';
            } else if (strength <= 80) {
                strengthMeter.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Sedang: Sudah lumayan baik.';
                strengthText.className = 'form-text text-warning mt-1';
            } else {
                strengthMeter.className = 'progress-bar bg-success';
                strengthText.textContent = 'Kuat: Password Anda sangat aman!';
                strengthText.className = 'form-text text-success mt-1';
            }
        } else {
            strengthContainer.style.display = 'none';
            strengthText.style.display = 'none';
        }
        checkMatch();
    });

    // Password Match Checker
    ulangPass.addEventListener('input', checkMatch);
    
    function checkMatch() {
        if(ulangPass.value.length > 0) {
            if(passBaru.value === ulangPass.value) {
                matchMessage.textContent = 'Password cocok!';
                matchMessage.className = 'form-text text-success mt-1 font-weight-bold';
            } else {
                matchMessage.textContent = 'Password tidak cocok!';
                matchMessage.className = 'form-text text-danger mt-1';
            }
        } else {
            matchMessage.textContent = '';
        }
    }
});
</script>
<!-- /.container-fluid -->