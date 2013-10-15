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
<title>Crypto - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="/scripts/sha256.js"></script>
<script type="text/javascript">
function updateHash()
{
	var field = document.getElementsByName("passwd")[0];
	document.getElementsByName("hash")[0].value = SHA256(field.value);
	//field.value = "";
	//document.getElementById("userCreateForm").submit();
}

function checkUpdate(e)
{
	if(e && e.keyCode == 13)
	{
		updateHash();
	}
}
</script>
</head>
<body>

<form id="userCreateForm" method="post" action="user.php" onKeyPress="checkUpdate(event)">
<table>
<tr><td>Password</td><td><input name="passwd" type="text" size="64" /></td></tr>
<tr><td>Hash</td><td><input name="hash" readonly="readonly" type="text" size="64" /></td></tr>
</table>
<input type="button" value="Submit" onClick="updateHash()" />
</form>

</body>
</html>