<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!='' && $_POST['userID']!='' )
{
	$db = connectDB();
	
	$stmt = $db->prepare("insert ignore into usermission(userID, missionID) values (?, ?)");
	$stmt->bind_param('dd', $_POST['userID'], $_POST['missionID']);
	$stmt->execute();
	if($stmt->error!=="")
	{
		$stmt->close();
		$db->close();
		$result['OK'] = 0;
		$result['error'] = "Please ensure userID and missionID are valid.";
		exit(json_encode($result));
	}
	$stmt->close();
	
	$stmt = $db->prepare("select missionlocation.locationOrder, ".
	"location.lat, location.lng, location.radius from location, missionlocation ".
	"where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"order by locationOrder ASC");
	$stmt->bind_param('d', $_POST['missionID']);
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
	
	$stmt = $db->prepare("select count(locationOrder) from missionlocation where missionID = ?");
	$stmt->bind_param('d', $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	
	$db->close();
	
	if($count==3 || $count==2) $stars = 2;
	else if($count==1) $stars = 1;
	else $stars = 3;
	$result['numStars'] = $stars;
	
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