<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['missionID']!='')
{
	$db = connectDB();
	
	$stmt = $db->prepare("select imageuri from missionimage ".
	"where missionID = ?");
	$stmt->bind_param('d', $_POST['missionID']);
	$stmt->execute();
	bind_array($stmt, $rows);
	while($stmt->fetch())
	{
		$result['images'][] = $rows['imageuri'];
	}

	$stmt->close();
	
	
	$stmt = $db->prepare("select COUNT(imageuri) from missionimage ".
	"where missionID = ?");
	$stmt->bind_param('d', $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($imageNUM);
	$stmt->fetch();
	$stmt->close();
	$result['imageNumber'] = $imageNUM;
	
	$result['OK'] = 1;
	echo json_encode($result);
	$db->close();
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must supply a missionID";
	echo json_encode($result);
}

?>