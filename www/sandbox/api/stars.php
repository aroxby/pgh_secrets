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
<title>API - Completed</title>
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
function doSubmit()
{
	document.getElementById('userForm').action = document.getElementById('actionInput').value;

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

function checkSubmit(e)
{
	if(e && e.keyCode == 13)
	{
		doSubmit();
	}
}

nextID = 2;
</script>
</head>

<body>
<form id="userForm" method="post" action="/secrets/stars.php" onKeyPress="checkSubmit(event)" target="_blank">
<div id="dataTableMaster">
<table class="bordered"><tr><td>Action</td><td><input type="text" size="30" value="/secrets/stars.php" id="actionInput" /></td></tr></table>
<div id="dataTable0">
<table class="bordered"><tr><td>Name</td><td><input type="text" id="name0" size="30" value="userID"/ ></td><td>Value</td><td><input id="value0" type="text" size="30" onfocus="checkCreate(0)" value="3"/ ></td></tr></table>
</div>
<div id="dataTable1">
<table class="subbordered"><tr><td>Name</td><td><input type="text" id="name1" size="30" value="type" / ></td><td>Value</td><td><input id="value1" type="text" size="30" onfocus="checkCreate(1)" value="Art & Culture" / ></td></tr></table>
</div>
<div id="dataTable2">
<table class="subbordered"><tr><td>Name</td><td><input type="text" id="name2" size="30" value="" / ></td><td>Value</td><td><input id="value2" type="text" size="30" onfocus="checkCreate(2)" value="" / ></td></tr></table>
</div>
<div id="dataTable3"></div>
</div>
<input type="button" class="leftAlign" value="Submit" onClick="doSubmit()" />
</form>

</body>
</html>