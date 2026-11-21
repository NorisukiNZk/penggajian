-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: penggajian
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `penggajian`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `penggajian` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `penggajian`;

--
-- Table structure for table `absensi_harian`
--

DROP TABLE IF EXISTS `absensi_harian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `absensi_harian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status` enum('tepat_waktu','terlambat','alpha','sakit','izin') NOT NULL DEFAULT 'alpha',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_nik_tanggal` (`nik`,`tanggal`),
  KEY `idx_nik` (`nik`),
  KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi_harian`
--

LOCK TABLES `absensi_harian` WRITE;
/*!40000 ALTER TABLE `absensi_harian` DISABLE KEYS */;
INSERT INTO `absensi_harian` VALUES (1,'76788','2026-08-07','11:44:30','11:44:34','terlambat','Terlambat berat | Pulang awal','2026-08-07 09:44:30'),(2,'76788','2026-08-15','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(3,'76788','2026-08-16','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(4,'76788','2026-08-17','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(5,'76788','2026-08-18','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(6,'76788','2026-08-19','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(7,'76788','2026-08-20','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(8,'76788','2026-08-21','00:00:00','00:00:00','izin','Cuti: as','2026-08-07 11:54:48'),(9,'87667','2026-08-07','16:32:26','16:32:39','terlambat','Terlambat berat | Pulang awal','2026-08-07 14:32:26'),(10,'6778','2026-08-07','16:35:53','16:37:25','terlambat','Terlambat berat | Pulang awal','2026-08-07 14:35:53'),(11,'87789','2026-08-07','21:40:07','21:40:35','terlambat','Terlambat berat','2026-08-07 14:40:07'),(12,'76788','2026-08-08','08:59:52','10:02:45','terlambat','Terlambat 45 menit | Pulang awal','2026-08-08 01:59:52'),(13,'87667','2026-08-08','11:08:36','11:09:45','terlambat','Terlambat berat | Pulang awal','2026-08-08 03:08:36'),(14,'87667','2026-08-09','00:00:00','00:00:00','sakit','Cuti: es Tross','2026-08-08 03:10:57'),(15,'87667','2026-08-10','00:00:00','00:00:00','sakit','Cuti: es Tross','2026-08-08 03:10:57'),(16,'76788','2026-08-09','11:55:16',NULL,'terlambat','Terlambat 221 menit','2026-08-09 03:55:16'),(17,'986662','2026-08-09','12:02:52',NULL,'alpha','Terlambat Fatal (Otomatis Alpha)','2026-08-09 04:02:52'),(18,'76788','2026-08-10','08:25:01','16:59:04','terlambat','Terlambat 11 menit | Pulang awal','2026-08-10 00:25:01'),(19,'87667','2026-08-15','00:00:00','00:00:00','sakit','Cuti: Radang Tenggorokan','2026-08-14 01:26:25'),(20,'87667','2026-08-16','00:00:00','00:00:00','sakit','Cuti: Radang Tenggorokan','2026-08-14 01:26:25'),(21,'76788','2026-08-25','09:14:18',NULL,'terlambat','Terlambat 60 menit','2026-08-25 01:14:18'),(22,'76788','2026-08-28','00:00:00','00:00:00','sakit','Cuti: Pusing','2026-08-27 03:08:31'),(23,'76788','2026-08-29','00:00:00','00:00:00','sakit','Cuti: Pusing','2026-08-27 03:08:31'),(24,'76788','2026-08-30','00:00:00','00:00:00','sakit','Cuti: Pusing','2026-08-27 03:08:31'),(25,'76788','2026-09-08','08:07:00','19:31:17','tepat_waktu','','2026-09-08 00:07:00'),(26,'76788','2026-09-15','00:00:00','00:00:00','izin','Cuti (Tahunan): Keperluan keluarga di luar kota','2026-09-08 04:26:47'),(27,'76788','2026-09-16','00:00:00','00:00:00','izin','Cuti (Tahunan): Keperluan keluarga di luar kota','2026-09-08 04:26:47'),(28,'76788','2026-09-17','00:00:00','00:00:00','izin','Cuti (Tahunan): Keperluan keluarga di luar kota','2026-09-08 04:26:47'),(29,'76788','2026-09-18','00:00:00','00:00:00','izin','Cuti (Tahunan): Keperluan keluarga di luar kota','2026-09-08 04:26:47'),(30,'87667','2026-09-10','00:00:00','00:00:00','sakit','Cuti Sah (Sakit): berak muntaber','2026-09-08 14:42:17'),(31,'87667','2026-09-11','00:00:00','00:00:00','sakit','Cuti Sah (Sakit): berak muntaber','2026-09-08 14:42:17'),(32,'87667','2026-09-12','00:00:00','00:00:00','sakit','Cuti Sah (Sakit): berak muntaber','2026-09-08 14:42:17'),(33,'76788','2026-09-11','09:12:44',NULL,'tepat_waktu','','2026-09-11 01:12:44');
/*!40000 ALTER TABLE `absensi_harian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_log`
--

DROP TABLE IF EXISTS `audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_log` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_log`
--

