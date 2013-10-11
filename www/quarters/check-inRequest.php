<?php
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "Database error. Try again later.";
	Die();
}

if($_POST['lat']!='' || $_POST['lng']!='' || $_POST['missionID']!='' || $_POST['userID']){
	$stmt = $db->prepare("SELECT location.latSin, location.latCos, location.lng, location.radius, missionlocation.locationOrder FROM location,".
	"missionlocation WHERE missionlocation.missionID=? AND missionlocation.locationID = location.id ORDER BY missionlocation.locationOrder ASC");
	$stmt->bind_param('d',  $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($latSin, $latCos, $lngDB, $radius, $order);
	
	$stmtProgress = $db->prepare("SELECT progess FROM usermission WHERE missionID=? AND userID=?");
	$stmtProgress->bind_param('dd',  $_POST['missionID'],$_POST['userID']);
	$stmtProgress->execute();
	$stmtProgress->bind_result($progressTEMP);
		
	//get $progress
	if($stmtProgress->affected_rows<=0 || !$stmtProgress->fetch()) 
	{
		$progess = $progressTemp;
	}
	$stmtProgress->close();
	
	$LAT = $_POST['lat'];
	$LNG = $_POST['lng'];
	
	if($stmt->affected_rows<=0) 
	{
		echo "No such mission!";
	}
	else {
		//judge whether it is a effective check in
		while($stmt->fetch())
		{
			$mask = 0x1<<$order;
			if($mask & $progress == 0){
				if(acos(sin($LAT)*latSin+cos($LAT)*latCos * cos($lngDB - $LNG))* 6371 < $radius){
					$progress |= $mask;
					//update progress
					$stmtUpdate = $db->prepare("UPDATE usermission SET progress = ? WHERE missionID=? AND userID=?");
					$stmtUpdate->bind_param('idd', $progress, $_POST['missionID'],$_POST['userID']);
					$stmtUpdate->execute();
					if($stmtUpdate->affected_rows<=0) echo "Error inserting rows!";
					$stmtUpdate->close();
					echo"successful check-in!";
					break;
				}
				else{
					echo"wrong place";
				}
			}
			echo "You have already checked in here!";
		}
	}
	
	//check if mission completes
	$count =0;
	for($i = 0;$i < $stmt->num_rows;$i++)
	{
		if(($progress>>$i) & 0x1 == 1){
			count++;
		}
	}
	if(count >= $stmt->num_rows - 3){
		echo"complete";//player meets mission the requirment
	}
	else{
		echo"continue";//player haven't met the basic requirement
	}
	
	$stmt->close();
}
$db->close();
?>


