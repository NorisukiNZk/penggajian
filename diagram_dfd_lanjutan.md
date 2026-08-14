# Kumpulan Data Flow Diagram (DFD)

Berikut adalah _source code_ Mermaid untuk **DFD Level 1**, **DFD Level 2 (Fokus Admin)**, dan **DFD Level 3 (Fokus Pegawai)**. Anda dapat me-_copy-paste_ masing-masing kode blok ini ke [Mermaid Live Editor](https://mermaid.live/) seperti sebelumnya untuk mengubahnya menjadi gambar.

---

## 1. DFD Level 1 (Diagram Utama)
Menjabarkan proses-proses utama di dalam sistem. Terdapat 5 proses utama: Kelola Data Master, Proses Absensi & Lembur, Proses Cuti, Proses Penggajian, dan Pembuatan Laporan.

```mermaid
graph TD
    Admin["Admin / HRD"]
    Pegawai["Pegawai"]
    Pimpinan["Pimpinan Klinik"]

    P1(("1.0<br>Kelola Data<br>Master"))
    P2(("2.0<br>Proses<br>Absensi & Lembur"))
    P3(("3.0<br>Proses<br>Cuti"))
    P4(("4.0<br>Proses<br>Penggajian"))
    P5(("5.0<br>Pembuatan<br>Laporan"))

    D1[("D1 Pegawai")]
    D2[("D2 Jabatan")]
    D3[("D3 Absensi")]
    D4[("D4 Cuti")]
    D5[("D5 Lembur")]
    D6[("D6 Gaji")]

    Admin -- "Data Pegawai, Jabatan" --> P1
    P1 -- "Info Master" --> Admin
    P1 --> D1
    P1 --> D2

    Pegawai -- "Data Kehadiran" --> P2
    Pegawai -- "Pengajuan Lembur" --> P2
    Admin -- "Validasi Lembur" --> P2
    P2 --> D3
    P2 --> D5

    Pegawai -- "Pengajuan Cuti" --> P3
    Admin -- "Validasi Cuti" --> P3
    P3 --> D4
    P3 -- "Notifikasi Cuti" --> Pegawai

    Admin -- "Data Potongan/Tunjangan" --> P4
    D1 --> P4
    D2 --> P4
    D3 --> P4
    D5 --> P4
    P4 --> D6
    P4 -- "Slip Gaji" --> Pegawai

    Admin -- "Request Laporan" --> P5
    Pimpinan -- "Request Laporan" --> P5
    D6 --> P5
    D3 --> P5
    D4 --> P5
    P5 -- "Lap. Gaji & Absensi" --> Admin
    P5 -- "Lap. Gaji Tahunan" --> Pimpinan

    classDef process fill:#ffffff,stroke:#000000,stroke-width:2px
    classDef entity fill:#f0f0f0,stroke:#000000,stroke-width:2px
    classDef store fill:#ffffff,stroke:#000000,stroke-width:2px

    class Admin,Pegawai,Pimpinan entity
    class P1,P2,P3,P4,P5 process
    class D1,D2,D3,D4,D5,D6 store
```

---

## 2. DFD Level 2 (Fokus Admin)
Memecah/menjabarkan proses `1.0 Kelola Data Master` dan proses `4.0 Proses Penggajian` menjadi aktivitas yang lebih detail dari sisi Admin HRD.

```mermaid
graph TD
    Admin["Admin / HRD"]

    P11(("1.1<br>Kelola<br>Data Pegawai"))
    P12(("1.2<br>Kelola<br>Data Jabatan"))
    P41(("4.1<br>Kalkulasi Gaji<br>& Potongan"))
    P42(("4.2<br>Cetak Slip<br>& Cetak QR"))

    D1[("D1 Pegawai")]
    D2[("D2 Jabatan")]
    D3[("D3 Absensi")]
    D6[("D6 Gaji")]

    Admin -- "Data Pegawai (CRUD)" --> P11
    P11 --> D1
    
    Admin -- "Data Jabatan (CRUD)" --> P12
    P12 --> D2

    Admin -- "T-Potongan / Set Gaji" --> P41
    D1 --> P41
    D2 --> P41
    D3 --> P41
    P41 --> D6

    Admin -- "Request Cetak" --> P42
    D6 --> P42
    P42 -- "File Slip Gaji" --> Admin

    classDef process fill:#ffffff,stroke:#000000,stroke-width:2px
    classDef entity fill:#f0f0f0,stroke:#000000,stroke-width:2px
    classDef store fill:#ffffff,stroke:#000000,stroke-width:2px

    class Admin entity
    class P11,P12,P41,P42 process
    class D1,D2,D3,D6 store
```

---

## 3. DFD Level 3 (Fokus Pegawai)
Memecah/menjabarkan proses `2.0 Absensi` dan `3.0 Cuti` menjadi aktivitas yang lebih detail dari sisi Pegawai. Secara penamaan akademis ini biasanya disebut DFD Level 2 untuk Proses 2.0 & 3.0, namun kita beri label sesuai konteks Pegawai.

```mermaid
graph TD
    Pegawai["Pegawai"]
    Admin["Admin (Validasi)"]

    P21(("2.1<br>Input<br>Absensi"))
    P22(("2.2<br>Pengajuan<br>Lembur"))
    P31(("3.1<br>Pengajuan<br>Cuti"))
    P32(("3.2<br>Cek Status<br>& Riwayat"))

    D3[("D3 Absensi")]
    D4[("D4 Cuti")]
    D5[("D5 Lembur")]

    Pegawai -- "Scan / Input Kehadiran" --> P21
    P21 --> D3

    Pegawai -- "Form Lembur" --> P22
    P22 --> D5
    Admin -- "Status Validasi Lembur" --> P22

    Pegawai -- "Form Cuti" --> P31
    P31 --> D4
    Admin -- "Status Validasi Cuti" --> P31

    Pegawai -- "Request Riwayat" --> P32
    D3 --> P32
    D4 --> P32
    D5 --> P32
    P32 -- "Notifikasi & Info" --> Pegawai

    classDef process fill:#ffffff,stroke:#000000,stroke-width:2px
    classDef entity fill:#f0f0f0,stroke:#000000,stroke-width:2px
    classDef store fill:#ffffff,stroke:#000000,stroke-width:2px

    class Pegawai,Admin entity
    class P21,P22,P31,P32 process
    class D3,D4,D5 store
```
