-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: symfony
-- ------------------------------------------------------
-- Server version	5.7.18-1

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
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'Forkalkié','34000','123 je sais aps'),(3,'Montpellier','34090','5 rue javadoc'),(4,'Vaison','84110','27 impasse beausoleil'),(5,'Cirebon','84651','5 rue javadoc');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (2,'Philosophy',0),(3,'Novel',0),(4,'Physics',0),(5,'IT',0);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `librarian_username` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5F9E962A8B9D1CC4` (`member_code`),
  KEY `IDX_5F9E962ABF257463` (`item_code`),
  KEY `IDX_5F9E962A8E23B596` (`librarian_username`),
  CONSTRAINT `FK_5F9E962A8B9D1CC4` FOREIGN KEY (`member_code`) REFERENCES `member` (`code`) ON DELETE CASCADE,
  CONSTRAINT `FK_5F9E962A8E23B596` FOREIGN KEY (`librarian_username`) REFERENCES `librarian` (`username`) ON DELETE CASCADE,
  CONSTRAINT `FK_5F9E962ABF257463` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (6,NULL,'000003','C\'est ma pièce favorite de Camus !','lolo');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `degree`
--

DROP TABLE IF EXISTS `degree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `degree`
--

LOCK TABLES `degree` WRITE;
/*!40000 ALTER TABLE `degree` DISABLE KEYS */;
INSERT INTO `degree` VALUES (1,'Bacchelor'),(2,'Master');
/*!40000 ALTER TABLE `degree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `degree_year`
--

DROP TABLE IF EXISTS `degree_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `degree_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `degree_year`
--

LOCK TABLES `degree_year` WRITE;
/*!40000 ALTER TABLE `degree_year` DISABLE KEYS */;
INSERT INTO `degree_year` VALUES (1,1),(2,2),(3,3),(4,4);
/*!40000 ALTER TABLE `degree_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (1,'IT'),(2,'Civil Engineering'),(3,'Mechanics');
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `function`
--

DROP TABLE IF EXISTS `function`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `function`
--

LOCK TABLES `function` WRITE;
/*!40000 ALTER TABLE `function` DISABLE KEYS */;
INSERT INTO `function` VALUES (1,'Developper'),(2,'Lecturer'),(3,'Administration');
/*!40000 ALTER TABLE `function` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` int(11) NOT NULL,
  `isbn` int(11) DEFAULT NULL,
  `total_unit` int(11) NOT NULL,
  `borrowed_unit` int(11) NOT NULL,
  `lost_unit` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `disable` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `bookable` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` date NOT NULL,
  `booked_unit` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `IDX_1F1B251E82F1BAF4` (`language_id`),
  KEY `IDX_1F1B251EC54C8C93` (`type_id`),
  KEY `IDX_1F1B251E12469DE2` (`category_id`),
  CONSTRAINT `FK_1F1B251E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1F1B251E82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  CONSTRAINT `FK_1F1B251EC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES ('000001',5,2,4,'Principia Mathematica Philosophiae Naturalis','Isaac Newton','Benjamin Motte',1687,NULL,1,0,0,100,0,3,'Available','2017-06-16',0),('000002',2,2,2,'Das Kapital','Karl Marx','N/A',1867,NULL,5,0,0,20,0,2,'Available','2017-06-16',0),('000003',2,2,2,'Les Justes','Albert Camus','N/A',1949,NULL,6,0,0,5,0,5,'Available','2017-06-16',1);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemunits`
--

DROP TABLE IF EXISTS `itemunits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemunits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CA540A9BF257463` (`item_code`),
  CONSTRAINT `FK_7CA540A9BF257463` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemunits`
--

LOCK TABLES `itemunits` WRITE;
/*!40000 ALTER TABLE `itemunits` DISABLE KEYS */;
INSERT INTO `itemunits` VALUES (2,'000003',5,'2017-06-16');
/*!40000 ALTER TABLE `itemunits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (2,'English'),(3,'Khmer'),(4,'French'),(5,'Latin');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `librarian`
--

DROP TABLE IF EXISTS `librarian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `librarian` (
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hire_date` date NOT NULL,
  `resign_date` date DEFAULT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disable` int(11) NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`username`),
  KEY `IDX_3DB7FC74F5B7AF75` (`address_id`),
  CONSTRAINT `FK_3DB7FC74F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `librarian`
--

LOCK TABLES `librarian` WRITE;
/*!40000 ALTER TABLE `librarian` DISABLE KEYS */;
INSERT INTO `librarian` VALUES ('lolo',4,'Léo','Andeol','M','leo.andeol@gmail.com','0777380980','2017-06-14',NULL,'f412d25190fb44b5bc48fe2fbfc000567f8f212bff935b976fa41e2e2ab1bb8e',0,'Lib-lolo.jpeg');
/*!40000 ALTER TABLE `librarian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `librarian_username` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_date` date NOT NULL,
  `action` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F08FC65C8E23B596` (`librarian_username`),
  CONSTRAINT `FK_F08FC65C8E23B596` FOREIGN KEY (`librarian_username`) REFERENCES `librarian` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (7,'lolo','2017-06-14','Connection'),(8,'lolo','2017-06-16','Disconnection'),(9,'lolo','2017-06-16','Connection'),(11,'lolo','2017-06-16','Added new member NPIC-8899'),(12,'lolo','2017-06-16','Disconnection'),(13,'lolo','2017-06-16','Connection'),(14,'lolo','2017-06-16','Added 7 units to the item YOLO'),(15,'lolo','2017-06-16','Disconnection'),(16,'lolo','2017-06-16','Connection'),(17,'lolo','2017-06-16','Added item $code'),(18,'lolo','2017-06-16','Disconnection'),(19,'lolo','2017-06-16','Connection'),(20,'lolo','2017-06-16','Added new motd '),(21,'lolo','2017-06-16','Added new motd '),(22,'lolo','2017-06-16','Disconnection'),(23,'lolo','2017-06-16','Connection'),(24,'lolo','2017-06-16','Disconnection'),(25,'lolo','2017-06-16','Connection'),(26,'lolo','2017-06-16','Connection'),(27,'lolo','2017-06-16','Connection'),(28,'lolo','2017-06-16','Updated librarian lolo'),(29,'lolo','2017-06-16','Updated member NPIC-8899'),(30,'lolo','2017-06-16','Updated member NPIC-8899'),(31,'lolo','2017-06-16','Added item $code'),(32,'lolo','2017-06-16','Added item $code'),(33,'lolo','2017-06-16','Added item $code'),(34,'lolo','2017-06-16','Added 5 units to the item 000003'),(35,'lolo','2017-06-16','Disconnection');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `major`
--

LOCK TABLES `major` WRITE;
/*!40000 ALTER TABLE `major` DISABLE KEYS */;
INSERT INTO `major` VALUES (1,'IT'),(2,'Networking'),(3,'Architecture'),(4,'Mechanics');
/*!40000 ALTER TABLE `major` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `function_id` int(11) DEFAULT NULL,
  `major_id` int(11) DEFAULT NULL,
  `degree_id` int(11) DEFAULT NULL,
  `degree_year_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` int(11) NOT NULL,
  `civil_situation` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `tel_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_home` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_date` date NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff` tinyint(1) NOT NULL,
  `student` tinyint(1) NOT NULL,
  `disable` int(11) NOT NULL,
  `disable_reason` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disable_date` date DEFAULT NULL,
  `current_borrowed_books_nb` int(11) NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`code`),
  KEY `IDX_70E4FA7867048801` (`function_id`),
  KEY `IDX_70E4FA78E93695C7` (`major_id`),
  KEY `IDX_70E4FA78B35C5756` (`degree_id`),
  KEY `IDX_70E4FA78DD03B561` (`degree_year_id`),
  KEY `IDX_70E4FA78F5B7AF75` (`address_id`),
  KEY `IDX_70E4FA78680CAB68` (`faculty_id`),
  CONSTRAINT `FK_70E4FA7867048801` FOREIGN KEY (`function_id`) REFERENCES `function` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_70E4FA78680CAB68` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_70E4FA78B35C5756` FOREIGN KEY (`degree_id`) REFERENCES `degree` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_70E4FA78DD03B561` FOREIGN KEY (`degree_year_id`) REFERENCES `degree_year` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_70E4FA78E93695C7` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_70E4FA78F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES ('NPIC-8899',1,2,1,4,5,1,'Dina','Shintika',89746521,'single','F','2017-01-01','4654987645312','012345678','045648998','dinas@yopmail.fr','2017-06-16','fbe8a01a1293880ab43b188f8d83a66121419dd257ff191131ec6768311e8c6f',0,1,0,NULL,NULL,1,'Member-NPIC-8899.jpeg');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motd`
--

DROP TABLE IF EXISTS `motd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motd_content` varchar(640) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motd`
--

LOCK TABLES `motd` WRITE;
/*!40000 ALTER TABLE `motd` DISABLE KEYS */;
INSERT INTO `motd` VALUES (1,'cc les gens'),(2,'Bienvenue sur le site');
/*!40000 ALTER TABLE `motd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motddisplayed`
--

DROP TABLE IF EXISTS `motddisplayed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motddisplayed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motd_content` varchar(640) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motddisplayed`
--

LOCK TABLES `motddisplayed` WRITE;
/*!40000 ALTER TABLE `motddisplayed` DISABLE KEYS */;
INSERT INTO `motddisplayed` VALUES (1,'Bienvenue sur le site');
/*!40000 ALTER TABLE `motddisplayed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `item_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  PRIMARY KEY (`item_code`,`member_code`),
  KEY `IDX_CFBDFA14BF257463` (`item_code`),
  KEY `IDX_CFBDFA148B9D1CC4` (`member_code`),
  CONSTRAINT `FK_CFBDFA148B9D1CC4` FOREIGN KEY (`member_code`) REFERENCES `member` (`code`) ON DELETE CASCADE,
  CONSTRAINT `FK_CFBDFA14BF257463` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES ('000001','NPIC-8899',3),('000002','NPIC-8899',2),('000003','NPIC-8899',5);
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliments`
--

DROP TABLE IF EXISTS `suppliments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `disable` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8E752F17BF257463` (`item_code`),
  CONSTRAINT `FK_8E752F17BF257463` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliments`
--

LOCK TABLES `suppliments` WRITE;
/*!40000 ALTER TABLE `suppliments` DISABLE KEYS */;
/*!40000 ALTER TABLE `suppliments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `fine_cost_per_day` int(11) NOT NULL,
  `state` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lib_for_borrow` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lib_for_return` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booked_date` date DEFAULT NULL,
  `to_return_date` date DEFAULT NULL,
  `fine_to_pay` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_723705D18B9D1CC4` (`member_code`),
  KEY `IDX_723705D1BF257463` (`item_code`),
  KEY `IDX_723705D1510850E2` (`lib_for_borrow`),
  KEY `IDX_723705D1A34DC75D` (`lib_for_return`),
  CONSTRAINT `FK_723705D1510850E2` FOREIGN KEY (`lib_for_borrow`) REFERENCES `librarian` (`username`) ON DELETE CASCADE,
  CONSTRAINT `FK_723705D18B9D1CC4` FOREIGN KEY (`member_code`) REFERENCES `member` (`code`) ON DELETE CASCADE,
  CONSTRAINT `FK_723705D1A34DC75D` FOREIGN KEY (`lib_for_return`) REFERENCES `librarian` (`username`) ON DELETE CASCADE,
  CONSTRAINT `FK_723705D1BF257463` FOREIGN KEY (`item_code`) REFERENCES `item` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (3,'NPIC-8899','000003',NULL,NULL,1,'Booked',NULL,NULL,NULL,'2017-06-16',NULL,0);
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (2,'Book'),(3,'CD'),(4,'DVD');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlogs`
--

DROP TABLE IF EXISTS `userlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_date` date NOT NULL,
  `action` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_56F2BE2D8B9D1CC4` (`member_code`),
  CONSTRAINT `FK_56F2BE2D8B9D1CC4` FOREIGN KEY (`member_code`) REFERENCES `member` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlogs`
--

LOCK TABLES `userlogs` WRITE;
/*!40000 ALTER TABLE `userlogs` DISABLE KEYS */;
INSERT INTO `userlogs` VALUES (1,'NPIC-8899','2017-06-16','Connection'),(2,'NPIC-8899','2017-06-16','Disconnection'),(3,'NPIC-8899','2017-06-16','Connection'),(4,'NPIC-8899','2017-06-16','Disconnection'),(5,'NPIC-8899','2017-06-16','Connection'),(6,'NPIC-8899','2017-06-16','Disconnection'),(7,'NPIC-8899','2017-06-16','Connection'),(8,'NPIC-8899','2017-06-16','Disconnection'),(9,'NPIC-8899','2017-06-16','Connection'),(10,'NPIC-8899','2017-06-16','Disconnection'),(11,'NPIC-8899','2017-06-16','Connection');
/*!40000 ALTER TABLE `userlogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-16 13:28:00
