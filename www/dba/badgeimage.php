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
<title>BadgeImage - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="/scripts/sha256.js"></script>
<script type="text/javascript">
function removeRow(mid, bn)
{
	document.getElementsByName("removeMID")[0].value = mid;
	document.getElementsByName("removeBN")[0].value = bn;
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
$table = "badgeImage";
if(mysqli_connect_errno())
{
	echo "<h3>Database error. Try again later.</h3>\n</body></html>";
	Die();
}

if(is_numeric($_POST['removeBN']))
{
	$stmt = $db->prepare("delete from $table where missionID = ? and badgeNumber = ?");
	$stmt->bind_param('ii', $_POST['removeMID'], $_POST['removeBN']);
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error removing rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

if($_POST['imguri']!='')
{
	$stmt = $db->prepare("insert into $table(missionID, badgeNumber, imageURI) values (?, ?, ?)");
	$stmt->bind_param( 'iis', $_POST['mid'], $_POST['badgeNum'], $_POST['imguri'] );
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select missionID, badgeNumber, imageURI from $table");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>Mission ID</th><th>Badge Number</th><th>Image URI</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($mid, $badgeNum, $imguri);

while($stmt->fetch())
{
	echo "<tr>".
	"<td>$mid</td><td>$badgeNum</td>".
	"<td><a href=\"$imguri\" target=\"_blank\">$imguri</a></td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($mid, $badgeNum)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form method="post" action="badgeimage.php">
<table>
<tr><td>Mission ID</td><td><input name="mid" type="text" size="50"/ ></td></tr>
<tr><td>Badge Number</td><td><input name="badgeNum" type="text" size="50"/ ></td></tr>
<tr><td>Image URI</td><td><input name="imguri" type="text" size="50" /></td></tr>
</table>
<input type="Submit" />
</form>

<form id="removalFrm" method="post" action="badgeimage.php">
<input type="hidden" name="removeMID" />
<input type="hidden" name="removeBN" />
</form>

</body>
</html>