-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: orphanage
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `adopt`
--

DROP TABLE IF EXISTS `adopt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adopt` (
  `AdoptId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AdoptedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdopId` int(10) unsigned NOT NULL,
  `OId` int(10) unsigned NOT NULL,
  `ChId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`AdoptId`),
  KEY `AdopId` (`AdopId`),
  KEY `OId` (`OId`),
  KEY `ChId` (`ChId`),
  CONSTRAINT `adopt_ibfk_1` FOREIGN KEY (`AdopId`) REFERENCES `adopter` (`AdopId`),
  CONSTRAINT `adopt_ibfk_2` FOREIGN KEY (`OId`) REFERENCES `orphanage` (`OId`),
  CONSTRAINT `adopt_ibfk_3` FOREIGN KEY (`ChId`) REFERENCES `godchild` (`ChId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adopt`
--

LOCK TABLES `adopt` WRITE;
/*!40000 ALTER TABLE `adopt` DISABLE KEYS */;
/*!40000 ALTER TABLE `adopt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adopter`
--

DROP TABLE IF EXISTS `adopter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adopter` (
  `AdopId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FName` varchar(32) NOT NULL,
  `LName` varchar(32) NOT NULL,
  `Gender` tinyint(1) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `City` varchar(64) NOT NULL,
  `Pin` char(6) NOT NULL,
  `State` varchar(64) NOT NULL,
  `RegdOn` date DEFAULT NULL,
  `AadhaarNo` varchar(12) DEFAULT NULL,
  `Email` varchar(64) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`AdopId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adopter`
--

LOCK TABLES `adopter` WRITE;
/*!40000 ALTER TABLE `adopter` DISABLE KEYS */;
INSERT INTO `adopter` VALUES (1,'Talaha','Ansari',1,'23, Lane no 2, Jagatdal','','Kankinara','743125','West Bengal','2017-05-08','110856981233','talaha@gmail.com','7003054711','/assets/img/sites/avatar_m.png'),(2,'Ibtesham','Shaheen',2,'25/2, E.G.P. Road, Naihati','','Kolkata','743127','West Bengal','2017-05-08','567899991234','ibtesham@live.com','9331098798','/assets/img/usr/20170508084944.jpg');
/*!40000 ALTER TABLE `adopter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment` (
  `AppId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AppTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AppCreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(255) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `AdopId` int(10) unsigned NOT NULL,
  `OId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`AppId`),
  KEY `AdopId` (`AdopId`),
  KEY `OId` (`OId`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`AdopId`) REFERENCES `adopter` (`AdopId`),
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`OId`) REFERENCES `orphanage` (`OId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `children_count_V`
--

DROP TABLE IF EXISTS `children_count_V`;
/*!50001 DROP VIEW IF EXISTS `children_count_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `children_count_V` AS SELECT 
 1 AS `OId`,
 1 AS `Children`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `children_female_V`
--

DROP TABLE IF EXISTS `children_female_V`;
/*!50001 DROP VIEW IF EXISTS `children_female_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `children_female_V` AS SELECT 
 1 AS `OId`,
 1 AS `Female`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `children_male_V`
--

DROP TABLE IF EXISTS `children_male_V`;
/*!50001 DROP VIEW IF EXISTS `children_male_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `children_male_V` AS SELECT 
 1 AS `OId`,
 1 AS `Male`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `children_stats_V`
--

DROP TABLE IF EXISTS `children_stats_V`;
/*!50001 DROP VIEW IF EXISTS `children_stats_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `children_stats_V` AS SELECT 
 1 AS `OId`,
 1 AS `Children`,
 1 AS `Male`,
 1 AS `Female`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `ConId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) DEFAULT NULL,
  `Email` varchar(64) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `ContactedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ConId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'','aman@gmail.com','9836123456','2017-05-08 16:35:55',''),(2,'Aman Singh','aman@gmail.com','9836123456','2017-05-08 16:40:04','this is also a dummy content.');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `godchild`
--

DROP TABLE IF EXISTS `godchild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `godchild` (
  `ChId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FName` varchar(32) NOT NULL,
  `LName` varchar(32) NOT NULL,
  `Dob` date DEFAULT NULL,
  `Gender` tinyint(1) NOT NULL,
  `Age` tinyint(3) unsigned NOT NULL,
  `Colour` varchar(32) DEFAULT NULL,
  `RegOn` date DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `OId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ChId`),
  KEY `OId` (`OId`),
  CONSTRAINT `godchild_ibfk_1` FOREIGN KEY (`OId`) REFERENCES `orphanage` (`OId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `godchild`
--

LOCK TABLES `godchild` WRITE;
/*!40000 ALTER TABLE `godchild` DISABLE KEYS */;
INSERT INTO `godchild` VALUES (1,'Punam','Shaw','2008-01-01',2,9,'Brown','2017-05-10','/assets/img/godschild/20170510030836_1494409116.jpg',2),(3,'Sahil','Das','2012-02-06',1,5,'Brown','2017-05-10','/assets/img/godschild/20170510041426_1494413066.jpg',2),(4,'Suhani','Siriwastaw','2011-01-08',2,6,'fair','2017-05-10','/assets/img/godschild/20170510042234_1494413554.jpg',2),(5,'Rukhsana','Parveen','2010-01-01',2,7,'fair','2017-05-10','/assets/img/godschild/20170510050413_1494416053.jpg',2),(6,'Anshuman','Rana','2008-02-12',1,9,'Fair','2017-05-11','/assets/img/godschild/20170511020143_1494491503.jpg',1),(7,'Ananya','Pretty','2008-11-12',2,8,'Fair','2017-05-11','/assets/img/godschild/20170511020320_1494491600.jpg',1),(8,'Ravi','Kishan','2009-06-05',1,7,'Brown','2017-05-11','/assets/img/godschild/20170511020443_1494491683.jpg',1);
/*!40000 ALTER TABLE `godchild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `LId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserId` int(10) unsigned NOT NULL,
  `UserType` tinyint(1) NOT NULL,
  PRIMARY KEY (`LId`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'talaha@gmail.com','$2y$10$4D8EkZ4o1JGQJa93J/vhPug2m20MfnYWa7TahWWZAYx6Vtak4PAuW',1,1),(2,'rupali@gmail.com','$2y$10$iyLh8mRrlTYfQFkF1dJZMuST/ARh78zMokquiKI0RT.H42evBrSDW',1,2),(3,'muktar@yahoo.com','$2y$10$wA/7J.w3rZtDks2/AwiYhuRMuNJChEzaM5t/baM/VEJnKFEhHP/by',2,2),(4,'ibtesham@live.com','$2y$10$MAdztYYmENjF96806TnoP.hepRdMonNGtj/NN823RDlKH3IuqeDXS',2,1);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `MsgId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MsgDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IsRead` tinyint(1) DEFAULT NULL,
  `AdopId` int(10) unsigned NOT NULL,
  `OId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`MsgId`),
  KEY `AdopId` (`AdopId`),
  KEY `OId` (`OId`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`AdopId`) REFERENCES `adopter` (`AdopId`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`OId`) REFERENCES `orphanage` (`OId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orphanage`
--

DROP TABLE IF EXISTS `orphanage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orphanage` (
  `OId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FName` varchar(32) NOT NULL,
  `LName` varchar(32) NOT NULL,
  `OrgName` varchar(100) NOT NULL,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `City` varchar(64) NOT NULL,
  `Pin` char(6) NOT NULL,
  `State` varchar(64) NOT NULL,
  `RegNo` varchar(32) NOT NULL,
  `RegdOn` date DEFAULT NULL,
  `Email` varchar(64) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Website` varchar(64) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`OId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orphanage`
--

LOCK TABLES `orphanage` WRITE;
/*!40000 ALTER TABLE `orphanage` DISABLE KEYS */;
INSERT INTO `orphanage` VALUES (1,'Rupali','Tiwari','Parvarish','7, Kachahari road','Kankinara','Kolkata','743126','West Bengal','1234566','2017-05-08','rupali@gmail.com','9831546588',NULL,'/assets/img/usr/20170511061206.jpg'),(2,'Shek','Muktar','God\'s child','25/2, G.T. Road, Behala','','Kolkata','700123','West Bengal','AA98GC123','2017-05-08','muktar@yahoo.com','9163899894',NULL,'/assets/img/usr/20170511023144.jpg');
/*!40000 ALTER TABLE `orphanage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `RId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Reporter` varchar(64) DEFAULT NULL,
  `Email` varchar(64) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `ReportedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Location` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`RId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `children_count_V`
--

/*!50001 DROP VIEW IF EXISTS `children_count_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `children_count_V` AS select `godchild`.`OId` AS `OId`,count(`godchild`.`ChId`) AS `Children` from `godchild` group by `godchild`.`OId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `children_female_V`
--

/*!50001 DROP VIEW IF EXISTS `children_female_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `children_female_V` AS select `godchild`.`OId` AS `OId`,count(`godchild`.`Gender`) AS `Female` from `godchild` where (`godchild`.`Gender` = 2) group by `godchild`.`OId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `children_male_V`
--

/*!50001 DROP VIEW IF EXISTS `children_male_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `children_male_V` AS select `godchild`.`OId` AS `OId`,count(`godchild`.`Gender`) AS `Male` from `godchild` where (`godchild`.`Gender` = 1) group by `godchild`.`OId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `children_stats_V`
--

/*!50001 DROP VIEW IF EXISTS `children_stats_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `children_stats_V` AS select `ch`.`OId` AS `OId`,`ch`.`Children` AS `Children`,`chm`.`Male` AS `Male`,`chf`.`Female` AS `Female` from ((`children_count_V` `ch` join `children_male_V` `chm` on((`ch`.`OId` = `chm`.`OId`))) join `children_female_V` `chf` on((`ch`.`OId` = `chf`.`OId`))) order by `ch`.`OId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-11 15:13:52
