<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");
noCache();

$db = connectDB();

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

$stmt = $db->prepare("insert into mission(name, neighborhood, tags, type, description, timeEstimate, startdate, enddate, locationsOrdered, photo, showLocations) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssissiii', $name, $neighborhood, $tags, $type, $description, $estMinutes, $startdate, $enddate, $ordered, $photo, $shown);
$err = $stmt->execute();
$stmt->close();
$mid = $db->insert_id;

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

for($i = 0; $i<count($images); $i++)
{
	$uri = '/images/mcTool/'.basename($images[$i]);
	
	$src = $images[$i];
	$dst = $_SERVER['DOCUMENT_ROOT'].$uri;
	exec('cp '.escapeshellarg($src).' '.escapeshellarg($dst).' > /dev/null 2>&1 &');
	
	$stmt = $db->prepare("insert into missionimage(missionID, imageURI) values(?, ?)");
	$stmt->bind_param('is', $mid, $uri);
	$err = $stmt->execute();
	$stmt->close();
}

for($i = 0; $i<count($locations); $i++)
{
	$stmt = $db->prepare("insert into missionlocation(missionID, locationid) values(?, ?)");
	$stmt->bind_param('ii', $mid, $locations[$i]['id']);
	$err = $stmt->execute();
	$stmt->close();
}

$db->close();

echo "\n:-D\n";

?>
