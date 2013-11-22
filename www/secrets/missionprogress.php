<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!='' && $_POST['userID']!='')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select bit_count(progress), count(locationOrder) from usermission,missionlocation
	where userid=?
	and missionlocation.missionid=?
	and usermission.missionid=?");
	$stmt->bind_param('iii', $_POST['userID'], $_POST['missionID'], $_POST['missionID']);
	$stmt->execute();
	bind_array($stmt, $row);
	$stmt->fetch();
	$stmt->close();
	
	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationorder, usermission.progress&(1<<missionlocation.locationOrder)
	from usermission,missionlocation,location
	where usermission.missionid=?
	and usermission.userid=?
	and location.id=missionlocation.locationid
	and usermission.missionid=missionlocation.missionid
	");
	$stmt->bind_param('ii', $_POST['missionID'], $_POST['userID']);
	$stmt->execute();
	bind_array($stmt, $loc);
	while($stmt->fetch())
	{
		$temp = copyArray($loc);
		renameKey($temp, 'usermission.progress&(1<<missionlocation.locationOrder)', 'visited');
		$temp['visited'] = ($temp['visited']==0)?0:1;
		$superLoc[] = $temp;
	}
	$stmt->close();
	
	$db->close();
	
	//column name fix up
	renameKey($row, 'bit_count(progress)', 'progress');
	renameKey($row, 'count(locationOrder)', 'total');
	
	if($row['progress']===null) $row['progress'] = 0;
	$result = $row;
	
	$result['locations'] = $superLoc;
	
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
