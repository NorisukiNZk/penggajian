<div align="center">

  <!-- Logo & Title Header -->
  <img src="assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" width="130" style="margin-bottom: 10px;"/>
  
  # 🏥 Enterprise HRIS & Payroll Management System
  ### Sistem Informasi Manajemen Kepegawaian & Penggajian Terpadu
  **Klinik Pratama Dr. H.M. Hidayatullah — Banjarbaru, Kalimantan Selatan**

  <br>

  <!-- Badges -->
  <p>
    <a href="https://codeigniter.com"><img src="https://img.shields.io/badge/Framework-CodeIgniter%203.1.11-DD4814?style=for-the-badge&logo=codeigniter&logoColor=white" alt="CodeIgniter"></a>
    <a href="https://php.net"><img src="https://img.shields.io/badge/Language-PHP%207.4%20%7C%208.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
    <a href="https://mysql.com"><img src="https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"></a>
    <a href="https://getbootstrap.com"><img src="https://img.shields.io/badge/UI%20Framework-Bootstrap%204.6-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap"></a>
  </p>
  <p>
    <img src="https://img.shields.io/badge/Security-BCRYPT%20%2B%20CSRF%20%2B%20reCAPTCHA-success?style=flat-square&logo=shield" alt="Security">
    <img src="https://img.shields.io/badge/Reporting-Smart%20QR%20%26%20Watermark-informational?style=flat-square&logo=adobeacrobatreader" alt="Reporting">
    <img src="https://img.shields.io/badge/Status-Production%20Ready-brightgreen?style=flat-square" alt="Status">
    <img src="https://img.shields.io/badge/License-MIT-blue?style=flat-square" alt="License">
  </p>

</div>

---

