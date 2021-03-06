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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adopt`
--

LOCK TABLES `adopt` WRITE;
/*!40000 ALTER TABLE `adopt` DISABLE KEYS */;
INSERT INTO `adopt` VALUES (1,'2017-05-14 12:32:49',1,2,1);
/*!40000 ALTER TABLE `adopt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `adopt_V`
--

DROP TABLE IF EXISTS `adopt_V`;
/*!50001 DROP VIEW IF EXISTS `adopt_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `adopt_V` AS SELECT 
 1 AS `AdoptId`,
 1 AS `AdoptedAt`,
 1 AS `AdopId`,
 1 AS `OId`,
 1 AS `ChId`,
 1 AS `OrgName`,
 1 AS `gcFName`,
 1 AS `gcLName`*/;
SET character_set_client = @saved_cs_client;

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
  `Poi` varchar(255) DEFAULT NULL,
  `Poa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`AdopId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adopter`
--

LOCK TABLES `adopter` WRITE;
/*!40000 ALTER TABLE `adopter` DISABLE KEYS */;
INSERT INTO `adopter` VALUES (1,'Talaha','Ansari',1,'23, Lane no 2, Jagatdal','','Kolkata','743125','West Bengal','2017-05-08','110856981233','talaha@gmail.com','7003054711','/assets/img/sites/avatar_m.png','',NULL),(2,'Ibtesham','Shaheen',2,'25/2, E.G.P. Road, Naihati','','Kolkata','743127','West Bengal','2017-05-08','567899991234','ibtesham@live.com','9331098798','/assets/img/usr/20170508084944.jpg','',NULL),(3,'Rathish','Sharma',1,'23/2, B.L. No.-12, Papermill, Patna','Dist - Ara jila','Patna','900123','Bihar','2017-05-14','123456789123','rathish@gmail.com','8192309966','/assets/img/usr/20170514023106.jpg','/assets/img/usr/docs/poi_20170514023106.jpg','/assets/img/usr/docs/poa_20170514023106.jpg');
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
  `RequestedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(255) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `AdopId` int(10) unsigned NOT NULL,
  `OId` int(10) unsigned NOT NULL,
  `ChId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`AppId`),
  KEY `AdopId` (`AdopId`),
  KEY `OId` (`OId`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`AdopId`) REFERENCES `adopter` (`AdopId`),
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`OId`) REFERENCES `orphanage` (`OId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,'2017-05-13 00:23:01','2017-05-12 00:23:01','You have not uploaded your documents of proof, so we can not verify your identity!',3,2,1,1),(2,'2017-05-29 06:00:00','2017-05-12 00:26:38',NULL,2,1,2,1);
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `appointment_V`
--

DROP TABLE IF EXISTS `appointment_V`;
/*!50001 DROP VIEW IF EXISTS `appointment_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `appointment_V` AS SELECT 
 1 AS `AppId`,
 1 AS `AppTimestamp`,
 1 AS `RequestedOn`,
 1 AS `Description`,
 1 AS `Status`,
 1 AS `AdopId`,
 1 AS `OId`,
 1 AS `ChId`,
 1 AS `OrgName`,
 1 AS `FName`,
 1 AS `LName`,
 1 AS `gcFName`,
 1 AS `gcLName`*/;
SET character_set_client = @saved_cs_client;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `godchild`
--

