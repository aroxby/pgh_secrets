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
	
	//column name fix up
	renameKey($row, 'bit_count(progress)', 'progress');
	renameKey($row, 'count(locationOrder)', 'total');
	
	if($row['progress']===null) $row['progress'] = 0;
	$result = $row;
	$stmt->close();
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
