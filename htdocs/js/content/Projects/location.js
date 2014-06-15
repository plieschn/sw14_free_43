function initialize(centerLongitude, centerLatitude, initialZoom, mapUrl) {
    var initialCenter = new google.maps.LatLng(centerLatitude, centerLongitude);
    var mapOptions = {
	zoom: initialZoom,
	center: initialCenter
    }

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

    var layer = new google.maps.KmlLayer({
	url: mapUrl
    });
    
    layer.setMap(map);
}

