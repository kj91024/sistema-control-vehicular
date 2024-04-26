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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` (`id`, `id_user`, `plate`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES (3,NULL,'AFH-849',NULL,'2024-04-22 17:47:48','2024-04-22 17:47:48',NULL),(5,NULL,'CVB-123',NULL,'2024-04-24 23:25:40','2024-04-24 23:25:40',NULL),(6,NULL,'HJK-123',NULL,'2024-04-24 23:25:43','2024-04-24 23:25:43',NULL),(7,NULL,'ERT-123',NULL,'2024-04-24 23:25:48','2024-04-24 23:25:48',NULL),(8,2,'ENX-567',NULL,'2024-04-25 11:54:24','2024-04-25 11:54:24',NULL),(10,4,'TTT-111',NULL,'2024-04-25 12:26:09','2024-04-25 12:26:09',NULL),(13,8,'QQQ-415',NULL,'2024-04-25 17:25:00','2024-04-25 17:25:00',NULL);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records`
--

DROP TABLE IF EXISTS `records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_car` bigint(11) DEFAULT NULL,
  `type` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records`
--

LOCK TABLES `records` WRITE;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
INSERT INTO `records` (`id`, `id_car`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,8,'in','2024-04-24 19:12:13','2024-04-24 19:12:13',NULL),(2,3,'no-registered','2024-04-24 22:54:51','2024-04-24 22:54:51',NULL),(3,3,'no-registered','2024-04-24 22:55:26','2024-04-24 22:55:26',NULL),(4,3,'no-registered','2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(5,3,'no-registered','2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(6,3,'no-registered','2024-04-24 22:55:39','2024-04-24 22:55:39',NULL),(7,5,'no-registered','2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(8,2,'no-registered','2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(9,3,'no-registered','2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(10,3,'no-registered','2024-04-24 22:55:40','2024-04-24 22:55:40',NULL),(11,3,'no-registered','2024-04-24 22:56:28','2024-04-24 22:56:28',NULL),(12,3,'no-registered','2024-04-24 22:59:01','2024-04-24 22:59:01',NULL),(13,3,'no-registered','2024-04-24 22:59:08','2024-04-24 22:59:08',NULL),(14,3,'no-registered','2024-04-24 23:06:38','2024-04-24 23:06:38',NULL),(15,3,'no-registered','2024-04-24 23:25:35','2024-04-24 23:25:35',NULL),(18,6,'no-registered','2024-04-24 23:25:46','2024-04-24 23:25:46',NULL),(20,6,'no-registered','2024-04-24 23:25:50','2024-04-24 23:25:50',NULL),(21,5,'no-registered','2024-04-24 23:25:51','2024-04-24 23:25:51',NULL),(22,3,'no-registered','2024-04-24 23:25:51','2024-04-24 23:25:51',NULL);
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
  PRIMARY KEY (`id_sat`)
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `dni`, `first_names`, `last_names`, `cellphone`, `type`, `username`, `password`, `license_number`, `created_at`, `updated_at`, `deleted_at`) VALUES (1,73376702,'Kevin Jhomar','Sanchez Sanchez','986253357','seguridad','kj91024','$2y$10$pf9FV4tiDdNAiQIhnruRGuA711J71hjjWRkyNvQlc2aaU01J8euOC',12334556712,'2024-04-22 15:07:26','2024-04-22 15:07:26',NULL),(2,12345678,'Alumno','Alumno','123456789','alumno','alumno','$2y$10$q5PBZKCqnCdRvOxjYdwAAe/TGCfGUVJq7aBPlrtpWTdjVw9GSXY4O',12345678912,'2024-04-25 11:54:24','2024-04-25 11:54:24',NULL),(4,98765434,'Profesor','Profesor','513424567','profesor','profesor','$2y$10$PqJUdJoE6eq3BV/6Xpg7BeKfOdhJeWcL7pL7E5xcYJbi4JRAOi9o.',34512345623,'2024-04-25 12:26:09','2024-04-25 12:26:09',NULL),(6,12390734,'Seguridad','Seguridad','123123543','seguridad','seguridad','$2y$10$ZRm.6eit9/bYwB78MESJxOF6mO63tAB35.Ahs8Pa03a.JzkpT.Fj6',0,'2024-04-25 13:50:28','2024-04-25 13:50:28',NULL),(8,12344567,'Administrativo','Administrativo','456734584','administrativo','administrativo','$2y$10$GCpfFo5I.GE8tkWLPFwq1eUtiDrFrao2hSdI9nYfBNjv3WTOjVYQS',12343456678,'2024-04-25 17:25:00','2024-04-25 17:25:00',NULL);
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

-- Dump completed on 2024-04-26 11:56:35
