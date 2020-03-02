<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<link rel="stylesheet" href="{{ asset('css/google-maps-index_id.css') }}"
	type="text/css" media="all" />
</head>
<body>
	<div id="map"></div>
	<script>
      function initMap() {
        var location = {lat: {{$storeInfo->store_lat}}, lng: {{$storeInfo->store_lon}}};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: location
        });

        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h2 id="firstHeading" class="firstHeading">{{$storeInfo->store_title}}</h2>'+
            '<div id="bodyContent">'+
            '<p>{{$storeInfo->store_description}}</p>'+
            '<p><b>{{$storeInfo->store_city}}</b></p>'+
            '<p><b>{{$storeInfo->store_phone}}</b></p>'+
            '<p><b>{{$storeInfo->store_email}}</b></p>'+
            '<p><a href="/../store/{{$storeInfo->id}}"  target="_blank">Go to {{$storeInfo->store_title}}</a></p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
        });

        var marker = new google.maps.Marker({
          position: location,
          map: map,
          title: '{{$storeInfo->store_title}}'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
    </script>
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key={{$apiKeyAndCountry->google_api_keys}}&callback=initMap">
    </script>
</body>
</html>