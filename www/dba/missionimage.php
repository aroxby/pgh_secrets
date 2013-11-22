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
<title>MissionImage - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="/scripts/sha256.js"></script>
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
$table = "missionimage";
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

if($_POST['imguri']!='')
{
	$stmt = $db->prepare("insert into $table(missionID, imageURI) values (?, ?)");
	$stmt->bind_param( 'is', $_POST['mid'], $_POST['imguri'] );
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select id, missionID, imageURI from $table order by missionid asc");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>Row ID</th><th>Mission ID</th><th>Image URI</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($id, $mid, $imguri);

while($stmt->fetch())
{
	echo "<tr>".
	"<td>$id</td><td>$mid</td>".
	"<td><a href=\"$imguri\" target=\"_blank\">$imguri</a></td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($id)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="missionimage.php">
<table>
<tr><td>Mission ID</td><td><input name="mid" type="text" size="50"/ ></td></tr>
<tr><td>Image URI</td><td><span style="margin:0px;border:0px;padding:0xp">&nbsp;http://pgh-challenge.etc.cmu.edu</span><input name="imguri" type="text" size="50" value="/images/" /></td></tr>
</table>
<input type="Submit" />
</form>

<form id="removalFrm" method="post" action="missionimage.php">
<input type="hidden" name="removeRow" />
</form>

</body>
</html>