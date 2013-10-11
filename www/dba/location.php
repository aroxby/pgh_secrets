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
<title>Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript">
function removeRow(id)
{
	document.getElementsByName("removeRow")[0].value = id;
	document.getElementById("removalFrm").submit();
}

function zoomMap(lat, lng)
{
	var url = "http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=300x300&maptype=roadmap&sensor=false&center="+lat+","+lng+"&markers=color:red%7C"+lat+","+lng;
	document.getElementById("mapImage").src = url;
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
$table = "location";
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}

if(is_numeric($_POST['removeRow']))
{
	$stmt = $db->prepare("delete from $table where id = ?");
	$stmt->bind_param('i', $_POST['removeRow']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error removing rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

if($_POST['lat']!='' && $_POST['lng']!='')
{
	$stmt = $db->prepare("insert into $table(lat, lng, name, latSin, latCos) values (?, ?, ?, ?, ?)");
	$stmt->bind_param( 'ddsdd', $_POST['lat'], $_POST['lng'], $_POST['name'], sin(deg2rad($_POST['lat'])), cos(deg2rad($_POST['lat'])) );
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows!</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select id, lat, lng, name, description, latSin, latCos from $table");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th></th><th>ID</th><th>Latitude</th><th>Longitute</th><th>Name</th><th>Description</th><th>sin</th><th>cos</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($id, $lat, $lng, $name, $desc, $sin, $cos);

while($stmt->fetch())
{
	echo "<tr>".
	"<td><a class=\"zoomtext\" href=\"javascript:void(0)\" onclick=\"zoomMap($lat, $lng)\">+</td>".
	"<td>$id</td><td>$lat</td><td>$lng</td><td>$name</td><td>$desc</td><td>$sin</td><td>$cos</td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($id)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>
<img id="mapImage" src="http://maps.googleapis.com/maps/api/staticmap?zoom=10&size=300x300&maptype=roadmap&sensor=false&center=40.433160,-79.964940" />

<hr/>

<form method="post" action="location.php">
<table>
<tr><td>Name</td><td><input name="name" type="text" size="50"/ ></td></tr>
<tr><td>Latitude</td><td><input name="lat" type="text" size="50" /></td></tr>
<tr><td>Longitute</td><td><input name="lng" type="text" size="50" /></td></tr>
</table>
<input type="submit"/>
</form>

<form id="removalFrm" method="post" action="location.php">
<input type="hidden" name="removeRow" />
</form>

</body>
</html>