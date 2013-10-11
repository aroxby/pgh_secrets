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
function removeRow(uid, mid)
{
	document.getElementsByName("removeUID")[0].value = uid;
	document.getElementsByName("removeMID")[0].value = mid;
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
$table = "usermission";
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}

if(is_numeric($_POST['removeUID']))
{
	$stmt = $db->prepare("delete from $table where userID = ? and missionID = ?");
	$stmt->bind_param('ii', $_POST['removeUID'], $_POST['removeMID']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error removing rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

if($_POST['uid']!='')
{
	$stmt = $db->prepare("insert into $table(userID, missionID, progress) values (?, ?, ?)");
	$stmt->bind_param( 'iii', $_POST['uid'], $_POST['mid'], bindec($_POST['progress']));
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select userID, missionID, BIN(progress+0) from $table");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>User ID</th><th>Mission ID</th><th>Progress</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($uid, $mid, $progress);

while($stmt->fetch())
{
	echo "<tr>".
	"<td>$uid</td><td>$mid</td><td>$progress</td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($uid, $mid)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="usermission.php">
<table>
<tr><td>User ID</td><td><input name="uid" type="text" /></td></tr>
<tr><td>Mission ID</td><td><input name="mid" type="text" / ></td></tr>
<tr><td>Progress</td><td><input name="progress" type="text" /></td></tr>
</table>
<input type="submit"/>
</form>

<form id="removalFrm" method="post" action="usermission.php">
<input type="hidden" name="removeUID" />
<input type="hidden" name="removeMID" />
</form>

</body>
</html>