<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" value="{{ csrf_token() }}">
	<title>TenantWire</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="{{ asset('js/charts.js') }}"></script>

</head>
<body>

	@yield('content')

	<div id="map"></div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/calculateAjax.js') }}"></script>
<script>

	$(document).ready(function () {
		
		$('#submit-user-info-btn').click(function() {
			$('#user-info-modal').hide();
		});

		var counter = 0;
		$('#add-freq-loc-input').click(function() {
			counter++;
			$('#input-group-'+counter+'').show();
			if(counter == 3) {
				$('#add-freq-loc-input').attr('disabled', 'disabled');
			}
		});

		$('.input-group-addon').click(function() {
				counter--;
				$('#add-freq-loc-input').removeAttr('disabled', 'disabled');
		});

	});

	// initialize GMAP function

	var panorama;
	var map;
	var marker;

    function initialize() {
    	var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
    // Create an array of styles.
	  var styles = [
	    {
	      stylers: [
	        { hue: "#183050" },
	        { saturation: -20 }
	      ]
	    },{
	      featureType: "road",
	      elementType: "geometry",
	      stylers: [
	        { lightness: 100 },
	        { visibility: "simplified" }
	      ]
	    },{
	      featureType: "road",
	      elementType: "labels",
	      stylers: [
	        { visibility: "off" }
	      ]
	    }
	  ];

	  // Create a new StyledMapType object, passing it the array of styles,
	  // as well as the name to be displayed on the map type control.
	  var styledMap = new google.maps.StyledMapType(styles,
	    {name: "Styled Map"});

	  var mapOptions = {
	    center: {lat:40.72, lng: -73.978},
	    zoom: 13,
	    scrollwheel: true,
	    mapTypeControl: false,
	    mapTypeControlOptions: {
	      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
	    }
	  };
	  
	  map = new google.maps.Map(document.getElementById('map'), mapOptions);

	  map.mapTypes.set('map_style', styledMap);
  	  map.setMapTypeId('map_style');

  	  directionsDisplay.setMap(map);

	  var workplaceInput = document.getElementById('workplace-search-input');
	  var freqLocInput1 = document.getElementById('freq-loc-input-1');
	  var freqLocInput2 = document.getElementById('freq-loc-input-2');
	  var freqLocInput3 = document.getElementById('freq-loc-input-3');

	  var workplaceCoordsInput = document.getElementById('workplace-coords-input');
	  var freqLocCoordsInput1 = document.getElementById('freq-loc-coords-input-1');
	  var freqLocCoordsInput2 = document.getElementById('freq-loc-coords-input-2');
	  var freqLocCoordsInput3 = document.getElementById('freq-loc-coords-input-3');

	  // Create the autocomplete helper, and associate it with
	  // an HTML text input box.
	  var autocompleteWorkplace = new google.maps.places.Autocomplete(workplaceInput);
	  var autocompleteFreqLoc1 = new google.maps.places.Autocomplete(freqLocInput1);
	  var autocompleteFreqLoc2 = new google.maps.places.Autocomplete(freqLocInput2);
	  var autocompleteFreqLoc3 = new google.maps.places.Autocomplete(freqLocInput3);

	  autocompleteWorkplace.bindTo('bounds', map);
	  autocompleteFreqLoc1.bindTo('bounds', map);
	  autocompleteFreqLoc2.bindTo('bounds', map);
	  autocompleteFreqLoc3.bindTo('bounds', map);

	google.maps.event.addListener(autocompleteWorkplace, 'place_changed', function() {
		var workplaceCoordinates = autocompleteWorkplace.getPlace();
		var wpLat = workplaceCoordinates.geometry.location.lat();
		var wpLng = workplaceCoordinates.geometry.location.lng();
		// console.log(''+wpLat+', '+wpLng+'');
		workplaceCoordsInput.value = wpLat+', '+wpLng;
		console.log(workplaceCoordsInput.value);
	});
	google.maps.event.addListener(autocompleteFreqLoc1, 'place_changed', function() {
		var freqLoc1Coordinates = autocompleteFreqLoc1.getPlace();
		var freqLoc1Lat = freqLoc1Coordinates.geometry.location.lat();
		var freqLoc1Lng = freqLoc1Coordinates.geometry.location.lng();
		// console.log(''+freqLoc1Lat+', '+freqLoc1Lng+'');
		freqLocCoordsInput1.value = freqLoc1Lat+', '+freqLoc1Lng;
		console.log(freqLocCoordsInput1.value);
	});
	google.maps.event.addListener(autocompleteFreqLoc2, 'place_changed', function() {
		var freqLoc2Coordinates = autocompleteFreqLoc2.getPlace();
		var freqLoc2Lat = freqLoc2Coordinates.geometry.location.lat();
		var freqLoc2Lng = freqLoc2Coordinates.geometry.location.lng();
		// console.log(''+freqLoc2Lat+', '+freqLoc2Lng+'');
		freqLocCoordsInput2.value = freqLoc2Lat+', '+freqLoc2Lng;
		console.log(freqLocCoordsInput2.value);
	});
	google.maps.event.addListener(autocompleteFreqLoc3, 'place_changed', function() {
		var freqLoc3Coordinates = autocompleteFreqLoc3.getPlace();
		var freqLoc3Lat = freqLoc3Coordinates.geometry.location.lat();
		var freqLoc3Lng = freqLoc3Coordinates.geometry.location.lng();
		// console.log(''+freqLoc3Lat+', '+freqLoc3Lng+'');
		freqLocCoordsInput3.value = freqLoc3Lat+', '+freqLoc3Lng;
		console.log(freqLocCoordsInput3.value);
	});


	@if(Route::currentRouteName() == 'dovetail')

	var home = new google.maps.LatLng(40.712551,-74.00435);
	var service = new google.maps.DistanceMatrixService();
	
		var infowindow = new google.maps.InfoWindow();
		  marker = new google.maps.Marker({
		    map: map
		  });
		  google.maps.event.addListener(marker, 'click', function() {
		    infowindow.open(map, marker);
		  });
	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA
	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA
	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA

		var workplaces = [
		    @foreach ($workplace as $wp)
		        [ {{ $wp->lat }}, {{ $wp->lng }}, "{{ $wp->title }}", "{{ $wp->address }}", "{{ $wp->city }}", "{{ $wp->state }}" ]    
		    @endforeach
	    ];

		var frequentedLocations = [
		    @foreach ($frequented_locations as $fl)
		        [ {{ $fl->lat }}, {{ $fl->lng }}, "{{ $fl->title }}", "{{ $fl->address }}", "{{ $fl->city }}", "{{ $fl->state }}" ], 
		    @endforeach
	    ];

	    var work = new google.maps.LatLng(workplaces[0][0], workplaces[0][1]);
	
	    var workplace;

	    for (i = 0; i < workplaces.length; i++) {

	        workplace = new google.maps.LatLng(workplaces[i][0], workplaces[i][1]);

			// console.log(workplace);
	        var marker = new google.maps.Marker({
	            position: workplace,
	            map: map,
	        });

	        marker.setVisible(true); 

	        // infowindow.setContent('<div>'+workplaces[i][2]+'<br>'+workplaces[i][3]+', '+workplaces[i][4]+', '+workplaces[i][5]+'</div>');
	        // infowindow.open(map, marker);

	    }

	    var freqLocArray = new Array();
	    var freqLoc;

	    for (i = 0; i < frequentedLocations.length; i++) {

	    	freqLoc = new google.maps.LatLng(frequentedLocations[i][0], frequentedLocations[i][1]);

	        freqLocArray.push(freqLoc);

			// console.log(workplace);
	        var marker = new google.maps.Marker({
	            position: freqLoc,
	            map: map,
	        });

	        marker.setVisible(true); 

	        // infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
	        // infowindow.open(map, marker);
	    
	        
	    }

	    var pathOne;
	    var pathTwo;
	    var pathThree;

	    freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
	    freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());

		service= new google.maps.DistanceMatrixService();

		    service.getDistanceMatrix(
			{
			origins: [home],
			destinations: [freq_loc_1, freq_loc_2, freq_loc_3],
			travelMode: google.maps.TravelMode.TRANSIT,
			}, callback);
		
			function callback(response, status) {
				console.log(response);
				console.log(status);
				calcRouteOne();
				calcRouteTwo();
				calcRouteThree();
				calcRouteWork();
			}

			function calcRouteOne() {
					var start = home;
					var end = freq_loc_1;
					var request = {
					origin:start,
					destination:end,
					travelMode: google.maps.TravelMode.TRANSIT
					};
					directionsService.route(request, function(result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  directionsDisplay.setDirections(result);

					   console.log(result);

						console.log(result.routes[0].legs[0].steps);
						// console.log(result.routes[0].legs[0].steps[0].start_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].start_point.lng());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lng());

					   var pathCoords = [
					    {lat: result.routes[0].legs[0].steps[0].start_point.lat(), lng: result.routes[0].legs[0].steps[0].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[0].end_point.lat(), lng: result.routes[0].legs[0].steps[0].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].start_point.lat(), lng: result.routes[0].legs[0].steps[1].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].end_point.lat(), lng: result.routes[0].legs[0].steps[1].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].start_point.lat(), lng: result.routes[0].legs[0].steps[2].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].end_point.lat(), lng: result.routes[0].legs[0].steps[2].end_point.lng()},
					  ];
					  pathOne = new google.maps.Polyline({
					    path: pathCoords,
					    geodesic: true,
					    strokeColor: 'red',
					    strokeOpacity: 1.0,
					    strokeWeight: 4
					  });
  					 pathOne.setMap(map);
					}
				});
			}

			function calcRouteTwo() {
					var start = home;
					var end = freq_loc_2;
					var request = {
					origin:start,
					destination:end,
					travelMode: google.maps.TravelMode.TRANSIT
					};
					directionsService.route(request, function(result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  directionsDisplay.setDirections(result);
					  console.log(result);

						console.log(result.routes[0].legs[0].steps);
						// console.log(result.routes[0].legs[0].steps[0].start_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].start_point.lng());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lng());

					   var pathCoords = [
					    {lat: result.routes[0].legs[0].steps[0].start_point.lat(), lng: result.routes[0].legs[0].steps[0].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[0].end_point.lat(), lng: result.routes[0].legs[0].steps[0].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].start_point.lat(), lng: result.routes[0].legs[0].steps[1].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].end_point.lat(), lng: result.routes[0].legs[0].steps[1].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].start_point.lat(), lng: result.routes[0].legs[0].steps[2].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].end_point.lat(), lng: result.routes[0].legs[0].steps[2].end_point.lng()},
					  ];
					  pathTwo = new google.maps.Polyline({
					    path: pathCoords,
					    geodesic: true,
					    strokeColor: 'red',
					    strokeOpacity: 1.0,
					    strokeWeight: 4
					  });
  					 pathTwo.setMap(map);
					}
				});
			}

			function calcRouteThree() {
					var start = home;
					var end = freq_loc_3;
					var request = {
					origin:start,
					destination:end,
					travelMode: google.maps.TravelMode.TRANSIT
					};
					directionsService.route(request, function(result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  directionsDisplay.setDirections(result);

					   console.log(result);

						console.log(result.routes[0].legs[0].steps);
						// console.log(result.routes[0].legs[0].steps[0].start_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].start_point.lng());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lat());
						// console.log(result.routes[0].legs[0].steps[0].end_point.lng());

					   var pathCoords = [
					    {lat: result.routes[0].legs[0].steps[0].start_point.lat(), lng: result.routes[0].legs[0].steps[0].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[0].end_point.lat(), lng: result.routes[0].legs[0].steps[0].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].start_point.lat(), lng: result.routes[0].legs[0].steps[1].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[1].end_point.lat(), lng: result.routes[0].legs[0].steps[1].end_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].start_point.lat(), lng: result.routes[0].legs[0].steps[2].start_point.lng()},
					    {lat: result.routes[0].legs[0].steps[2].end_point.lat(), lng: result.routes[0].legs[0].steps[2].end_point.lng()},
					  ];
					  pathThree = new google.maps.Polyline({
					    path: pathCoords,
					    geodesic: true,
					    strokeColor: 'red',
					    strokeOpacity: 1.0,
					    strokeWeight: 4
					  });
  					 pathThree.setMap(map);

					}
				});
			}

			function calcRouteWork() {
					var start = home;
					var end = workplace;
					var request = {
					origin:start,
					destination:end,
					travelMode: google.maps.TravelMode.TRANSIT
					};
					directionsService.route(request, function(result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  directionsDisplay.setDirections(result);

					 //   console.log(result);

						// console.log(result.routes[0].legs[0].steps);
						// // console.log(result.routes[0].legs[0].steps[0].start_point.lat());
						// // console.log(result.routes[0].legs[0].steps[0].start_point.lng());
						// // console.log(result.routes[0].legs[0].steps[0].end_point.lat());
						// // console.log(result.routes[0].legs[0].steps[0].end_point.lng());

					 //   var pathCoords = [
					 //    {lat: result.routes[0].legs[0].steps[0].start_point.lat(), lng: result.routes[0].legs[0].steps[0].start_point.lng()},
					 //    {lat: result.routes[0].legs[0].steps[0].end_point.lat(), lng: result.routes[0].legs[0].steps[0].end_point.lng()},
					 //    {lat: result.routes[0].legs[0].steps[1].start_point.lat(), lng: result.routes[0].legs[0].steps[1].start_point.lng()},
					 //    {lat: result.routes[0].legs[0].steps[1].end_point.lat(), lng: result.routes[0].legs[0].steps[1].end_point.lng()},
					 //    {lat: result.routes[0].legs[0].steps[2].start_point.lat(), lng: result.routes[0].legs[0].steps[2].start_point.lng()},
					 //    {lat: result.routes[0].legs[0].steps[2].end_point.lat(), lng: result.routes[0].legs[0].steps[2].end_point.lng()},
					 //  ];
					 //  pathThree = new google.maps.Polyline({
					 //    path: pathCoords,
					 //    geodesic: true,
					 //    strokeColor: 'red',
					 //    strokeOpacity: 1.0,
					 //    strokeWeight: 4
					 //  });
  				// 	 pathThree.setMap(map);

					}
				});
			}

	@endif
	
	

	}

	google.maps.event.addDomListener(document, 'load', initialize);

	</script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqOQUEpaayq3Z0N4u2wtCu-i1npOoJzM&callback=initialize&libraries=places">
    </script>

</body>
</html>
