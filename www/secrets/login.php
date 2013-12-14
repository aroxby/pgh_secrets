<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

if($_POST['username']!='' /*&& $_POST['password']!=''*/)
{

	$db = connectDB();
	//validates a username/password conbination
	$stmt = $db->prepare("select id from user where userName=? and password=? limit 1");
	$stmt->bind_param( 'ss', $_POST['username'], $pass );
	$pass = pack("H*" , $_POST['password']);
	
	$stmt->bind_result($uid);
	$stmt->execute();
	if($stmt->fetch()===TRUE)
	{
		$result['OK'] = 1;
		$result['userID'] = $uid;
	}
	else
	{
		$result['OK'] = 0;
		$result['error'] = "Bad username or password.";
	}
	$stmt->close();
	$db->close();
}
else
{
	$result['OK'] = 0;
	$result['error'] = "You must specify and username and password";
}

echo json_encode($result);
?>
