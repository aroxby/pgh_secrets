<?php
//no  cache headers 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "Database error. Try again later.";
	Die();
}
if($_GET['lat']!='' || $_GET['lng']!='')
{
	$stmt = $db->prepare("insert into quarters(lat, lng, timestamp) values (?, ?, NOW())");
	$stmt->bind_param('dd', $_GET['lat'], $_GET['lng']);
	$stmt->execute();
	if($stmt->affected_rows<=0) {echo "Error inserting rows!";}
	else {echo"success";}
	$stmt->close();
}
$db->close();
?>