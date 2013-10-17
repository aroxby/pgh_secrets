<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['lat']!='' && $_POST['lng']!='' && $_POST['missionID']!='' && $_POST['userID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationOrder, location.radius ".
	"from location, missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"and (ACOS(SIN(?)*latsin+COS(?)*latcos*COS(radians(lng-?)))*6371000) < location.radius ORDER BY missionlocation.locationOrder ASC");
	
	$stmt->bind_param('iddd', $_POST['missionID'], $latRadians, $latRadians, $_POST['lng']);
	$latRadians = deg2rad($_POST['lat']);
	$stmt->execute();
	bind_array($stmt, $row);
	while($stmt->fetch())
	{
		$stmt_rows[] = copyArray($row);
	}
	$stmt->close();
	
	//get progress from usermission
	$stmt = $db->prepare("SELECT progress FROM usermission WHERE missionID=? AND userID=?");
	$stmt->bind_param('ii',  $_POST['missionID'],$_POST['userID']);
	$stmt->execute();
	$stmt->bind_result($oldProgress);
	$stmt->fetch();
	$stmt->close();
	$progress = $oldProgress;
	
	//update check in
	$result['update'] = 0;
	foreach($stmt_rows as $next)
	{
		//fix field name
		$next['order'] = $next['locationOrder'];
		unset($next['locationOrder']);

		$mask = 0x1<<$next['order'];
		
		if(($mask & $progress) == 0)
		{
			$progress |= $mask;
			//update progress
			$stmt = $db->prepare("UPDATE usermission SET progress = progress|? WHERE missionID=? AND userID=?");
			$stmt->bind_param('iii', $mask, $_POST['missionID'],$_POST['userID']);
			$stmt->execute();
			$stmt->close();
			$result['update'] = 1;
			$result['locations'][] = $next;
		}
	}
	
		
	//get total number of lacations
	$totalLocationNUM = 0; 
	$stmt = $db->prepare("SELECT COUNT(DISTINCT missionlocation.locationID), bit_count(usermission.progress) FROM missionlocation, usermission WHERE missionlocation.missionID=? and usermission.userID=? and usermission.missionID=?");
	$stmt->bind_param('iii', $_POST['missionID'], $_POST['userID'], $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($totalLocationNUM, $count);
	$stmt->fetch();
	$stmt->close();
	
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
	$stmt->bind_param('iiddsii', $_POST['userID'], $_POST['missionID'], $_POST['lat'],$_POST['lng'], $debugjson, $oldProgress, $progress);
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
