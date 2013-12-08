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
  radius decimal(18,6) NOT NULL,
  latSin double NOT NULL,
  latCos double NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES location WRITE;
/*!40000 ALTER TABLE location DISABLE KEYS */;
INSERT INTO location VALUES (1,40.428251,-79.970312,75.000000,0.648495316214921,0.7612186445741523,'Veterans Leadership Program'),(2,40.428378,-79.971449,75.000000,0.6484970035063305,0.761217207138219,' Double Wide Grill'),(3,40.429454,-79.996997,75.000000,0.6485112988553022,0.7612050283970863,'E.Carson St & Terminal Way'),(4,40.428576,-79.980126,75.000000,0.6484996340802827,0.7612149660889094,'United American Savings Bank'),(5,40.428592,-79.971148,75.000000,0.6484998466515769,0.7612147849936187,'Wrights way & S 24th St'),(6,40.428833,-79.984144,75.000000,0.6485030485005795,0.761212057238622,'Beehive Coffeehouse'),(7,40.428713,-79.986013,75.000000,0.6485014542203527,0.761213415458561,'Dave\'s Music Mine'),(8,40.428670,-79.987515,75.000000,0.6485008829359123,0.7612139021532267,'E Carson St & S 11th St'),(10,40.426728,-79.968984,30.000000,0.6484750817555583,0.7612358821956057,'Zenith Antiques'),(11,40.429862,-79.965809,50.000000,0.6485167193367434,0.761200410365567,'South Shore Riverfront Park Sculpture'),(12,40.428571,-79.965573,30.000000,0.6484995676517428,0.7612150226811757,'Tunnel Blvd & S 27th St'),(13,40.427970,-79.965619,50.000000,0.648491582905281,0.7612218250293425,'South Side Works Town Square'),(19,40.451994,-79.982844,10.000000,0.6488107097103519,0.7609498426080062,'Colangelo\'s Bakery'),(20,40.480428,-79.918212,30.000000,0.6491882646651568,0.7606277650868671,'Highland Park Super Playground '),(21,40.447421,-80.005748,10.000000,0.6487499681557622,0.7610016286565341,'PNC Park'),(23,40.444969,-79.956402,107.757863,0.6487174001368455,0.7610293915215705,'Soldiers & Sailors Memorial Hall & Museum'),(24,40.446388,-79.951143,67.314983,0.6487362477608175,0.7610133250089747,'Mellon Institute of Industrial Research'),(25,40.442316,-79.946400,91.845440,0.648682161052266,0.761059428647042,'Hamerschlag Hall'),(26,40.439606,-79.995851,150.000000,0.6486461634161047,0.7610901094388023,'Bank of New York Mellon'),(27,40.440002,-80.003612,150.000000,0.6486514236778245,0.7610856263001762,'PPG Industries Inc'),(28,40.438935,-80.011191,136.376885,0.6486372501241249,0.7610977057851466,'Fort Pitt Bridge'),(29,40.446892,-80.005722,157.359493,0.6487429419585576,0.7610076183974478,'PNC Park'),(30,40.476062,-79.913583,28.170008,0.6491302998788221,0.7606772336406753,'Farmhouse Playground'),(31,40.482753,-79.910311,10.000000,0.6492191204072955,0.760601428934746,'Pool Grove Shelter'),(33,40.479352,-79.915525,10.000000,0.6491739744201306,0.760639961437454,' Highland Park Entry Garden'),(34,40.482268,-79.911496,15.000000,0.6492126854381965,0.7606069215213107,'Highland Swimming Pool'),(35,40.480749,-79.911316,25.000000,0.6491925138441242,0.7606241384341853,'Carnegie Lake'),(37,40.433108,-79.964897,85.452822,0.64855983828331,0.7611636723898,'ETC Superman (Softs)'),(38,40.540850,-80.181774,10.332281,0.649990025800423,0.7599427388691634,'Body and Birth Wellness Center'),(39,40.583017,-79.865185,225.000000,0.6505491336295788,0.7594641694864903,'Pittsburgh Harlequins Rugby'),(40,40.482406,-79.916507,516.432558,0.6492145108800752,0.7606053634196546,'Lake Dr'),(41,40.452384,-79.983966,354.598136,0.6488158858862888,0.7609454292008003,'21st St & Smallman St'),(42,40.429162,-79.982875,150.000000,0.6485074194709441,0.7612083334351621,'S 16th St & E Carson St'),(43,40.448401,-80.002469,50.000000,0.6487629822769343,0.7609905339931228,'The Andy Worhol Musesum'),(44,40.438809,-79.996373,68.407864,0.6486355716993599,0.7610991362012208,'Allegheny County Courthouse'),(45,40.441183,-80.009820,15.000000,0.6486671142690332,0.76107225338064,'Fort Pitt Blockhouse'),(46,40.440603,-79.996457,75.000000,0.6486594055634793,0.7610788234959857,'Omni William Penn Hotel'),(47,40.439929,-79.996907,75.000000,0.6486504552605262,0.7610864516533664,'Union Trust Building'),(48,40.446421,-79.992020,71.813542,0.6487366832248093,0.7610129537915065,'Senator John Heinz History Center'),(50,40.407006,-79.917091,56.147974,0.6482130140414223,0.7614590523641668,'Bar Louie Waterfront'),(51,40.406562,-79.918384,84.330522,0.6482071160261644,0.7614640731728862,'AMC Loews Waterfront'),(52,40.427624,-79.964839,60.456992,0.6484869889772871,0.7612257386131738,'South Side Works'),(53,40.428170,-79.972835,20.000000,0.6484942413757758,0.7612195602468823,'The Library'),(54,40.428200,-79.965300,31.136712,0.6484946386403084,0.761219221811152,'Cheesecake Factory'),(55,40.428880,-79.987194,25.000000,0.6485036734806156,0.7612115247959317,'Tad\'s'),(56,40.428909,-79.986743,25.000000,0.6485040526856392,0.761211201737272,'Jack Rose Bar'),(57,40.429146,-79.984686,39.091568,0.6485072069737018,0.7612085144710142,'1311 E Carson St'),(58,40.428570,-79.984683,29.545731,0.6484995523359691,0.7612150357290951,'Dee\'s Cafe '),(59,40.443530,-79.951507,11.929817,0.6486982837181645,0.7610456863428816,'Dippy '),(60,40.442386,-79.952865,7.158013,0.648683090149347,0.7610586367385198,'Schenley Dr, The PNC Carousel'),(61,40.441991,-79.951891,20.453012,0.6486778405007207,0.7610631112091305,'Mary Schenley Memorial Fountain'),(68,40.453591,-79.982293,15.481390,0.6488319112011428,0.7609317650138364,'Marty\'s Market'),(69,40.451773,-79.984393,15.481390,0.648807772878716,0.7609523466368708,'21st Street Coffee and Tea'),(70,40.451545,-79.982821,15.481390,0.6488047368602634,0.76095493521475,'La Prima Espresso Co'),(71,40.450087,-79.985578,15.481390,0.6487853817570604,0.7609714373209716,'Prestogeorge Coffee & Tea'),(72,40.451414,-79.983594,15.481390,0.6488030019833024,0.7609564144006244,'DeLuca\'s'),(73,40.440943,-79.995207,29.555157,0.6486639188134671,0.7610749768778079,'Steel Plaza'),(74,40.439767,-80.003174,33.191100,0.6486482997513778,0.7610882887219108,'PPG Place'),(75,40.440685,-80.002589,55.006549,0.6486605021903227,0.7610778888511993,'Market Square'),(76,40.439531,-79.998311,60.460505,0.6486451677382669,0.7610909580134267,'Macy\'s'),(77,40.441609,-80.011609,104.090741,0.6486727720843299,0.7610674311494553,'Point State Park Tree'),(78,40.430234,-80.003316,56.362774,0.6485216594252268,0.7611962015514464,'East Sycamore Street'),(79,40.427467,-79.933358,56.362774,0.6484849040914518,0.7612275147191545,'Monteiro Street'),(80,40.458575,-79.987416,56.362774,0.6488980985307465,0.7608753233764265,'Troy Hill Road'),(81,40.476246,-79.973339,56.362774,0.6491327377578086,0.7606751532494355,'Logan Road'),(82,40.457956,-79.963957,56.362774,0.6488898866315436,0.7608823266624758,'Heron Avenue'),(83,40.454908,-79.982298,27.297164,0.6488494076191196,0.7609168458066345,'EE Offices'),(85,40.464571,-79.933552,32.077524,0.6489777230759438,0.7608074098950164,'Voluto'),(89,40.434079,-79.969992,70.910208,0.6485727456724307,0.7611526742848143,'ptc'),(90,40.435140,-79.942145,805.418346,0.6485868350641053,0.761140668589931,'Schenley Park Area');
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission`
--

LOCK TABLES mission WRITE;
/*!40000 ALTER TABLE mission DISABLE KEYS */;
INSERT INTO mission VALUES (1,0,'Murals Finder','Pittsburgh is not only a city of rivers and bridges, it\'s also a city of murals. There are 376 (excluding graffiti) murals in the city. These works run the gamut, from abstract to representational, political to whimsical. Some are based on famous paintings, others came from the artists\' experience and imagination.','South Side','Art & Culture','Culture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0),(3,21,'Antiques & Food!?!','Looking for a vegetarian bite to eat? How about a ridiculous amount of antique stuff? If you answered yes to either question, then you should check out Zenith at the corner of Sarah St. and S. 26th St. Check-in when you get there to earn the Antique Gourmet badge!','South Side Flats','Food & Drink','Food',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(4,14,'South Side Summer (for kids)','Take your kids on a mini-adventure at the South Side Works (and have lunch at Hofbrauhaus when you\'re done)! Start by going down by the river on the Three Rivers Heritage Trail. While there, take in the river view while your kids play around a group of rusty sculptures (your first check-in). Then walk to the main retail area and let your kids watch climbers practice rock climbing on the Pinnacle (your second check-in). Finally, find the fountain and watch the kids cool down (your third and final check-in). Find all three locations to earn the South Side Parent badge.','South Side Flats','Education & Kids','Kids, Outdoors',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(6,6,'Sfogliatelle Pastry','Eat an authentic italian sfogliatelle at Colangelo\'s Bakery (goes very well with a macchiato or cappuccino).','Strip District','Food & Drink','Food, Ethnic',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(7,7,'Super Playground','Climb through the wooden structure of Highland Parks\' \"Super Playground\".','Highland Park','Education & Kids','Kids, Play',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(8,8,'Willie Stargell Statue','Rub Willie Stargell\'s knee with your hand for good luck!','North Shore','Sports','Sports, History',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(9,3,'Pittsburgh Movies','Always wanted to see your face in a movie? Here\'s your\r\nchance! More than 50 major films have been shot in Pittsburgh. Find landmarks from these famous movies and capture the shots that were once shown on the big screen.','Pittsburgh','Uniquely Pittsburgh','Movies,film,hollywood',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,1),(10,4,'Playspaces of Highland Park','Highland Park is a great place to take kids (even grown-up kids). Explore the 3 playgrounds, the fountain, and the spray park. Special bonus: the duck pond.','Highland Park','Education & Kids','kids, playgrounds, outdoors, parks',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0),(14,9,'Yoga experience','Experience Yogi Dana\'s transformative session of curated vinyasa flow. This is a great challenge for all fitness abilities and well worth the trek to Sewickley. Warning: addictive.','Sewickley','Health & Fitness','yoga, health, fitness, sweat',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',90,1,0),(15,10,'Harlequins Rugby Game','Take a picture with the players of The Pittsburgh Harlequins Rugby Team','Cheswick','Sports','Sports, Club Sports, Rugby',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',120,1,1),(16,5,'Pedal Pittsburgh','Tour some of the most city neighborhoods on two wheels (a bike) as part of the 25-mile Pedal Pittsburgh annual ride.  Enjoy refreshments and support along the way during this uniquely Pittsburgh event.','Pittsburgh','Health & Fitness','Bike, biking, tour, fitness',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',150,1,0),(17,11,'Screen Test for Andy Warhol','Think you would have what it takes to be in Andy Warhol film? Experience the \"screen test\" as Andy\'s actors once did - in a recreated screen test environment at the Andy Warhol Museum.','North Side','Art & Culture','Andy Warhol',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',45,1,0),(18,12,'Historic Buildings','Pittsburgh is a city with long history.  Thus a lot of historic buildings are hiding in downtown, with their own stories. Are you interested? Choose this mission and we will guide you through all these Pittsburgh treasures.\r\n','Downtown','Art & Culture','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',240,1,0),(19,13,'Western Pennsylvania history','Do you want to know more about Pittsburgh? Accept this mission, you can discover over 250 years of Pittsburgh history at the Senator John Heinz History Center and the Western Pennsylvania Sports Museum, a Smithsonian-affiliated museum located in Pittsburgh\'s historic Strip District.','Downtown','Art & Culture','History',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',120,1,0),(20,17,'Burgers and a Flick','Head down the waterfront any Tuesday after 5PM and get $1 burgers at Bar Louie (with purchase of a drink)!  Once you\'re full of burgers caught a movie at AMC Loews Waterfront 22, right across the street!  Sweet.','Homestead','Uniquely Pittsburgh','Waterfront, Movies, Bar Louie, AMC, Loews',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',180,1,0),(21,18,'South Side Date Night','Want a great date without spending a fortune?  Start out at South Side Works and catch a Matinee.  Afterwards get dinner at The Library Restaurant and top it all off by splitting some Cheesecake Factory Cheesecake.  Total cost is less than $50.','South Side','Food & Drink','Library, Cheesecake Factory, South Side Works',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',180,1,0),(23,19,'East Carson Dive Crawl','Visit some well-known cheap bars on East Carson St.\r\nTad\'s, Jack Rose Bar, 1311, and Dee\'s Cafe.','South Side','Food & Drink','bar,crawl,alcohol',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',150,1,0),(24,20,'Beasts of Schenley Plaza','Did you know that Schenley Plaza is full of wild beasts? Find each of these three and take a picture with them: Dippy the Diplodocus (a really big dinosaur), the god Pan (he\'s the one with pointy ears, surrounded by turtles) and the giant sea horse (who is carousing with many friends).','Oakland','Uniquely Pittsburgh','kids, outdoors, dinosaurs, sculpture',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',30,0,1),(29,16,'Caffeine Fiend','There are many coffee shops in Pittsburgh, but the Strip is home to some of the best. See if you can find them all but make sure to check-in at these five: Marty\'s Market, 21st Street Coffee and Tea, La Prima Espresso, Prestogeorge, and DeLuca\'s.','Strip District','Food & Drink','coffee, caffeine',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',90,0,0),(30,1,'Holiday Cheer','Photograph the holiday sights in Downtown Pittsburgh. Visit the creche at Steel Plaza; go ice skating at PPG Place (Pittsburgh\'s Rockefeller Center); check out the Holiday Market in Market Square; look at what\'s up in Macy\'s window displays; and soak in the glory of the tree at the Point.','Downtown','Art & Culture','holiday, winter, skating, christmas',0,'2013-11-23 05:00:00','2013-12-23 05:00:00',120,0,0),(31,2,'Roller Coaster Roads','Kennywood isn\'t the only way to get your roller coaster fix in Pittsburgh. Steep hills make for fun (some would say scary) driving. Here\'s five to get you started (make sure to have your passenger do your check-in so you can concentrate on driving): Sycamore St. in Mount Washington, Monteiro St. in Greenfield, Troy Hill Rd. up to Goettmann St. in Troy Hill, Logan St. in Millvale, and Heron Ave. in Polish Hill.','Pittsburgh','Uniquely Pittsburgh','hills, driving',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',240,0,0),(32,23,'Visit Etcetera','Check in at Etcetera\'s offices!','Strip District','Uniquely Pittsburgh','Testing, Etcetera',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',5,0,0),(34,24,'Demo: Denizens of the East End (Voluto)','If you visit Voluto Coffee on Penn Ave., you might catch some local celebs ;-).  Take a picture at Voluto with Cathy Lewis Long and/or Matt Hannigan.','Garfield','Uniquely Pittsburgh','Sprout, coffee, voluto',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',10,0,0),(36,15,'Demo: Tech Council','Check-in at the Pittsburgh Tech Council and snag a selfie with President and CEO Audrey Russo... if you can find her...','Oakland','Uniquely Pittsburgh','demo, ptc, celebs',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',10,0,0),(37,22,'Run in Schenely','Run around in Schenley park!','Oakland','Health & Fitness','Park, Running, Excerise',0,'0000-00-00 00:00:00','0000-00-00 00:00:00',60,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missionimage`
--

