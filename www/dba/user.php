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
<title>User - Pittsburgh Challenge Database</title>
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

function hashSubmit()
{
	var field = document.getElementsByName("old_passwd")[0];
	document.getElementsByName("passwd")[0].value = SHA256(field.value);
	field.value = "";
	document.getElementById("userCreateForm").submit();
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
$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
$table = "user";
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

if($_POST['passwd']!='')
{
	$stmt = $db->prepare("insert into $table(userName, firstName, lastName, email, password) values (?, ?, ?, ?, ?)");
	$stmt->bind_param( 'ssssi', $_POST['uname'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['passwd'] );
	$stmt->execute();
	if($stmt->affected_rows<=0) echo "<div class=\"errortext\">Error inserting rows: ".htmlspecialchars($db->error)."</div>\n";
	$stmt->close();
}

$stmt = $db->prepare("select id, userName, firstName, lastName, email, registered, confirmLink, confirmedEmail, hex(password) from $table");

echo "<input class=\"refreshBtn\" type=\"button\" value=\"Reload\" onclick=\"refreshPage()\" />\n";
echo "<table id=\"dataTable\">\n";
echo "<tr><th>ID</th><th>User Name</th><th>First Name</th><th>Last Name</th><th>E-Mail Address</th><th>Registered On</th/th><th>Confirmation Link</th><th>Confirmed E-Mail</th><th>Password Hash</th>";
echo "<td></td></tr>\n";

$stmt->execute();
$stmt->bind_result($id, $uname, $fname, $lname, $email, $registered, $confirmLink, $confirmed, $passwd);

while($stmt->fetch())
{
	echo "<tr>".
	"<td>$id</td><td>$uname</td><td>$fname</td><td>$lname</td><td>$email</td><td>$registered</td><td>$confirmLink</td>";
	if(is_numeric($confirmed) && $confirmed>0) echo "<td><input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\"/></td>";
	else echo "<td><input type=\"checkbox\" disabled=\"disabled\" /></td>";
	echo"<td>$passwd</td>".
	"<td><a class=\"deletetext\" href=\"javascript:void(0)\" onclick=\"removeRow($id)\">X</a></td>".
	"</tr>\n";
}
echo "</table>\n";

$stmt->close();
$db->close();
?>

<hr/>

<form id="userCreateForm" method="post" action="user.php" onKeyPress="checkSubmit(event)">
<table>
<tr><td>User Name</td><td><input name="uname" type="text" size="50"/ ></td></tr>
<tr><td>First Name</td><td><input name="fname" type="text" size="50"/ ></td></tr>
<tr><td>Last Name</td><td><input name="lname" type="text" size="50"/ ></td></tr>
<tr><td>E-Mail Address</td><td><input name="email" type="text" size="50" /></td></tr>
<tr><td>Password</td><td><input name="old_passwd" type="password" size="50" /></td></tr>
</table>
<input type="button" value="Submit" onClick="hashSubmit()" />
<input type="hidden" name="passwd" />
</form>

<form id="removalFrm" method="post" action="user.php">
<input type="hidden" name="removeRow" />
</form>

</body>
</html>