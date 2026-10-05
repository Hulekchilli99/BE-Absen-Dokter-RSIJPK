-- MySQL dump 10.13  Distrib 8.4.11, for Linux (x86_64)
--
-- Host: localhost    Database: absen_dokter
-- ------------------------------------------------------
-- Server version	8.4.11

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
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint unsigned NOT NULL,
  `attendance_date` date NOT NULL,
  `checked_in_at` datetime NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `accuracy_meters` decimal(8,2) DEFAULT NULL,
  `distance_meters` decimal(8,2) NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_doctor_id_attendance_date_unique` (`doctor_id`,`attendance_date`),
  KEY `attendances_attendance_date_checked_in_at_index` (`attendance_date`,`checked_in_at`),
  CONSTRAINT `attendances_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,26,'2026-10-05','2026-10-05 09:29:19',-6.2202649,106.9399345,5.00,0.00,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0','2026-10-05 09:29:19','2026-10-05 09:29:19');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_name_unique` (`name`),
  KEY `doctors_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (1,'dr. Wening Tri Mawanti, Sp.Ok',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(2,'dr. H. Lukman Ali Husin, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(3,'dr. H. Kusdiantomo, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(4,'dr. Dewi Martalena, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(5,'dr. Tanggo Meriza, Sp.PD, KR',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(6,'dr. Yuanita, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(7,'dr. Umairah Assagaf, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(8,'dr. Muthia Farani, Sp.PD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(9,'dr. Hj. Khomimah, Sp.PD, KEMD',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(10,'dr. Kuspuji Dwitanto Rahardjo, Sp.PD-KGH',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(11,'dr. Salman Paris Harahap, Sp.PD-KHOM',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(12,'dr. Maulana Suryamin, Sp.PD-KGEH',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(13,'dr. Ika Fitriana, Sp.PD, (K) Ger',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(14,'dr. dr. H. M. Natsir Nugroho, Sp.OG, M.Kes',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(15,'dr. Hj. Husna Amelz, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(16,'dr. Kartini, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(17,'dr. Kalsah Nugroho Ariyanto K, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(18,'dr. Dewi Rochyantini, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(19,'dr. Chaeranisa Akmelia, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(20,'dr. Nessyah Fatahan, Sp.OG',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(21,'dr. H. Suryono Wibowo, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(22,'dr. Roito Elmina G.H, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(23,'dr. Yunetti, Sp.A, M.Biomed',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(24,'dr. Siti Nurhidayah I.D, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(25,'dr. Leny Ambarwati, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(26,'dr. Raden Lia Mulyani, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(27,'dr. Tri Sunarti, Sp.A',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(28,'dr. Muhammad Fachri, Sp.P, FAPSR, FISR',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(29,'dr. H. Rahmadi Iwan G, Sp.P',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(30,'dr. Bobby Anggara, Sp.P',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(31,'dr. Andari Rahmani Putri, Sp.P, MKM',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(32,'dr. Flora Eka Sari, Sp.P(K) Onk',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(33,'dr. Arum Sari Pertiwi, MARS',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(34,'dr. H. Denny P. M, Sp.THT',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(35,'dr. Hj. Fitriah Shebubakar, Sp.THT',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(36,'dr. Dian Nurul Al Amini, Sp.THT',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(37,'dr. Hj. Hasri Darni, Sp.M',1,'2026-10-05 10:18:09','2026-10-05 10:18:10'),(38,'dr. Masitah Wilma Wahyuni, Sp.M',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(39,'dr. Amelia Hidayati, Sp.M',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(40,'dr. Pradnya Pramitha, Sp.M',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(41,'dr. Atik Mufidah, Sp.JP, FIHA, M.Kes',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(42,'dr. Medika Prasetya, Sp.JP, FIHA',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(43,'dr. Gesza Utama Putra, Sp.JP',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(44,'dr. Irfan Taufik, Sp.S',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(45,'dr. Wiwin Sundawiyani, Sp.S',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(46,'dr. Yaumi Faiza, Sp.N, M.Biomed',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(47,'dr. Khonita Adian Utami, Sp.N',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(48,'dr. Sudirman, Sp.N',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(49,'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(50,'dr. Ridhawati Mukhtar, Sp.KK',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(51,'dr. Rizqa Haerani S, Sp.D.V.E, M.Kes, FINSDV',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(52,'dr. Wuriandaru Kurniasih, Sp.DV',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(53,'drg. Hj. Evi Hafifah, Sp.KG',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(54,'drg. Rini Susanti, Sp.Ort',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(55,'drg. Juretta Sintawati, Sp.KGA',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(56,'drg. Martina Ichsanti, Sp.Perio',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(57,'drg. Hardiono, Sp.BM',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(58,'drg. Arian Reza Marwan, Sp.BMM',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(59,'dr. Friendy Ahdimar, Sp.KJ',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(60,'dr. Sheery Hendrika, Sp.Akp',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(61,'dr. H. Saleh Setiawan, Sp.B',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(62,'dr. Donny Sandra, Sp.B',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(63,'dr. M. Riza El Anshory, Sp.B',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(64,'dr. Afrimal Syafarudin, Sp.B, Subsp.Onk(K), SH, MH',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(65,'dr. Arief Setiawan, Sp.B-KBD',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(66,'dr. H. Yusuf Saleh Bazed, Sp.BU',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(67,'dr. H. Waluyo Eko, Sp.BU',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(68,'dr. Raga Manduaru, Sp.U',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(69,'dr. Sumono Handoyo, Sp.OT, FICS',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(70,'dr. Mahardhika Ichsantyaridha, Sp.OT, AIFO-K',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(71,'dr. Mohammad Walid Kuncoro, Sp.OT',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(72,'dr. Ilham Suryo Wibowo Antono, Sp.OT',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(73,'dr. Rally Galang P.P, Sp.BTKV',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(74,'dr. Endi Suryo Utomo, Sp.BS',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(75,'dr. Alvin Abrar Harahap, Sp.BS',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(76,'dr. Livia Faranita Gianni, Sp.BP-RE',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(77,'dr. Elly Triturawati, Sp.RM',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(78,'dr. Rahmania Noor Adiba, Sp.KFR',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(79,'dr. Umi Sjarqiah, Sp.KFR, MKM',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(80,'dr. Evi Rachmawati Nur Hidayati, Sp.KFR, Ger(K), FIPM(USG), Ph.D',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(81,'dr. R. Suryoseto, Sp.Rad(K) Onk.Rad',1,'2026-10-05 10:18:10','2026-10-05 10:18:10'),(82,'dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)',1,'2026-10-05 10:18:10','2026-10-05 10:18:10');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
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
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_30_073800_create_doctors_table',1),(5,'2026_09_30_073801_create_attendances_table',1),(6,'2026_10_02_102743_add_no_pegawai_and_api_token_to_users_table',1);
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_no_pegawai_unique` (`no_pegawai`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','sirspondokkopi@gmail.com','1212',NULL,'$2y$12$cyohZv4cCT0wUYf9BsgBq.B4pDADv6BTc1/QP46lM4bDpcAhImGOy','SQRZAmw4E4R1fM57QgpS7GqOSzrIQCwUEnHArnpiIiIaC5x8x8h7e58sX5KO',NULL,'2026-10-05 10:18:09','2026-10-05 10:29:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'absen_dokter'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-05  3:31:59
