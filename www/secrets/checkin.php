<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['lat']!='' && $_POST['lng']!='' && $_POST['missionID']!='' && $_POST['userID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("insert ignore into checkin(userID, missionID, lat, lng) values (?, ?, ?, ?)");
	$stmt->bind_param('iidd', $_POST['userID'], $_POST['missionID'], $_POST['lat'],$_POST['lng']);
	$stmt->execute();
	$stmt->close();
	
	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationOrder, location.radius ".
	"from location missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"and (ACOS(SIN(?)*latsin+COS(?)*latcos*COS(radians(lng)-?))*6371000) < location.radius ORDER BY missionlocation.locationOrder ASC");
	
	$stmt->bind_param('iddd', $_POST['missionID'], deg2rad($_POST['lat']), deg2rad($_POST['lat']), deg2rad($_POST['lng']));
	$stmt->execute();
	$stmt->bind_result($lat,$lng, $order, $radius, $latsin, $latcos);
	
	$stmt_rows = array();
	while($stmt->fetch()){
		$stmt_rows[] = array($lat,$lng, $order, $radius);
	}
	$stmt->close();
	
	//get progress from usermission
	$stmtProgress = $db->prepare("SELECT progress FROM usermission WHERE missionID=? AND userID=?");
	$stmtProgress->bind_param('ii',  $_POST['missionID'],$_POST['userID']);
	//$stmtProgress->bind_param('ii',  $mIDtest, $uIDtest);
	$stmtProgress->execute();
	$stmtProgress->bind_result($progressTEMP);
	
	while($stmtProgress->fetch()){
		$progress = $progressTEMP;
	}
	$stmtProgress->close();
	
	//echo $progress;
	
	//update check in
	foreach($stmt_rows as $temp){
		$next['lat'] = $temp[0];
		$next['lng'] = $temp[1];
		$next['order'] = $temp[2];
		$next['radius'] = $temp[3];
		$mask = 0x1<<$temp[2];
		
		if(($mask & $progress) == 0){
			$progress |= $mask;
			//update progress
			$stmtUpdate = $db->prepare("UPDATE usermission SET progress = progress|? WHERE missionID=? AND userID=?");
			$stmtUpdate->bind_param('idd', $mask, $_POST['missionID'],$_POST['userID']);
			//$stmtUpdate->bind_param('idd', $mask, $mIDtest,$uIDtest);
			$stmtUpdate->execute();
			if($stmtUpdate->affected_rows<=0){
			$result['update'] = 0;
			}
			else{
				$result['update'] = 1;
				$result[] = $next;
			}
			$stmtUpdate->close();
		}
		else{
			$result['update'] = 0;
		}
	}
	$result['complete'] = 0;
		
	//check if mission completes
	/*
	$count =0;
	for($i = 0;$i < ;$i$stmt->num_rows++)
	{
		if(($progress>>$i) & 0x1 == 1){
			$count++;
		}
	}
	if($count >= $stmt->num_rows - 3){
		$result['complete'] = 1;//player meets mission the requirment
	}
	else{
		$result['complete'] = 0;//playe haven't met the basic requirement
	}
	*/
	$db->close();
}
else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}

echo '['.json_encode($result).']';
?>
