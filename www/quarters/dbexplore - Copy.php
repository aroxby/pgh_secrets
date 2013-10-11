<?php
//no  cache headers 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<html>
<head>
<title>Pittsburgh Challenge Quarters Database</title>
<style>
table, tr, td, th
{
	border: 1px solid black;
}
.centered
{
	display: block;
	margin: auto;
	text-align: center;
}
.errortext, .deletetext
{
	font-weight: bold;
	color: red;
	text-decoration: none;
}
.zoomtext
{
	font-weight: bold;
	color: blue;
	text-decoration: none;
}
.refreshBtn
{
	vertical-align: top;
}
#dataTable
{
	vertical-align: top;
	display: inline;
	*border: 0px;
}
</style>
<script type="text/javascript">
function submitRemove()
{
	document.getElementsByName("removeKey")[0].value = window.prompt("Enter Removal Key");
	document.getElementById("removalFrm").submit();
}

function removeRow(id)
{
	document.getElementsByName("removeRow")[0].value = id;
	submitRemove();
	
}

function removeAll()
{
	document.getElementsByName("removeAll")[0].value = 1;
	submitRemove();
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
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}

if($_POST['removeKey']==="007")
{
	if(is_numeric($_POST['removeRow']))
	{
		$stmt = $db->prepare("delete from quarters where rowID = ?");
		$stmt->bind_param('d', $_POST['removeRow']);
		$stmt->execute();
		$stmt->close();
	}
	if(is_numeric($_POST['removeAll']))
	{
		$stmt = $db->prepare("truncate table quarters");
		$stmt->execute();
		$stmt->close();
	}
}

if($_POST['lat']!='' || $_POST['lng']!='')
{
	$stmt = $db->prepare("insert into quarters(lat, lng, timestamp) values (?, ?, NOW())");
	$stmt->bind_param('dd', $_POST['lat'], $_POST['lng']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows!</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select rowID, userID, lat, lng, timestamp from quarters");

echo "<div class=\"centered\">\n";
echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th></th><th>User ID</th><th>Latitude</th><th>Longitute</th><th>Timestamp</th>";
echo "<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeAll()\">X</a></td></tr>\n";

$stmt->execute();
$stmt->bind_result($rowid, $uid, $lat, $lng, $stamp);
$i = 0;

while($stmt->fetch())
{
	echo "<tr>".
	"<td><a class=\"zoomtext\" href=\"javascript:void(0)\" onclick=\"zoomMap($lat, $lng)\">+</td>".
	"<td>$uid</td><td>$lat</td><td>$lng</td><td>$stamp</td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($rowid)\">X</a></td>".
	"</tr>\n";
	$i++;
}
echo "</table>\n";

$stmt->close();
$db->close();
?>
<img id="mapImage" src="http://maps.googleapis.com/maps/api/staticmap?zoom=10&size=300x300&maptype=roadmap&sensor=false&center=40.433160,-79.964940" />
</div>

<!--
<hr/>

<form method="post" action="dbexplore.php">
<table class="centered">
<tr>
	<td>User ID</td><td><input type="text" value="1001" disabled="disabled"/></td>
	<td>Timestamp</td><td><input type="text" disabled="disabled" value="<?echo date("Y-m-d H:i:s"); ?>" /></td>
</tr><tr>
	<td>Latitude</td><td><input name="lat" type="text" /></td>
	<td>Longitute</td><td><input name="lng" type="text" /></td>	
</tr>
</table>
<input class="centered" type="submit"/>
</form>

<form id="removalFrm" method="post" action="dbexplore.php">
<input type="hidden" name="removeRow" />
<input type="hidden" name="removeAll" />
<input type="hidden" name="removeKey" />
</form>
-->

</body>
</html>