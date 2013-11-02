<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!='' && $_POST['badgeNumber']!= '')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select imageuri from badgeImage ".
	"where missionID = ? and badgeNumber = ?");
	$stmt->bind_param('ii', $_POST['missionID'], $_POST['badgeNumber']);
	$stmt->execute();
	$stmt->bind_result($uri);
	if($stmt->fetch()) $result['imageuri'] = $uri;

	$stmt->close();
	$db->close();
	
	$result['OK'] = 1;
	echo json_encode($result);
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must supply a missionID and a badgeNumber";
	echo json_encode($result);
}

?>