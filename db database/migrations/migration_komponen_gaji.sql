-- =====================================================
-- Migration: Komponen Tunjangan & Potongan Dinamis
-- Database: penggajian
-- Date: 2026-08-07
-- =====================================================

-- Hapus tabel lama jika ada (dari percobaan sebelumnya)
DROP TABLE IF EXISTS `komponen_gaji_pegawai`;
DROP TABLE IF EXISTS `komponen_gaji`;

-- --------------------------------------------------------
-- Tabel `komponen_gaji`
-- --------------------------------------------------------

CREATE TABLE `komponen_gaji` (
  `id_komponen` int(11) NOT NULL AUTO_INCREMENT,
  `nama_komponen` varchar(100) NOT NULL,
  `tipe` enum('tunjangan','potongan') NOT NULL,
  `nominal` int(11) NOT NULL DEFAULT 0,
  `is_persentase` tinyint(1) NOT NULL DEFAULT 0,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_komponen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabel `komponen_gaji_pegawai`
-- --------------------------------------------------------

CREATE TABLE `komponen_gaji_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_komponen` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `bulan` varchar(6) NOT NULL,
  `nominal_override` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_komponen` (`id_komponen`),
  KEY `idx_nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Awal (Contoh)
-- --------------------------------------------------------

INSERT INTO `komponen_gaji` (`nama_komponen`, `tipe`, `nominal`, `is_persentase`, `is_aktif`) VALUES
('BPJS Kesehatan', 'potongan', 150000, 0, 1),
('BPJS Ketenagakerjaan', 'potongan', 100000, 0, 1),
('Tunjangan Hari Raya (THR)', 'tunjangan', 100, 1, 0),
('Tunjangan Kesehatan', 'tunjangan', 200000, 0, 1);