## 📑 Daftar Isi (*Table of Contents*)
- [Ringkasan Eksekutif (*Executive Summary*)](#-ringkasan-eksekutif-executive-summary)
- [Arsitektur & Modul Unggulan (*Core Modules*)](#-arsitektur--modul-unggulan-core-modules)
  - [1. Manajemen Data Master & Hak Akses (RBAC)](#1--manajemen-data-master--hak-akses-rbac)
  - [2. Modul Pinjaman Karyawan / Kasbon (Stateless Dynamic Deduct)](#2--modul-pinjaman-karyawan--kasbon-stateless-dynamic-deduct)
  - [3. Manajemen Presensi, Lembur & Cuti](#3--manajemen-presensi-lembur--cuti)
  - [4. Standardisasi Cetak Dokumen Enterprise (Smart Reporting)](#4--standardisasi-cetak-dokumen-enterprise-smart-reporting)
  - [5. Dashboard Analytics & Interaktivitas UI/UX](#5--dashboard-analytics--interaktivitas-uiux)
- [Matriks Keamanan & Integritas Data (*Security Hardening*)](#-matriks-keamanan--integritas-data-security-hardening)
- [Tumpukan Teknologi (*Technology Stack*)](#-tumpukan-teknologi-technology-stack)
- [Struktur Direktori Proyek (*Project Directory Structure*)](#-struktur-direktori-proyek-project-directory-structure)
- [Panduan Instalasi & Menjalankan Sistem (*Installation Guide*)](#-panduan-instalasi--menjalankan-sistem-installation-guide)
- [Kredensial Pengujian Bawaan (*Default Accounts*)](#-kredensial-pengujian-bawaan-default-accounts)
- [Hak Cipta & Pengembang (*Credits*)](#-hak-cipta--pengembang-credits)

---

## 💡 Ringkasan Eksekutif (*Executive Summary*)
**Enterprise HRIS & Payroll Management System** adalah platform berbasis Web terintegrasi yang dirancang untuk menjawab kompleksitas pengelolaan sumber daya manusia, presensi harian, administrasi lembur/cuti, serta komputasi penggajian (*Payroll*) pada fasilitas kesehatan (**Klinik Pratama Dr. H.M. Hidayatullah**).

Sistem ini mengimplementasikan logika komputasi tingkat lanjut (*Advanced Computational Logic*), validasi silang bebas kecurangan (*Anti-Fraud Cross-Validation*), arsitektur perhitungan pinjaman tanpa mutasi ganda (*Stateless Anti-Double Deduct*), serta format berkas cetak resmi berstandar korporat dengan verifikasi digital QR Code.

---

## 🚀 Arsitektur & Modul Unggulan (*Core Modules*)

### 1. 👥 Manajemen Data Master & Hak Akses (RBAC)
* **Master Pegawai:** Manajemen biodata lengkap, Nomor Induk Kependudukan (NIK) terisolasi unik, jabatan, status kerja (Tetap / Kontrak), filter rekapitulasi, dan manajemen avatar profil.
* **Master Jabatan & Komponen Upah:** Pengaturan terstruktur untuk besaran Gaji Pokok, Tunjangan Transportasi, serta Uang Makan per posisi jabatan.
* **Tunjangan & Potongan Dinamis:** Dukungan penambahan komponen insentif atau potongan kustom baik bernilai nominal tetap (Rp) maupun persentase (%).
* **Role-Based Access Control (RBAC):**
  * 👑 **Administrator (HRD & Finance):** Akses komprehensif ke seluruh modul master, transaksi, persetujuan (*approval*), audit presensi, dan rekapitulasi laporan.
  * 👤 **Pegawai (ESS - Employee Self-Service):** Akses mandiri untuk pemantauan kehadiran, pengajuan permohonan lembur & cuti, pengajuan pinjaman kasbon, serta pengunduhan slip gaji pribadi.

---

### 2. 💸 Modul Pinjaman Karyawan / Kasbon (*Stateless Dynamic Deduct*)
Sistem mengadopsi mekanisme perhitungan pinjaman mutakhir yang bersifat **Stateless**:

```
[ Pegawai Mengajukan Pinjaman (Pilih Tenor 1-12 Bln) ]
                        │
                        ▼
           [ Panel Approval Admin HRD ]
            ├── Setujui (Approved)
            └── Tolak (Rejected)
                        │
                        ▼ (Jika Disetujui)
[ Komputasi Penggajian & Cetak Slip Gaji Real-Time ]
  └─ Evaluasi Periode: Apakah Bulan Gaji Masuk Masa Cicilan?
      ├─ YA  ➔ Potongan disuntikkan: "Potongan Pinjaman (Cicilan X/Y)"
      └─ TDK ➔ Bebas Potongan (Tanpa Mengubah Saldo Database)
```

* 🛡️ **Anti-Double Deduction:** Slip gaji tidak menyimpan mutasi statis; pencetakan slip hingga 1000 kali tidak akan mengurangi sisa pinjaman secara keliru.
* 🏷️ **Label Status Transparan:** Menampilkan keterangan urutan angsuran secara eksplisit pada rincian slip gaji pegawai.

---

### 3. ⏱️ Manajemen Presensi, Lembur & Cuti
* **Monitoring Absensi Harian:** Pencatatan waktu masuk dan kepulangan pegawai secara presisi dengan klasifikasi status: *Tepat Waktu*, *Terlambat*, *Sakit*, *Izin*, dan *Alpha*.
* **Anti-Fraud Overtime Validation:** Sistem secara otomatis melakukan validasi silang (*Cross-Validation*) antara jam lembur yang diajukan dengan **Waktu Pulang Aktual** dari mesin absensi. Apabila pegawai pulang sebelum batas lembur berakhir, durasi lembur dipotong secara proporsional.
* **Siklus Cuti Terstruktur:** Formulir pengajuan cuti dua arah (*Request-Verification*) dilengkapi kolom pesan/umpan balik dari HRD.
* **Sinkronisasi Hari Libur Nasional:** Penarikan data kalender merah dan cuti bersama secara otomatis via *API Public Holidays (APIHariLibur_V2)*.

---

### 4. 🖨️ Standardisasi Cetak Dokumen Enterprise (*Smart Reporting*)
Seluruh berkas keluaran (*Print Out*) telah distandarisasi untuk keperluan legalitas, audit, dan arsip formal:

```
┌────────────────────────────────────────────────────────────────────────┐
│  [LOGO]          KLINIK PRATAMA HIDAYATULLAH                           │
│           Jl. A. Yani KM 23 Liang Anggang, Banjarbaru                  │
├────────────────────────────────────────────────────────────────────────┤
│  Nomor : 260819/HRD-KPMH/VIII/2026                                     │
│                                                                        │
│                    LAPORAN / SLIP GAJI RESMI                           │
│                      [ WATERMARK INSTANSI ]                            │
│                                                                        │
│                      (Tabel Rincian Data)                              │
│                                                                        │
│                                           Banjarbaru, 19 Agustus 2026  │
│  Pegawai Yang Bersangkutan,               Mengetahui Pimpinan Klinik,  │
│                                                    [QR-CODE]           │
│                                                Validasi Digital        │
│  ( Nama Pegawai )                         Dr. H. Muhammad Hidayatullah │
└────────────────────────────────────────────────────────────────────────┘
```

#### 📊 Matriks 10 Modul Laporan Resmi:
| No | Nama Dokumen / Laporan | Filter & Fitur Utama | QR Code | Watermark | Nomor Romawi |
| :---: | :--- | :--- | :---: | :---: | :---: |
| 1 | **Slip Gaji Pegawai (ESS)** | Rincian Pendapatan, Potongan Alpha, Cicilan Kasbon | ✅ | ✅ | ✅ |
| 2 | **Slip Gaji Pegawai (Admin)** | Cetak Massal / Perorangan Slip Gaji Karyawan | ✅ | ✅ | ✅ |
| 3 | **Laporan Rekapitulasi Gaji Bulanan** | Rekap Gaji Pokok, Tunjangan, Lembur & Total Netto | ✅ | ✅ | ✅ |
| 4 | **Laporan Gaji Tahunan (*Annual*)** | Komputasi Akumulatif Penggajian 12 Bulan Penuh | ✅ | ✅ | ✅ |
| 5 | **Laporan Rekapitulasi Lembur** | Akumulasi Jam Lembur & Total Uang Lembur Bersih | ✅ | ✅ | ✅ |
| 6 | **Laporan Rekapitulasi Potongan** | Rincian Pemotongan Denda Alpha & Potongan Dinamis | ✅ | ✅ | ✅ |
| 7 | **Laporan Rekapitulasi Absensi** | Statistik Kehadiran, Sakit, Izin, dan Alpha | ✅ | ✅ | ✅ |
| 8 | **Laporan Pengajuan Cuti** | Rekap Permohonan Cuti beserta Status Verifikasi | ✅ | ✅ | ✅ |
| 9 | **Laporan Master Data Pegawai** | Rekapitulasi Direktori Seluruh Pegawai Aktif | ✅ | ✅ | ✅ |
| 10 | **Laporan Master Data Jabatan** | Struktur Skala Upah & Tunjangan Operasional | ✅ | ✅ | ✅ |

---

### 5. 📊 Dashboard Analytics & Interaktivitas UI/UX
* **Kartu KPI Real-Time:** Monitoring cepat jumlah total pegawai aktif, hadir tepat waktu, terlambat, dan sakit/izin hari ini.
* **Grafik Tren Kehadiran (Line Chart):** Analisis histori kehadiran 6 bulan terakhir berbasis Chart.js.
* **Komposisi Pegawai (Doughnut Chart):** Visualisasi proporsi distribusi karyawan berdasarkan posisi jabatan.
* **Widget Hari Libur Terdekat:** Informasi jadwal cuti bersama dan libur nasional terdekat.
* **Persistent Dark Mode:** Pengaturan tema gelap/terang ramah mata dengan status tersimpan permanen di `localStorage`.
* **Live Digital Clock:** Penunjuk jam digital real-time dengan zona waktu lokal (WITA).
* **Mobile-First Responsive Sidebar:** Sidebar otomatis menutup (*auto-collapse*) pada perangkat berlayar kecil (Android/iOS) sehingga konten tidak tertimpa.

---

## 🛡️ Matriks Keamanan & Integritas Data (*Security Hardening*)

| Fitur Keamanan | Implementasi Teknis | Keuntungan |
| :--- | :--- | :--- |
| **Kriptografi Sandi** | `password_hash()` & `password_verify()` via **BCRYPT** | Melindungi kredensial pengguna dari serangan *Rainbow Table* & *Hash Cracking*. |
| **Anti-Bot Defense** | **Google reCAPTCHA v2** pada Halaman Login | Mencegah serangan *Brute-Force Attack* dan otomasi skrip berbahaya. |
| **Proteksi CSRF** | Injeksi Token `security->get_csrf_token_name()` | Menggagalkan manipulasi *Cross-Site Request Forgery* pada seluruh form POST. |
| **Pembersihan XSS** | Global XSS Filtering & `htmlspecialchars()` | Menetralkan injeksi skrip berbahaya (*Cross-Site Scripting*) pada tampilan. |
| **SQL Injection Prevention** | CodeIgniter Active Record & *Parameterized Queries* | Isolasi penuh antara perintah SQL dengan parameter data masukan pengguna. |
| **Sinkronisasi Sesi** | Real-time Session Re-binding on Profile Update | Pembaruan hak akses/identitas pengguna langsung aktif tanpa perlu *re-login*. |
| **Validasi NIK & Jabatan** | Aturan `is_unique` & Custom Callback Update | Mencegah terjadinya duplikasi data master saat proses *create* maupun *update*. |
| **Error Obfuscation** | Penonaktifan `db_debug` pada lingkungan publik | Menghilangkan kebocoran informasi teknis database (*Information Disclosure*). |
| **Anti-Spam Flashdata** | Manipulasi DOM `.remove()` pada SweetAlert2 | Mencegah alert muncul berulang saat refresh (*bfcache browser*). |

---

## 💻 Tumpukan Teknologi (*Technology Stack*)

```
┌─────────────────────────────────────────────────────────────┐
│                       PRESENTATION LAYER                    │
│   HTML5  •  CSS3  •  JavaScript (ES6)  •  Bootstrap 4.6     │
│   SB Admin 2  •  SweetAlert2  •  Chart.js  •  FontAwesome 5 │
├─────────────────────────────────────────────────────────────┤
│                       APPLICATION LAYER                     │
│               PHP 7.4+ / 8.x  •  CodeIgniter 3.1.11         │
│   MVC Architecture  •  REST Client API  •  cURL Engine      │
├─────────────────────────────────────────────────────────────┤
│                          DATA LAYER                         │
│                    MySQL 5.7+ / MariaDB 10.x                │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Struktur Direktori Proyek (*Project Directory Structure*)

```
penggajian/
├── application/
│   ├── config/             # Konfigurasi database, routes, autoload, dll.
│   ├── controllers/
│   │   ├── admin/          # Controller Modul Administrator / HRD
│   │   ├── pegawai/        # Controller Modul Employee Self-Service (ESS)
│   │   └── Login.php       # Autentikasi Login, reCAPTCHA & Sesi
│   ├── models/
│   │   ├── ModelPenggajian.php   # Komputasi Gaji, Lembur, Pinjaman & CRUD
│   │   └── ModelKomponen.php     # Komputasi Tunjangan & Potongan Dinamis
│   └── views/
│       ├── admin/          # Tampilan UI & Form Cetak Administrator
│       ├── pegawai/        # Tampilan UI & Form Cetak Pegawai
│       ├── template_admin/ # Header, Sidebar, Topbar & Footer Admin
│       └── template_pegawai/# Header, Sidebar, Topbar & Footer Pegawai
├── assets/
│   ├── css/                # Stylesheet kustom & Dark Mode CSS
│   ├── img/                # Aset logo instansi, watermark, & QR Code dummy
│   ├── js/                 # Skrip logika Chart, Live Clock, & SweetAlert2
│   └── vendor/             # Bootstrap, FontAwesome, DataTables, ChartJS
├── db database/            # Berkas migrasi database SQL (penggajian.sql)
└── README.md               # Dokumentasi Proyek
```

---

## ⚡ Panduan Instalasi & Menjalankan Sistem (*Installation Guide*)

### 1. Prasyarat Lingkungan (*Prerequisites*)
* Web Server (Apache via **XAMPP**, **Laragon**, atau **WampServer**)
* PHP versi **7.4** s/d **8.2**
* Database Server **MySQL** / **MariaDB**
* Web Browser Modern (Google Chrome, Mozilla Firefox, Microsoft Edge)

### 2. Langkah-Langkah Setup

1. **Kloning Repositori:**
   ```bash
   cd c:/xampp/htdocs/
   git clone https://github.com/NorisukiNZk/penggajian.git
   ```

2. **Inisialisasi Basis Data:**
   * Buka browser dan navigasikan ke `http://localhost/phpmyadmin`.
   * Buat database baru bernama `penggajian`.
   * Pilih menu **Import**, lalu pilih berkas `db database/penggajian.sql` dan klik **Go**.

3. **Konfigurasi Koneksi Database:**
   * Buka berkas `application/config/database.php` menggunakan teks editor.
   * Sesuaikan kredensial server lokal Anda:
     ```php
     'hostname' => 'localhost',
     'username' => 'root',
     'password' => '',
     'database' => 'penggajian',
     ```

4. **Konfigurasi Base URL:**
   * Buka berkas `application/config/config.php`.
   * Pastikan direktori *Base URL* telah sesuai:
     ```php
     $config['base_url'] = 'http://localhost/penggajian/';
     ```

5. **Akses Aplikasi:**
   * Buka browser dan akses: `http://localhost/penggajian/`

---

## 🔑 Kredensial Pengujian Bawaan (*Default Accounts*)

| Hak Akses / Role | Username | Password Default | Target Halaman Dasbor |
| :--- | :--- | :--- | :--- |
| **Administrator (HRD)** | `admin` | `admin` | `/admin/dashboard` |
| **Pegawai (Contoh)** | `pegawai` *(atau NIK)* | `123456` *(atau sesuai DB)* | `/pegawai/dashboard` |

> ℹ️ *Catatan: Untuk pengujian verifikasi reCAPTCHA di server localhost, sistem secara otomatis menggunakan Google Test Keys yang selalu valid.*

---

## 👨‍💻 Hak Cipta & Pengembang (*Credits*)

<div align="center">

  Dibuat dan Didedikasikan untuk **Tugas Akhir / Skripsi Bidang Teknologi Informasi**.<br>
  *Implementasi Nyata Sistem Informasi Penggajian & Kepegawaian pada Klinik Pratama Dr. H.M. Hidayatullah.*

  <br>

  **&copy; 2026 NorisukiNZk &bull; All Rights Reserved**

</div>
