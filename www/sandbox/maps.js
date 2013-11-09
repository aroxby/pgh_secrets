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
	var container = document.createElement('div');
	var canvas = document.createElement('div');
	var body = document.body;
	container.appendChild(canvas);
	body.insertBefore(container, body.firstChild);
	
	container.style.cssText = 'position:fixed;right:0;top:0;height:100%;width:50%';
	canvas.style.cssText = 'height:100%;width:100%';

	var center = new google.maps.LatLng(40.432691, -79.964586);

	var mapOptions =
	{
		center: center,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		tilt: 0
	};
	var map = new google.maps.Map(canvas, mapOptions);
	
	map.centerOn = function(lat, lng)
	{
		var center = new google.maps.LatLng(lat, lng);
		map.setCenter(center);
	}
	
	initialize.callback(map);
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
