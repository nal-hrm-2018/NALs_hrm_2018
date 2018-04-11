-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: hrm
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB

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
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `EMP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_EMAIL` varchar(255) NOT NULL,
  `EMP_PASSWORD` varchar(255) NOT NULL,
  `EMP_NAME` varchar(255) NOT NULL,
  `EMP_BIRTHDAY` date NOT NULL,
  `EMP_GENDER` bit(1) DEFAULT NULL,
  `EMP_MOBILE` varchar(20) NOT NULL,
  `EMP_ADDRESS` text,
  `EMP_STATUS` varchar(45) NOT NULL,
  `EMP_SKILL` varchar(255) NOT NULL,
  `EMP_STARTWORK` date NOT NULL,
  `EMP_ENDWORK` date DEFAULT NULL,
  `EMP_CV` text,
  `EMP_TEAM_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`EMP_ID`),
  KEY `fk_EMPLOYEE_TEAM1_idx` (`EMP_TEAM_NAME`),
  CONSTRAINT `fk_EMPLOYEE_TEAM1` FOREIGN KEY (`EMP_TEAM_NAME`) REFERENCES `team` (`TEAM_NAME`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_has_project`
--

DROP TABLE IF EXISTS `employee_has_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_has_project` (
  `EMPLOYEE_EMP_ID` int(11) NOT NULL,
  `PROJECT_PRO_ID` varchar(50) NOT NULL,
  PRIMARY KEY (`EMPLOYEE_EMP_ID`,`PROJECT_PRO_ID`),
  KEY `fk_EMPLOYEE_has_PROJECT1_PROJECT1_idx` (`PROJECT_PRO_ID`),
  KEY `fk_EMPLOYEE_has_PROJECT1_EMPLOYEE1_idx` (`EMPLOYEE_EMP_ID`),
  CONSTRAINT `fk_EMPLOYEE_has_PROJECT1_EMPLOYEE1` FOREIGN KEY (`EMPLOYEE_EMP_ID`) REFERENCES `employee` (`EMP_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EMPLOYEE_has_PROJECT1_PROJECT1` FOREIGN KEY (`PROJECT_PRO_ID`) REFERENCES `project` (`PRO_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_has_project`
--

LOCK TABLES `employee_has_project` WRITE;
/*!40000 ALTER TABLE `employee_has_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_has_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `MEMBER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MEMBER_VEN_ID` int(11) NOT NULL,
  `MEMBER_EMP_ID` int(11) NOT NULL,
  `PROJECT_PRO_ID` varchar(50) NOT NULL,
  PRIMARY KEY (`MEMBER_ID`),
  KEY `fk_MEMBER_VENDER1_idx` (`MEMBER_VEN_ID`),
  KEY `fk_MEMBER_EMPLOYEE1_idx` (`MEMBER_EMP_ID`),
  KEY `fk_MEMBER_PROJECT1_idx` (`PROJECT_PRO_ID`),
  CONSTRAINT `fk_MEMBER_EMPLOYEE1` FOREIGN KEY (`MEMBER_EMP_ID`) REFERENCES `employee` (`EMP_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MEMBER_PROJECT1` FOREIGN KEY (`PROJECT_PRO_ID`) REFERENCES `project` (`PRO_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MEMBER_VENDER1` FOREIGN KEY (`MEMBER_VEN_ID`) REFERENCES `vendor` (`VEN_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performance`
--

DROP TABLE IF EXISTS `performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `performance` (
  `PER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PER_TITLE` varchar(45) NOT NULL,
  `PER_POINT` int(11) NOT NULL,
  `PER_STRONG` text,
  `PER_WEAK` text,
  `PER_SUGGEST` text,
  `PER_TEAM_NAME` varchar(55) NOT NULL,
  PRIMARY KEY (`PER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performance`
--

LOCK TABLES `performance` WRITE;
/*!40000 ALTER TABLE `performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `performance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `PERM_ID` int(11) NOT NULL,
  `PERM_EMP_VIEW` bit(1) DEFAULT NULL,
  `PERM_VEN_VIEW` bit(1) DEFAULT NULL,
  `PERM_EMP_EDIT` bit(1) DEFAULT NULL,
  `PERM_VEN_EDIT` bit(1) DEFAULT NULL,
  `PERM_EMP_REMOVE` bit(1) DEFAULT NULL,
  `PERM_VEN_REMOVE` bit(1) DEFAULT NULL,
  `VENDOR_VEN_ID` int(11) NOT NULL,
  `EMPLOYEE_EMP_ID` int(11) NOT NULL,
  PRIMARY KEY (`PERM_ID`),
  KEY `fk_PERMISSION_VENDOR1_idx` (`VENDOR_VEN_ID`),
  KEY `fk_PERMISSION_EMPLOYEE1_idx` (`EMPLOYEE_EMP_ID`),
  CONSTRAINT `fk_PERMISSION_EMPLOYEE1` FOREIGN KEY (`EMPLOYEE_EMP_ID`) REFERENCES `employee` (`EMP_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PERMISSION_VENDOR1` FOREIGN KEY (`VENDOR_VEN_ID`) REFERENCES `vendor` (`VEN_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `PRO_ID` varchar(50) NOT NULL,
  `PRO_NAME` varchar(255) NOT NULL,
  `PRO_INCOME` double NOT NULL,
  `PRO_REAL_COST` double NOT NULL,
  `PRO_DESCRIPTION` text NOT NULL,
  `PRO_STATUS` varchar(45) NOT NULL,
  `PRO_PER_ID` int(11) NOT NULL,
  `PRO_START_DAY` date NOT NULL,
  `PRO_END_DAY` date NOT NULL,
  `PRO_MAN_POWER` float NOT NULL,
  `PRO_ROLE_ID` int(11) NOT NULL,
  PRIMARY KEY (`PRO_ID`),
  KEY `fk_PROJECT_PERFORMANCE1_idx` (`PRO_PER_ID`),
  KEY `fk_PROJECT_ROLE1_idx` (`PRO_ROLE_ID`),
  CONSTRAINT `fk_PROJECT_PERFORMANCE1` FOREIGN KEY (`PRO_PER_ID`) REFERENCES `performance` (`PER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PROJECT_ROLE1` FOREIGN KEY (`PRO_ROLE_ID`) REFERENCES `role` (`ROLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(45) NOT NULL,
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `TEAM_NAME` varchar(100) NOT NULL,
  `TEAM_ROLE_ID` int(11) NOT NULL,
  PRIMARY KEY (`TEAM_NAME`),
  KEY `fk_TEAM_ROLE1_idx` (`TEAM_ROLE_ID`),
  CONSTRAINT `fk_TEAM_ROLE1` FOREIGN KEY (`TEAM_ROLE_ID`) REFERENCES `role` (`ROLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor` (
  `VEN_ID` int(11) NOT NULL AUTO_INCREMENT,
  `VEN_EMAIL` varchar(255) NOT NULL,
  `VEN_NAME` varchar(55) NOT NULL,
  `VEN_BIRTHDAY` date NOT NULL,
  `VEN_GENDER` bit(1) DEFAULT NULL,
  `VEN_MOBILE` varchar(20) NOT NULL,
  `VEN_ROLE` varchar(45) NOT NULL,
  `VEN_ADDRESS` text,
  `VEN_STATUS` varchar(45) NOT NULL,
  `VEN_SKILL` text,
  `VEN_COMPANY` varchar(45) NOT NULL,
  `VEN_START` date NOT NULL,
  `VEN_END` date DEFAULT NULL,
  `VEN_CV` text,
  `VEN_PASSWORD` varchar(255) NOT NULL,
  PRIMARY KEY (`VEN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_has_project`
--

DROP TABLE IF EXISTS `vendor_has_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor_has_project` (
  `VENDOR_VEN_ID` int(11) NOT NULL,
  `PROJECT_PRO_ID` varchar(50) NOT NULL,
  PRIMARY KEY (`VENDOR_VEN_ID`,`PROJECT_PRO_ID`),
  KEY `fk_VENDER_has_PROJECT_PROJECT1_idx` (`PROJECT_PRO_ID`),
  KEY `fk_VENDER_has_PROJECT_VENDER1_idx` (`VENDOR_VEN_ID`),
  CONSTRAINT `fk_VENDER_has_PROJECT_PROJECT1` FOREIGN KEY (`PROJECT_PRO_ID`) REFERENCES `project` (`PRO_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_VENDER_has_PROJECT_VENDER1` FOREIGN KEY (`VENDOR_VEN_ID`) REFERENCES `vendor` (`VEN_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_has_project`
--

LOCK TABLES `vendor_has_project` WRITE;
/*!40000 ALTER TABLE `vendor_has_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_has_project` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-10 16:06:48
