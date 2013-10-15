<?php
//no  cache headers 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkin - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY1D4KC4Rs0dHqfab46Qi84BR3EisJ8xQ&sensor=false"></script>
<script type="text/javascript" src="maps.js"></script>

<script type="text/javascript">
function zoomMap(lat, lng)
{
	centerMap(lat, lng);
}

function refreshPage()
{
	location.reload();
}
</script>
</head>
<body>
<?php
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
$table = "checkin";
if(mysqli_connect_errno())
{
	echo "<h3 id=\"errorText\">Database error. Try again later.</h3>\n</body></html>";
	Die();
}

$stmt = $db->prepare("select id, userID, missionID, lat, lng, timestamp, json, beforeProgress, afterProgress from $table");
$stmt->execute();
$stmt->bind_result($id, $uid, $mid, $lat, $lng, $timestamp, $json, $before, $after);

echo "<table id=\"dataTable\" width=\"50%\">\n";
echo "<tr><th></th><th>Check-in ID</th><th>User ID</th><th>Mission ID</th><th>Latitude</th><th>Longitude</th><th>Timestamp</th>";
echo "<th>JSON String</th><th>Before Progress</th><th>After Progress</th>";
echo "</tr>\n";

while($stmt->fetch())
{
	echo "<tr>".
	"<td><a class=\"zoomtext\" href=\"javascript:void(0)\" onclick=\"zoomMap($lat, $lng)\">+</a></td>".
	"<td>$id</td><td>$uid</td><td>$mid</td><td>$lat</td><td>$lng</td><td>$timestamp</td><td>$json</td><td>$before</td><td>$after</td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

</body>
</html>