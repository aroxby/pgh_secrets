<?php
//include base functions
include($_SERVER['DOCUMENT_ROOT']."/scripts/common.php");

//do not allow users to navigate to this file
dropDirectRequest(__FILE__);

//conecto to database
function connectDB()
{
	$db = connectDBUser();
	if($db->connect_errno)
	{
		$result = array();
		$result['OK'] = 0;
		$result['error'] = "Database error. Please try again later.";
		exit(json_encode($result));
	}
	return $db;
}

//main connection line, gives host,username,password,and database
function connectDBUser()
{
	return new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
}

//bind assoicatiave array to SQL statement
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