LOCK TABLES `audit_log` WRITE;
/*!40000 ALTER TABLE `audit_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_cuti`
--

DROP TABLE IF EXISTS `data_cuti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_cuti` (
  `id_cuti` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jenis_cuti` varchar(50) NOT NULL,
  `alasan` text NOT NULL,
  `nik_pengganti` varchar(50) DEFAULT NULL,
  `tugas_pengganti` text DEFAULT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `kontak_darurat` varchar(30) DEFAULT NULL,
  `alamat_cuti` text DEFAULT NULL,
  `status_cuti` varchar(50) NOT NULL DEFAULT 'Menunggu',
  `status_approval` varchar(50) DEFAULT 'Menunggu Review HRD',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pesan_admin` text DEFAULT NULL,
  `catatan_hrd` text DEFAULT NULL,
  PRIMARY KEY (`id_cuti`),
  KEY `idx_cuti_nik` (`nik`),
  KEY `idx_cuti_status` (`status_cuti`),
  KEY `idx_cuti_tgl_mulai` (`tanggal_mulai`),
  KEY `idx_cuti_pengganti` (`nik_pengganti`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_cuti`
--

LOCK TABLES `data_cuti` WRITE;
/*!40000 ALTER TABLE `data_cuti` DISABLE KEYS */;
INSERT INTO `data_cuti` VALUES (1,'76788','2026-08-08','2026-08-09','Sakit','Capek wok',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-08-07 11:50:05',NULL,NULL),(2,'76788','2026-08-15','2026-08-21','Tahunan','as',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-08-07 11:54:28',NULL,NULL),(3,'76788','2026-08-30','2026-08-31','Melahirkan','ds',NULL,NULL,NULL,NULL,NULL,'Ditolak','Ditolak','2026-08-07 12:48:27','masih ada jadwal cuti di bulan lain',NULL),(4,'76788','2026-09-07','2026-09-08','Tahunan','ads',NULL,NULL,NULL,NULL,NULL,'Ditolak','Ditolak','2026-08-07 12:55:00','banyak cuti lu',NULL),(5,'87667','2026-08-09','2026-08-10','Sakit','es Tross',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-08-08 03:09:01','yayaya saya setuju',NULL),(6,'87667','2026-08-15','2026-08-16','Sakit','Radang Tenggorokan',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-08-14 01:24:19','Baik',NULL),(7,'87667','2026-08-17','2026-08-18','Sakit','Bronkitis',NULL,NULL,NULL,NULL,NULL,'Ditolak','Ditolak','2026-08-14 01:25:59','Masih bisa itu',NULL),(8,'76788','2026-08-28','2026-08-30','Sakit','Pusing',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-08-27 03:07:49','boleh ',NULL),(9,'76788','2026-09-15','2026-09-18','Tahunan','Keperluan keluarga di luar kota',NULL,NULL,NULL,NULL,NULL,'Disetujui','Disetujui Direktur','2026-09-08 04:24:33','Selamat berlibur, pastikan operasional apotek aman.',NULL),(10,'87667','2026-09-10','2026-09-12','Sakit','berak muntaber','76788','cek darah orang','skd_87667_1788878467.png','0876786667','banjarbaru','Disetujui','Disetujui Direktur','2026-09-08 14:41:07','Disetujui sah oleh Direktur Utama & Manajemen HRD.','');
/*!40000 ALTER TABLE `data_cuti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_jabatan`
--

DROP TABLE IF EXISTS `data_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(120) NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL,
  `tj_transport` varchar(50) NOT NULL,
  `uang_makan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_jabatan`
--

LOCK TABLES `data_jabatan` WRITE;
/*!40000 ALTER TABLE `data_jabatan` DISABLE KEYS */;
INSERT INTO `data_jabatan` VALUES (1,'Dokter','4000000','600000','400000'),(2,'Apoteker','2500000','300000','200000'),(3,'Admin','2200000','300000','200000'),(4,'Perawat','2500000','300000','200000'),(5,'Perawat Senior','3000000','500000','300000'),(6,'Asisten Apoteker','1500000','200000','200000'),(7,'Dokter Pengganti','1500000','300000','120000'),(10,'Direktur','6000000','800000','500000');
/*!40000 ALTER TABLE `data_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_kehadiran`
--

DROP TABLE IF EXISTS `data_kehadiran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_kehadiran` (
  `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(15) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `hadir` int(11) NOT NULL,
  `sakit` int(11) NOT NULL,
  `alpha` int(11) NOT NULL,
  PRIMARY KEY (`id_kehadiran`),
  KEY `idx_kehadiran_nik` (`nik`),
  KEY `idx_kehadiran_bulan` (`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_kehadiran`
--

LOCK TABLES `data_kehadiran` WRITE;
/*!40000 ALTER TABLE `data_kehadiran` DISABLE KEYS */;
INSERT INTO `data_kehadiran` VALUES (5,'022025','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,0),(8,'012025','896676','Muhammad Waffa','Laki-Laki','Admin',30,0,0),(11,'032025','7678923','Moona Hoshinova','Perempuan','Sales',0,0,0),(12,'032025','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,0),(13,'022025','7678923','Moona Hoshinova','Perempuan','Sales',20,5,3),(14,'022025','76788','Anya Melfisa','Perempuan','Apoteker',20,5,3),(15,'022025','6778','Melisa Yuresha','Perempuan','Perawat',15,5,8),(16,'022025','87667','Rizky Hara','Laki-Laki','Dokter',28,0,0),(17,'012020','76788','Anya Melfisa','Perempuan','Apoteker',30,0,0),(18,'012020','6778','Melisa Yuresha','Perempuan','Perawat',25,5,5),(19,'012020','896676','Muhammad Waffa','Laki-Laki','Admin',15,10,5),(20,'012020','87667','Rizky Hara','Laki-Laki','Dokter',5,0,0),(21,'022025','10000001','Admin1','Perempuan','Admin',20,8,0),(22,'022025','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',25,3,0),(23,'022025','2123112312','Hana Yureka Auditore','Perempuan','Dokter',28,0,0),(24,'022025','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',28,0,0),(25,'022025','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',15,5,8),(26,'022025','87789','Tiara Puteri','Perempuan','Asisten Apoteker',1,27,0),(27,'032025','10000001','Admin1','Perempuan','Admin',30,0,0),(28,'032025','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,30,0),(29,'032025','76788','Anya Melfisa','Perempuan','Apoteker',0,0,0),(30,'032025','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,30),(31,'032025','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',25,5,0),(32,'032025','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',20,5,5),(33,'032025','6778','Melisa Yuresha','Perempuan','Perawat',15,5,10),(34,'032025','87667','Rizky Hara','Laki-Laki','Dokter',30,0,0),(35,'032025','87789','Tiara Puteri','Perempuan','Asisten Apoteker',30,0,0),(36,'022025','677766','Dhea Rahayu','Perempuan','Perawat',15,5,10),(37,'022025','6388927742','Selfia Rizky','Perempuan','Perawat Senior',20,5,5),(38,'082026','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,24),(39,'082026','76788','Anya Melfisa','Perempuan','Apoteker',4,0,14),(40,'082026','87667','Rizky Hara','Laki-Laki','Dokter',2,2,20),(41,'082026','6778','Melisa Yuresha','Perempuan','Perawat',1,0,23),(42,'082026','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,24),(43,'082026','10000001','Admin1','Perempuan','Admin',0,0,24),(44,'082026','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,0,24),(45,'082026','87789','Tiara Puteri','Perempuan','Asisten Apoteker',1,0,23),(46,'082026','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',0,0,24),(47,'082026','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',0,0,24),(48,'082026','6388927742','Selfia Rizky','Perempuan','Perawat Senior',0,0,24),(49,'082026','677766','Dhea Rahayu','Perempuan','Perawat',0,0,24),(50,'082026','001233','Supa Nika','Laki-Laki','Admin',0,0,24),(51,'092026','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,25),(52,'092026','76788','Anya Melfisa','Perempuan','Apoteker',2,0,19),(53,'092026','87667','Rizky Hara','Laki-Laki','Dokter',0,3,22),(54,'092026','6778','Melisa Yuresha','Perempuan','Perawat',0,0,25),(55,'092026','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,25),(56,'092026','10000001','Admin1','Perempuan','Admin',0,0,25),(57,'092026','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,0,25),(58,'092026','87789','Tiara Puteri','Perempuan','Asisten Apoteker',0,0,25),(59,'092026','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',0,0,25),(60,'092026','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',0,0,25),(61,'092026','6388927742','Selfia Rizky','Perempuan','Perawat Senior',0,0,25),(62,'092026','677766','Dhea Rahayu','Perempuan','Perawat',0,0,25),(63,'102026','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,1),(64,'102026','76788','Anya Melfisa','Perempuan','Apoteker',0,0,1),(65,'102026','87667','Rizky Hara','Laki-Laki','Dokter',0,0,1),(66,'102026','6778','Melisa Yuresha','Perempuan','Perawat',0,0,1),(67,'102026','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,1),(68,'102026','10000001','Admin1','Perempuan','Admin',0,0,1),(69,'102026','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,0,1),(70,'102026','87789','Tiara Puteri','Perempuan','Asisten Apoteker',0,0,1),(71,'102026','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',0,0,1),(72,'102026','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',0,0,1),(73,'102026','6388927742','Selfia Rizky','Perempuan','Perawat Senior',0,0,1),(74,'102026','677766','Dhea Rahayu','Perempuan','Perawat',0,0,1),(75,'122026','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,0),(76,'122026','76788','Anya Melfisa','Perempuan','Apoteker',0,0,0),(77,'122026','87667','Rizky Hara','Laki-Laki','Dokter',0,0,0),(78,'122026','6778','Melisa Yuresha','Perempuan','Perawat',0,0,0),(79,'122026','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,0),(80,'122026','10000001','Admin1','Perempuan','Admin',0,0,0),(81,'122026','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,0,0),(82,'122026','87789','Tiara Puteri','Perempuan','Asisten Apoteker',0,0,0),(83,'122026','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',0,0,0),(84,'122026','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',0,0,0),(85,'122026','6388927742','Selfia Rizky','Perempuan','Perawat Senior',0,0,0),(86,'122026','677766','Dhea Rahayu','Perempuan','Perawat',0,0,0),(87,'112026','896676','Muhammad Waffa','Laki-Laki','Admin',0,0,18),(88,'112026','76788','Anya Melfisa','Perempuan','Apoteker',0,0,18),(89,'112026','87667','Rizky Hara','Laki-Laki','Dokter',0,0,18),(90,'112026','6778','Melisa Yuresha','Perempuan','Perawat',0,0,18),(91,'112026','2123112312','Hana Yureka Auditore','Perempuan','Dokter',0,0,18),(92,'112026','10000001','Admin1','Perempuan','Admin',0,0,18),(93,'112026','986662','Andika Saputro','Laki-Laki','Dokter Pengganti',0,0,18),(94,'112026','87789','Tiara Puteri','Perempuan','Asisten Apoteker',0,0,18),(95,'112026','78665','Melfisa Hanifah Sukamara','Perempuan','Dokter Pengganti',0,0,18),(96,'112026','128823','Junaidi Hafiz','Laki-Laki','Perawat Senior',0,0,18),(97,'112026','6388927742','Selfia Rizky','Perempuan','Perawat Senior',0,0,18),(98,'112026','677766','Dhea Rahayu','Perempuan','Perawat',0,0,18),(99,'112026','198001010001','dr. H.M. Hidayatullah','Laki-Laki','Direktur',0,0,18);
/*!40000 ALTER TABLE `data_kehadiran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_lembur`
--

DROP TABLE IF EXISTS `data_lembur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_lembur` (
  `id_lembur` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) NOT NULL,
  `tanggal_lembur` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `durasi_jam` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  PRIMARY KEY (`id_lembur`),
  KEY `idx_lembur_nik` (`nik`),
  KEY `idx_lembur_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_lembur`
--

LOCK TABLES `data_lembur` WRITE;
/*!40000 ALTER TABLE `data_lembur` DISABLE KEYS */;
INSERT INTO `data_lembur` VALUES (1,'76788','2026-08-10','16:40:00','22:37:00',6,'lembur','Disetujui'),(2,'87667','2026-08-13','16:53:00','21:53:00',5,'Kerja Rodi','Ditolak'),(3,'76788','2026-08-13','17:38:00','22:42:00',5,'Ada kerjaan tambahan','Disetujui'),(4,'76788','2026-08-15','17:34:00','21:34:00',4,'Banyak Pasien','Disetujui'),(5,'76788','2026-09-02','18:10:00','11:10:00',17,'Ada kerjaan mendadak','Disetujui');
/*!40000 ALTER TABLE `data_lembur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pegawai`
--

DROP TABLE IF EXISTS `data_pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `hak_akses` int(11) NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `idx_nik_unique` (`nik`),
  KEY `idx_pegawai_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pegawai`
--

LOCK TABLES `data_pegawai` WRITE;
/*!40000 ALTER TABLE `data_pegawai` DISABLE KEYS */;
INSERT INTO `data_pegawai` VALUES (3,'896676','Muhammad Waffa','waffa','$2y$10$qP74IL9jTi61IiK8uI4sb.CXY9Zpi4bYN48iQkypod0kQP2xa5fUa','Laki-Laki','Admin','2024-10-01','Karyawan Tetap','pegawai-250210-adbf1afbf1.jpg',1),(5,'76788','Anya Melfisa','anya','$2y$10$ZQgIW2A5PXjmdfAuqlmX0utaTmmFPgPGeQfsw1TLEYxIh3oolgCy6','Perempuan','Apoteker','2025-02-08','Karyawan Tetap','pegawai-250208-6ec3bdfec3.jpg',2),(6,'87667','Rizky Hara','hara','$2y$10$vfSBLb49moj74OJknjtVkuoNWghGHYo/tDOBvrj0MGpOIDBPrw4yi','Laki-Laki','Dokter','2025-02-08','Karyawan Tetap','pegawai-250208-8ced01677c.png',2),(7,'6778','Melisa Yuresha','melisa','$2y$10$qzecZdeXEAhN1N2zhREh2.der3j3zOJkIUTSQWPddqjYAVH/vAAOK','Perempuan','Perawat','2025-02-08','Karyawan Tidak Tetap','pegawai-250208-54db48de4f.png',2),(8,'2123112312','Hana Yureka Auditore','hana','$2y$10$SomwZb8xusxISiZy1hLjeOEs4Z.5Mg07SgG7Qo20keUnqoaWP8VeS','Perempuan','Dokter','2025-02-10','Karyawan Tetap','pegawai-250210-77155dea05.jpg',1),(9,'10000001','Admin1','admin1','$2y$10$R0CpDLofYfV1hgYq5kHFA.sOo8KRWkjrDEeqL/7dXt3NpcQObu/Oq','Perempuan','Admin','2025-02-10','Karyawan Tetap','pegawai-250210-59d1b4d95b.jpg',1),(10,'986662','Andika Saputro','andika','$2y$10$qt/5O8EIPx5BwGvyP9tOaOppzOP69B2ey8ywdY4bRjNT.J2lXdJ0u','Laki-Laki','Dokter Pengganti','2025-02-11','Karyawan Tidak Tetap','pegawai-250211-20fd0172ef.png',2),(11,'87789','Tiara Puteri','tiara','$2y$10$eSF6YV7DzgZwjt9LmHWDx.baRM.PbX2lh80R92cXXLa.vuOIfLc0u','Perempuan','Asisten Apoteker','2025-02-11','Karyawan Tidak Tetap','pegawai-250211-ac4d3b89bf.jpg',2),(12,'78665','Melfisa Hanifah Sukamara','melfisa','f27a788aa42eb87a1cf854982db3cd0e','Perempuan','Dokter Pengganti','2025-02-01','Karyawan Tetap','',2),(13,'128823','Junaidi Hafiz','junaidi','$2y$10$zvQXxxihRZ2bPZqTvIcuZeXHAbmdiRha3u8YzF2UDdQzmS/o8iO0S','Laki-Laki','Perawat Senior','2025-01-09','Karyawan Tidak Tetap','pegawai-250211-00f9d2ed8d.png',2),(14,'6388927742','Selfia Rizky','selfia','$2y$10$MS5P55bIcIi40x1pfqt2KehLe2S/Shf.sE/p6ojN8bkjyy8W7nKwO','Perempuan','Perawat Senior','2025-02-19','Karyawan Tetap','pegawai-250220-1166bfbe84.jpg',2),(15,'677766','Dhea Rahayu','dhea','1c1d655f0a880b9a577db312cf702e2a','Perempuan','Perawat','2025-02-20','Karyawan Tetap','pegawai-250220-a8fcc6c9c0.jpg',2),(18,'198001010001','dr. H.M. Hidayatullah','pimpinan','$2y$10$vfHgI4t1l/FrRWq/rDI/C.qW2wuTPTWgpewZQautkq01srsuk0MEK','Laki-Laki','Direktur','2020-01-01','Karyawan Tetap','kpmh.jpg',3);
/*!40000 ALTER TABLE `data_pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_pinjaman`
--

DROP TABLE IF EXISTS `data_pinjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_pinjaman` (
  `id_pinjaman` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `jumlah_pinjaman` int(11) DEFAULT NULL,
  `tenor_bulan` int(11) DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_jaminan` varchar(255) DEFAULT NULL,
  `kontak_darurat_nama` varchar(100) DEFAULT NULL,
  `kontak_darurat_hp` varchar(30) DEFAULT NULL,
  `kontak_darurat_hubungan` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `tgl_disetujui` date DEFAULT NULL,
  `pesan_admin` text DEFAULT NULL,
  `sisa_tenor` int(11) DEFAULT 0,
  PRIMARY KEY (`id_pinjaman`),
  KEY `idx_pinjaman_nik` (`nik`),
  KEY `idx_pinjaman_status` (`status`),
  KEY `idx_pinjaman_tgl` (`tgl_pengajuan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_pinjaman`
--

LOCK TABLES `data_pinjaman` WRITE;
/*!40000 ALTER TABLE `data_pinjaman` DISABLE KEYS */;
INSERT INTO `data_pinjaman` VALUES (3,'76788','2026-09-08',2000000,4,'Biaya perbaikan rumah mendesak','ktp_76788_1788842984.jpg','jaminan_76788_1788842984.jpg','Budi Santoso','081234567890','Orang Tua','Disetujui','2026-09-08','Disetujui oleh HRD/Pimpinan Klinik. Pemotongan cicilan aktif mulai payroll bulan ini.',4);
/*!40000 ALTER TABLE `data_pinjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hak_akses`
--

DROP TABLE IF EXISTS `hak_akses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hak_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) NOT NULL,
  `hak_akses` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hak_akses`
--

LOCK TABLES `hak_akses` WRITE;
/*!40000 ALTER TABLE `hak_akses` DISABLE KEYS */;
INSERT INTO `hak_akses` VALUES (1,'admin',1),(2,'pegawai',2),(3,'pimpinan',3);
/*!40000 ALTER TABLE `hak_akses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hari_libur`
--

DROP TABLE IF EXISTS `hari_libur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hari_libur` (
  `id_libur` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_libur`),
  UNIQUE KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hari_libur`
--

LOCK TABLES `hari_libur` WRITE;
/*!40000 ALTER TABLE `hari_libur` DISABLE KEYS */;
INSERT INTO `hari_libur` VALUES (1,'2026-08-17','Hari Kemerdekaan RI'),(3,'2026-01-01','Tahun Baru'),(4,'2026-01-16','Isra Mikraj Nabi Muhammad'),(5,'2026-02-16','Cuti Bersama Tahun Baru Imlek'),(6,'2026-02-17','Tahun Baru Imlek'),(7,'2026-03-18','Cuti Bersama Hari Suci Nyepi (Tahun Baru Saka)'),(8,'2026-03-19','Hari Suci Nyepi (Tahun Baru Saka)'),(9,'2026-03-20','Cuti Bersama Idul Fitri'),(10,'2026-03-21','Hari Idul Fitri'),(11,'2026-03-22','Hari Idul Fitri'),(12,'2026-03-23','Cuti Bersama Idul Fitri'),(13,'2026-03-24','Cuti Bersama Idul Fitri'),(14,'2026-04-03','Wafat Isa Almasih'),(15,'2026-04-05','Hari Paskah'),(16,'2026-05-01','Hari Buruh Internasional / Pekerja'),(17,'2026-05-14','Kenaikan Isa Al Masih'),(18,'2026-05-15','Cuti Bersama Kenaikan Isa Al Masih'),(19,'2026-05-27','Idul Adha (Lebaran Haji)'),(20,'2026-05-28','Idul Adha (Lebaran Haji)'),(21,'2026-05-31','Hari Raya Waisak (belum pasti)'),(22,'2026-06-01','Hari Lahir Pancasila'),(23,'2026-06-16','Hari Kedua Muharram'),(24,'2026-08-25','Maulid Nabi Muhammad (belum pasti)'),(25,'2026-12-24','Cuti Bersama Natal (Malam Natal)'),(26,'2026-09-30','Ulang Tahun Klinik Ke-10'),(27,'2026-12-25','Hari Raya Natal');
/*!40000 ALTER TABLE `hari_libur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komponen_gaji`
--

DROP TABLE IF EXISTS `komponen_gaji`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komponen_gaji` (
  `id_komponen` int(11) NOT NULL AUTO_INCREMENT,
  `nama_komponen` varchar(100) NOT NULL,
  `tipe` enum('tunjangan','potongan') NOT NULL,
  `nominal` int(11) NOT NULL DEFAULT 0,
  `is_persentase` tinyint(1) NOT NULL DEFAULT 0,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_komponen`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komponen_gaji`
--

LOCK TABLES `komponen_gaji` WRITE;
/*!40000 ALTER TABLE `komponen_gaji` DISABLE KEYS */;
INSERT INTO `komponen_gaji` VALUES (1,'BPJS Kesehatan','potongan',150000,0,1,'2026-08-07 05:16:26'),(2,'BPJS Ketenagakerjaan','potongan',100000,0,1,'2026-08-07 05:16:26'),(3,'Tunjangan Hari Raya (THR)','tunjangan',100,1,1,'2026-08-07 05:16:26'),(4,'Tunjangan Kesehatan','tunjangan',200000,0,1,'2026-08-07 05:16:26');
/*!40000 ALTER TABLE `komponen_gaji` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komponen_gaji_pegawai`
--

DROP TABLE IF EXISTS `komponen_gaji_pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komponen_gaji_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_komponen` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `bulan` varchar(6) NOT NULL,
  `nominal_override` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_komponen` (`id_komponen`),
  KEY `idx_nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komponen_gaji_pegawai`
--

LOCK TABLES `komponen_gaji_pegawai` WRITE;
/*!40000 ALTER TABLE `komponen_gaji_pegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `komponen_gaji_pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(120) NOT NULL DEFAULT '',
  `is_success` tinyint(1) NOT NULL DEFAULT 0,
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_login_ip_time` (`ip_address`,`attempted_at`),
  KEY `idx_login_user_time` (`username`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `potongan_gaji`
--

DROP TABLE IF EXISTS `potongan_gaji`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `potongan_gaji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `potongan` varchar(120) NOT NULL,
  `jml_potongan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `potongan_gaji`
--

LOCK TABLES `potongan_gaji` WRITE;
/*!40000 ALTER TABLE `potongan_gaji` DISABLE KEYS */;
INSERT INTO `potongan_gaji` VALUES (1,'Alpha',50000),(2,'Sakit',30000);
/*!40000 ALTER TABLE `potongan_gaji` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_absensi`
--

DROP TABLE IF EXISTS `setting_absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_absensi` (
  `id` int(11) NOT NULL DEFAULT 1,
  `jam_masuk` time NOT NULL DEFAULT '08:00:00',
  `mulai_absen_masuk` time DEFAULT '06:00:00',
  `toleransi_menit` int(11) NOT NULL DEFAULT 15,
  `jam_pulang` time NOT NULL DEFAULT '17:00:00',
  `mulai_absen_pulang` time DEFAULT '15:00:00',
  `batas_terlambat_berat` time NOT NULL DEFAULT '09:00:00',
  `maks_terlambat_jadi_alpha` int(11) NOT NULL DEFAULT 3,
  `tarif_lembur_per_jam` int(11) DEFAULT 20000,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_absensi`
--

LOCK TABLES `setting_absensi` WRITE;
/*!40000 ALTER TABLE `setting_absensi` DISABLE KEYS */;
INSERT INTO `setting_absensi` VALUES (1,'11:39:00','07:50:00',15,'17:00:00','16:59:00','10:00:00',3,20000);
/*!40000 ALTER TABLE `setting_absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_cuti`
--

DROP TABLE IF EXISTS `setting_cuti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_cuti` (
  `id` int(11) NOT NULL DEFAULT 1,
  `mode_kuota_cuti` enum('Tahunan','Bulanan','Kombinasi') NOT NULL DEFAULT 'Kombinasi',
  `kuota_cuti_tahunan` int(11) NOT NULL DEFAULT 12,
  `kuota_cuti_bulanan` int(11) NOT NULL DEFAULT 5,
  `keterangan_kebijakan` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_cuti`
--

LOCK TABLES `setting_cuti` WRITE;
/*!40000 ALTER TABLE `setting_cuti` DISABLE KEYS */;
INSERT INTO `setting_cuti` VALUES (1,'Kombinasi',12,5,'Kebijakan Standar: Jatah tahunan 12 hari dengan batas maksimal pengambilan 5 hari per bulan kerja.','2026-09-08 14:33:34');
/*!40000 ALTER TABLE `setting_cuti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-21 23:06:11
