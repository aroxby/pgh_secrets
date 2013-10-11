<?php
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}
if($_POST['lat']!='' || $_POST['lng']!='')
{
	$stmt = $db->prepare("insert into quarters(lat, lng, timestamp) values (?, ?, NOW())");
	$stmt->bind_param('dd', $_POST['lat'], $_POST['lng']);
	$stmt->execute();
	if($stmt->affected_rows<=0) {echo "<div class=\"errortext\">Error inserting rows!</div>\n";}
	else {echo"hello,chitin";}
	$stmt->close();
}
$db->close();

//$LAT=$_POST["lat"];
//$LNG=$_POST["lng"];
//$con = mysql_connect('localhost', 'pgh-challenge', '5NdSW4FaAqQXthqs');
//if (!$con)
//{
//die('Could not connect: ' . mysql_error());
//}
//mysql_select_db("game", $con);
//$sql="insert into quarters(lat, lng, timestamp) values ('$LAT', '$LNG', NOW())";
//if(mysql_query($sql)) 
//{
//echo 'sucess';	
//}
//else
//{
//    die('failed'.mysql_error());
//}
//mysql_close($con);
?>