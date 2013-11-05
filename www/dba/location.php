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
<title>Location - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="maps.js"></script>
<script type="text/javascript">
createMap(function(map, marker, circle)
{
	zoomMap.map = map;
	
	marker.onDrop = function(e)
	{
		updateLatLng(e.latLng, false, true);
	};
	
	map.onClick = function(e)
	{
		updateLatLng(e.latLng, true, true);
	};
	
	circle.onChanged = function()
	{
		updateLatLng(circle.getCenter(), true, false);
	};
	
	updateLatLng.marker = marker;
	updateLatLng.circle = circle;
});

function removeRow(id)
{
	document.getElementsByName("removeRow")[0].value = id;
	if(confirm('Are you sure you want to delete this record?')) document.getElementById("removalFrm").submit();
}

function zoomMap(lat, lng, radius)
{
	zoomMap.map.centerOn(lat, lng, radius);
}

function zoomMapForm()
{
	var lat = document.getElementsByName("lat")[0].value;
	var lng = document.getElementsByName("lng")[0].value;
	var rad = document.getElementsByName("radius")[0].value;
	if(lat!="" && lng!="") zoomMap(lat, lng, rad);
}

function refreshPage()
{
	location.reload();
}

function updateLatLng(ll, updateMaker, updateCircle, updateMap)
{
	var lat = ll.lat();
	var lng = ll.lng();
	var radius = updateLatLng.circle.getRadius();

	document.getElementsByName("lat")[0].value = lat;
	document.getElementsByName("lng")[0].value = lng;
	document.getElementsByName("radius")[0].value = radius;
	if(updateMaker) updateLatLng.marker.setPosition(ll);
	if(updateCircle)
	{
		var oldFn = updateLatLng.circle.onChanged;
		updateLatLng.circle.onChanged = function(){};
		updateLatLng.circle.setCenter(ll);
		updateLatLng.circle.onChanged = oldFn;
	}
}

function stripslashes(str)
{
	str = str.replace(/\\'/g, '\'');
	str = str.replace(/\\"/g, '"');
	str = str.replace(/\\0/g, '\0');
	str = str.replace(/\\\\/g, '\\');
	return str;
}

function duplicate(id, lat, lng, radius, name, photo)
{
	name = stripslashes(name);
	document.getElementsByName("id")[0].value = id
	document.getElementsByName("lat")[0].value = lat;
	document.getElementsByName("lng")[0].value = lng;
	document.getElementsByName("radius")[0].value = radius;
	document.getElementsByName("name")[0].value = name;
	document.getElementsByName("photo")[0].checked = !!photo;
	zoomMap(lat, lng, radius);
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
	$stmt = "";
	$photo = isset($_POST['photo']);
	if(is_numeric($_POST['id']))
	{
		$stmt = $db->prepare("update $table set lat=?, lng=?, radius=?, name=?, latSin=?, latCos=?, photoCheckIn=? where id=?");
		$stmt->bind_param( 'dddsddii', $_POST['lat'], $_POST['lng'], $_POST['radius'], $_POST['name'], sin(deg2rad($_POST['lat'])), cos(deg2rad($_POST['lat'])), $photo, $_POST['id'] );
	}
	else
	{
		$stmt = $db->prepare("insert into $table(lat, lng, radius, name, latSin, latCos, photoCheckIn) values (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param( 'dddsddi', $_POST['lat'], $_POST['lng'], $_POST['radius'], $_POST['name'], sin(deg2rad($_POST['lat'])), cos(deg2rad($_POST['lat'])), $photo );
	}

	$stmt->execute();
	if($stmt->affected_rows<=0 && !is_numeric($_POST['id'])) echo "<div class=\"errortext\">Error inserting rows!</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select id, lat, lng, radius, name, photoCheckIn, latSin, latCos from $table");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th></th><th></th><th>ID</th><th>Latitude</th><th>Longitude</th><th>Radius</th><th>Name</th><th>Photo Check In</th><th>sin</th><th>cos</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($id, $lat, $lng, $radius, $name, $photo, $sin, $cos);

while($stmt->fetch())
{
	echo "<tr>".
	"<td><a class=\"zoomtext\" href=\"javascript:void(0)\" onclick=\"zoomMap($lat, $lng, $radius)\">+</td>".
	"<td><a class=\"copyText\" href=\"javascript:void(0)\" onClick=\"duplicate($id, $lat, $lng, $radius, '".addslashes($name)."', $photo)\">&dArr;</a></td>".
	"<td>$id</td><td>$lat</td><td>$lng</td><td>$radius</td><td>$name</td>";
	
	if(is_numeric($photo) && $photo!=0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	
	echo "<td>$sin</td><td>$cos</td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($id)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="location.php">
<table>
<tr>
	<td rowspan="100"><a class="zoomtext" href="javascript:void(0)" onclick="zoomMapForm()">+</td>
	<td>ID</td><td><input class="grayed" name="id" readonly="readonly" type="text" size="50"/ ></td>
</tr>
<td>Name</td><td><input name="name" type="text" size="50"/ ></td>
<tr><td>Latitude</td><td><input name="lat" type="text" size="50" /></td></tr>
<tr><td>Longitude</td><td><input name="lng" type="text" size="50" /></td></tr>
<tr><td>Radius (meters)</td><td><input name="radius" type="text" size="50" /></td></tr>
<tr><td>Photo Check In</td><td><input name="photo" type="checkbox" /></td></tr>
</table>
<input type="submit"/>
</form>

<form id="removalFrm" method="post" action="location.php">
<input type="hidden" name="removeRow" />
</form>

</body>
</html>