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
<title>Boundary Test API</title>
<style>
.halfWidth
{
	width:50%;
}
#serverOutput
{
	white-space: normal;
	word-break:break-all;
	font-size:112.5%;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="maps.js"></script>
<script type="text/javascript">
createMap(function(map)
{
	updateMap.map = map;

	updateMap.shape = new google.maps.Polygon({
		strokeColor: 'blue',
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: 'blue',
		fillOpacity: 0.35
	});
	
	doPost();
});

function dump(x)
{
	var s = '';
	for(y in x)
	{
		s += '' + y + '->' + x[y] + '\n';
	}
	alert(s);
}

function isNumber(n)
{
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function doPost()
{
	var url = $('#inputFrm').attr('action');

	var mid = $('#missionInput').val();
	if(isNumber(mid)) postIt(url, mid);
	
	return false;
}

function postIt(url, mid)
{
	var posting = $.post(url, { missionID : mid});
	posting.done(function(responseText)
	{
		$('#serverOutput').text(responseText);
		var data = JSON.parse(responseText)[0];;
		if(data['OK']) updateMap(data);
	});
}

function getLatLng(dict)
{
	return new google.maps.LatLng(dict['lat'], dict['lng']);
}

function updateMap(shapeData)
{
	var vertices = [ ];
	for(indx in shapeData['vertices'])
	{
		vertices.push(getLatLng(shapeData['vertices'][indx]));
	}
	
	updateMap.shape.setPath(vertices);
	updateMap.shape.setMap(updateMap.map);
	updateMap.map.centerOn(shapeData['center']['lat'], shapeData['center']['lng']);
}

</script>
</head>
<body>

<form class="halfWidth" id="inputFrm" action="/secrets/missionboundarynew.php" method="post" onsubmit="return doPost()">
<label>MissionID</label><input type="text" id="missionInput" value="1" />
<input type="submit" />
</form>

<hr/>
<pre class="halfWidth" id="serverOutput">
</pre>

</body>
</html>