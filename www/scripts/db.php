<?php

include($_SERVER['DOCUMENT_ROOT']."/scripts/common.php");

dropDirectRequest(__FILE__);

function connectDB()
{
	$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
	if(mysqli_connect_errno())
	{
		$result = array();
		$result['OK'] = 0;
		$result['error'] = "Database error. Please try again later.";
		exit(json_encode($result));
	}
	return $db;
}

function bind_array($stmt, &$row)
{
	$md = $stmt->result_metadata();
	$params = array();
	while($field = $md->fetch_field())
	{
		$params[] = &$row[$field->name];
	}
	call_user_func_array(array($stmt, 'bind_result'), $params);
}

?>
