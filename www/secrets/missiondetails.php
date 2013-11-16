<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!='')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select name, type, description, showLocations from mission ".
	"where ((year(startDate)<=0) or (year(startDate)>0 and now() between startDate and endDate)) and mission.id=?");
	$stmt->bind_param('i', $_POST['missionID']);
	$stmt->execute();
	bind_array($stmt, $row);
	$stmt->fetch();
	$result = $row;
	$stmt->close();
	
	$stmt = $db->prepare("select missionlocation.locationOrder, ".
	"location.lat, location.lng, location.radius from location, missionlocation ".
	"where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"order by locationOrder ASC");
	$stmt->bind_param('i', $_POST['missionID']);
	$stmt->execute();
	bind_array($stmt, $rows);
	while($stmt->fetch())
	{
		$result['locations'][] = copyArray($rows);
	}
	$stmt->close();
	
	
	$stmt = $db->prepare("select photo from mission where id = ?");
	$stmt->bind_param('d', $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($photo);
	$stmt->fetch();
	$stmt->close();
	$result['photo'] = $photo;
	
	$db->close();
	
	$result['OK'] = 1;
	echo json_encode($result);
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must supply a userID and missionID";
	echo json_encode($result);
}

?>