-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: game
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Dumping data for table `badgeImage`
--

LOCK TABLES badgeImage WRITE;
/*!40000 ALTER TABLE badgeImage DISABLE KEYS */;
/*!40000 ALTER TABLE badgeImage ENABLE KEYS */;
UNLOCK TABLES;

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
  radius decimal(9,6) NOT NULL,
  latSin double NOT NULL,
  latCos double NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES location WRITE;
/*!40000 ALTER TABLE location DISABLE KEYS */;
INSERT INTO location VALUES (1,40.428251,-79.970312,75.000000,0.648495316214921,0.7612186445741523,'mural1'),(2,40.428378,-79.971449,75.000000,0.6484970035063305,0.761217207138219,'mural2'),(3,40.429454,-79.996997,75.000000,0.6485112988553022,0.7612050283970863,'mural3'),(4,40.428576,-79.980126,75.000000,0.6484996340802827,0.7612149660889094,'mural4'),(5,40.428592,-79.971148,75.000000,0.6484998466515769,0.7612147849936187,'mural5'),(6,40.428833,-79.984144,75.000000,0.6485030485005795,0.761212057238622,'mural6'),(7,40.428713,-79.986013,75.000000,0.6485014542203527,0.761213415458561,'mural7'),(8,40.428670,-79.987515,75.000000,0.6485008829359123,0.7612139021532267,'mural8'),(10,40.426728,-79.968984,30.000000,0.6484750817555583,0.7612358821956057,'ss_Zenith'),(11,40.429862,-79.965809,50.000000,0.6485167193367434,0.761200410365567,'sss_sculpture'),(12,40.428571,-79.965573,30.000000,0.6484995676517428,0.7612150226811757,'sss_climbing'),(13,40.427970,-79.965619,50.000000,0.648491582905281,0.7612218250293425,'sss_fountain'),(15,40.432683,-79.964607,50.000000,0.6485541946035074,0.7611684811276646,'ETC'),(16,40.454960,-79.982267,30.000000,0.6488500954170667,0.7609162593066752,'Etcetera'),(17,40.454074,-79.979794,30.000000,0.6488383288217552,0.7609262927851763,'Hair By Design'),(18,40.456924,-79.975609,20.000000,0.6488761779261901,0.7608940174031461,'Klavon\'s'),(19,40.451994,-79.982844,10.000000,0.6488107097103519,0.7609498426080062,'Colangelo Bakery'),(20,40.480428,-79.918212,30.000000,0.6491882646651568,0.7606277650868671,'Super Playground Highland Park'),(21,40.447421,-80.005748,10.000000,0.6487499681557622,0.7610016286565341,'Willie Stargell Statue');
/*!40000 ALTER TABLE location ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission`
--

DROP TABLE IF EXISTS mission;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE mission (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  description varchar(10000) NOT NULL,
  neighborhood varchar(1000) NOT NULL,
  tags varchar(1000) NOT NULL,
  locationsOrdered tinyint(1) unsigned NOT NULL,
  startDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  endDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  minuteLimit int(11) NOT NULL,
  badgeName varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission`
--

LOCK TABLES mission WRITE;
/*!40000 ALTER TABLE mission DISABLE KEYS */;
INSERT INTO mission VALUES (1,'Murals Finder','Pittsburgh is not only a city of rivers and bridges, it\'s also a city of murals. There are 376 (excluding graffiti) murals in the city. These works run the gamut, from abstract to representational, political to whimsical. Some are based on famous paintings, others came from the artists\' experience and imagination.','South Side','culture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Mural Master'),(3,'Antiques & Food!?!','Looking for a vegetarian bite to eat? How about a ridiculous amount of antique stuff? If you answered yes to either question, then you should check out Zenith at the corner of Sarah St. and S. 26th St. Check-in when you get there to earn the Antique Gourmet badge!','South Side Flats','Food',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Antique Gourmet'),(4,'South Side Summer (for kids)','Take your kids on a mini-adventure at the South Side Works (and have lunch at Hofbrauhaus when you\'re done)! Start by going down by the river on the Three Rivers Heritage Trail. While there, take in the river view while your kids play around a group of rusty sculptures (your first check-in). Then walk to the main retail area and let your kids watch climbers practice rock climbing on the Pinnacle (your second check-in). Finally, find the fountain and watch the kids cool down (your third and final check-in). Find all three locations to earn the South Side Parent badge.','South Side Flats','Kids, Outdoors',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'South Side Parent'),(5,'Shave and a Haircut','Follow Eben through a typical day in the Strip. Check-in at the office (Etcetera Edutainment, of course) and then head over to Hair By Design for a quick trim. Wind up at Klavon\'s for some Penn State Creamery ice cream.','Strip District','Culture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Eben\'s Thursday'),(6,'Sfogliatelle Pastry','Eat an authentic italian sfogliatelle at Colangelo\'s Bakery (goes very well with a macchiato or cappuccino).','Strip District','Food, Ethnic',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Ethnic Pastries'),(7,'Super Playground','Climb through the wooden structure of Highland Parks\' \"Super Playground\".','Highland Park','Kids, Play',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Super Playground'),(8,'Willie Stargell Statue','Rub Willie Stargell\'s knee with your hand for good luck!','North Shore','Sports, History',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'Stargell Statue');
/*!40000 ALTER TABLE mission ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missionimage`
--

LOCK TABLES missionimage WRITE;
/*!40000 ALTER TABLE missionimage DISABLE KEYS */;
INSERT INTO missionimage VALUES (1,1,'/images/mural1.jpg'),(2,1,'/images/mural2.jpg'),(3,1,'/images/mural3.jpg'),(4,1,'/images/mural4.jpg'),(5,1,'/images/mural5.jpg'),(6,1,'/images/mural6.jpg'),(7,1,'/images/mural7.jpg'),(8,1,'/images/mural8.jpg'),(9,6,'/images/Sfogliatelle.jpeg'),(10,7,'/images/HighlandPark.jpg'),(11,8,'/images/Willie.jpg');
/*!40000 ALTER TABLE missionimage ENABLE KEYS */;
UNLOCK TABLES;

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
  showOnMap tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (missionID,locationID),
  KEY locationID (locationID),
  CONSTRAINT missionlocation_ibfk_1 FOREIGN KEY (missionID) REFERENCES mission (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT missionlocation_ibfk_2 FOREIGN KEY (locationID) REFERENCES location (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missionlocation`
--

LOCK TABLES missionlocation WRITE;
/*!40000 ALTER TABLE missionlocation DISABLE KEYS */;
INSERT INTO missionlocation VALUES (1,1,0,0),(1,2,1,0),(1,3,2,0),(1,4,3,0),(1,5,4,0),(1,6,5,0),(1,7,6,0),(1,8,7,0),(3,10,1,1),(4,11,1,1),(4,12,2,1),(4,13,3,1),(5,16,1,1),(5,17,2,1),(5,18,3,1),(6,19,1,1),(7,20,1,1),(8,21,1,1);
/*!40000 ALTER TABLE missionlocation ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
