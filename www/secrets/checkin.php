<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['lat']!='' && $_POST['lng']!='' && $_POST['missionID']!='' && $_POST['userID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationOrder, location.radius ".
	"from location, missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"and (ACOS(SIN(?)*latsin+COS(?)*latcos*COS(radians(lng-?)))*6371000) < location.radius ORDER BY missionlocation.locationOrder ASC");
	
	$stmt->bind_param('iddd', $_POST['missionID'], deg2rad($_POST['lat']), deg2rad($_POST['lat']), $_POST['lng']);
	$stmt->execute();
	$stmt->bind_result($lat, $lng, $order, $radius);
	
	$stmt_rows = array();
	while($stmt->fetch()){
		$stmt_rows[] = array($lat,$lng, $order, $radius);
	}
	$stmt->close();
	
	//get progress from usermission
	$stmtProgress = $db->prepare("SELECT progress FROM usermission WHERE missionID=? AND userID=?");
	$stmtProgress->bind_param('ii',  $_POST['missionID'],$_POST['userID']);
	$stmtProgress->execute();
	$stmtProgress->bind_result($progressTEMP);
	
	while($stmtProgress->fetch()){
		$progress = $progressTEMP;
	}
	$stmtProgress->close();
	
	//echo $progress;
	
	//update check in
	$result['update'] = 0;
	foreach($stmt_rows as $temp){
		$next['lat'] = $temp[0];
		$next['lng'] = $temp[1];
		$next['order'] = $temp[2];
		$next['radius'] = $temp[3];
		$mask = 0x1<<$temp[2];
		
		if(($mask & $progress) == 0)
		{
			$progress |= $mask;
			//update progress
			$stmtUpdate = $db->prepare("UPDATE usermission SET progress = progress|? WHERE missionID=? AND userID=?");
			$stmtUpdate->bind_param('iii', $mask, $_POST['missionID'],$_POST['userID']);
			$stmtUpdate->execute();
			$stmtUpdate->close();
			$result['update'] = 1;
			$result[] = $next;
		}
	}
	
		
	//get total number of lacations
	$totalLocationNUM = 0; 
	$stmtTotalLocation = $db->prepare("SELECT COUNT(DISTINCT missionlocation.locationID), bit_count(usermission.progress) FROM missionlocation, usermission WHERE missionlocation.missionID=? and usermission.userID=? and usermission.missionID=?");
	$stmtTotalLocation->bind_param('iii', $_POST['missionID'], $_POST['userID'], $_POST['missionID']);
	$stmtTotalLocation->execute();
	$stmtTotalLocation->bind_result($totalLocationNUM, $count);
	$stmtTotalLocation->fetch();
	$stmtTotalLocation->close();
	
	if($count < (int)($totalLocationNUM/2)){
		$result['complete'] = 0;
		$result['badges'] = 0;
	}
	else{
		$result['complete'] = 1;
		if($count == $totalLocationNUM){
			$result['badges'] = 3;
		}
		else if($count >= (int)($totalLocationNUM*0.8)){
			$result['badges'] = 2;
		}
		else{
			$result['badges'] = 1;
		}
	}
	
	$result['progress'] = $count;
	$result['totalLocations'] = $totalLocationNUM;
	
	$stmt = $db->prepare("insert ignore into checkin(userID, missionID, lat, lng, json, beforeProgress, afterProgress) values (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('iiddsii', $_POST['userID'], $_POST['missionID'], $_POST['lat'],$_POST['lng'], $debugjson, $progressTEMP, $progress);
	$debugjson = '['.json_encode($result).']';
	$stmt->execute();
	$stmt->close();
	
	$db->close();
}
else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}

echo '['.json_encode($result).']';
?>
