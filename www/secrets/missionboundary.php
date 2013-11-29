<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("select max(location.lat), min(location.lat), max(location.lng), min(location.lng) from location, missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id");
	$stmt->bind_param('i', $_POST['missionID']);
	$stmt->execute(); 
	$stmt->bind_result($maxlat, $minlat, $maxlng, $minlng);
	$stmt->fetch();
	//$result['maxLAT'] = 1.2 *($maxlat-$minlat) + $minlat;
	//$result['minLAT'] = $maxlat - 1.2 *($maxlat-$minlat);
	//$result['maxLNG'] = 1.2 *($maxlng-$minlng) + $minlng;;
	//$result['minLNG'] = $maxlng - 1.2 *($maxlng-$minlng);
	$result['maxLAT'] = $maxlat;
	$result['minLAT'] = $minlat;
	$result['maxLNG'] = $maxlng;
	$result['minLNG'] = $minlng;
}
else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}

echo '['.json_encode($result).']';
?>