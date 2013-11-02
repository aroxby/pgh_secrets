<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['userID']!='')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select missionid from usermission where userid=?");
	$stmt->bind_param('i', $_POST['userID']);
	$stmt->execute();
	bind_array($stmt, $row);
	while($stmt->fetch())
	{
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
