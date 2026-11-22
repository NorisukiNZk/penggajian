-- Migrasi Hardening Keamanan & Audit Trail HRIS Klinik Pratama Dr. H.M. Hidayatullah
-- Aman dijalankan berulang (idempotent) pada database penggajian yang sudah berjalan.

CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aktor_id` int(11) DEFAULT NULL,
  `aktor_nama` varchar(120) NOT NULL DEFAULT 'System',
  `hak_akses` varchar(20) NOT NULL DEFAULT 'guest',
  `modul` varchar(60) NOT NULL,
  `aksi` varchar(60) NOT NULL,
  `target_id` varchar(64) DEFAULT NULL,
  `ringkasan` varchar(255) NOT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0.0.0.0',
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_audit_modul` (`modul`),
  KEY `idx_audit_aktor` (`aktor_id`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(120) NOT NULL DEFAULT '',
  `is_success` tinyint(1) NOT NULL DEFAULT 0,
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_login_ip_time` (`ip_address`,`attempted_at`),
  KEY `idx_login_user_time` (`username`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
