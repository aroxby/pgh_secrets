-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.12.04.1

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
-- Table structure for table `badgeImage`
--

DROP TABLE IF EXISTS badgeImage;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE badgeImage (
  missionID int(11) NOT NULL,
  badgeNumber int(11) NOT NULL,
  imageURI varchar(10000) NOT NULL,
  PRIMARY KEY (missionID,badgeNumber),
  CONSTRAINT badgeImage_ibfk_1 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `checkin`
--

DROP TABLE IF EXISTS checkin;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE checkin (
  id int(11) NOT NULL AUTO_INCREMENT,
  userID int(11) NOT NULL,
  missionID int(11) NOT NULL,
  lat decimal(9,6) NOT NULL,
  lng decimal(9,6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  json varchar(1000) DEFAULT NULL,
  beforeProgress smallint(6) DEFAULT NULL,
  afterProgress smallint(6) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY userID (userID),
  KEY missionID (missionID),
  CONSTRAINT checkin_ibfk_1 FOREIGN KEY (userID) REFERENCES `user` (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT checkin_ibfk_2 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS location;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE location (
  id int(11) NOT NULL AUTO_INCREMENT,
  lat decimal(9,6) NOT NULL,
  lng decimal(9,6) NOT NULL,
  radius decimal(18,6) NOT NULL,
  latSin double NOT NULL,
  latCos double NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mission`
--

DROP TABLE IF EXISTS mission;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE mission (
  id int(11) NOT NULL AUTO_INCREMENT,
  sortOrder int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  description varchar(10000) NOT NULL,
  neighborhood varchar(1000) NOT NULL,
  `type` varchar(100) NOT NULL,
  tags varchar(1000) NOT NULL,
  locationsOrdered tinyint(1) unsigned NOT NULL,
  startDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  endDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  timeEstimate int(11) NOT NULL,
  showLocations tinyint(1) NOT NULL,
  photo tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `missionimage`
--

DROP TABLE IF EXISTS missionimage;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE missionimage (
  id int(11) NOT NULL AUTO_INCREMENT,
  missionID int(11) NOT NULL,
  imageURI varchar(10000) NOT NULL,
  PRIMARY KEY (id),
  KEY missionID (missionID),
  CONSTRAINT missionimage_ibfk_1 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `missionlocation`
--

DROP TABLE IF EXISTS missionlocation;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE missionlocation (
  missionID int(11) NOT NULL,
  locationID int(11) NOT NULL,
  locationOrder tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (missionID,locationID),
  KEY locationID (locationID),
  CONSTRAINT missionlocation_ibfk_1 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT missionlocation_ibfk_2 FOREIGN KEY (locationID) REFERENCES location (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS user;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  id int(11) NOT NULL AUTO_INCREMENT,
  userName varchar(100) NOT NULL,
  firstName varchar(255) NOT NULL,
  lastName varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  confirmLink varchar(100) NOT NULL,
  confirmedEmail tinyint(1) NOT NULL DEFAULT '0',
  `password` binary(32) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usermission`
--

DROP TABLE IF EXISTS usermission;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE usermission (
  userID int(11) NOT NULL,
  missionID int(11) NOT NULL,
  progress smallint(6) NOT NULL,
  startTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userID,missionID),
  KEY missionID (missionID),
  CONSTRAINT usermission_ibfk_1 FOREIGN KEY (userID) REFERENCES `user` (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT usermission_ibfk_2 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
