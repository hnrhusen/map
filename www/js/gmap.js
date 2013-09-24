var map;

function initialize() 
{
	//Set the url for discovery of the current default place
	var url = '/index.php/json/place';
	
	//Carry out ajax get to get the current default place, either the place last selected by the user
	//or the default place	
	$.get(url,function(data){
		if (data)
		{	
			//Create a google latlng object		
			var latlng = new google.maps.LatLng(data.latitude,data.longitude);
			
			//Call the function to render the map using this latlng as the center of the viewport
			render(latlng);
		}
	},'json');

}

function render(latlng) 
{		
	//Declare the initial map options
	var opts = {
	  zoom: 11,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  scrollwheel: false,
	  disableDefaultUI:true
	};

	//Declare the google map with the options provided
	map = new google.maps.Map(document.getElementById("map"),opts);

	//Add an event listener to occur when the map has finished loading and is idle
	google.maps.event.addListener(map, 'idle', function() {
		
		//Set the url to post this ajax call to
		var url = '/index.php/json/points';
		
		//Set the post variables to include the bounds of the current viewport and the CSRF token 
		//to ensure that Codeigniter doesn't throw 500 errors on breaking its CSRF protection
		var post = {
			'swlat':map.getBounds().getSouthWest().lat(),
			'swlng':map.getBounds().getSouthWest().lng(),
			'nelat':map.getBounds().getNorthEast().lat(),
			'nelng':map.getBounds().getNorthEast().lng(),
			'ci_csrf_token':$.cookie('ci_csrf_token')
		}
		
		//Carry out the post returning a json object													
		$.post(url,post,function(data)
		{	
			//If there is data
			if (data)
			{	
				//Create a markers array for marker clusterer
				var markers = [];
				
				//Iterate through the point collection in the json object that returned			
				for(i = 0;i < data.points.length;i++)
				{
					//Create a google maps latitude and longitude from the point collection
					var point = new google.maps.LatLng(data.points[i].latitude,data.points[i].longitude);
				
					//Create a marker and add to the map at the point specified
					var marker = new google.maps.Marker({
						position: point, 
						title: data.points[i].name
					}); 		
					
					//Push the created marker into an array
					markers.push(marker);
					
					//Call a function to create an info window displayed when the marker is clicked
					createInfoWindow(marker,data.points[i].description);			
				}
				
				//Create the marker clusterer
				var clusterer = new MarkerClusterer(map,markers);				
			}
		},'json');
		
	});	
	
	function createInfoWindow(marker,description)
	{
		//Create the info window with the passed description content
		var info = new google.maps.InfoWindow({
			content:description	
		});
		
		//Add an event listener to listen for the marker being clicked, which then opens the info window
		google.maps.event.addListener(marker, 'click', function() {
			info.open(map,marker);
		});				
				
	}
}

function zoomInMap()
{	
	//If the map is less than the maximum zoom in level
	if (map.getZoom() < 18)
	{
		//Increase the map zoom level by 1
		map.setZoom(map.getZoom() + 1);
	}
}

function zoomOutMap()
{
	//If the map is greater than the maximum zoom out level
	if (map.getZoom() > 0)
	{
		//Decrease the map zoom level by 1
		map.setZoom(map.getZoom() - 1);
	}
}

function setMapType($type)
{
	//Based on the map type selected change the map type of the map to the selected constant
	switch($type.toLowerCase())
	{
		case 'hybrid':
			map.setMapTypeId(google.maps.MapTypeId.HYBRID);	
			break;
		case 'roadmap':
			map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
			break;
		case 'satellite':
			map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
			break;
		case 'terrain':
			map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
			break;
	}
}
