<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['userID']!='')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select usermission.missionid, bit_count(progress)=count(locationorder)
	from missionlocation,usermission
	where userid=?
	and usermission.missionid=missionlocation.missionid
	group by missionlocation.missionid");
	$stmt->bind_param('i', $_POST['userID']);
	$stmt->execute();
	bind_array($stmt, $row);
	
	while($stmt->fetch())
	{
		if($row['bit_count(progress)=count(locationorder)'] == 0) continue;
		$result['missions'][] = $row['missionid'];
	}
	$stmt->close();
	$db->close();
	
	$result['OK'] = 1;
	echo json_encode($result);
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must supply a userID";
	echo json_encode($result);
}

?>
