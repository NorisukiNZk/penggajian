# Diagram Konteks Sistem Informasi Penggajian

Berikut adalah *source code* Mermaid untuk diagram konteks aplikasi (DFD Level 0). Anda dapat menggunakan diagram ini di editor Markdown yang mendukung Mermaid (seperti VS Code, Typora, Obsidian) atau menyalin kode di bawah ini ke situs [Mermaid Live Editor](https://mermaid.live/) untuk mengekspornya menjadi format JPG/PNG beresolusi tinggi untuk keperluan naskah skripsi Anda.

```mermaid
graph LR
    Admin["Admin / HRD"]
    Pegawai["Pegawai"]
    Pimpinan["Pimpinan Klinik"]

    Sistem(("0<br>Sistem Informasi<br>Kepegawaian &<br>Penggajian"))

    %% Aliran dari Admin ke Sistem
    Admin -- "1. Data Pegawai, Jabatan, Komponen Gaji<br>2. Validasi Cuti & Lembur" --> Sistem
    
    %% Aliran dari Sistem ke Admin
    Sistem -- "1. Laporan Gaji & Absensi<br>2. Data Pengajuan Pegawai" --> Admin

    %% Aliran dari Pegawai ke Sistem
    Pegawai -- "1. Data Absensi<br>2. Pengajuan Cuti & Lembur" --> Sistem
    
    %% Aliran dari Sistem ke Pegawai
    Sistem -- "1. Slip Gaji<br>2. Status Cuti & Lembur" --> Pegawai

    %% Aliran dari Sistem ke Pimpinan
    Sistem -- "1. Laporan Penggajian<br>2. Laporan Absensi & Cuti" --> Pimpinan

    classDef process fill:#ffffff,stroke:#000000,stroke-width:2px
    classDef entity fill:#f0f0f0,stroke:#000000,stroke-width:2px
    
    class Admin,Pegawai,Pimpinan entity
    class Sistem process
```
