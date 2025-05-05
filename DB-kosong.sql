-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_sibekisar_empty.coms_role
DROP TABLE IF EXISTS `coms_role`;
CREATE TABLE IF NOT EXISTS `coms_role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.coms_role: ~3 rows (approximately)
REPLACE INTO `coms_role` (`id_role`, `role`) VALUES
	(1, 'Admin'),
	(2, 'Admin PD Penilai'),
	(3, 'Operator');

-- Dumping structure for table db_sibekisar_empty.coms_user
DROP TABLE IF EXISTS `coms_user`;
CREATE TABLE IF NOT EXISTS `coms_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_unit` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_role` int DEFAULT NULL,
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `unik` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.coms_user: ~1 rows (approximately)
REPLACE INTO `coms_user` (`id_user`, `username`, `nama`, `email`, `password`, `nip`, `avatar`, `hp`, `id_unit`, `id_role`, `is_aktif`) VALUES
	(1, 'admin', 'admin Aplikasi', NULL, '$2y$11$60830d0e38db7b12b09c4OTJRipugs7vAkHLiseMOB2jYcyzj4kza', NULL, NULL, NULL, NULL, 1, 1);

-- Dumping structure for table db_sibekisar_empty.coms_user_role
DROP TABLE IF EXISTS `coms_user_role`;
CREATE TABLE IF NOT EXISTS `coms_user_role` (
  `id_role` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_role`,`id_user`) USING BTREE,
  UNIQUE KEY `unik` (`id_role`,`id_user`) USING BTREE,
  KEY `id_user` (`id_user`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.coms_user_role: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.coms_user_unit
DROP TABLE IF EXISTS `coms_user_unit`;
CREATE TABLE IF NOT EXISTS `coms_user_unit` (
  `id_unit` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_unit`,`id_user`) USING BTREE,
  UNIQUE KEY `id_unit` (`id_unit`,`id_user`) USING BTREE,
  KEY `id_user` (`id_user`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.coms_user_unit: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.evaluasi
DROP TABLE IF EXISTS `evaluasi`;
CREATE TABLE IF NOT EXISTS `evaluasi` (
  `id_evaluasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_unit` int DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `bulan_mulai` int DEFAULT NULL,
  `bulan_selesai` int DEFAULT NULL,
  `periode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tahun',
  `id_indikator` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai_awal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai_akhir` float DEFAULT NULL,
  `nilai_konversi` float DEFAULT NULL,
  `nilai_maks` int DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `timestamp` datetime DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `user_verifikasi` int DEFAULT NULL,
  `catatan_verifikasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `catatan_indikator` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `rekomendasi_indikator` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `waktu_verifikasi` datetime DEFAULT NULL,
  `is_verify` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_evaluasi`) USING BTREE,
  KEY `FK_evaluasi_m_indikator` (`id_indikator`),
  KEY `FK_evaluasi_m_periode` (`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.evaluasi: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_aspek
DROP TABLE IF EXISTS `m_aspek`;
CREATE TABLE IF NOT EXISTS `m_aspek` (
  `id_aspek` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `periode` int NOT NULL DEFAULT '0',
  `aspek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai_maks` int DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_aspek`) USING BTREE,
  KEY `FK_m_aspek_m_periode` (`periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_aspek: ~6 rows (approximately)
REPLACE INTO `m_aspek` (`id_aspek`, `periode`, `aspek`, `nilai_maks`, `keterangan`, `is_aktif`, `tag`, `icon`) VALUES
	('C0202201', 1, 'Cepat', 20, 'REAL TIME, QUICK RESPONSE, ANTI LELET , JAGA MOMENTUM\r\n', 1, 'opd', 'icon-layers'),
	('C0202202', 1, 'Efektif & Efisien', 15, 'CARA TERBAIK, HASIL PRIMA, EFISIEN WAKTU, TIDAK ADA PEMBOROSAN \r\n', 1, 'opd', 'icon-diamond'),
	('C0202203', 1, 'Tanggap', 15, 'MEMBALAS SECARA AKTIF, MEMBACA GESTUR\r\n', 1, 'opd', 'icon-star'),
	('C0202204', 1, 'Transparan', 15, 'DILAKUKAN SECARA TERBUKA, INFORMASI JELAS DAN TERBAGI\r\n', 1, 'opd', 'icon-globe'),
	('C0202205', 1, 'Akuntabel', 20, 'SESUAI ATURAN PROSEDURAL DAN DAPAT DIPERTANGGUNGJAWABKAN\r\n', 1, 'opd', 'icon-calculator'),
	('C0202206', 1, 'Responsive', 15, 'MEMBALAS SEMUA TUGAS, MENINDAKLANJUTI\r\n', 1, 'opd', 'icon-size-actual');

-- Dumping structure for table db_sibekisar_empty.m_aspek_copy
DROP TABLE IF EXISTS `m_aspek_copy`;
CREATE TABLE IF NOT EXISTS `m_aspek_copy` (
  `id_aspek` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `aspek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai_maks` int DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_aspek`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_aspek_copy: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_indikator
DROP TABLE IF EXISTS `m_indikator`;
CREATE TABLE IF NOT EXISTS `m_indikator` (
  `id_indikator` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `indikator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_aspek` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bobot` decimal(10,2) NOT NULL DEFAULT '0.00',
  `periode` int DEFAULT NULL,
  `jml_periode` int NOT NULL DEFAULT '1',
  `opd_pengampu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_opd` int DEFAULT NULL,
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_indikator`) USING BTREE,
  KEY `FK_m_indikator_m_periode` (`periode`),
  KEY `FK_m_indikator_m_aspek` (`id_aspek`),
  KEY `FK_m_indikator_m_unit` (`id_opd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_indikator: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_indikator_copy
DROP TABLE IF EXISTS `m_indikator_copy`;
CREATE TABLE IF NOT EXISTS `m_indikator_copy` (
  `id_indikator` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `indikator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_aspek` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bobot` decimal(10,2) NOT NULL DEFAULT '0.00',
  `periode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'tahunan',
  `jml_periode` int NOT NULL DEFAULT '1',
  `opd_pengampu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_opd` int DEFAULT NULL,
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_indikator`) USING BTREE,
  KEY `id_aspek` (`id_aspek`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_indikator_copy: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_periode
DROP TABLE IF EXISTS `m_periode`;
CREATE TABLE IF NOT EXISTS `m_periode` (
  `id_periode` int NOT NULL AUTO_INCREMENT,
  `tahun_periode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_periode` enum('aktif','lock') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `tanggal_dibuat` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_periode`),
  UNIQUE KEY `id_periode` (`tahun_periode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_periode: ~1 rows (approximately)
REPLACE INTO `m_periode` (`id_periode`, `tahun_periode`, `status_periode`, `tanggal_dibuat`, `updated_at`) VALUES
	(1, '2025', 'aktif', NULL, '2025-05-05 04:54:48');

-- Dumping structure for table db_sibekisar_empty.m_unit
DROP TABLE IF EXISTS `m_unit`;
CREATE TABLE IF NOT EXISTS `m_unit` (
  `id_unit` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `tujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tugas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fungsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_parent` int DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nm_jabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Kepala',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `website` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_ig` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_fb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_twitter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_bidang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_upt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_anggaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_sdm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tag_unit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_tmp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_akses` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Kode akses untuk unduh LHE',
  PRIMARY KEY (`id_unit`) USING BTREE,
  UNIQUE KEY `kode_akses` (`kode_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_unit: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_unit_copy1
DROP TABLE IF EXISTS `m_unit_copy1`;
CREATE TABLE IF NOT EXISTS `m_unit_copy1` (
  `id_unit` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `id_parent` int DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `website` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_ig` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_fb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_twitter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_bidang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_upt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_anggaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_sdm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_unit`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_unit_copy1: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.m_unit_copy2
DROP TABLE IF EXISTS `m_unit_copy2`;
CREATE TABLE IF NOT EXISTS `m_unit_copy2` (
  `id_unit` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_unit` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `is_aktif` tinyint NOT NULL DEFAULT '1',
  `id_parent` int DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profil` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `website` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_ig` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_fb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `medsos_twitter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_bidang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_upt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_anggaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_sdm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tag_unit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_tmp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_unit`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.m_unit_copy2: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.vw_rekap_by_aspek
DROP TABLE IF EXISTS `vw_rekap_by_aspek`;
CREATE TABLE IF NOT EXISTS `vw_rekap_by_aspek` (
  `tahun` int NOT NULL,
  `id_unit` int NOT NULL,
  `unit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `id_aspek` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `aspek` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_akhir` decimal(10,2) DEFAULT NULL,
  `nilai_maks` decimal(10,2) DEFAULT NULL,
  `total_nilai` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`tahun`,`id_unit`,`id_aspek`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.vw_rekap_by_aspek: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty.vw_rekap_by_spirit
DROP TABLE IF EXISTS `vw_rekap_by_spirit`;
CREATE TABLE IF NOT EXISTS `vw_rekap_by_spirit` (
  `tahun` int NOT NULL,
  `id_unit` int NOT NULL,
  `tag` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'opd',
  `unit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai` decimal(10,2) DEFAULT NULL,
  `nilai_huruf` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `predikat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`tahun`,`id_unit`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty.vw_rekap_by_spirit: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty._sync_serapan
DROP TABLE IF EXISTS `_sync_serapan`;
CREATE TABLE IF NOT EXISTS `_sync_serapan` (
  `id_unit` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_unit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agr` float DEFAULT NULL,
  `real` float DEFAULT NULL,
  `persen` float DEFAULT NULL,
  `grup` tinyint DEFAULT NULL,
  `id_indikator` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'C0201',
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_unit`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty._sync_serapan: ~0 rows (approximately)

-- Dumping structure for table db_sibekisar_empty._sync_serapan_copy1
DROP TABLE IF EXISTS `_sync_serapan_copy1`;
CREATE TABLE IF NOT EXISTS `_sync_serapan_copy1` (
  `id_unit` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_unit` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agr` float DEFAULT NULL,
  `real` float DEFAULT NULL,
  `persen` float DEFAULT NULL,
  `grup` tinyint DEFAULT NULL,
  `id_indikator` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'C0201',
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_unit`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_sibekisar_empty._sync_serapan_copy1: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
