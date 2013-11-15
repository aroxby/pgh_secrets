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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES location WRITE;
/*!40000 ALTER TABLE location DISABLE KEYS */;
INSERT INTO location VALUES (1,40.428251,-79.970312,75.000000,0.648495316214921,0.7612186445741523,'mural1'),(2,40.428378,-79.971449,75.000000,0.6484970035063305,0.761217207138219,'mural2'),(3,40.429454,-79.996997,75.000000,0.6485112988553022,0.7612050283970863,'mural3'),(4,40.428576,-79.980126,75.000000,0.6484996340802827,0.7612149660889094,'mural4'),(5,40.428592,-79.971148,75.000000,0.6484998466515769,0.7612147849936187,'mural5'),(6,40.428833,-79.984144,75.000000,0.6485030485005795,0.761212057238622,'mural6'),(7,40.428713,-79.986013,75.000000,0.6485014542203527,0.761213415458561,'mural7'),(8,40.428670,-79.987515,75.000000,0.6485008829359123,0.7612139021532267,'mural8'),(10,40.426728,-79.968984,30.000000,0.6484750817555583,0.7612358821956057,'ss_Zenith'),(11,40.429862,-79.965809,50.000000,0.6485167193367434,0.761200410365567,'sss_sculpture'),(12,40.428571,-79.965573,30.000000,0.6484995676517428,0.7612150226811757,'sss_climbing'),(13,40.427970,-79.965619,50.000000,0.648491582905281,0.7612218250293425,'sss_fountain'),(15,40.432683,-79.964607,50.000000,0.6485541946035074,0.7611684811276646,'ETC'),(16,40.454960,-79.982267,30.000000,0.6488500954170667,0.7609162593066752,'Etcetera'),(17,40.454074,-79.979794,30.000000,0.6488383288217552,0.7609262927851763,'Hair By Design'),(18,40.456924,-79.975609,20.000000,0.6488761779261901,0.7608940174031461,'Klavon\'s'),(19,40.451994,-79.982844,10.000000,0.6488107097103519,0.7609498426080062,'Colangelo Bakery'),(20,40.480428,-79.918212,30.000000,0.6491882646651568,0.7606277650868671,'Super Playground Highland Park'),(21,40.447421,-80.005748,10.000000,0.6487499681557622,0.7610016286565341,'Willie Stargell Statue'),(22,40.432691,-79.964586,13.636277,0.648554303093959,0.7611683886882777,'Photo Test (Debug)'),(23,40.444969,-79.956402,38.174555,0.6487174036962746,0.7610293884874386,'Hollywood: Soldiers and Sailors'),(24,40.446388,-79.951143,42.718337,0.648736252934469,0.7610133205986244,'Hollywood: Mellon Institute'),(25,40.442316,-79.946400,35.449173,0.6486821622605525,0.7610594276171698,'Hollywood: Hamerschlag Hall'),(26,40.439606,-79.995851,55.902951,0.6486461656160099,0.7610901075639125,'Hollywood: BNY Mellon'),(27,40.440002,-80.003612,36.813871,0.6486514272424052,0.7610856232621863,'Hollywood: PPG Place'),(28,40.438935,-80.011191,161.348801,0.6486372496668111,0.7610977061748873,'Hollywood: Fort Pitt Bridge'),(29,40.446892,-80.005722,109.067196,0.6487429419585576,0.7610076183974478,'Hollywood: PNC Park'),(30,40.476062,-79.913583,28.170008,0.6491302998788221,0.7606772336406753,'farmhousePG'),(31,40.482753,-79.910311,10.000000,0.6492191204072955,0.760601428934746,'poolPG '),(33,40.479352,-79.915525,10.000000,0.6491739744201306,0.760639961437454,'PG fountain'),(34,40.482268,-79.911496,15.000000,0.6492126854381965,0.7606069215213107,'PG poolSpray'),(35,40.480749,-79.911316,25.000000,0.6491925138441242,0.7606241384341853,'PG Duck Pond');
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
  `type` varchar(100) NOT NULL,
  tags varchar(1000) NOT NULL,
  locationsOrdered tinyint(1) unsigned NOT NULL,
  startDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  endDate timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  timeEstimate int(11) NOT NULL,
  showLocations tinyint(1) NOT NULL,
  photo tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission`
--

LOCK TABLES mission WRITE;
/*!40000 ALTER TABLE mission DISABLE KEYS */;
INSERT INTO mission VALUES (1,'Murals Finder','Pittsburgh is not only a city of rivers and bridges, it\'s also a city of murals. There are 376 (excluding graffiti) murals in the city. These works run the gamut, from abstract to representational, political to whimsical. Some are based on famous paintings, others came from the artists\' experience and imagination.','South Side','Culture','Culture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0),(3,'Antiques & Food!?!','Looking for a vegetarian bite to eat? How about a ridiculous amount of antique stuff? If you answered yes to either question, then you should check out Zenith at the corner of Sarah St. and S. 26th St. Check-in when you get there to earn the Antique Gourmet badge!','South Side Flats','Food','Food',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(4,'South Side Summer (for kids)','Take your kids on a mini-adventure at the South Side Works (and have lunch at Hofbrauhaus when you\'re done)! Start by going down by the river on the Three Rivers Heritage Trail. While there, take in the river view while your kids play around a group of rusty sculptures (your first check-in). Then walk to the main retail area and let your kids watch climbers practice rock climbing on the Pinnacle (your second check-in). Finally, find the fountain and watch the kids cool down (your third and final check-in). Find all three locations to earn the South Side Parent badge.','South Side Flats','Kids','Kids, Outdoors',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(5,'Shave and a Haircut','Follow Eben through a typical day in the Strip. Check-in at the office (Etcetera Edutainment, of course) and then head over to Hair By Design for a quick trim. Wind up at Klavon\'s for some Penn State Creamery ice cream.','Strip District','Culture','Culture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(6,'Sfogliatelle Pastry','Eat an authentic italian sfogliatelle at Colangelo\'s Bakery (goes very well with a macchiato or cappuccino).','Strip District','Food','Food, Ethnic',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(7,'Super Playground','Climb through the wooden structure of Highland Parks\' \"Super Playground\".','Highland Park','Kids','Kids, Play',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(8,'Willie Stargell Statue','Rub Willie Stargell\'s knee with your hand for good luck!','North Shore','Sports','Sports, History',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(9,'Pittsburgh Movies','Always wanted to see your face in a movie? Here\'s your\r\nchance! More than 50 major films have been shot in Pittsburgh. Find landmarks from these famous movies and capture the shots that were once shown on the big screen.','Pittsburgh','Entertainment','Movies,film,hollywood',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,1),(10,'Playspaces of Highland Park','Highland Park is a great place to take kids (even grown-up kids). Explore the 3 playgrounds, the fountain, and the spray park. Special bonus: the duck pond.','Highland Park','Education & Kids','kids, playgrounds, outdoors, parks',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missionimage`
--

