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
<title>Login - Pittsburgh Challenge Database</title>
<link rel="stylesheet" type="text/css" href="dba.css">
<script type="text/javascript" src="/scripts/sha256.js"></script>
<script type="text/javascript">
function refreshPage()
{
	location.reload();
}

function hashSubmit()
{
	var field = document.getElementsByName("old_passwd")[0];
	document.getElementsByName("passwd")[0].value = SHA256(field.value);
	field.value = "";
	document.getElementById("loginForm").submit();
}

function checkSubmit(e)
{
	if(e && e.keyCode == 13)
	{
		hashSubmit();
	}
}
</script>
</head>
<body>

<?php
if($_POST['passwd']!='')
{
	$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
	if(mysqli_connect_errno())
	{
		echo "<h3>Database error. Try again later.</h3>\n</body></html>";
		Die();
	}

	$stmt = $db->prepare("select null from user where userName = ? and password = ? limit 1");
	$stmt->bind_param( 'ss', $_POST['uname'], $pass );
	$pass = pack("H*" , $_POST['passwd']);
	$stmt->execute();
	if($stmt->fetch()===TRUE) echo "<div class=\"successText\">Login Successful!</div>\n";
	else echo "<div class=\"errortext\">Username or password incorrect!</div>\n";
	$stmt->close();
	
	$db->close();
	
	echo "<hr/>";
}
?>

<form id="loginForm" method="post" action="login.php" onKeyPress="checkSubmit(event)">
<table>
<tr><td>User Name</td><td><input name="uname" type="text" size="50"/ ></td></tr>
<tr><td>Password</td><td><input name="old_passwd" type="password" size="50" /></td></tr>
</table>
<input type="button" value="Submit" onClick="hashSubmit()" />
<input type="hidden" name="passwd" />
</form>

</body>
</html>