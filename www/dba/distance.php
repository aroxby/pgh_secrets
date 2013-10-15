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
<title>Distance - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="/scripts/sha256.js"></script>
<script type="text/javascript">
function updateDist()
{
	var degrad = Math.PI/180;
	var lat1 = document.getElementById("lat1").value*degrad;
	var lon1 = document.getElementById("lon1").value*degrad;
	var lat2 = document.getElementById("lat2").value*degrad;
	var lon2 = document.getElementById("lon2").value*degrad;
	var dist = Math.acos(Math.sin(lat1)*Math.sin(lat2)+Math.cos(lat1)*Math.cos(lat2)*Math.cos(lon2-lon1))*6371000;
	document.getElementById("dist").value = dist;
}

function checkUpdate(e)
{
	if(e && e.keyCode == 13)
	{
		updateDist();
	}
}
</script>
</head>
<body>

<form id="distanceFrm" onKeyPress="checkUpdate(event)">
<table>
<tr><th></th><th>Latitude</th><th>Logitude</th></tr>
<tr><td>Point 1</td><td><input id="lat1" type="text" size="20" /></td><td><input id="lon1" type="text" size="20" /></td></tr>
<tr><td>Point 2</td><td><input id="lat2" type="text" size="20" /></td><td><input id="lon2" type="text" size="20" /></td></tr>
<tr><td>Distance</td><td colspan="3"><input id="dist" readonly="readonly" type="text" size="30" />&nbsp;meters</td><tr>
</table>
<input type="button" value="Submit" onClick="updateDist()" />
</form>

</body>
</html>