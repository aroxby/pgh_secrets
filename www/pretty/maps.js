function loadScript(url)
{
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = url;
	document.head.appendChild(script);
}

function initialize()
{
	var canvas = document.createElement('div');
	canvas.style.cssText = 'height:100%;width:100%';
	document.getElementById('MapContainer').appendChild(canvas);

	var center = new google.maps.LatLng(40.432767560433206, -79.96478180125808);

	var mapOptions =
	{
		center: center,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		tilt: 0
	};
	var map = new google.maps.Map(canvas, mapOptions);
	
	var markerOptions = 
	{
		map: map,
		position: center,
		draggable: true
	};
	var marker = new google.maps.Marker(markerOptions);
	
	var circleOptions = 
	{
		map: map,
		center: center,
		radius: 100,
		fillColor: 'blue',
		fillOpacity: 0.5,
		strokeWeight: 0,
		clickable: false,
		editable: true
	};
	var circle = new google.maps.Circle(circleOptions);
	
	marker._onDrop = function(e){marker.onDrop(e);};
	google.maps.event.addListener(marker,'dragend',marker._onDrop);
	map._onClick = function(e){map.onClick(e);};
	google.maps.event.addListener(map,'click',map._onClick);
	circle._onChanged = function(){circle.onChanged();};
	google.maps.event.addListener(circle,'center_changed',circle._onChanged);
	google.maps.event.addListener(circle,'radius_changed',circle._onChanged);
	
	map.centerOn = function(lat, lng, radius)
	{
		var center = new google.maps.LatLng(lat, lng);
		map.setCenter(center);
		marker.setPosition(center);
		circle.setRadius(radius-0);
		circle.setCenter(center);
	}
	
	initialize.callback(map, marker, circle);
}

function initMaps()
{
	google.maps.event.addDomListener(window, 'load', initialize);
}

function createMap(callback)
{
	initialize.callback = callback;
	var url = 'https://maps.googleapis.com/maps/api/js?'+
		'key=AIzaSyBY1D4KC4Rs0dHqfab46Qi84BR3EisJ8xQ&'
		+'sensor=false&'
		+'callback=initMaps';
	loadScript(url);
}

createMap(function(map, marker, circle)
{
	zoomMap.map = map;
	
	marker.onDrop = function(e)
	{
		updateLatLng(e.latLng, false, true);
	};
	
	map.onClick = function(e)
	{
		updateLatLng(e.latLng, true, true);
	};
	
	circle.onChanged = function()
	{
		updateLatLng(circle.getCenter(), true, false);
	};
	
	updateLatLng.marker = saveLocaton.marker = marker;
	updateLatLng.circle = saveLocaton.circle = circle;
});

function zoomMap(lat, lng, radius)
{
	zoomMap.map.centerOn(lat, lng, radius);
}

function updateLatLng(ll, updateMaker, updateCircle, updateMap)
{
	var lat = ll.lat();
	var lng = ll.lng();
	var radius = updateLatLng.circle.getRadius();

	if(updateMaker) updateLatLng.marker.setPosition(ll);
	if(updateCircle)
	{
		var oldFn = updateLatLng.circle.onChanged;
		updateLatLng.circle.onChanged = function(){};
		updateLatLng.circle.setCenter(ll);
		updateLatLng.circle.onChanged = oldFn;
	}
}

function generateNextRowID()
{
	var id = generateNextRowID.baseString + generateNextRowID.nextID;
	generateNextRowID.nextID++
	return id;
}
generateNextRowID.baseString = 'mc_auto_';
generateNextRowID.nextID = 0;

function removeLocation(id)
{
	delete getLocationJSON.Obj[id];

	var node = document.getElementById(id);
	node.parentNode.removeChild(node);
}

function createTableRow(lat,lng,rad)
{
	var rowID = generateNextRowID();

	var zoomAction = 'zoomMap('+lat+','+lng+','+rad+')';
	var suffixAction = 'removeLocation(\''+rowID+'\')';
	var prefix = '<th><a href="javascript:void(0)" onclick="'+zoomAction+'"><img src="Magnify.gif" /><a/></th>'
	var suffix = '<th><a class="deleteText" href="javascript:void(0)"  onclick="'+suffixAction+'">X</a></th>';
	var row = document.createElement('tr');
	
	row.innerHTML = prefix+'<th>'+lat+'</th><th>'+lng+'</th><th>'+rad+'</th>'+suffix;
	row.id = rowID;
	
	return row;
}

function saveLocaton()
{
	var lat = saveLocaton.marker.getPosition().lat();
	var lng = saveLocaton.marker.getPosition().lng();
	var rad = saveLocaton.circle.getRadius();
	var row = createTableRow(lat,lng,rad);
	var table = document.getElementById('LocationTable');
	table.appendChild(row);
	
	getLocationJSON.Obj[row.id] = {
		latitude: lat,
		longitude: lng,
		radius: rad
	};
}

function getLocationJSON()
{
	var newObj = [];
	for(i in getLocationJSON.Obj)
	{
		newObj.push(getLocationJSON.Obj[i]);
	}
	return JSON.stringify(newObj);
}
getLocationJSON.Obj = {};