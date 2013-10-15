function initialize()
{
	var container = document.createElement("div");
	var canvas = document.createElement("div");
	container.appendChild(canvas);
	document.body.insertBefore(container, document.getElementById("errorText")||document.getElementById("dataTable"));
	
	container.style.cssText = "position:fixed;left:50%;top:0;height:100%;width:50%";
	canvas.style.cssText = "height:100%;width:100%";

	var center = new google.maps.LatLng(40.432691, -79.964586);

	var mapOptions =
	{
		center: center,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		tilt: 0
	};
	theMap = new google.maps.Map(canvas, mapOptions);
	
	var markerOptions = 
	{
		map: theMap,
		position: center
	};
	theMarker = new google.maps.Marker(markerOptions);
}

function centerMap(lat, lng)
{
	var center = new google.maps.LatLng(lat, lng);
	theMap.setCenter(center);
	theMarker.setPosition(center);
	theMap.setZoom(18);
}
google.maps.event.addDomListener(window, 'load', initialize);