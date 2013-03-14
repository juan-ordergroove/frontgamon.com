
<html>
<head>
<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA75yExUyA2Yj3zhLGYAaBmxQJsJA7Zu2adCr7nhYxGwuUkYpeYBS-C6nK4W9Esog_G2j2y6818HjX7Q">
</script>

<script type="text/javascript">
var geocoder = null;
var map = null;
var currentPoint = null;
google.load("maps", "2.x");
   
// Call this function when the page has been loaded
function initialize() {
		map = new google.maps.Map2(document.getElementById("map"));
		map.setUIToDefault();
		
		geocoder = new google.maps.ClientGeocoder();
}

function setPoint(point)
{
		if (!point) 
		{
				alert(address + " not found");
		} 
		else 
		{
				if (currentPoint)
				{
						map.clearOverlays();
				}
				
				currentPoint = point;
				map.setCenter(point, 13);
				var marker = new google.maps.Marker(point);
				map.addOverlay(marker);
				marker.openInfoWindowHtml(address);
		}
}

function showAddress(address)
{
		geocoder.getLatLng(address, setPoint);
}
google.setOnLoadCallback(initialize);
</script>
</head>
<body onunload="GUnload()">
		<form action="#" onsubmit="showAddress(this.address.value); return false">
		<p>
		<input type="text" size="60" name="address" value="" />
		<input type="submit" value="Go!" />
		</p>
		<div id="map" style="width: 500px; height: 300px"></div>
		</form>
		
</body>
</html>