<?php
//this is a debugging one
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

//if($_POST['lat']!='' && $_POST['lng']!='' && $_POST['missionID']!='' && $_POST['userID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error";

	//test only
	$lattest = 40.428251;
	$lngtest = -79.970312;
	$mIDtest = 1;
	$uIDtest = 2;

	$stmt = $db->prepare("select location.lat, location.lng, missionlocation.locationOrder, location.radius ".
	"from location, missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id ".
	"and (ACOS(SIN(?)*latsin+COS(?)*latcos*COS(radians(lng-?)))*6371000) < location.radius ORDER BY missionlocation.locationOrder ASC");
	
	$stmt->bind_param('iddd', $mIDtest, $latRadians, $latRadians, $lngtest);
	$latRadians = deg2rad($lattest);
	$stmt->execute();
	bind_array($stmt, $row);
	while($stmt->fetch())
	{
		$stmt_rows[] = copyArray($row);
	}
	$stmt->close();
	
	//get progress from usermission
	$stmt = $db->prepare("SELECT progress FROM usermission WHERE missionID=? AND userID=?");
	
	//$stmtProgress->bind_param('dd',  $_POST['missionID'],$_POST['userID']);
	$stmt->bind_param('ii',  $mIDtest, $uIDtest);
	$stmt->execute();
	$stmt->bind_result($oldProgress);
	$stmt->fetch();
	$stmt->close();
	$progress = $oldProgress;
	
	//update check in
	$result['update'] = 0;
	$result['alreadyFound'] = 0;
	$alreadyFound = false;
	foreach($stmt_rows as $next)
	{
		//fix field name
		renameKey($next, 'locationOrder', 'order');

		$mask = 0x1<<$next['order'];
		
		if(($mask & $progress) == 0)
		{
			$progress |= $mask;
			//update progress
			$stmt = $db->prepare("UPDATE usermission SET progress = progress|? WHERE missionID=? AND userID=?");
			$stmt->bind_param('iii', $mask, $mIDtest, $uIDtest);
			$stmt->execute();
			$stmt->close();
			$result['update'] = 1;
			$result['locations'][] = copyArray($next);
		}
		else
		{
			$alreadyFound = true;
		}
	}
	
	if($result['update']!==1) $result['alreadyFound'] = 1;
	
	//get total number of lacations
	$totalLocationNUM = 0; 
	$stmt = $db->prepare("SELECT COUNT(DISTINCT missionlocation.locationID), bit_count(usermission.progress) FROM missionlocation, usermission WHERE missionlocation.missionID=? and usermission.userID=? and usermission.missionID=?");
	$stmt->bind_param('iii', $mIDtest, $uIDtest, $mIDtest);
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

$db->close();
/*
}else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}
*/
echo "<pre>";
print_r($result);
echo "\n----------------------------\n";

echo json_encode($result);

echo "</pre>";
?>
