-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: app_kdo
-- ------------------------------------------------------
-- Server version	5.5.5-10.5.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kdos`
--

DROP TABLE IF EXISTS `kdos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kdos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `perangkat_daerah_id` bigint(20) unsigned NOT NULL,
  `pns_id` bigint(20) unsigned DEFAULT NULL,
  `nomor_polisi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Roda 4','Roda 2','Roda 6','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Roda 4',
  `tahun_produksi` year(4) NOT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rangka` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_mesin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_bpkb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `status_penggunaan` enum('Digunakan','Tersedia/Pool','Dalam Perbaikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Digunakan',
  `tanggal_pajak` date DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kdos_nomor_polisi_unique` (`nomor_polisi`),
  KEY `kdos_perangkat_daerah_id_foreign` (`perangkat_daerah_id`),
  KEY `kdos_pns_id_foreign` (`pns_id`),
  CONSTRAINT `kdos_perangkat_daerah_id_foreign` FOREIGN KEY (`perangkat_daerah_id`) REFERENCES `perangkat_daerahs` (`id`),
  CONSTRAINT `kdos_pns_id_foreign` FOREIGN KEY (`pns_id`) REFERENCES `pns` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kdos`
--

LOCK TABLES `kdos` WRITE;
/*!40000 ALTER TABLE `kdos` DISABLE KEYS */;
INSERT INTO `kdos` VALUES (1,1,1,'B 1001 PQD','02.03.01.01.001','Toyota','Kijang Innova 2.0 V A/T','Roda 4',2022,'Hitam Metalik','MHF11GB40K0012398','1TR-FE-7892341','N-04581298','Baik','Digunakan','2026-12-15',NULL,'Kendaraan dinas operasional Kepala Dinas Pendidikan. Kondisi mesin terawat, servis berkala di bengkel resmi.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,1,2,'B 1024 PQD','02.03.01.01.002','Toyota','Avanza 1.3 G M/T','Roda 4',2021,'Silver Metalik','MHKM1BA3JK0098451','1NR-VE-4458912','M-07891244','Baik','Digunakan','2026-11-20',NULL,'Kendaraan dinas Sekretaris Disdik. AC dingin, ban depan baru diganti.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(3,1,NULL,'B 1876 PQD','02.03.01.01.003','Isuzu','Panther Grand Touring 2.5','Roda 4',2016,'Abu-abu Tua Metalik','MHCTBR54F0033129','4JA1-L-8891024','K-01298451','Rusak Berat','Dalam Perbaikan','2025-08-10',NULL,'Mobil pool dinas pendidikan. Mengalami kerusakan pada sistem transmisi dan turun mesin, diusulkan untuk lelang BMD.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(4,1,3,'B 3450 PQD','02.03.01.02.001','Honda','Vario 125 CBS','Roda 2',2021,'Merah Hitam','MH1JM3114KK091243','JM31E-1456789','N-09871234','Baik','Digunakan','2027-01-18',NULL,'Kendaraan roda dua operasional kurir pengantaran berkas dinas.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(5,2,4,'B 1002 PQD','02.03.01.01.004','Honda','CR-V 1.5 Turbo Prestige','Roda 4',2023,'Putih Mutiara','MHRRW1880NJ004561','L15BE-9912045','P-03341982','Baik','Digunakan','2027-03-12',NULL,'Kendaraan dinas jabatan Kepala Dinas Kesehatan. Kondisi sangat prima.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(6,2,5,'B 1419 PQD','02.03.01.01.005','Toyota','Hilux 2.4 Single Cabin 4x2','Roda 4',2019,'Putih','MR0KB3CD2J0018742','2GD-FTV-8941023','L-08971266','Rusak Ringan','Digunakan','2026-11-28',NULL,'Digunakan untuk distribusi obat dan logistik puskesmas. Ada lecet bemper depan kanan dan kampas rem menipis.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(7,2,6,'B 1655 PQD','02.03.01.01.006','Daihatsu','Terios 1.5 R Deluxe A/T','Roda 4',2020,'Bronze Metalik','MHKF8EA2JK0041289','2NR-VE-6671249','M-05128941','Baik','Digunakan','2026-12-05',NULL,'Kendaraan lapangan surveilans imunisasi dan penanganan stunting dinas kesehatan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(8,3,7,'B 1003 PQD','02.03.01.01.007','Toyota','Fortuner 2.8 VRZ 4x4 A/T','Roda 4',2022,'Hitam Metalik','MHF11GB50M0019283','1GD-FTV-9012348','N-09918234','Baik','Digunakan','2027-02-14',NULL,'Kendaraan dinas jabatan Kepala Dinas PUPR. Rutin meninjau medan proyek jalan dan jembatan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(9,3,8,'B 1789 PQD','02.03.01.01.008','Mitsubishi','Strada Triton 2.4 Ultimate 4x4','Roda 4',2020,'Silver Metalik','MMBJJKL30LH004128','4N15-UC-8912401','M-06612984','Rusak Ringan','Digunakan','2026-11-15',NULL,'Kendaraan patroli dan survei kondisi infrastruktur jalan. Suspensi belakang berbunyi dan butuh ganti shock absorber.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(10,3,9,'B 9234 PQD','02.03.01.03.001','Hino','Dutro 130 HD Dump Truck','Roda 6',2018,'Hijau Muda','MJEC17610J0081249','W04D-TM-1289451','L-01824791','Baik','Digunakan','2027-04-20',NULL,'Truk pengangkut material aspal dan batu untuk perbaikan jalan darurat.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(11,4,10,'B 1005 PQD','02.03.01.01.009','Toyota','Kijang Innova 2.4 G Diesel M/T','Roda 4',2021,'Abu-abu Metalik','MHF11GB40K0099412','2GD-FTV-1123490','M-09124458','Baik','Digunakan','2026-12-29',NULL,'Kendaraan dinas Kepala BPKAD. Pengelolaan aset dan anggaran daerah.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(12,5,11,'B 3012 PQD','02.03.01.02.002','Yamaha','NMAX 155 Connected ABS','Roda 2',2022,'Putih Biru (Patroli Dishub)','MH3SG5620NJ009124','G3L8E-0192841','N-05189241','Baik','Digunakan','2027-05-10',NULL,'Kendaraan dinas pengawalan dan patroli rekayasa lalu lintas Dishub.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(13,4,NULL,'B 1099 PQD','02.03.01.01.010','Toyota','Avanza 1.5 Veloz A/T','Roda 4',2022,'Hitam','MHKM1BA3JK0011894','2NR-VE-9912341','N-01824901','Baik','Tersedia/Pool','2026-11-18',NULL,'Mobil pool BPKAD tersedia untuk tamu kementerian atau penugasan luar kota mendadak.','2026-11-09 21:47:54','2026-11-09 21:47:54');
/*!40000 ALTER TABLE `kdos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_10_044518_create_personal_access_tokens_table',2),(5,'2026_11_10_050001_create_perangkat_daerahs_table',3),(6,'2026_11_10_050002_create_pns_table',3),(7,'2026_11_10_050003_create_kdos_table',3),(8,'2026_11_10_050004_create_riwayat_pemeliharaans_table',3),(9,'2026_11_10_050005_create_riwayat_pemegangs_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_daerahs`
--

DROP TABLE IF EXISTS `perangkat_daerahs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perangkat_daerahs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_pd` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kepala` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_kepala` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perangkat_daerahs_kode_pd_unique` (`kode_pd`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_daerahs`
--

LOCK TABLES `perangkat_daerahs` WRITE;
/*!40000 ALTER TABLE `perangkat_daerahs` DISABLE KEYS */;
INSERT INTO `perangkat_daerahs` VALUES (1,'1.01.0.00.0.00.01.0000','Dinas Pendidikan','Disdik','Jl. Pemuda No. 45, Kompleks Perkantoran Pemerintah Daerah','(021) 8765432','Dr. H. Bambang Suherman, M.Pd.','19680315 199303 1 004','2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,'1.02.0.00.0.00.01.0000','Dinas Kesehatan','Dinkes','Jl. Kesehatan Raya No. 12, Lingkar Barat','(021) 8761234','dr. Hj. Siti Rahmawati, M.Kes.','19720719 200003 2 003','2026-11-09 21:47:54','2026-11-09 21:47:54'),(3,'1.03.0.00.0.00.01.0000','Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)','Dinas PUPR','Jl. Jenderal Sudirman No. 88, Zona Pelayanan Terpadu','(021) 8769876','Ir. Hendra Gunawan, M.T.','19701108 199603 1 002','2026-11-09 21:47:54','2026-11-09 21:47:54'),(4,'5.02.0.00.0.00.01.0000','Badan Pengelolaan Keuangan dan Aset Daerah','BPKAD','Gedung A Lantai 3, Kantor Pusat Pemkab','(021) 8762233','Drs. Agus Triyono, M.Si.','19690522 199403 1 005','2026-11-09 21:47:54','2026-11-09 21:47:54'),(5,'2.15.0.00.0.00.01.0000','Dinas Perhubungan','Dishub','Jl. Terminal Baru No. 10','(021) 8764455','Rahmat Hidayat, S.STP., M.M.','19750914 199912 1 001','2026-11-09 21:47:54','2026-11-09 21:47:54');
/*!40000 ALTER TABLE `perangkat_daerahs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'auth_token','6d15d577e0e9c4ef3cea696f23152828e1fc0e7debc1c4f1bee928cf7284c8dc','[\"*\"]',NULL,NULL,'2026-11-09 22:00:57','2026-11-09 22:00:57'),(2,'App\\Models\\User',1,'auth_token','cfc2b7f461ef4f2b5219edd3b78f310b8bbc6ff27a52e1ae65b93f743e7661ae','[\"*\"]',NULL,NULL,'2026-11-09 22:08:12','2026-11-09 22:08:12'),(3,'App\\Models\\User',1,'auth_token','149284e06e69bb8700f4e776fbd53cb8b686befd9628d417f883a05a344daa80','[\"*\"]',NULL,NULL,'2026-11-09 22:08:25','2026-11-09 22:08:25'),(4,'App\\Models\\User',1,'auth_token','1fb34068ebdca45c26f1b9944ee98c0c57fec8f741f24b89da332c8150993dbf','[\"*\"]',NULL,NULL,'2026-11-09 22:44:16','2026-11-09 22:44:16'),(5,'App\\Models\\User',1,'auth_token','0c094b7dfc4727031025c0a4510d6c89bbb807e0e1443541a56be0686d17f3c5','[\"*\"]',NULL,NULL,'2026-11-09 22:50:09','2026-11-09 22:50:09');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pns`
--

DROP TABLE IF EXISTS `pns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `perangkat_daerah_id` bigint(20) unsigned NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pegawai` enum('Aktif','Pensiun','Mutasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pns_nip_unique` (`nip`),
  KEY `pns_perangkat_daerah_id_foreign` (`perangkat_daerah_id`),
  CONSTRAINT `pns_perangkat_daerah_id_foreign` FOREIGN KEY (`perangkat_daerah_id`) REFERENCES `perangkat_daerahs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pns`
--

LOCK TABLES `pns` WRITE;
/*!40000 ALTER TABLE `pns` DISABLE KEYS */;
INSERT INTO `pns` VALUES (1,1,'19680315 199303 1 004','Dr. H. Bambang Suherman, M.Pd.','Kepala Dinas Pendidikan','Pembina Utama Muda (IV/c)','081289123456','bambang.disdik@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,1,'19770821 200212 1 002','Dedi Suryadi, S.Pd., M.Si.','Sekretaris Dinas Pendidikan','Pembina (IV/a)','081311223344','dedi.suryadi@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(3,1,'19850410 200902 2 006','Nurul Hidayati, S.E.','Pengurus Barang Pengguna (BMD)','Penata (III/c)','085712345678','nurul.asetdisdik@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(4,2,'19720719 200003 2 003','dr. Hj. Siti Rahmawati, M.Kes.','Kepala Dinas Kesehatan','Pembina Utama Muda (IV/c)','081198765432','siti.rahmawati@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(5,2,'19810115 200604 1 008','dr. Ahmad Fauzi, Sp.A.','Kepala Bidang Pelayanan Kesehatan','Pembina (IV/a)','081298445566','ahmad.fauzi@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(6,2,'19890612 201101 2 015','Dewi Sartika, S.Kep., Ners.','Koordinator Tim Survailans Puskesmas','Penata Muda Tk. I (III/b)','087855667788','dewi.sartika@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(7,3,'19701108 199603 1 002','Ir. Hendra Gunawan, M.T.','Kepala Dinas PUPR','Pembina Utama Madya (IV/d)','081233445566','hendra.pupr@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(8,3,'19820325 200801 1 011','Bayu Wicaksono, S.T., M.Eng.','Kepala Bidang Bina Marga','Penata Tingkat I (III/d)','081399887766','bayu.binamarga@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(9,3,'19900918 201402 1 003','Eko Prasetyo, A.Md.','Teknisi Pengawas Proyek Lapangan','Pengatur (II/c)','085611223344','eko.prasetyo@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(10,4,'19690522 199403 1 005','Drs. Agus Triyono, M.Si.','Kepala BPKAD','Pembina Utama Muda (IV/c)','081122334455','agus.triyono@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(11,5,'19750914 199912 1 001','Rahmat Hidayat, S.STP., M.M.','Kepala Dinas Perhubungan','Pembina Tingkat I (IV/b)','081255667788','rahmat.dishub@pemda.go.id','Aktif','2026-11-09 21:47:54','2026-11-09 21:47:54'),(12,1,'48935983495309595','Jono Sarwono','kasubag','Pembina 1','0485849549','jono@gmail.com','Aktif','2026-11-09 22:16:00','2026-11-09 22:16:00');
/*!40000 ALTER TABLE `pns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_pemegangs`
--

DROP TABLE IF EXISTS `riwayat_pemegangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_pemegangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kdo_id` bigint(20) unsigned NOT NULL,
  `pns_id` bigint(20) unsigned NOT NULL,
  `nomor_bast` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_bast` enum('Aktif','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `catatan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riwayat_pemegangs_kdo_id_foreign` (`kdo_id`),
  KEY `riwayat_pemegangs_pns_id_foreign` (`pns_id`),
  CONSTRAINT `riwayat_pemegangs_kdo_id_foreign` FOREIGN KEY (`kdo_id`) REFERENCES `kdos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `riwayat_pemegangs_pns_id_foreign` FOREIGN KEY (`pns_id`) REFERENCES `pns` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_pemegangs`
--

LOCK TABLES `riwayat_pemegangs` WRITE;
/*!40000 ALTER TABLE `riwayat_pemegangs` DISABLE KEYS */;
INSERT INTO `riwayat_pemegangs` VALUES (1,1,1,'028/429/BAST-KDO/2026','2026-03-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,2,2,'028/110/BAST-KDO/2026','2026-04-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(3,4,3,'028/837/BAST-KDO/2026','2025-03-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(4,5,4,'028/487/BAST-KDO/2026','2026-01-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(5,6,5,'028/469/BAST-KDO/2026','2025-02-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(6,7,6,'028/260/BAST-KDO/2026','2026-01-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(7,8,7,'028/786/BAST-KDO/2026','2026-04-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(8,9,8,'028/380/BAST-KDO/2026','2026-04-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(9,10,9,'028/363/BAST-KDO/2026','2026-05-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(10,11,10,'028/146/BAST-KDO/2026','2026-04-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54'),(11,12,11,'028/644/BAST-KDO/2026','2024-12-10',NULL,'Aktif','Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.','2026-11-09 21:47:54','2026-11-09 21:47:54');
/*!40000 ALTER TABLE `riwayat_pemegangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_pemeliharaans`
--

DROP TABLE IF EXISTS `riwayat_pemeliharaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_pemeliharaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kdo_id` bigint(20) unsigned NOT NULL,
  `tanggal_servis` date NOT NULL,
  `jenis_pemeliharaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bengkel_pelaksana` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kondisi_sebelum` enum('Baik','Rusak Ringan','Rusak Berat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `kondisi_setelah` enum('Baik','Rusak Ringan','Rusak Berat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riwayat_pemeliharaans_kdo_id_foreign` (`kdo_id`),
  CONSTRAINT `riwayat_pemeliharaans_kdo_id_foreign` FOREIGN KEY (`kdo_id`) REFERENCES `kdos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_pemeliharaans`
--

LOCK TABLES `riwayat_pemeliharaans` WRITE;
/*!40000 ALTER TABLE `riwayat_pemeliharaans` DISABLE KEYS */;
INSERT INTO `riwayat_pemeliharaans` VALUES (1,1,'2026-09-15','Servis Berkala 40.000 KM & Ganti Oli Mesin','Bengkel Resmi Toyota Auto2000 Juanda',2450000.00,'Baik','Baik','Penggantian oli mesin TMO Synthetic 5W-30, filter oli, filter AC kabin, kuras minyak rem, dan tune-up.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,2,'2026-08-20','Penggantian 2 Buah Ban Depan & Spooring Balancing','Toko Ban Bridgestone Pro-Tire Sentra',1850000.00,'Rusak Ringan','Baik','Ban depan sudah aus tipis, diganti dengan Bridgestone Ecopia 185/65 R15 + wheel alignment 4 roda.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54'),(3,3,'2026-06-10','Diagnosa Transmisi & Kompresi Mesin Lemah','Bengkel Diesel Berkah Jaya Motor',750000.00,'Rusak Berat','Rusak Berat','Ditemukan blok silinder retak rambut dan transmisi selip parah. Estimasi perbaikan besar Rp 28.000.000, direkomendasikan penghapusan aset.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54'),(4,6,'2026-10-02','Perbaikan Sistem Pengereman & Ganti Kampas Rem','Bengkel Mobil Utama Mandiri',1250000.00,'Rusak Ringan','Rusak Ringan','Ganti kampas rem depan Bendix dan bubut piringan cakram. Bemper depan masih menunggu antrean klaim asuransi perbaikan bodi.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54'),(5,9,'2026-07-25','Servis Berkala & Penggantian Filter Solar Solar Double Cabin','Dealer Resmi Mitsubishi Srikandi Motors',3100000.00,'Baik','Rusak Ringan','Ganti oli mesin gardan 4x4 dan filter solar. Teknisi mencatat karet bushing per daun belakang getas.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54'),(6,10,'2026-05-18','Servis Pompa Hidrolik Dump & Ganti Oli Transmisi','Bengkel Truk Armada Raya Hino',4500000.00,'Rusak Ringan','Baik','Sil silinder hidrolik dump bocor, diganti kit seal baru dan pengisian fluida hidrolik ISO VG 46.',NULL,'2026-11-09 21:47:54','2026-11-09 21:47:54');
/*!40000 ALTER TABLE `riwayat_pemeliharaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('hUbAC3DOVj5Wh7RJq5FwNmAVrMMoDowIEMUefW1a',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoibzBWdklFR3JXUEhHbm5KRW4yN1FIRk9WaVBCSzNzcEw2ajhyRnZaeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wbnMiO3M6NToicm91dGUiO3M6OToicG5zLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMWNkNTg1MmY1MGEwOTNiNmU0MjU0YWUwMDU4OGY4OTdhNDk5NDI1YzVjOTkxMjA4OWQyOWQyMjg5NGIyZjliMCI7fQ==',1794290001);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator BMD','admin@kdo.go.id',NULL,'$2y$12$Fv2uI4d84SOKy5waBXR9PuZOiiBT5br0Hdx7gfTuHuQv/ih4BxCN2','bZ89tIru8JOe8rtfk8Y0Ca7CkPIayBgVN9q2QhidhbwaHGE3tLzx2gMGqVMh','2026-11-09 21:47:54','2026-11-09 21:47:54'),(2,'Operator Aset Daerah','operator@kdo.go.id',NULL,'$2y$12$X4Psfu5RLwbPZ7Y28vcYku8PLjyImJ2y6ttWX7c3L8c7dsijhrfM2','uWKpy0HgjaF1AtRg8b7g1hjPQMljzdXgOYIfVjXBGmsmhGYgB0fd0wx2Ku2U','2026-11-09 21:47:54','2026-11-09 21:47:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'app_kdo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-10 12:56:36
