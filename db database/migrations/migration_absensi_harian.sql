-- =====================================================
-- Migration: Sistem Absensi Digital Real-Time
-- Database: penggajian
-- =====================================================

-- Hapus tabel lama jika ada (dari percobaan sebelumnya)
DROP TABLE IF EXISTS `absensi_harian`;
DROP TABLE IF EXISTS `setting_absensi`;

-- --------------------------------------------------------
-- Tabel `setting_absensi`
-- Aturan jam kerja (bisa diubah admin)
-- --------------------------------------------------------

CREATE TABLE `setting_absensi` (
  `id` int(11) NOT NULL DEFAULT 1,
  `jam_masuk` time NOT NULL DEFAULT '08:00:00',
  `toleransi_menit` int(11) NOT NULL DEFAULT 15,
  `jam_pulang` time NOT NULL DEFAULT '17:00:00',
  `batas_terlambat_berat` time NOT NULL DEFAULT '09:00:00',
  `maks_terlambat_jadi_alpha` int(11) NOT NULL DEFAULT 3,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default setting
INSERT INTO `setting_absensi` (`id`, `jam_masuk`, `toleransi_menit`, `jam_pulang`, `batas_terlambat_berat`, `maks_terlambat_jadi_alpha`) VALUES
(1, '08:00:00', 15, '17:00:00', '09:00:00', 3);

-- --------------------------------------------------------
-- Tabel `absensi_harian`
-- Catatan absensi harian per pegawai
-- --------------------------------------------------------

CREATE TABLE `absensi_harian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status` enum('tepat_waktu','terlambat','alpha','sakit','izin') NOT NULL DEFAULT 'alpha',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_nik_tanggal` (`nik`, `tanggal`),
  KEY `idx_nik` (`nik`),
  KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
