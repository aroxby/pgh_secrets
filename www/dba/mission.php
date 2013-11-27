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
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript">
function removeRow(id)
{
	document.getElementsByName("removeRow")[0].value = id;
	document.getElementById("removalFrm").submit();
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
$table = "mission";
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

if($_POST['name']!='')
{
	$stmt = $db->prepare("insert into $table(name, description, neighborhood, type, tags, locationsOrdered, startDate, endDate, timeEstimate, showLocations, photo, sortOrder) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 15)");
	$stmt->bind_param(
		'sssssissiii', $_POST['name'], $_POST['desc'], $_POST['neighborhood'], $_POST['type'], $_POST['tags'], $orderd,
		$_POST['startdate'], $_POST['enddate'], $_POST['limit'],
		$ShowLocations, $photo
	);
	$orderd = isset($_POST['ordered']);
	$ShowLocations = isset($_POST['showLocations']);
	$photo = isset($_POST['photo']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select id, name, description, neighborhood, type, tags, locationsOrdered, startDate, endDate, timeEstimate, showLocations, photo from $table order by sortOrder asc");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Neighborhood</th><th>Type</th><th>Tags</th>".
"<th>Locations Ordered</th>".
"<th>Start Date</th><th>End Date</th><th>Time Limit</th>".
"<th>Show Locations</th><th>Photo Mission</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($id, $name, $desc, $neighborhood, $type, $tags, $ordered, $startdate, $enddate , $limit, $ShowLocations, $photo);

$missionCount = 0;
while($stmt->fetch())
{
	echo "<tr>".
	"<td>$id</td><td>$name</td><td><pre>".htmlspecialchars($desc)."</pre></td><td>$neighborhood</td><td>$type</td><td>$tags</td>";
	
	if(is_numeric($ordered) && $ordered>0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	
	echo "<td>$startdate</td><td>$enddate</td><td>$limit</td>";
	
	if(is_numeric($ShowLocations) && $ShowLocations>0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	
	if(is_numeric($photo) && $photo>0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	
	echo "<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($id)\">X</a></td>".
	"</tr>\n";
	
	$missionCount++;
}
echo "</table>\n<hr/>Total Missions: $missionCount\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="mission.php">
<table>
<tr><td>Name</td><td><input name="name" type="text" size="50"/ ></td></tr>
<tr><td>Neighborhood</td><td><input name="neighborhood" type="text" size="50" /></td></tr>
<tr><td>Type</td><td><input name="type" type="text" size="50" /></td></tr>
<tr><td>Tags (Comma Seperated)</td><td><input name="tags" type="text" size="50" /></td></tr>
<tr><td colspan="2">Description</td></tr>
<tr><td colspan="2"><textarea name="desc" rows="10" style="width:98.5%"></textarea></td></tr>
<tr><td>Locations Orderd</td><td><input name="ordered" type="checkbox" /></td></tr>
<tr><td>Start Date</td><td><input name="startdate" type="date" /></td></tr>
<tr><td>End Date</td><td><input name="enddate" type="date" /></td></tr>
<tr><td>Time Estimate (in Minutes)</td><td><input name="limit" type="text" /></td></tr>
<tr><td>Show Locations</td><td><input name="showLocations" type="checkbox" /></td></tr>
<tr><td>Photo Mission</td><td><input name="photo" type="checkbox" /></td></tr>
</table>
<input type="submit"/>
</form>

<form id="removalFrm" method="post" action="mission.php">
<input type="hidden" name="removeRow" />
</form>

</body>
</html>