<?php
//Include our base function and db functions
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");
noCache();

//Connecto database
$db = connectDB();

//grab mission data
$name = $_POST['name'];
$neighborhood = $_POST['neighborhood'];
$tags = $_POST['tags'];
$type = $_POST['type'];
$description = $_POST['description'];
$estMinutes = $_POST['estMinutes'] + $_POST['estHours']*60;
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$ordered = $_POST['ordered'];
$photo = $_POST['photo'];
$shown = $_POST['shown'];

$locations = json_decode($_POST['locationJSON'], true);
$images = json_decode($_POST['imageJSON'], true);

//Create mission
$stmt = $db->prepare("insert into mission(name, neighborhood, tags, type, description, timeEstimate, startdate, enddate, locationsOrdered, photo, showLocations, sortOrder) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 15)");
$stmt->bind_param('sssssissiii', $name, $neighborhood, $tags, $type, $description, $estMinutes, $startdate, $enddate, $ordered, $photo, $shown);
$err = $stmt->execute();
$stmt->close();
$mid = $db->insert_id;

//Create locations
for($i = 0; $i<count($locations); $i++)
{
	$lat = $locations[$i]['latitude'];
	$lng = $locations[$i]['longitude'];
	$radius = $locations[$i]['radius'];
	$latSin = sin(deg2rad($lat));
	$latCos = cos(deg2rad($lat));
	$locName = $locations[$i]['name'];
	
	
	$stmt = $db->prepare("insert into location(lat, lng, radius, latSin, latCos, name) values(?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ddddds', $lat, $lng, $radius, $latSin, $latCos, $locName);
	$err = $stmt->execute();
	$stmt->close();
	
	$locations[$i]['id'] = $db->insert_id;
}

//Save and associate images
for($i = 0; $i<count($images); $i++)
{
	$uri = '/images/mcTool/'.basename($images[$i]);
	
	//Do not allow users the speificy files like /etc/passwd
	$src = 'temp_images/'.basename($images[$i]);
	$dst = $_SERVER['DOCUMENT_ROOT'].$uri;
	exec('cp '.escapeshellarg($src).' '.escapeshellarg($dst).' > /dev/null 2>&1 &');
	
	$stmt = $db->prepare("insert into missionimage(missionID, imageURI) values(?, ?)");
	$stmt->bind_param('is', $mid, $uri);
	$err = $stmt->execute();
	$stmt->close();
}

//Assoicate locations
for($i = 0; $i<count($locations); $i++)
{
	$stmt = $db->prepare("insert into missionlocation(missionID, locationid, locationOrder) values(?, ?, ?)");
	$stmt->bind_param('iii', $mid, $locations[$i]['id'], $i);
	$err = $stmt->execute();
	$stmt->close();
}

$db->close();

echo "\n:-D\n";

?>
