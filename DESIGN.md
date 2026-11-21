# Design Direction: HRIS & Payroll Klinik Pratama Dr. H.M. Hidayatullah

Dokumen ini menjadi sumber arah desain (design direction) untuk sistem HRIS Klinik Pratama Dr. H.M. Hidayatullah dengan arsitektur tiga pengalaman antarmuka berbasis peran (role-differentiated UI/UX).

## 1. Strategi Peran & Pemisahan Antarmuka

Setiap peran memiliki pekerjaan utama dan frekuensi penggunaan yang berbeda, sehingga kerangka layout tidak diseragamkan:

1. **Admin / HRD (`hak_akses = 1`)**: Tetap menggunakan kerangka **SB Admin 2** (`template_admin`) dengan sidebar accordion untuk kebutuhan operasional input data massal, pengaturan payroll, dan pemeliharaan master data.
2. **Pegawai (`hak_akses = 2`)**: Menggunakan **Portal Pegawai Mobile-First (Top-Nav + Bottom Bar)** (`template_pegawai`), tanpa sidebar SB Admin. Fokus utama adalah aksi harian dalam satu ketukan (absen masuk/pulang), pemantauan slip gaji, serta pengajuan cuti, lembur, dan pinjaman.
3. **Pimpinan / Direktur (`hak_akses = 3`)**: Menggunakan **Portal Pimpinan Executive Briefing / Editorial** (`template_pimpinan`), tanpa sidebar SB Admin. Fokus utama adalah ringkasan eksekutif, meja persetujuan (cuti, lembur, pinjaman), pemantauan kehadiran & SDM, serta cetak seluruh laporan resmi.

---

## 2. Portal Pegawai (`hak_akses = 2`)

- **Design Read**: Portal layanan mandiri mobile-first untuk tenaga kesehatan dan staf Klinik Pratama Dr. H.M. Hidayatullah, bergaya klinis-botani bersih dengan navigasi atas (desktop) dan bottom bar (ponsel).
- **Dial**: `ENERGY 2 / RHYTHM 2 / MOTION 1`
- **Titik Fokus Utama**: Kartu status dan tombol Presensi Hari Ini (Absen Masuk / Absen Pulang), diikuti akses cepat slip gaji terbaru dan pengajuan.
- **Struktur Layout**:
  - Desktop (`>= 992px`): Topbar horizontal sticky (`64px`) berisi identitas klinik, 5 menu utama (`Beranda`, `Absensi`, `Pengajuan`, `Slip Gaji`, `Riwayat`), notifikasi status pengajuan, toggle tema terang/gelap, dan menu profil. Lebar konten terpusat `max-width: 1180px`.
  - Tablet (`640px - 991px`): Topbar ringkas dengan tombol menu eksplisit berlabel "Menu" + grid konten 2 kolom.
  - Ponsel (`< 640px`): Header atas ringkas (`56px`) + fixed Bottom Navigation Bar (`64px + safe-area-inset-bottom`) dengan 4 tujuan utama (`Beranda`, `Absen`, `Pengajuan`, `Gaji`) dan tombol `Lainnya` (membuka sheet menu untuk Riwayat, Lembur, Pinjaman, Ganti Password, Logout). Konten utama menyisakan ruang bawah agar tidak pernah tertutup bar navigasi.
- **Tipografi**:
  - Utama: `Plus Jakarta Sans` (geometris ramah, keterbacaan tinggi di layar ponsel maupun desktop, selaras identitas klinik).
  - Angka & jam: `font-variant-numeric: tabular-nums` agar angka nominal Rupiah dan jam presensi rata vertikal.
- **Palet Warna (Terverifikasi WCAG AA >= 4.5:1)**:
  - Light Mode: Ground `#F4F7F5` (sage-tinted paper), Surface `#FFFFFF` (border `#DCE5DF`), Core Primary `#0F5132` (deep clinical emerald, 9.36:1 dengan putih), Core Secondary `#134E4A` (deep surgical teal, 9.48:1 dengan putih), Deliberate Accent `#9A3412` (warm terracotta untuk perhatian/pending, 7.31:1 pada putih), Ink `#11211A` (16.72:1), Muted `#495E54` (6.97:1).
  - Dark Mode: Ground `#0C1512`, Surface `#13201B` (border `#243830`), Interactive Primary `#34D399` (8.74:1 pada surface), Button Teal `#0F766E` (5.47:1 dengan putih), Accent `#FBBF24` (10.06:1 pada surface), Ink `#ECF3EF` (14.91:1), Muted `#9EB3A8` (7.57:1).
