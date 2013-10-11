<?php
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}
if($_GET['lat']!='' || $_GET['lng']!='')
{
	$stmt = $db->prepare("insert into quarters(lat, lng, timestamp) values (?, ?, NOW())");
	$stmt->bind_param('dd', $_GET['lat'], $_GET['lng']);
	$stmt->execute();
	if($stmt->affected_rows<=0) {echo "<div class=\"errortext\">Error inserting rows!</div>\n";}
	else
	{
		echo "<script javascript=\"text/javascript\">location.href=\"dbexplore.php\"</script>";
	}
	$stmt->close();
}
$db->close();
?>