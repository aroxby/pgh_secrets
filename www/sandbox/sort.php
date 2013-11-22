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
<script type="text/javascript">
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

$stmt = $db->prepare("select id, sortOrder, name, type, tags, photo from mission order by sortOrder");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>Sort Order</th><th>ID</th><th>Name</th><th>Type</th><th>Tags</th><th>Photo Mission</th>";
echo "</tr>\n";

$stmt->execute();
$stmt->bind_result($id, $order, $name, $type, $tags, $photo);

$map = array();

while($stmt->fetch())
{
	$map[] = $id;

	echo "<tr>".
	"<td>$order</td><td>$id</td><td>$name</td><td>$type</td><td>$tags</td>";
	
	if(is_numeric($photo) && $photo>0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	
	echo "</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();

$GLOBALS['map'] = $map;
$GLOBALS['height'] = count($map);

function getMapString()
{
	$map = $GLOBALS['map'];
	
	$str = "";
	$str = $map[0];
	for($i=1;$i<count($map);$i++)
	{
		$str = $str.','.$map[$i];
	}
	return $str;
}
?>

<hr/>

<script type="text/javascript">
function generateSQL()
{
	var input = document.getElementById('sort').value;
	while(input.search(",,")>0)
	{
		input = input.replace(",,", ",");
	}
	var values = input.split(',');
	
	var str = '';
	for(var i = 0; i<values.length; i++)
	{
		str = str + 'Update mission set sortOrder='+i+' where id='+values[i]+';\n';
	}
	document.getElementById('sql').value = str;
}
</script>

<table style="width:500px;">
<tr><td>Sorting Order</td></tr>
<tr><td><textarea id="sort" rows="1" onkeyup="generateSQL()" style="width:98.5%"><? echo getMapString(); ?></textarea></td></tr>
<tr><td><input type="button" onclick="generateSQL()" value="&darr;&nbsp;&darr;&nbsp;&darr;&nbsp;&darr;&nbsp;" /></td></tr>
<tr><td><textarea id="sql" rows="<? echo $GLOBALS['height']+1; ?>" style="width:98.5%"></textarea></td></tr>
</table>

<script type="text/javascript">
generateSQL();
</script>

</body>
</html>