//Include another javascript file
function loadScript(url)
{
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = url;
	document.head.appendChild(script);
}

//Initializes the map
function initialize()
{
	//Create HTML elements
	var canvas = document.createElement('div');
	canvas.style.cssText = 'height:100%;width:100%';
	document.getElementById('MapContainer').appendChild(canvas);

	//Centers map on the ETC
	var center = new google.maps.LatLng(40.432767560433206, -79.96478180125808);

	//Map defaults
	var mapOptions =
	{
		center: center,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		tilt: 0
	};
	var map = new google.maps.Map(canvas, mapOptions);
	
	//The type of marker we want
	var markerOptions = 
	{
		map: map,
		position: center,
		draggable: true
	};
	var marker = new google.maps.Marker(markerOptions);
	
	//The type of circle we want
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
	
	//Click/drag/drop handlers
	marker._onDrop = function(e){marker.onDrop(e);};
	google.maps.event.addListener(marker,'dragend',marker._onDrop);
	map._onClick = function(e){map.onClick(e);};
	google.maps.event.addListener(map,'click',map._onClick);
	circle._onChanged = function(){circle.onChanged();};
	google.maps.event.addListener(circle,'center_changed',circle._onChanged);
	google.maps.event.addListener(circle,'radius_changed',circle._onChanged);
	
	//map re-centering function
	map.centerOn = function(lat, lng, radius)
	{
		var center = new google.maps.LatLng(lat, lng);
		map.setCenter(center);
		marker.setPosition(center);
		circle.setRadius(radius-0);
		circle.setCenter(center);
	}
	
	//Tell the calling script we are done
	initialize.callback(map, marker, circle);
}

//Called by our script loader when Google Maps API is loaded
function initMaps()
{
	google.maps.event.addDomListener(window, 'load', initialize);
}

//Call this from your page when you want to start loading maps
//This happens asynchronously so specify a callback
function createMap(callback)
{
	initialize.callback = callback;
	var url = 'https://maps.googleapis.com/maps/api/js?'+
		'key=AIzaSyBY1D4KC4Rs0dHqfab46Qi84BR3EisJ8xQ&'
		+'sensor=false&'
		+'callback=initMaps';
	loadScript(url);
}

//Create the map for the mission creator
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

//Shows a location on the map
function zoomMap(lat, lng, radius)
{
	zoomMap.map.centerOn(lat, lng, radius);
}

//Updates the map and markers to a LatLng
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

//Generates a unique ID for locations in the mission creator
function generateNextRowID()
{
	var id = generateNextRowID.baseString + generateNextRowID.nextID;
	generateNextRowID.nextID++
	return id;
}
generateNextRowID.baseString = 'mc_auto_';
generateNextRowID.nextID = 0;

//Removes a location from the table
function removeLocation(id)
{
	delete getLocationJSON.Obj[id];

	var node = document.getElementById(id);
	node.parentNode.removeChild(node);
	
	node  = document.getElementById(id+'-name');
	node.parentNode.removeChild(node);
	
	node  = document.getElementById(id+'-label');
	node.parentNode.removeChild(node);
	
	node  = document.getElementById(id+'-break');
	node.parentNode.removeChild(node);
}

//Creates a new row in the location table for location name
function createTableNameRow(lat,lng,rad,rowID)
{
	var zoomAction = 'zoomMap('+lat+','+lng+','+rad+')';

	var prefix = '<th><a href="javascript:void(0)" onclick="'+zoomAction+'"><img src="Magnify.gif" /><a/>&nbsp;&nbsp;';

	var row = document.createElement('tr');
	row.innerHTML = prefix + 'Name:</th><th colspan="3"><input id="' + rowID + '-input' + '" size="45" type="text"/></th>';
	row.id = rowID+'-name';
	
	return row;
}

//Creates a new row in the location table for location label
function createTableLabelRow(rowID)
{
	var row = document.createElement('tr');
	row.innerHTML = '<tr><th>Latitude</th><th>Longitude</th><th colspan="2">Check-In Radius (meters)</th></tr>';
	row.id = rowID+'-label';
	
	return row;
}

//Creates a new row in the location table for location data
function createTableDataRow(lat,lng,rad,rowID)
{
	var removeAction = 'removeLocation(\''+rowID+'\')';
	var suffix = '<th><a class="deleteText" href="javascript:void(0)"  onclick="'+removeAction+'">X</a></th>';

	var row = document.createElement('tr');
	
	row.innerHTML = '<th>'+lat+'</th><th>'+lng+'</th><th colspan="1">'+rad+'</th>'+suffix;
	row.id = rowID;
	
	return row;
}

//Creates an empty table row (as a spacer or whatever)
function createTableEmptyRow(rowID)
{
	var row = document.createElement('tr');
	row.innerHTML='<td colspan="4"><hr/></td>';
	row.id = rowID+'-break';
	return row;
}

//Saves a location from the map to the table
function saveLocaton()
{
	var lat = saveLocaton.marker.getPosition().lat();
	var lng = saveLocaton.marker.getPosition().lng();
	var rad = saveLocaton.circle.getRadius();
	
	var rowID = generateNextRowID();
	
	var row = createTableDataRow(lat,lng,rad,rowID);
	var empty = createTableEmptyRow(rowID);
	var label = createTableLabelRow(rowID);
	var name = createTableNameRow(lat,lng,rad,rowID);
	
	var table = document.getElementById('LocationTable');
	table.appendChild(name);
	table.appendChild(label);
	table.appendChild(row);
	table.appendChild(empty);
	
	getLocationJSON.Obj[row.id] = {
		latitude: lat,
		longitude: lng,
		radius: rad
	};
}

//Creates a JSON object describing the location for final submision
function getLocationJSON()
{
	var newObj = [];
	var n = 0;
	for(i in getLocationJSON.Obj)
	{
		n++;
		var o = getLocationJSON.Obj[i];
		var name = document.getElementById(i+'-input').value;
		if(name=='')
		{
			alert('You must enter a name for location #'+n);
			return 0;
		}
		
		o.name = name;
		newObj.push(o);
	}
	return JSON.stringify(newObj);
}
getLocationJSON.Obj = {};
