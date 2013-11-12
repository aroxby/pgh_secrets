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
<title>MissionLocation - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript">
function removeRow(mid, lid)
{
	document.getElementsByName("removeMID")[0].value = mid;
	document.getElementsByName("removeLID")[0].value = lid;
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
$table = "missionlocation";
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}

if(is_numeric($_POST['removeMID']))
{
	$stmt = $db->prepare("delete from $table where missionID = ? and locationID = ?");
	$stmt->bind_param('ii', $_POST['removeMID'], $_POST['removeLID']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error removing rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

if($_POST['mid']!='')
{
	$stmt = $db->prepare("insert into $table(missionID, locationID, locationOrder) values (?, ?, ?)");
	$stmt->bind_param( 'iii', $_POST['mid'], $_POST['lid'], $_POST['order']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select missionID, locationID, locationOrder from $table order by missionID asc,locationOrder asc");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>Mission ID</th><th>Location ID</th><th>Location Order</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($mid, $lid, $order);

while($stmt->fetch())
{
	echo "<tr>".
	"<td>$mid</td><td>$lid</td><td>$order</td>";
	echo "<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($mid, $lid, $order)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="missionlocation.php">
<table>
<tr><td>Mission ID</td><td><input name="mid" type="text" /></td></tr>
<tr><td>Location ID</td><td><input name="lid" type="text" / ></td></tr>
<tr><td>Location Order</td><td><input name="order" type="text" /></td></tr>
</table>
<input type="submit"/>
</form>

<form id="removalFrm" method="post" action="missionlocation.php">
<input type="hidden" name="removeMID" />
<input type="hidden" name="removeLID" />
</form>

</body>
</html>