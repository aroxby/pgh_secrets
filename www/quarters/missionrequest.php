<?php

function bind_array($stmt, &$row) {
    $md = $stmt->result_metadata();
    $params = array();
    while($field = $md->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
}

$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "Database error. Try again later.";
	Die();
}

if($_POST['missionID']!='' || $_POST['userID']!='' ){
	$stmt = $db->prepare("select location.id, location.lat, location.lng, location.radius from location,".
	"missionlocation where missionlocation.missionID=? and missionlocation.locationID = location.id order by location.id ASC");
	$stmt->bind_param('d',  $_POST['missionID']);
	$stmt->execute();
	$stmt->bind_result($id, $lat, $lng, $radius);
	
	$rows = array();
	bind_array($stmt, $rows);	
	$result = array();
	while($stmt->fetch()){
		$result[] =$rows; 
	}
	echo json_encode($result);
	
	
	/*
	$stmtUM = $db->prepare("insert into usermission(userID, missionID, progress) values (?, ?, 0x0)");
	echo "b1";
	$stmtUM->bind_param('dd', $_POST['userID'], $_POST['missionID']);
	echo "b2";
	$stmtUM->execute();
	echo "b3";
	if($stmtUM->affected_rows<=0) {echo "Error inserting rows!";}
	echo "b4";
	$stmtUM->close();
	*/
}


$stmt->close();
$db->close();
?>