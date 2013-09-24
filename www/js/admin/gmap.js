var map;
var marker;

function initialize(lat,lng) 
{
	//Create a google latlng object		
	var latlng = new google.maps.LatLng(lat,lng);

	//Declare the initial map options
	var opts = {
	  zoom: 11,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  scrollwheel: false,
	  disableDefaultUI:false
	};

	//Declare the google map with the options provided
	map = new google.maps.Map(document.getElementById("map"),opts);

	//Create a marker and add to the map at the point specified
	addMarker(latlng);

	google.maps.event.addListener(map, 'click', function(event) {
		
		removeMarker();
		
		addMarker(event.latLng);
		
		$('INPUT[name="latitude"]').val(event.latLng.lat());
		$('INPUT[name="longitude"]').val(event.latLng.lng());
		
	});
}

function removeMarker()
{
	marker.setMap(null);
}

function addMarker(latlng)
{
	marker = new google.maps.Marker({
		position: latlng,
		map: map
	});
}