@extends('layouts.app') @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
       @include('includes.navbar')
		<br>
		 @include('includes.error')
         @include('includes.success')
		<script>
        var map;
        var InforObj = [];
        var centerCords = {
            lat: {{$geoDataofMultiStore->latitude}},
            lng: {{$geoDataofMultiStore->longitude}}
        };
        var markersOnMap = [
        	@foreach($storeInfo as $item)
            {                
                placeName: "{{$item['store_title']}}",
                LatLng: [{
                    lat: {{$item['store_lat']}},
                    lng: {{$item['store_lon']}}
                }]
            },
            @endforeach
        ];
 
        window.onload = function () {
            initMap();
        };
        var storeInfo = [
        	@foreach($storeInfo as $item)
        	{ 
        	  id : '{{$item['id']}}',
        	  title : '{{$item['store_title']}}',
        	  description : '{{$item['store_description']}}',
        	  city : '{{$item['store_city']}}',
        	  phone : '{{$item['store_phone']}}',
        	  email : '{{$item['store_email']}}'
        	},
        	@endforeach
        ];    
        function addMarkerInfo() {

        	for (var i = 0; i < markersOnMap.length; i++) {

                var contentString = '<div id="content"><h1>' + markersOnMap[i].placeName +
                    '</h1><p>' + storeInfo[i].description +'</p>' + 
                    '<p><b>' + storeInfo[i].city +'</b></p>' +
                    '<p><b>' + storeInfo[i].phone +'</b></p>' +
                    '<p><b>' + storeInfo[i].email +'</b></p>' +
                    '<p><a href="/../store/' + storeInfo[i].id + '"  target="_blank">Go to ' + storeInfo[i].title + '</a></p>'+
                    '</div>';
                    
                
                const marker = new google.maps.Marker({
                    position: markersOnMap[i].LatLng[0],
                    map: map
                });
 
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200
                });
 
                marker.addListener('click', function () {
                    closeOtherInfo();
                    infowindow.open(marker.get('map'), marker);
                    InforObj[0] = infowindow;
                });

        	}  
        }
 
        function closeOtherInfo() {
            if (InforObj.length > 0) {
                /* detach the info-window from the marker ... undocumented in the API docs */
                InforObj[0].set("marker", null);
                /* and close it */
                InforObj[0].close();
                /* blank the array */
                InforObj.length = 0;
            }
        }
 
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: centerCords
            });
            addMarkerInfo();
        }
    </script>



		<div id="map"></div>

		</script>
		<script
			src="https://maps.googleapis.com/maps/api/js?key={{$apiKeyAndCountry->google_api_keys}}&libraries=places&callback=initMap"
			async defer></script>

</div>
@endsection
