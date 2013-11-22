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

	var center = new google.maps.LatLng(40.432691, -79.964586);

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
		map.setZoom(18);
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
	
	saveLocaton.marker = marker;
	saveLocaton.circle = circle;
});

function zoomMap(lat, lng, radius)
{
	zoomMap.map.centerOn(lat, lng, radius);
}

function createTableRow()
{
}

function saveLocaton()
{
	var lat = saveLocaton.marker.getPosition().lat();
	alert(lat);
	var rad = saveLocaton.circle.getRadius();
	alert(rad);
}
