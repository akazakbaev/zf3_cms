-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: zf3_cms
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `application_translate_key`
--

DROP TABLE IF EXISTS `application_translate_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_translate_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `translate_text` text NOT NULL,
  `js` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_translate_key`
--

LOCK TABLES `application_translate_key` WRITE;
/*!40000 ALTER TABLE `application_translate_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_translate_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_translates`
--

DROP TABLE IF EXISTS `application_translates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_translates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` int(11) NOT NULL,
  `translate` text NOT NULL,
  `translate_key_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `application_translates_application_translate_key__fk` (`translate_key_id`),
  CONSTRAINT `application_translates_application_translate_key__fk` FOREIGN KEY (`translate_key_id`) REFERENCES `application_translate_key` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_translates`
--

LOCK TABLES `application_translates` WRITE;
/*!40000 ALTER TABLE `application_translates` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_translates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_allows`
--

DROP TABLE IF EXISTS `user_allows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_allows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_allows_user_levels__fk` (`level_id`),
  KEY `user_allows_user_permissions__fk` (`permission_id`),
  CONSTRAINT `user_allows_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_allows_user_permissions__fk` FOREIGN KEY (`permission_id`) REFERENCES `user_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_allows`
--

LOCK TABLES `user_allows` WRITE;
/*!40000 ALTER TABLE `user_allows` DISABLE KEYS */;
INSERT INTO `user_allows` VALUES (8,1,1),(9,1,2);
/*!40000 ALTER TABLE `user_allows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_levels`
--

DROP TABLE IF EXISTS `user_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `description` text,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_levels`
--

LOCK TABLES `user_levels` WRITE;
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT INTO `user_levels` VALUES (1,'admin','admin','admin');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_logins`
--

LOCK TABLES `user_logins` WRITE;
/*!40000 ALTER TABLE `user_logins` DISABLE KEYS */;
INSERT INTO `user_logins` VALUES (1,1,'admin',1,'127.0.0.1','2018-10-09 11:56:37'),(2,1,'admin',1,'127.0.0.1','2018-10-09 11:57:45'),(3,1,'admin',1,'127.0.0.1','2018-10-09 12:15:02'),(4,1,'admin',1,'127.0.0.1','2018-10-10 11:09:52'),(5,1,'admin',1,'127.0.0.1','2018-10-10 12:58:21');
/*!40000 ALTER TABLE `user_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,'languages.list','Languages List Page'),(2,'settings.permissions','Permission Page');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_users`
--

DROP TABLE IF EXISTS `user_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_users_email_uindex` (`email`),
  UNIQUE KEY `user_users_username_uindex` (`username`),
  KEY `user_users_user_levels__fk` (`level_id`),
  CONSTRAINT `user_users_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_users`
--

LOCK TABLES `user_users` WRITE;
/*!40000 ALTER TABLE `user_users` DISABLE KEYS */;
INSERT INTO `user_users` VALUES (1,'kazakbaev-89@mail.ru','admin','$2y$10$FEznmCetodvLsMrr5/raPuupsdZp2WxmXgYcm3TH2ZBrHq.DYGDQG',1,1,'2018-10-09 11:55:21');
/*!40000 ALTER TABLE `user_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-11 17:54:12
