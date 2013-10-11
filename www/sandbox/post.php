<?php
//no  cache headers 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<html>
<head>
<title>POST Test</title>
<style>
.bordered
{
	border: 1px solid black;
}
.subbordered
{
	border: 1px solid black;
	border-top: none;
}
.centered
{
	display: block;
	margin: auto;
	text-align: center;
}
</style>
<script type="text/javascript">
function refreshPage()
{
	location.reload();
}

function doSubmit()
{
	for(var i = 0; i<=nextID; i++)
	{
		document.getElementById('value'+i).name = document.getElementById('name'+i).value;
	}
	document.getElementById('userForm').submit();
}

function checkCreate(thisID)
{
	if(thisID==nextID)
	{
		nextID++;
		document.getElementById('dataTable'+nextID).innerHTML += '<table class="subbordered"><tr><td>Name</td><td><input type="text" id="name'+nextID+'" size="30"/ ></td><td>Value</td><td><input id="value'+nextID+'" type="text" size="30" onfocus="checkCreate('+nextID+')"/ ></td></tr></table>';
		var nextDiv = document.createElement("div")
		nextDiv.id = 'dataTable'+(nextID+1);
		document.getElementById('dataTableMaster').appendChild(nextDiv);
	}
}

function setAction(field)
{
	document.getElementById('userForm').action = field.value;
}

function checkSubmit(e)
{
	if(e && e.keyCode == 13)
	{
		doSubmit();
	}
}

function skipTo(n)
{
	while(nextID<n) checkCreate(nextID);
}

function populate()
{
<?php
	echo "\tskipTo(".count($_POST).");";
	$id = 0;

	foreach ($_POST as $name => $value)
	{
		echo "\tdocument.getElementById('name'+$id).value = '$name';\n";
		echo "\tdocument.getElementById('value'+$id).value = '$value';\n";
		$id++;
	}
?>
}

nextID = 0;
</script>
</head>
<?php
	echo "<body onload=\"populate()\">";
?>

<form id="userForm" method="post" action="post.php" onKeyPress="checkSubmit(event)" target="_blank">
<div id="dataTableMaster">
<table class="bordered"><tr><td>Action</td><td><input type="text" size="30" onblur="setAction(this)" / ></td></tr></table>
<div id="dataTable0">
<table class="bordered"><tr><td>Name</td><td><input type="text" id="name0" size="30"/ ></td><td>Value</td><td><input id="value0" type="text" size="30" onfocus="checkCreate(0)"/ ></td></tr></table>
</div>
<div id="dataTable1"></div>
</div>
<input type="button" class="leftAlign" value="Submit" onClick="doSubmit()" />
</form>
<input type="button" value="Refresh" onClick="refreshPage()" />

<hr/>
<pre>
<?php
	echo count($_POST)." elements\n";
	print_r($_POST);
?>
</pre>

</body>
</html>