LOCK TABLES missionimage WRITE;
/*!40000 ALTER TABLE missionimage DISABLE KEYS */;
INSERT INTO missionimage VALUES (1,1,'/images/mural1.jpg'),(2,1,'/images/mural2.jpg'),(3,1,'/images/mural3.jpg'),(4,1,'/images/mural4.png'),(5,1,'/images/mural5.jpg'),(6,1,'/images/mural6.jpg'),(7,1,'/images/mural7.jpg'),(9,6,'/images/Sfogliatelle.jpeg'),(10,7,'/images/HighlandPark.jpg'),(11,8,'/images/Willie.jpg'),(12,9,'/images/Hollywood1.jpg'),(13,9,'/images/Hollywood2.jpg'),(14,9,'/images/Hollywood3.jpg'),(15,9,'/images/Hollywood4.jpg'),(16,9,'/images/Hollywood5.jpg'),(17,9,'/images/Hollywood6.jpg'),(18,9,'/images/Hollywood7.jpg'),(19,10,'/images/PG/farmhouse.jpeg'),(20,10,'/images/PG/poolPG.png'),(21,10,'/images/PG/superPlayground.jpg'),(22,10,'/images/PG/fountain.jpg'),(23,10,'/images/PG/spray.png'),(24,10,'/images/PG/duckpond.jpg'),(25,1,'/images/mural8.jpg'),(31,15,'/images/Rugby.jpg'),(33,14,'/images/Yoga.jpg'),(34,16,'/images/Bikes1.jpg'),(36,17,'/images/Warhol1.jpg'),(38,16,'/images/Bikes2.jpg'),(39,17,'/images/Warhol2.jpg'),(40,18,'/images/CourthouseInside.jpg'),(41,18,'/images/CourthouseOutside.jpg'),(42,18,'/images/Blockhouse.jpg'),(43,18,'/images/PennHotel.jpg'),(44,18,'/images/Antitrust%20Building.jpg'),(46,24,'/images/dippy.jpg'),(47,24,'/images/seahorse.jpg'),(48,24,'/images/pan.jpg'),(53,29,'/images/mcTool/mc_img_tmpoqAfUd.jpg'),(54,29,'/images/mcTool/mc_img_tmpG1Jai5.jpg'),(55,29,'/images/mcTool/mc_img_tmpFnlA7D.jpg'),(56,29,'/images/mcTool/mc_img_tmpm0fYWP.jpg'),(57,29,'/images/mcTool/mc_img_tmpk0hYaN.jpg'),(58,30,'/images/mcTool/mc_img_tmp0L1QQP.png'),(59,31,'/images/mcTool/mc_img_tmpah3gYG.png'),(62,36,'/images/mcTool/mc_img_7xtmcly98m5gg3ep.jpg');
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
INSERT INTO missionlocation VALUES (1,1,0),(1,2,1),(1,3,2),(1,4,3),(1,5,4),(1,6,5),(1,7,6),(1,8,7),(3,10,0),(4,11,0),(4,12,1),(4,13,2),(6,19,0),(7,20,0),(8,21,0),(8,29,6),(9,23,0),(9,24,1),(9,25,2),(9,26,3),(9,27,4),(9,28,5),(9,29,6),(10,20,2),(10,30,0),(10,31,1),(10,33,3),(10,34,4),(10,35,5),(14,38,0),(15,39,0),(16,40,0),(16,41,1),(16,42,2),(17,43,0),(18,44,0),(18,45,1),(18,46,2),(18,47,3),(19,48,0),(20,50,0),(20,51,1),(21,52,0),(21,53,1),(21,54,2),(23,55,0),(23,56,1),(23,57,2),(23,58,3),(24,59,0),(24,60,1),(24,61,2),(29,68,0),(29,69,1),(29,70,2),(29,71,3),(29,72,4),(30,73,0),(30,74,1),(30,75,2),(30,76,3),(30,77,4),(31,78,0),(31,79,1),(31,80,2),(31,81,3),(31,82,4),(32,83,0),(34,85,0),(36,89,0),(37,90,0);
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
