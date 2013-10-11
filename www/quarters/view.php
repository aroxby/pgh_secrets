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
<style>
.centered
{
	display: block;
	margin: auto;
	text-align: center;
}
</style>
</head>
<body>

<div class="centered">
<h2>Last Check-in: (37.785834, -122.406417)</h2>
<img id="mapImage" src="http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=600x600&maptype=roadmap&sensor=false&center=37.785834,-122.406417&markers=color:red%7C37.785834,-122.406417" />
</div>

</body>
</html>