- **Motif Identitas**: Garis pembatas hairline bersih (`1px solid`), kartu berstruktur jelas tanpa left-stripe dekoratif ala SB Admin, indikator waktu tabular untuk presensi.
- **Alasan Keputusan Utama (R-31)**:
  - Warna hijau-botani dipilih untuk membedakan ruang kerja harian tenaga kesehatan dari panel admin biru gelap sekaligus memberi kesan tenang khas layanan medis.
  - Bottom bar di ponsel dipilih karena pegawai sering melakukan absensi cepat menggunakan ibu jari dari ponsel.

---

## 3. Portal Pimpinan (`hak_akses = 3`)

- **Design Read**: Portal executive briefing bergaya editorial untuk Pimpinan/Direktur Klinik Pratama Dr. H.M. Hidayatullah tanpa sidebar, menonjolkan kejelasan angka keputusan dan arsip laporan resmi.
- **Dial**: `ENERGY 2 / RHYTHM 3 / MOTION 1`
- **Titik Fokus Utama**: Ringkasan harian operasional klinik dan antrean persetujuan yang memerlukan keputusan Direktur (Cuti, Lembur, Pinjaman).
- **Struktur Layout**:
  - Masthead editorial di atas (`max-width: 1280px`) menampilkan nama klinik, peran Pimpinan, stempel tanggal hari ini, toggle tema terang/gelap, serta menu akun.
  - Bar navigasi kategori tepat di bawah garis pembatas masthead: `Ringkasan`, `Persetujuan` (dengan badge jumlah antrean aktual), `Monitoring SDM`, `Pusat Laporan`.
  - Komposisi asimetris antar-seksi (`RHYTHM 3`): blok briefing asimetris 7/5 di atas, pita angka ledger horizontal berbatas garis vertikal tipis, blok analitik 8/4 (grafik tren kehadiran 6 bulan dengan judul pertanyaan eksplisit + komposisi jabatan & jadwal libur), dan indeks cetak laporan resmi.
- **Tipografi**:
  - Judul editorial & angka ringkasan utama: `Source Serif 4` (memberi karakter briefing eksekutif dan pembeda visual tegas terhadap Admin maupun Pegawai).
  - Antarmuka, tabel, kontrol filter: `Plus Jakarta Sans` dengan `tabular-nums` pada nominal Rupiah dan metrik.
- **Palet Warna (Terverifikasi WCAG AA >= 4.5:1)**:
  - Light Mode: Ground `#F6F4EF` (warm archival paper), Surface `#FFFDF9` (warm ivory, border `#E3DDD1`), Core Primary `#18293D` (executive ink navy, 14.75:1 dengan putih), Core Secondary `#334E68` (slate), Deliberate Accent `#854D0E` (burnished bronze untuk penanda aktif & sorotan keputusan, 6.74:1 pada ivory), Ink `#141D26` (16.76:1), Muted `#525E6B` (6.52:1).
  - Dark Mode: Ground `#0F141B`, Surface `#171F2A` (border `#2A3646`), Button Primary `#26415E` (10.50:1 dengan putih), Accent `#E0A449` (brushed gold, 7.56:1 pada surface; 7.76:1 dengan teks `#141D26`), Ink `#F1EFEA` (14.44:1), Muted `#A4B0BD` (7.52:1).
- **Motif Identitas**: Garis aturan editorial (`1px` & aksen perunggu `2px` pada tab aktif), typographic serif numerals untuk KPI finansial, permukaan datar tenang dengan elevasi selektif hanya pada dialog/modal dan popover.
- **Alasan Keputusan Utama (R-31)**:
  - Gaya editorial tanpa sidebar dipilih agar Pimpinan langsung membaca ringkasan dan mengambil keputusan persetujuan tanpa tersesat di menu operasional HRD.
  - Pasangan serif (`Source Serif 4`) dan kertas gading hangat memisahkan nuansa pengambilan keputusan strategis dari antarmuka operasional Admin maupun harian Pegawai.

---

## 4. Halaman Depan / Landing Page (`landing_page.php`)

