<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['lat']!='' && $_POST['lng']!='' && $_POST['missionID']!='' && $_POST['userID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error";
	
	//Find locations for this mission that the user is in rage of, uses spherical harversine distance
	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationOrder, location.radius ".
	"from location, missionlocation, mission where missionlocation.missionID=? and mission.id=? and missionlocation.locationID=location.id and ".
	"(ACOS(SIN(?)*latsin+COS(?)*latcos*COS(radians(lng-?)))*6371000) < location.radius ORDER BY missionlocation.locationOrder ASC");
	
	$stmt->bind_param('iiddd', $_POST['missionID'], $_POST['missionID'], $latRadians, $latRadians, $_POST['lng']);
	$photo  = intval($_POST['photo']);
	$latRadians = deg2rad($_POST['lat']);
	$stmt->execute();
	bind_array($stmt, $row);
	while($stmt->fetch())
	{
		$missionLocations[] = copyArray($row);
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
	$result['alreadyFound'] = 0;
	$alreadyFound = 0;
	foreach($missionLocations as $next)
	{
		//fix field name
		renameKey($next, 'locationOrder', 'order');

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
			$result['locations'][] = copyArray($next);
			
		}
		else
		{
			$alreadyFound = 1;
		}
	}
	
	if($result['update']!==1) $result['alreadyFound'] = $alreadyFound;
	
	//get total number of lacations
	$totalLocationNUM = 0; 
	$stmt = $db->prepare("SELECT COUNT(missionlocation.locationID), bit_count(usermission.progress) FROM missionlocation, usermission WHERE missionlocation.missionID=? and usermission.userID=? and usermission.missionID=?");
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
	
	
	//Save checking debugging information
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
