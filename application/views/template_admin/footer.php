<!-- Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">

          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Chart script initialization moved to specific view -->

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    <?php if($this->session->flashdata('welcome_msg')): ?>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });
        Toast.fire({
          icon: 'success',
          title: '<?php echo $this->session->flashdata("welcome_msg"); ?>'
        });
    <?php endif; ?>

    if ($('.alert-success').length > 0) {
        var msg = $('.alert-success').text().replace('×', '').replace('Berhasil!', '').trim();
        $('.alert-success').hide();
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: msg,
            showConfirmButton: false,
            timer: 2500
        });
    }

    if ($('.alert-danger').length > 0) {
        if (msg === "") msg = "Terjadi Kesalahan / Ditolak";
        $('.alert-danger').hide();
        Swal.fire({
            icon: 'error',
            title: 'Peringatan',
            text: msg,
            confirmButtonColor: '#d33'
        });
    }
});
</script>

<script>
  // Dark Mode Logic
  const darkModeToggle = document.getElementById('darkModeToggle');
  const darkModeIcon = document.getElementById('darkModeIcon');
  const body = document.body;

  if (localStorage.getItem('darkMode') === 'enabled') {
      body.classList.add('dark-mode');
      darkModeIcon.classList.remove('fa-moon');
      darkModeIcon.classList.add('fa-sun', 'text-warning');
      darkModeIcon.classList.remove('text-light');
  }

  darkModeToggle.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      if (body.classList.contains('dark-mode')) {
          localStorage.setItem('darkMode', 'enabled');
          darkModeIcon.classList.remove('fa-moon', 'text-light');
          darkModeIcon.classList.add('fa-sun', 'text-warning');
      } else {
          localStorage.setItem('darkMode', 'disabled');
          darkModeIcon.classList.remove('fa-sun', 'text-warning');
          darkModeIcon.classList.add('fa-moon', 'text-light');
      }
  });

  // Preloader Fade Out
  window.addEventListener('load', function() {
      setTimeout(function() {
          var preloader = document.getElementById('preloader');
          if (preloader) {
              preloader.style.opacity = '0';
              setTimeout(function() { preloader.style.display = 'none'; }, 500);
          }
      }, 300); // 300ms delay for smoothness
  });
</script>

</body>

</html>