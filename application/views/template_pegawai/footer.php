  </main>
  <!-- End Main Workspace -->

  <footer class="emp-footer">
    Portal Mandiri Pegawai &middot; Klinik Pratama Dr. H.M. Hidayatullah &copy; <?php echo date('Y'); ?>
  </footer>

  <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
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
          zeroRecords: '<div class="py-3 text-muted font-weight-bold">Tidak ada data yang cocok dengan pencarian Anda.</div>',
          emptyTable: '<div class="py-3 text-muted font-weight-bold">Belum ada data tercatat pada tabel ini.</div>',
          paginate: {
            first: '<i class="fas fa-angles-left"></i>',
            previous: '<i class="fas fa-angle-left"></i>',
            next: '<i class="fas fa-angle-right"></i>',
            last: '<i class="fas fa-angles-right"></i>'
          }
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
      timer: 3500,
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
        background: isDark ? '#13201B' : '#FFFFFF',
        color: isDark ? '#ECF3EF' : '#11211A'
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
      const hour = new Date().getHours();
      let greeting = 'Selamat Malam';
      if (hour >= 4 && hour < 11) greeting = 'Selamat Pagi';
      else if (hour >= 11 && hour < 15) greeting = 'Selamat Siang';
      else if (hour >= 15 && hour < 18.5) greeting = 'Selamat Sore';

      window.showToast('success', greeting + ', ' + welcomeName, 'Selamat bekerja di Portal Pegawai Klinik Hidayatullah.');
    })();
    <?php endif; ?>

    $(document).on('click', '.btn-konfirmasi', function(e) {
      e.preventDefault();
      const href  = $(this).attr('href');
      const form  = $(this).closest('form');
      const judul = $(this).data('judul') || 'Konfirmasi Tindakan';
      const pesan = $(this).data('pesan') || 'Lanjutkan proses ini?';
      const tipe  = $(this).data('tipe') || 'question';
      const isDark = isDarkMode();

      Swal.fire({
        title: judul,
        text: pesan,
        icon: tipe,
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0F5132',
        cancelButtonColor: '#64748B',
        reverseButtons: true,
        background: isDark ? '#13201B' : '#FFFFFF',
        color: isDark ? '#ECF3EF' : '#11211A'
      }).then((result) => {
        if (result.isConfirmed) {
          if (href) {
            window.location.href = href;
          } else if (form.length) {
            form.submit();
          }
        }
      });
    });

    $(document).on('click', '.btn-logout-swal, a[href*="login/logout"]', function(e) {
      e.preventDefault();
      const logoutUrl = $(this).attr('href') || '<?php echo base_url("login/logout"); ?>';
      const userName  = $(this).data('user') || '<?php echo htmlspecialchars($this->session->userdata("nama_pegawai") ?? "Pegawai", ENT_QUOTES, "UTF-8"); ?>';
      const isDark    = isDarkMode();

      Swal.fire({
        title: 'Keluar dari Portal Pegawai?',
        text: 'Sesi atas nama ' + userName + ' akan diakhiri. Pastikan seluruh pengajuan sudah disimpan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Tetap Masuk',
        confirmButtonColor: '#991B1B',
        cancelButtonColor: '#495E54',
        reverseButtons: true,
        background: isDark ? '#13201B' : '#FFFFFF',
        color: isDark ? '#ECF3EF' : '#11211A'
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

  // Tablet Drawer Toggle & Mobile Sheet Drawer (with Escape support)
  (function() {
    const tabletBtn    = document.getElementById('tabletMenuToggle');
    const tabletDrawer = document.getElementById('tabletDrawer');
    if (tabletBtn && tabletDrawer) {
      tabletBtn.addEventListener('click', function() {
        const isOpen = tabletDrawer.classList.toggle('open');
        tabletBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    }

    const sheetToggle   = document.getElementById('mobileSheetToggle');
    const sheetClose    = document.getElementById('mobileSheetClose');
    const sheet         = document.getElementById('mobileSheet');
    const sheetBackdrop = document.getElementById('mobileSheetBackdrop');

    function closeSheet() {
      if (!sheet) return;
      sheet.classList.remove('open');
      if (sheetBackdrop) sheetBackdrop.classList.remove('open');
      if (sheetToggle) sheetToggle.setAttribute('aria-expanded', 'false');
    }

    function openSheet() {
      if (!sheet) return;
      sheet.classList.add('open');
      if (sheetBackdrop) sheetBackdrop.classList.add('open');
      if (sheetToggle) sheetToggle.setAttribute('aria-expanded', 'true');
      if (sheetClose) sheetClose.focus();
    }

    if (sheetToggle) sheetToggle.addEventListener('click', openSheet);
    if (sheetClose) sheetClose.addEventListener('click', closeSheet);
    if (sheetBackdrop) sheetBackdrop.addEventListener('click', closeSheet);

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeSheet();
        if (tabletDrawer && tabletDrawer.classList.contains('open')) {
          tabletDrawer.classList.remove('open');
          if (tabletBtn) tabletBtn.setAttribute('aria-expanded', 'false');
        }
      }
    });
  })();

  // Live Clock (Tabular WITA)
  (function() {
    function tick() {
      const el = document.getElementById('live-clock');
      if (!el) return;
      const now = new Date();
      const h = String(now.getHours()).padStart(2, '0');
      const m = String(now.getMinutes()).padStart(2, '0');
      const s = String(now.getSeconds()).padStart(2, '0');
      const span = el.querySelector('span');
      if (span) span.textContent = h + ':' + m + ':' + s + ' WITA';
    }
    tick();
    setInterval(tick, 1000);
  })();
  </script>
</body>
</html>
