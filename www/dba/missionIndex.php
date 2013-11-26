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
<title>Mission - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="/dba/dba.css">
</head>
<body>

<?php
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
$table = "mission";
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}


$stmt = $db->prepare("select type, name, description, neighborhood from $table order by sortOrder asc");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>Type</th><th>Name</th><th>Description</th><th>Neighborhood</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($type, $name, $desc, $neighborhood);

$missionCount = 0;
while($stmt->fetch())
{
	echo "<tr>".
	"<td><img src=\"/images/typeIcon/$type.png\"/></td><td>$name</td><td><pre>".htmlspecialchars($desc)."</pre></td><td>$neighborhood</td>";
	
	echo "</tr>\n";
	$missionCount++;
}
echo "</table>\n<hr/>Total Missions: $missionCount\n";

$stmt->close();
$db->close();
?>
</body>
</html>