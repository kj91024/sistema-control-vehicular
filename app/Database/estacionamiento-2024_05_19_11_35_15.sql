-- MariaDB dump 10.19  Distrib 10.6.16-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: estacionamiento
-- ------------------------------------------------------
-- Server version	10.6.16-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(11) DEFAULT NULL,
  `plate` varchar(7) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_id_user_index` (`id_user`),
  KEY `cars_plate_index` (`plate`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` (`id`, `id_user`, `plate`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES (3,NULL,'AFH-849',NULL,'2024-04-22 17:47:48','2024-04-22 17:47:48',NULL),(5,NULL,'CVB-123',NULL,'2024-04-24 23:25:40','2024-04-24 23:25:40',NULL),(6,NULL,'HJK-123',NULL,'2024-04-24 23:25:43','2024-04-24 23:25:43',NULL),(7,NULL,'ERT-123',NULL,'2024-04-24 23:25:48','2024-04-24 23:25:48',NULL),(8,2,'BRV-597','#ff0000','2024-04-25 11:54:24','2024-05-16 11:50:47',NULL),(10,4,'TTT-111',NULL,'2024-04-25 12:26:09','2024-04-25 12:26:09',NULL),(13,8,'QQQ-415',NULL,'2024-04-25 17:25:00','2024-04-25 17:25:00',NULL),(14,11,'PPP-333','#000000','2024-05-06 23:15:35','2024-05-06 23:15:35',NULL),(15,12,'GGG-546','#ff0000','2024-05-06 23:20:27','2024-05-06 23:20:27',NULL),(16,13,'JYT-345','#0055ff','2024-05-08 10:38:12','2024-05-08 10:38:12',NULL),(17,NULL,'CBV-123',NULL,'2024-05-08 11:24:55','2024-05-08 11:24:55',NULL),(18,NULL,'TYY-123',NULL,'2024-05-08 11:25:50','2024-05-08 11:25:50',NULL),(19,NULL,'CCQ-408',NULL,'2024-05-10 14:00:42','2024-05-10 14:00:42',NULL),(20,NULL,'D0T-513',NULL,'2024-05-10 14:41:42','2024-05-10 14:41:42',NULL),(21,NULL,'A1F-138',NULL,'2024-05-10 18:03:52','2024-05-10 18:03:52',NULL),(22,NULL,'AWG-715',NULL,'2024-05-10 23:54:38','2024-05-10 23:54:38',NULL),(23,NULL,'N4F-138',NULL,'2024-05-11 00:02:10','2024-05-11 00:02:10',NULL),(24,NULL,'BOH-479',NULL,'2024-05-11 01:10:51','2024-05-11 01:10:51',NULL),(25,NULL,'BHC-429',NULL,'2024-05-11 01:18:31','2024-05-11 01:18:31',NULL),(26,NULL,'BCW-424',NULL,'2024-05-11 01:26:18','2024-05-11 01:26:18',NULL),(27,NULL,'BID-456',NULL,'2024-05-11 01:34:28','2024-05-11 01:34:28',NULL),(28,NULL,'API-142',NULL,'2024-05-12 02:09:52','2024-05-12 02:09:52',NULL),(29,NULL,'BRV-597',NULL,'2024-05-12 02:16:28','2024-05-12 02:16:28',NULL),(30,NULL,'CAA-618',NULL,'2024-05-12 02:17:58','2024-05-12 02:17:58',NULL),(31,NULL,'BZD-254',NULL,'2024-05-12 02:22:04','2024-05-12 02:22:04',NULL),(32,NULL,'B7D-254',NULL,'2024-05-12 02:26:07','2024-05-12 02:26:07',NULL),(33,NULL,'A4E-372',NULL,'2024-05-12 02:32:43','2024-05-12 02:32:43',NULL),(34,NULL,'BNG-537',NULL,'2024-05-14 15:52:16','2024-05-14 15:52:16',NULL),(35,NULL,'BLA-617',NULL,'2024-05-14 15:57:54','2024-05-14 15:57:54',NULL),(36,NULL,'1ZR-206',NULL,'2024-05-14 16:18:54','2024-05-14 16:18:54',NULL);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `places` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(200) NOT NULL,
  `place_address` text NOT NULL,
  `spaces` int(5) NOT NULL,
  `floor` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `remove_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `places`
--

LOCK TABLES `places` WRITE;
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` (`id`, `place_name`, `place_address`, `spaces`, `floor`, `created_at`, `updated_at`, `remove_at`) VALUES (1,'Torre A','Av. El Sol 235, San Juan de Lurigancho 15096',60,'[{\"levels\":0,\"places_quantity\":0,\"place_letter\":[]},{\"levels\":\"3\",\"place_letter\":[\"A\",\"B\"],\"places_quantity\":\"10\"}]','2024-05-07 01:08:42','2024-05-10 09:22:43',NULL),(2,'Torre B','Av. El Sol 235, San Juan de Lurigancho 15096',60,'[{\"levels\":0,\"places_quantity\":0,\"place_letter\":[]},{\"levels\":\"3\",\"place_letter\":[\"A\",\"B\"],\"places_quantity\":\"10\"}]','2024-05-07 01:19:32','2024-05-10 09:22:54',NULL);
/*!40000 ALTER TABLE `places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records`
--

DROP TABLE IF EXISTS `records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_car` bigint(11) NOT NULL,
  `id_place` bigint(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `do` tinyint(1) NOT NULL,
  `floor` int(3) DEFAULT NULL,
  `letter` varchar(3) DEFAULT NULL,
  `number` int(3) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `records_id_car_index` (`id_car`),
  KEY `records_id_place_index` (`id_place`),
  KEY `records_type_index` (`type`),
  KEY `records_do_index` (`do`),
  KEY `records_updated_at_index` (`updated_at`),
  KEY `records_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records`
--

LOCK TABLES `records` WRITE;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
INSERT INTO `records` (`id`, `id_car`, `id_place`, `type`, `do`, `floor`, `letter`, `number`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,8,1,'out',1,NULL,NULL,NULL,'2024-05-13 13:36:13','2024-05-16 12:46:19',NULL),(2,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:54:51','2024-04-24 22:54:51',NULL),(3,3,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:26','2024-04-24 22:55:26',NULL),(4,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(5,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(6,3,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(7,5,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(8,2,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(9,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(10,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(11,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:56:28','2024-04-24 22:56:28',NULL),(12,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:59:01','2024-04-24 22:59:01',NULL),(13,3,2,'no-registered',0,NULL,NULL,NULL,'2024-04-24 22:59:08','2024-04-24 22:59:08',NULL),(14,10,2,'in',1,-2,'A',4,'2024-04-24 23:06:38','2024-04-24 23:06:38',NULL),(15,3,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 23:25:35','2024-04-24 23:25:35',NULL),(18,6,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 23:25:46','2024-04-24 23:25:46',NULL),(20,6,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 23:25:50','2024-04-24 23:25:50',NULL),(21,5,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 23:25:51','2024-04-24 23:25:51',NULL),(22,2,1,'no-registered',0,NULL,NULL,NULL,'2024-04-24 23:25:51','2024-04-24 23:25:51',NULL),(23,17,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:24:55','2024-05-08 11:24:55',NULL),(24,18,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:25:50','2024-05-08 11:25:50',NULL),(25,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:26:57','2024-05-08 11:26:57',NULL),(26,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:27:11','2024-05-08 11:27:11',NULL),(27,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:28:18','2024-05-08 11:28:18',NULL),(28,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:28:44','2024-05-08 11:28:44',NULL),(29,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:30:00','2024-05-08 11:30:00',NULL),(30,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:30:01','2024-05-08 11:30:01',NULL),(31,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:30:01','2024-05-08 11:30:01',NULL),(32,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 13:31:02','2024-05-08 11:30:02',NULL),(33,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 13:32:02','2024-05-08 11:30:02',NULL),(34,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:39:15','2024-05-08 11:39:15',NULL),(35,5,1,'no-registered',0,NULL,NULL,NULL,'2024-05-08 11:42:27','2024-05-08 11:42:27',NULL),(36,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:00:42','2024-05-10 14:00:42',NULL),(37,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:16:12','2024-05-10 14:16:12',NULL),(38,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:16:12','2024-05-10 14:16:12',NULL),(39,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:16:13','2024-05-10 14:16:13',NULL),(40,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:16:13','2024-05-10 14:16:13',NULL),(41,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:17:48','2024-05-10 14:17:48',NULL),(42,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:17:53','2024-05-10 14:17:53',NULL),(43,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:17:58','2024-05-10 14:17:58',NULL),(44,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:24:38','2024-05-10 14:24:38',NULL),(45,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:26:28','2024-05-10 14:26:28',NULL),(46,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:27:26','2024-05-10 14:27:26',NULL),(47,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 14:41:42','2024-05-10 14:41:42',NULL),(48,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 15:09:52','2024-05-10 15:09:52',NULL),(49,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 15:20:55','2024-05-10 15:20:55',NULL),(50,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 15:24:47','2024-05-10 15:24:47',NULL),(51,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 15:30:29','2024-05-10 15:30:29',NULL),(52,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 16:48:18','2024-05-10 16:48:18',NULL),(53,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 16:51:40','2024-05-10 16:51:40',NULL),(54,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 17:19:49','2024-05-10 17:19:49',NULL),(55,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 17:33:00','2024-05-10 17:33:00',NULL),(56,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 18:00:40','2024-05-10 18:00:40',NULL),(57,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 18:01:35','2024-05-10 18:01:35',NULL),(58,21,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 18:03:52','2024-05-10 18:03:52',NULL),(59,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 18:56:58','2024-05-10 18:56:58',NULL),(60,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 19:16:50','2024-05-10 19:16:50',NULL),(61,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 19:29:52','2024-05-10 19:29:52',NULL),(62,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 23:39:54','2024-05-10 23:39:54',NULL),(63,22,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 23:54:38','2024-05-10 23:54:38',NULL),(64,22,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 23:56:27','2024-05-10 23:56:27',NULL),(65,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-10 23:58:08','2024-05-10 23:58:08',NULL),(66,23,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:02:10','2024-05-11 00:02:10',NULL),(67,21,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:10:34','2024-05-11 00:10:34',NULL),(68,23,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:15:10','2024-05-11 00:15:10',NULL),(69,23,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:18:39','2024-05-11 00:18:39',NULL),(70,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:40:10','2024-05-11 00:40:10',NULL),(71,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 00:50:19','2024-05-11 00:50:19',NULL),(72,24,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 01:10:51','2024-05-11 01:10:51',NULL),(73,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 01:13:54','2024-05-11 01:13:54',NULL),(74,25,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 01:18:31','2024-05-11 01:18:31',NULL),(75,26,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 01:26:18','2024-05-11 01:26:18',NULL),(76,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 01:34:28','2024-05-11 01:34:28',NULL),(77,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 23:17:52','2024-05-11 23:17:52',NULL),(78,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 23:30:04','2024-05-11 23:30:04',NULL),(79,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-11 23:52:40','2024-05-11 23:52:40',NULL),(80,22,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 00:11:44','2024-05-12 00:11:44',NULL),(81,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 00:14:56','2024-05-12 00:14:56',NULL),(82,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 00:32:28','2024-05-12 00:32:28',NULL),(83,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 00:41:37','2024-05-12 00:41:37',NULL),(84,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 01:56:43','2024-05-12 01:56:43',NULL),(85,27,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 01:59:16','2024-05-12 01:59:16',NULL),(86,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:09:52','2024-05-12 02:09:52',NULL),(87,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:16:28','2024-05-12 02:16:28',NULL),(88,30,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:17:58','2024-05-12 02:17:58',NULL),(89,31,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:22:04','2024-05-12 02:22:04',NULL),(90,32,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:26:07','2024-05-12 02:26:07',NULL),(91,30,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:27:24','2024-05-12 02:27:24',NULL),(92,33,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:32:43','2024-05-12 02:32:43',NULL),(93,20,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 02:52:20','2024-05-12 02:52:20',NULL),(94,22,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 12:28:06','2024-05-12 12:28:06',NULL),(95,19,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 12:32:13','2024-05-12 12:32:13',NULL),(96,21,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 13:20:18','2024-05-12 13:20:18',NULL),(97,21,1,'no-registered',0,NULL,NULL,NULL,'2024-05-12 13:31:04','2024-05-12 13:31:04',NULL),(98,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 14:36:34','2024-05-13 14:36:34',NULL),(99,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 14:37:53','2024-05-13 14:37:53',NULL),(100,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 14:43:01','2024-05-13 14:43:01',NULL),(101,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 14:44:34','2024-05-13 14:44:34',NULL),(102,28,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 14:51:47','2024-05-13 14:51:47',NULL),(103,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 16:03:54','2024-05-13 16:03:54',NULL),(104,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 16:12:15','2024-05-13 16:12:15',NULL),(105,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 16:16:48','2024-05-13 16:16:48',NULL),(106,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-13 16:19:12','2024-05-13 16:19:12',NULL),(107,29,1,'no-registered',1,NULL,NULL,NULL,'2024-05-14 11:28:33','2024-05-14 11:28:33',NULL),(108,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 12:18:00','2024-05-14 12:18:00',NULL),(109,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 12:22:58','2024-05-14 12:22:58',NULL),(110,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 12:32:42','2024-05-14 12:32:42',NULL),(111,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 12:42:35','2024-05-14 12:42:35',NULL),(112,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 12:49:34','2024-05-14 12:49:34',NULL),(113,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 12:53:15','2024-05-14 12:53:15',NULL),(114,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 12:56:48','2024-05-14 12:56:48',NULL),(115,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 12:58:58','2024-05-14 12:58:58',NULL),(116,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 13:14:17','2024-05-14 13:14:17',NULL),(117,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 13:45:52','2024-05-14 13:45:52',NULL),(118,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 13:53:20','2024-05-14 13:53:20',NULL),(119,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 14:01:36','2024-05-14 14:01:36',NULL),(120,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 14:14:08','2024-05-14 14:14:08',NULL),(121,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 14:22:35','2024-05-14 14:22:35',NULL),(122,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 14:32:22','2024-05-14 14:32:22',NULL),(123,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 15:35:50','2024-05-14 15:35:50',NULL),(124,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 15:41:03','2024-05-14 15:41:03',NULL),(125,34,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 15:52:16','2024-05-14 15:52:16',NULL),(126,35,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 15:57:54','2024-05-14 15:57:54',NULL),(127,36,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 16:18:54','2024-05-14 16:18:54',NULL),(128,37,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 16:32:09','2024-05-14 16:32:09',NULL),(129,37,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 16:34:43','2024-05-14 16:34:43',NULL),(130,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 16:37:42','2024-05-14 16:37:42',NULL),(131,29,1,'no-registered',0,NULL,NULL,NULL,'2024-05-14 16:43:02','2024-05-14 16:43:02',NULL),(132,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 15:28:33','2024-05-14 18:50:33',NULL),(133,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 19:09:34','2024-05-14 19:19:34',NULL),(134,8,1,'in',0,NULL,NULL,NULL,'2024-05-14 19:57:50','2024-05-14 19:57:50',NULL),(136,8,1,'in',1,NULL,NULL,NULL,'2024-05-14 21:27:16','2024-05-14 21:55:09',NULL),(137,8,1,'out',1,NULL,NULL,NULL,'2024-05-14 21:57:30','2024-05-14 21:57:47',NULL),(138,8,1,'in',0,NULL,NULL,NULL,'2024-05-15 00:12:22','2024-05-15 00:12:22',NULL),(139,8,1,'in',1,-1,'A',5,'2024-05-16 12:08:00','2024-05-16 12:35:29',NULL),(141,8,1,'out',1,NULL,NULL,NULL,'2024-05-16 14:12:32','2024-05-16 13:06:32',NULL);
/*!40000 ALTER TABLE `records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sat`
--

DROP TABLE IF EXISTS `sat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sat` (
  `id_sat` int(11) NOT NULL AUTO_INCREMENT,
  `plate` varchar(7) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_sat`),
  KEY `sat_plate_index` (`plate`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sat`
--

LOCK TABLES `sat` WRITE;
/*!40000 ALTER TABLE `sat` DISABLE KEYS */;
INSERT INTO `sat` (`id_sat`, `plate`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,'CVB-123','2024-04-24 14:25:49','2024-04-24 14:25:54',NULL);
/*!40000 ALTER TABLE `sat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `dni` bigint(8) NOT NULL,
  `first_names` varchar(100) NOT NULL,
  `last_names` varchar(100) NOT NULL,
  `cellphone` varchar(12) NOT NULL,
  `type` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `license_number` bigint(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `dni`, `first_names`, `last_names`, `cellphone`, `type`, `username`, `password`, `license_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,73376702,'Kevin Jhomar','Sanchez Sanchez','986253357','seguridad','kj91024','$2y$10$pf9FV4tiDdNAiQIhnruRGuA711J71hjjWRkyNvQlc2aaU01J8euOC',12334556712,'2024-04-22 15:07:26','2024-04-22 15:07:26',NULL),(2,98677654,'Alumno','Alumno','987609874','alumno','alumno','$2y$10$PnuQrj.08ql7bbMxK8oq0OFsxOxG0MHBe1PpNw0Ax.Gqex7hzpff.',98769876988,'2024-04-25 11:54:24','2024-05-16 11:50:47',NULL),(4,98765434,'Profesor','Profesor','513424567','profesor','profesor','$2y$10$PqJUdJoE6eq3BV/6Xpg7BeKfOdhJeWcL7pL7E5xcYJbi4JRAOi9o.',34512345623,'2024-04-25 12:26:09','2024-04-25 12:26:09',NULL),(6,12390734,'Seguridad','Seguridad','123123543','seguridad','seguridad','$2y$10$ZRm.6eit9/bYwB78MESJxOF6mO63tAB35.Ahs8Pa03a.JzkpT.Fj6',0,'2024-04-25 13:50:28','2024-04-25 13:50:28',NULL),(8,12344567,'Administrativo','Administrativo','456734584','administrativo','administrativo','$2y$10$GCpfFo5I.GE8tkWLPFwq1eUtiDrFrao2hSdI9nYfBNjv3WTOjVYQS',12343456678,'2024-04-25 17:25:00','2024-04-25 17:25:00',NULL),(11,73376707,'Pedrito Pedro','Kepler Kalixto','987654345','alumno','pedrito','$2y$10$z7IpbILpE7Vxa0/AexrVreR/lkd/4qRorr2GPVnM.Rr42TjqHn6nW',12344567789,'2024-05-06 23:15:35','2024-05-06 23:15:35',NULL),(12,65467809,'Glente Susano','Frio Feo','345654453','alumno','glente','$2y$10$Ija1nhIXiprjIawz8ZVSEODqeBJrG1rdZN1SjvkD5vvwfo4qipALu',56787890234,'2024-05-06 23:20:27','2024-05-06 23:20:27',NULL),(13,34568765,'Juancito','Pelaes','123445678','alumno','juancito','$2y$10$qAscWtr4fSC7Mfyf0BMA/.yfb3GReNF.hNMD5U7GnushH6dMjlL9a',12341234567,'2024-05-08 10:38:12','2024-05-08 10:38:12',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-19 11:35:15
