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
<title>Pittsburgh Challenge</title>
<script type="text/javascript">
function goView()
{
	document.open();
	waitExec(1250, navigateView);
}

function navigateView()
{
	location.href = "jump.php?lat=37.785834&lng=-122.406417";
}

function waitExec(timeout, func)
{
	setTimeout(function () { func(); }, timeout);
}

</script>
<style>
.centered
{
	display: block;
	margin: auto;
	text-align: center;
}
.bigText
{
	font-size: 15px;
}
</style>
</head>
<body>

<div class="centered">
<input type="button" class="bigText" value="Retrieve last check-in" onclick="goView()" />
</div>

</body>
</html>