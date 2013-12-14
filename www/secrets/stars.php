<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['userID']!='' && $_POST['type']!='')
{
	$result['numStars'] = 0;

	$db = connectDB();
	
	//Get the number of locations a user has checked in at for a given mission category
	$stmt = $db->prepare("select count(locationorder), bit_count(progress)=count(locationorder)
	from missionlocation,usermission,mission
	where userid=?
	and usermission.missionid=missionlocation.missionid
	and mission.id=usermission.missionid
	and mission.type=?
	group by missionlocation.missionid");
	$stmt->bind_param('is', $_POST['userID'], $_POST['type']);
	$stmt->execute();
	bind_array($stmt, $row);
	
	//Calculate how many stars they have earned
	while($stmt->fetch())
	{
		if($row['bit_count(progress)=count(locationorder)']===1)
		{
			$count = $row['count(locationorder)'];
			if($count==1) $result['numStars'] += 1;
			else if($count==2 || $count==3) $result['numStars'] += 2;
			else $result['numStars'] += 3;
		}
	}

	$stmt->close();
	$db->close();
	
	$result['OK'] = 1;
	echo json_encode($result);
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must supply a userID and type";
	echo json_encode($result);
}

?>