LOCK TABLES `godchild` WRITE;
/*!40000 ALTER TABLE `godchild` DISABLE KEYS */;
INSERT INTO `godchild` VALUES (1,'Punam','Shaw','2008-01-01',2,9,'Brown','2017-05-10','/assets/img/godschild/20170510030836_1494409116.jpg',2),(3,'Sahil','Das','2012-02-06',1,5,'Brown','2017-05-10','/assets/img/godschild/20170510041426_1494413066.jpg',2),(4,'Suhani','Siriwastaw','2011-01-08',2,6,'fair','2017-05-10','/assets/img/godschild/20170510042234_1494413554.jpg',2),(5,'Rukhsana','Parveen','2010-01-01',2,7,'fair','2017-05-10','/assets/img/godschild/20170510050413_1494416053.jpg',2),(6,'Anshuman','Rana','2008-02-12',1,9,'Fair','2017-05-11','/assets/img/godschild/20170511020143_1494491503.jpg',1),(7,'Ananya','Pretty','2008-11-12',2,8,'Fair','2017-05-11','/assets/img/godschild/20170511020320_1494491600.jpg',1),(8,'Ravi','Kishan','2009-06-05',1,7,'Brown','2017-05-11','/assets/img/godschild/20170511020443_1494491683.jpg',1),(9,'Piyush','Shaw','2002-08-13',1,14,'Fair','2017-05-13','/assets/img/godschild/20170513125512_1494617112.jpg',3),(10,'Shiwangi','Sharma','2005-12-03',2,11,'fair','2017-05-13','/assets/img/godschild/20170513010633_1494617793.jpg',3),(11,'Farhan','Quraishi','2005-10-03',1,11,'Fair','2017-05-16','/assets/img/godschild/20170516122835_1494874715.jpg',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'talaha@gmail.com','$2y$10$4D8EkZ4o1JGQJa93J/vhPug2m20MfnYWa7TahWWZAYx6Vtak4PAuW',1,1),(2,'rupali@gmail.com','$2y$10$iyLh8mRrlTYfQFkF1dJZMuST/ARh78zMokquiKI0RT.H42evBrSDW',1,2),(3,'muktar@yahoo.com','$2y$10$7Jn.KqDiqJYLh8P1qv8ZceQt4nA1Mr7Pi98z5WmlP0eKhtTVuKPMG',2,2),(4,'ibtesham@live.com','$2y$10$9kkVCUMmA5LcRfaVTZAFIOAYL3.mIdLijvv5G8LvCZKOdQi9q/wwK',2,1),(5,'abhiyan_office@sify.com','$2y$10$of/.r/VPDuT/bhnhSfUEJenCAC6HFtTNZnyMn/vOC6gCFMGmI8aGe',3,2),(6,'rathish@gmail.com','$2y$10$rtG2kOqVNhS.Skohg5ZgGuFxzbI3305LwQ0bLSMlgyevDVIu9WzV.',3,1),(7,'childrenwalkingtall@hotmail.com','$2y$10$VT0M6txtdTgan.frzTOaR.GII72pawvDENadtfELerPDUD0WoSWou',4,2),(8,'cini@ciniindia.org','$2y$10$lYbllYlXpkiV/zFs.iBMM.5NKyL6ecddmM44gpYX3sPhrUfjmcmuO',5,2),(9,'princeag@bsnl.in','$2y$10$WhJQ1d4F6xyr3ACbmZH73OnbXpeRpAp2IMg8.mfZZ.Y9Qdj/EVBXC',6,2),(10,'info@ccchildrenhome.org','$2y$10$hracmMhOEPznypyNyhU99e.709vDoPyXgNMhxHGN6WDJJp.W7vRQi',7,2),(11,'barasatanweshan@yahoo.com','$2y$10$J0IyNvMjSHWrK.xo8MwBiOE7uRSWzOQkxTwSl6skko1oKAuu6gejO',8,2),(12,'clgm1990@yahoo.co.uk','$2y$10$55WHeaLN4rfCywmrpytovO1mX1wiTCuFeRZ1.4m1QVvEIMXodbsXq',9,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orphanage`
--

LOCK TABLES `orphanage` WRITE;
/*!40000 ALTER TABLE `orphanage` DISABLE KEYS */;
INSERT INTO `orphanage` VALUES (1,'Rupali','Tiwari','Parvarish','7, Kachahari road','Kankinara','Kolkata','743126','West Bengal','1234566','2017-05-08','rupali@gmail.com','9831546588',NULL,'/assets/img/usr/20170511061206.jpg'),(2,'Shek','Muktar','God\'s child','25/2, G.T. Road, Behala','','Kolkata','700123','West Bengal','AA98GC123','2017-05-08','muktar@yahoo.com','9163899894',NULL,'/assets/img/usr/20170511023144.jpg'),(3,'Mr.','Chandrabhushan','Abhiyan','Abhiyan, Barai bhawan, Birsa Adivasi Colony','Gulzarbagh','Patna','800007','Bihar','FCRA [No. 031170097]','2017-05-13','abhiyan_office@sify.com','6122311874','www.sify.com','/assets/img/usr/20170513125255.jpg'),(4,'Denise',' Ganatra','Children Walking Tall','The Mango House Near Vrundavan Hospital Karaswada','Mapusa Panaji','Goa','403527','Goa','FCRA No.123098','2017-05-15','childrenwalkingtall@hotmail.com','9822124802','','/assets/img/usr/20170515115542.jpg'),(5,'S. N.','Chaudhari','Child In Need Institute','Dr. S.N. Chaudhuri, Vill: Daulatpur, Via Joka','','Kolkata','700104','West Bengal','FCRA [No. 031180012]','2017-05-15','cini@ciniindia.org','3324978241','www.cini-india.org','/assets/img/usr/20170515115954.png'),(6,'Prince','Aaron Golden','Care and Compassion','4-F / G-2, Models Complex, Taleigao Market, Tiswadi','','Goa','403002','Mumbai','Charitable Trust','2017-05-16','princeag@bsnl.in','9823043747','www.careandcompassion-goa.org','/assets/img/usr/20170516120557.jpg'),(7,'D.ethel ','Nina Joys','C.C.Charitable trust','98A, ANNAL GANDHI ST, MAMALLAPURAM','','Chennai','603104','Tamilnadu','FCRA [No. 031170504]','2017-05-16','info@ccchildrenhome.org','9444499321','www.ccchildrenhome.org','/assets/img/sites/avatar.jpg'),(8,'Shyamal','Ray Chowdhury','Barasat Anweshan','Harpara, P.O.-Beraberia, Madhavpur','North 24 Parganas','Kolkata','700121','West Bengal','80 G, 12AA, FCRA','2017-05-16','barasatanweshan@yahoo.com','3325426137','www.anweshan.in','/assets/img/usr/20170516121612.jpg'),(9,'Brother N','Joseph Raju','Agape Children Home','veerapaneni Gudem(Po), Gannavaram-Md Krishna Dist','','Hyedarabad','521286','Andhra Pradesh','Trust','2017-05-16','clgm1990@yahoo.co.uk','9186562247','www.orphange.org/stpaulsassociation','/assets/img/sites/avatar.jpg');
/*!40000 ALTER TABLE `orphanage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `orphanage_children_V`
--

DROP TABLE IF EXISTS `orphanage_children_V`;
/*!50001 DROP VIEW IF EXISTS `orphanage_children_V`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `orphanage_children_V` AS SELECT 
 1 AS `OId`,
 1 AS `FName`,
 1 AS `LName`,
 1 AS `OrgName`,
 1 AS `Address1`,
 1 AS `Address2`,
 1 AS `City`,
 1 AS `Pin`,
 1 AS `State`,
 1 AS `RegNo`,
 1 AS `RegdOn`,
 1 AS `Email`,
 1 AS `Phone`,
 1 AS `Website`,
 1 AS `Photo`,
 1 AS `Children`,
 1 AS `Male`,
 1 AS `Female`*/;
SET character_set_client = @saved_cs_client;

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
-- Final view structure for view `adopt_V`
--

/*!50001 DROP VIEW IF EXISTS `adopt_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `adopt_V` AS select `a`.`AdoptId` AS `AdoptId`,`a`.`AdoptedAt` AS `AdoptedAt`,`a`.`AdopId` AS `AdopId`,`a`.`OId` AS `OId`,`a`.`ChId` AS `ChId`,`o`.`OrgName` AS `OrgName`,`gc`.`FName` AS `gcFName`,`gc`.`LName` AS `gcLName` from (((`adopt` `a` join `orphanage` `o` on((`o`.`OId` = `a`.`OId`))) join `adopter` `ad` on((`a`.`AdopId` = `ad`.`AdopId`))) join `godchild` `gc` on((`gc`.`ChId` = `a`.`ChId`))) order by `a`.`AdoptId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `appointment_V`
--

/*!50001 DROP VIEW IF EXISTS `appointment_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `appointment_V` AS select `app`.`AppId` AS `AppId`,`app`.`AppTimestamp` AS `AppTimestamp`,`app`.`RequestedOn` AS `RequestedOn`,`app`.`Description` AS `Description`,`app`.`Status` AS `Status`,`app`.`AdopId` AS `AdopId`,`app`.`OId` AS `OId`,`app`.`ChId` AS `ChId`,`o`.`OrgName` AS `OrgName`,`a`.`FName` AS `FName`,`a`.`LName` AS `LName`,`gc`.`FName` AS `gcFName`,`gc`.`LName` AS `gcLName` from (((`appointment` `app` join `orphanage` `o` on((`o`.`OId` = `app`.`OId`))) join `adopter` `a` on((`a`.`AdopId` = `app`.`AdopId`))) join `godchild` `gc` on((`gc`.`ChId` = `app`.`ChId`))) order by `app`.`AppId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

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
/*!50001 VIEW `children_stats_V` AS select `ch`.`OId` AS `OId`,`ch`.`Children` AS `Children`,`chm`.`Male` AS `Male`,`chf`.`Female` AS `Female` from ((`children_count_V` `ch` left join `children_male_V` `chm` on((`ch`.`OId` = `chm`.`OId`))) left join `children_female_V` `chf` on((`ch`.`OId` = `chf`.`OId`))) order by `ch`.`OId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `orphanage_children_V`
--

/*!50001 DROP VIEW IF EXISTS `orphanage_children_V`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `orphanage_children_V` AS select `o`.`OId` AS `OId`,`o`.`FName` AS `FName`,`o`.`LName` AS `LName`,`o`.`OrgName` AS `OrgName`,`o`.`Address1` AS `Address1`,`o`.`Address2` AS `Address2`,`o`.`City` AS `City`,`o`.`Pin` AS `Pin`,`o`.`State` AS `State`,`o`.`RegNo` AS `RegNo`,`o`.`RegdOn` AS `RegdOn`,`o`.`Email` AS `Email`,`o`.`Phone` AS `Phone`,`o`.`Website` AS `Website`,`o`.`Photo` AS `Photo`,`chm`.`Children` AS `Children`,`chm`.`Male` AS `Male`,`chm`.`Female` AS `Female` from (`orphanage` `o` left join `children_stats_V` `chm` on((`o`.`OId` = `chm`.`OId`))) order by `o`.`OId` */;
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

-- Dump completed on 2017-05-16 17:17:47
