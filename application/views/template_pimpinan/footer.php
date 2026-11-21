  </main>

  <footer class="exec-footer">
    Portal Pimpinan &middot; Klinik Pratama Dr. H.M. Hidayatullah &copy; <?php echo date('Y'); ?>
  </footer>

  <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

  <script>
  $(document).ready(function() {
    if ($.fn.DataTable && $('#dataTable').length > 0 && !$.fn.DataTable.isDataTable('#dataTable')) {
      $('#dataTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
          search: "",
          searchPlaceholder: "Cari data...",
          lengthMenu: "Tampilkan _MENU_ baris",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
          infoEmpty: "Belum ada data",
          infoFiltered: "(disaring dari _MAX_ total data)",
          zeroRecords: '<div class="py-3 text-muted font-weight-bold">Tidak ada data yang cocok dengan pencarian.</div>',
          emptyTable: '<div class="py-3 text-muted font-weight-bold">Belum ada data tercatat.</div>'
        }
      });
    }

    function isDarkMode() {
      return document.documentElement.classList.contains('dark-mode') || document.body.classList.contains('dark-mode');
    }

    const toastConfig = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3800,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });

    window.showToast = function(icon, title, text) {
      const isDark = isDarkMode();
      toastConfig.fire({
        icon: icon === 'danger' ? 'error' : (icon || 'info'),
        title: title || 'Pemberitahuan',
        text: text || undefined,
        background: isDark ? '#171F2A' : '#FFFDF9',
        color: isDark ? '#F1EFEA' : '#141D26'
      });
    };

    const $flashAlert = $('.alert.alert-dismissible').first();
    if ($flashAlert.length) {
      let icon = 'info';
      if ($flashAlert.hasClass('alert-success')) icon = 'success';
      else if ($flashAlert.hasClass('alert-danger')) icon = 'error';
      else if ($flashAlert.hasClass('alert-warning')) icon = 'warning';

      const $clone = $flashAlert.clone();
      $clone.find('.close, button').remove();
      const fullText = $clone.text().replace(/\s+/g, ' ').trim();
      if (fullText.length > 0) {
        window.showToast(icon, fullText);
        if (fullText.length <= 160) {
          $flashAlert.hide();
        }
      }
    }

    <?php if ($this->session->flashdata('login_welcome')): ?>
    (function() {
      const welcomeName = <?php echo json_encode($this->session->flashdata('login_welcome')); ?>;
      window.showToast('success', 'Selamat datang, ' + welcomeName, 'Ringkasan eksekutif Klinik Pratama Hidayatullah siap ditinjau.');
    })();
    <?php endif; ?>

    $(document).on('click', '.btn-logout-swal, a[href*="login/logout"]', function(e) {
      e.preventDefault();
      const logoutUrl = $(this).attr('href') || '<?php echo base_url("login/logout"); ?>';
      const userName  = $(this).data('user') || '<?php echo htmlspecialchars($this->session->userdata("nama_pegawai") ?? "Pimpinan", ENT_QUOTES, "UTF-8"); ?>';
      const isDark    = isDarkMode();

      Swal.fire({
        title: 'Akhiri Sesi Pimpinan?',
        text: 'Anda akan keluar dari Portal Pimpinan atas nama ' + userName + '.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Tetap Masuk',
        confirmButtonColor: '#991B1B',
        cancelButtonColor: '#525E6B',
        reverseButtons: true,
        background: isDark ? '#171F2A' : '#FFFDF9',
        color: isDark ? '#F1EFEA' : '#141D26'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = logoutUrl;
        }
      });
    });
  });

  // Theme Toggle (Light / Dark)
  (function() {
    const btn  = document.getElementById('darkModeToggle');
    const icon = document.getElementById('darkModeIcon');

    function syncTheme(isDark) {
      document.documentElement.classList.toggle('dark-mode', isDark);
      document.body.classList.toggle('dark-mode', isDark);
      localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
      if (icon) {
        icon.classList.toggle('fa-sun', isDark);
        icon.classList.toggle('fa-moon', !isDark);
      }
    }

    syncTheme(localStorage.getItem('darkMode') === 'enabled');

    if (btn) {
      btn.addEventListener('click', function() {
        syncTheme(!document.documentElement.classList.contains('dark-mode'));
      });
    }
  })();
  </script>
</body>
</html>