LOCK TABLES missionimage WRITE;
/*!40000 ALTER TABLE missionimage DISABLE KEYS */;
INSERT INTO missionimage VALUES (1,1,'/images/mural1.jpg'),(2,1,'/images/mural2.jpg'),(3,1,'/images/mural3.jpg'),(4,1,'/images/mural4.jpg'),(5,1,'/images/mural5.jpg'),(6,1,'/images/mural6.jpg'),(7,1,'/images/mural7.jpg'),(8,1,'/images/mural8.jpg'),(9,6,'/images/Sfogliatelle.jpeg'),(10,7,'/images/HighlandPark.jpg'),(11,8,'/images/Willie.jpg'),(12,9,'/images/Hollywood1.jpg'),(13,9,'/images/Hollywood2.jpg'),(14,9,'/images/Hollywood3.jpg'),(15,9,'/images/Hollywood4.jpg'),(16,9,'/images/Hollywood5.jpg'),(17,9,'/images/Hollywood6.jpg'),(18,9,'/images/Hollywood7.jpg'),(19,10,'/images/PG/farmhouse.jpeg'),(20,10,'/images/PG/poolPG.png'),(21,10,'/images/PG/superPlayground.jpg'),(22,10,'/images/PG/fountain.jpg'),(23,10,'/images/PG/spray.png'),(24,10,'/images/PG/duckpond.jpg');
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
INSERT INTO missionlocation VALUES (1,1,0),(1,2,1),(1,3,2),(1,4,3),(1,5,4),(1,6,5),(1,7,6),(1,8,7),(3,10,1),(4,11,1),(4,12,2),(4,13,3),(5,16,1),(5,17,2),(5,18,3),(6,19,1),(7,20,1),(8,21,1),(8,29,7),(9,23,1),(9,24,2),(9,25,3),(9,26,4),(9,27,5),(9,28,6),(9,29,7),(10,20,3),(10,30,1),(10,31,2),(10,33,4),(10,34,5),(10,35,6);
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