- **Design Read**: Gerbang resmi sistem HRIS Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru, bergaya editorial-klinis yang menjembatani tiga portal peran berbeda (Admin, Pegawai, Pimpinan).
- **Dial**: `ENERGY 2 / RHYTHM 3 / MOTION 1`
- **Titik Fokus Utama**: Penjelasan satu sistem dengan tiga ruang kerja peran berbeda, disertai switcher interaktif pratinjau 3 portal dan akses langsung ke Login serta Verifikasi Dokumen QR.
- **Tipografi**: `Source Serif 4` untuk judul editorial dan angka ledger; `Plus Jakarta Sans` untuk isi, kontrol tab, dan navigasi.
- **Palet Warna (Terverifikasi WCAG AA >= 4.5:1)**:
  - Light Mode: Ground `#F6F4EF`, Surface `#FFFDF9`, Ink `#141D26`, Muted `#525E6B`, Primary Navy `#18293D`, Secondary Clinical Emerald `#0F5132`, Accent Bronze `#854D0E`.
  - Dark Mode: Ground `#0F141B`, Surface `#171F2A`, Ink `#F1EFEA`, Muted `#A4B0BD`, Primary Slate `#26415E`, Secondary Emerald `#34D399`, Accent Gold `#E0A449`.
- **Alasan Keputusan Utama (R-31 & R-22)**:
  - Pratinjau arsitektur 3 portal interaktif diletakkan di pusat halaman agar pembeda proyek langsung terlihat.
  - Ilustrasi aset proyek (`payroll.svg`, `administrator.svg`, `others-fitur.svg`) disertakan atas permintaan pemilik proyek dalam bingkai matte archival `.lp-illus-frame` yang menjaga keterbacaan di Light maupun Dark Mode dan terhubung langsung pada konteks Hero/Payroll, Panel Admin HRD, serta Panel Kolaborasi & FAQ.

---

## 5. Portal Autentikasi Terpadu (`login.php`, `lupa_password.php`, `reset_password.php`)

- **Design Read**: Gerbang autentikasi Single Sign-On dan pemulihan kata sandi bergaya editorial-klinis tanpa ketergantungan template admin generik.
- **Dial**: `ENERGY 2 / RHYTHM 2 / MOTION 1`
- **Stylesheet Bersama**: `assets/css/auth-portal.css` (menghapus `sb-admin-2.min.css` dan ratusan baris CSS inline yang sebelumnya terduplikasi di 3 file).
- **Keputusan & Konsistensi (R-09, R-19, R-36)**:
  - Menghapus elemen dekoratif menyesatkan seperti pill berdenyut (`SSL 256-Bit`) pada halaman autentikasi.
  - Quick Demo Chips pada halaman login dikendalikan oleh konfigurasi `$config['show_demo_chips']` dan hanya tampil pada lingkungan non-produksi.
  - Kunci sitekey Google reCAPTCHA v2 dimuat dinamis dari `application/config/app_security.php`.
  - Kebijakan panjang kata sandi seragam minimal 8 karakter (`reset_password.php`, `lupa_password.php`, dan seluruh halaman ganti kata sandi).

---

## 6. Penyelarasan Portal Admin & Halaman Error (`admin-portal.css`, `admin/dashboard.php`, `errors/html/*`)

- **Design Read**: Antarmuka backoffice HRD berbasis kertas klinis hangat (`#F6F4EF` / `#FFFDF9`) dan sidebar navy kontras tinggi (`#142233`) yang selaras dengan Portal Pegawai, Portal Pimpinan, dan Landing Page.
- **Perbaikan Struktural**:
  - Ekstraksi CSS dari `template_admin/header.php` ke stylesheet tercache `assets/css/admin-portal.css`.
  - Penghapusan aksen garis kiri kartu dekoratif (`.border-left-*`) dan penguatan kontras label sidebar serta tabel/kartu pada Light & Dark Mode.
  - Penambahan panel analitik **Estimasi Payroll Bulan Ini**, **Grafik Tren Beban Penggajian 6 Bulan**, dan **Audit Log Terbaru** pada `admin/dashboard.php`.
  - Pembaruan halaman galat (`error_404.php`, `error_db.php`, `error_general.php`) dengan identitas Klinik Hidayatullah, dukungan Dark Mode, serta penyembunyian rincian teknis saat `ENVIRONMENT === 'production'`.


