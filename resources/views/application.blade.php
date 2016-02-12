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
			if(counter == 5) {
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
	  var freqLocInput4 = document.getElementById('freq-loc-input-4');
	  var freqLocInput5 = document.getElementById('freq-loc-input-5');

	  var workplaceCoordsInput = document.getElementById('workplace-coords-input');
	  var freqLocCoordsInput1 = document.getElementById('freq-loc-coords-input-1');
	  var freqLocCoordsInput2 = document.getElementById('freq-loc-coords-input-2');
	  var freqLocCoordsInput3 = document.getElementById('freq-loc-coords-input-3');
	  var freqLocCoordsInput4 = document.getElementById('freq-loc-coords-input-4');
	  var freqLocCoordsInput5 = document.getElementById('freq-loc-coords-input-5');

	  // Create the autocomplete helper, and associate it with
	  // an HTML text input box.
	  var autocompleteWorkplace = new google.maps.places.Autocomplete(workplaceInput);
	  var autocompleteFreqLoc1 = new google.maps.places.Autocomplete(freqLocInput1);
	  var autocompleteFreqLoc2 = new google.maps.places.Autocomplete(freqLocInput2);
	  var autocompleteFreqLoc3 = new google.maps.places.Autocomplete(freqLocInput3);
	  var autocompleteFreqLoc4 = new google.maps.places.Autocomplete(freqLocInput4);
	  var autocompleteFreqLoc5 = new google.maps.places.Autocomplete(freqLocInput5);

	  autocompleteWorkplace.bindTo('bounds', map);
	  autocompleteFreqLoc1.bindTo('bounds', map);
	  autocompleteFreqLoc2.bindTo('bounds', map);
	  autocompleteFreqLoc3.bindTo('bounds', map);
	  autocompleteFreqLoc4.bindTo('bounds', map);
	  autocompleteFreqLoc5.bindTo('bounds', map);

	google.maps.event.addListener(autocompleteWorkplace, 'place_changed', function() {
		var workplaceCoordinates = autocompleteWorkplace.getPlace();
		console.log(workplaceCoordinates);
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
	google.maps.event.addListener(autocompleteFreqLoc4, 'place_changed', function() {
		var freqLoc4Coordinates = autocompleteFreqLoc4.getPlace();
		var freqLoc4Lat = freqLoc4Coordinates.geometry.location.lat();
		var freqLoc4Lng = freqLoc4Coordinates.geometry.location.lng();
		// console.log(''+freqLoc4Lat+', '+freqLoc4Lng+'');
		freqLocCoordsInput4.value = freqLoc4Lat+', '+freqLoc4Lng;
		console.log(freqLocCoordsInput4.value);
	});
	google.maps.event.addListener(autocompleteFreqLoc5, 'place_changed', function() {
		var freqLoc5Coordinates = autocompleteFreqLoc5.getPlace();
		var freqLoc5Lat = freqLoc5Coordinates.geometry.location.lat();
		var freqLoc5Lng = freqLoc5Coordinates.geometry.location.lng();
		// console.log(''+freqLoc5Lat+', '+freqLoc5Lng+'');
		freqLocCoordsInput5.value = freqLoc5Lat+', '+freqLoc5Lng;
		console.log(freqLocCoordsInput5.value);
	});


	@if(Route::currentRouteName() == 'dovetail')

	// var home = new google.maps.LatLng(40.724709, -73.98274200000003);
	// var service = new google.maps.DistanceMatrixService();
	
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

		var apartmentBuildings = [
		    @foreach ($apt_bldgs as $ab)
		        [ {{ $ab->lat }}, {{ $ab->lng }}, "{{ $ab->title }}", "{{ $ab->address }}", "{{ $ab->city }}", "{{ $ab->state }}"  ], 
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
	            icon: '/images/markers/orange_MarkerW.png'
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
	            icon: '/images/markers/yellow_MarkerF.png'
	        });

	        marker.setVisible(true); 

	        // infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
	        // infowindow.open(map, marker);
	    
	        
	    }

	    var totalDuration = 0;
	    var totalDurationArray = [];

	    var origin;
	    var originArray = [];

	    var pathOne;
	    var pathTwo;
	    var pathThree;
	    var pathFour;
	    var pathFive;

	    var workRouteDuration;
	    var routeOneDuration;
	    var routeTwoDuration;
	    var routeThreeDuration;
	    var routeFourDuration;
	    var routeFiveDuration;

	    var travelTime;
	    var travelDuration = [];
	    var totalTravelTime = [];
	    var minimumTripDuration;

	    freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
	    freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());
	    freq_loc_4 = new google.maps.LatLng(freqLocArray[3].lat(), freqLocArray[3].lng());
	    freq_loc_5 = new google.maps.LatLng(freqLocArray[4].lat(), freqLocArray[4].lng());

	    var aptBldgCoords = [];

		var service = new google.maps.DistanceMatrixService();
		// var service1 = new google.maps.DistanceMatrixService();
		// var service2 = new google.maps.DistanceMatrixService();
		// var service3 = new google.maps.DistanceMatrixService();

			    for (var i = 0; i < apartmentBuildings.length; i++) {
					
			    	
			    	aptBldgLat = apartmentBuildings[i][0];
			    	aptBldgLng = apartmentBuildings[i][1];
			    	aptBldgCoords = {lat: aptBldgLat, lng: aptBldgLng};
			    	// console.log(aptBldgCoords);

					origin = aptBldgCoords;
			    	originArray.push(origin);
			    	// console.log(origin);

			    }

			    for (var i = 0; i < originArray.length; i++) {
			    	service.getDistanceMatrix(
			    	{
			    		origins: [originArray[i]],
			    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3, freq_loc_4, freq_loc_5],
			    		travelMode: google.maps.TravelMode.TRANSIT,
			    	}, callback);
			    }

				

				function callback(response, status) {
					console.log(response);
					console.log(status);

					var elements = response.rows[0].elements;
					var tripDuration = [];

					for (var i = 0; i < elements.length; i++) {
						tripDuration.push(elements[i].duration.value);
					}
					for (var i = 0; i < tripDuration.length; i++) {
						totalDuration += (tripDuration[i]);
					}
					totalDurationArray.push(totalDuration);
					Array.min = function(totalDurationArray){
					    return Math.min.apply( Math, totalDurationArray);
					};

					minimumTripDuration = Array.min(totalDurationArray);

					calcRouteWork();
					calcRouteOne();
					calcRouteTwo();
					calcRouteThree();
					calcRouteFour();
					calcRouteFive();
				}

				for (var i = 0; i < apartmentBuildings.length; i++) {
					console.log(apartmentBuildings[i]);
				}



				function calcRouteWork() {
						var start = origin;
						var end = workplace;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  directionsDisplay.setDirections(result);

						  var workRouteDuration = result.routes[0].legs;

						  var travelDuration = [];

						for (i = 0; i < workRouteDuration.length; i++) {
							workRouteDurationValue = workRouteDuration[i].duration.value;
							travelDuration.push(workRouteDurationValue);
						}
						
						totalTravelTime.push(travelDuration);

						  // console.log(workRouteDuration);

						}
					});
				}

				function calcRouteOne() {
						var start = origin;
						var end = freq_loc_1;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  // directionsDisplay.setDirections(result);

						   // console.log(result);

							// console.log(result.routes[0].legs[0].steps);
							// console.log(result.routes[0].legs[0].steps.length);

						   var routeOneSteps = result.routes[0].legs[0].steps;
						   
						   var routeOneDuration = result.routes[0].legs;

						   var travelDuration = [];

							for (i = 0; i < routeOneDuration.length; i++) {
								routeOneDurationValue = routeOneDuration[i].duration.value;
								travelDuration.push(routeOneDurationValue);
							}
							
							totalTravelTime.push(travelDuration);
						   
						   // var dur = document.getElementById('duration');
						   // dur.innerHTML = '<li>'+routeOneDuration+'</li>';

						   var pathCoords = [];
						   
						   for (i = 0; i < routeOneSteps.length; i++) {
							   startLatLng = {lat: result.routes[0].legs[0].steps[i].start_point.lat(), lng: result.routes[0].legs[0].steps[i].start_point.lng()};
							   endLatLng = {lat: result.routes[0].legs[0].steps[i].end_point.lat(), lng: result.routes[0].legs[0].steps[i].end_point.lng()};
							   pathCoords.push(startLatLng);
							   pathCoords.push(endLatLng);
						   }						

						  pathOne = new google.maps.Polyline({
						    path: pathCoords,
						    geodesic: true,
						    strokeColor: 'blue',
						    strokeOpacity: 0.6,
						    strokeWeight: 4
						  });
	  					 pathOne.setMap(map);
						}
					});
				}

				function calcRouteTwo() {
						var start = origin;
						var end = freq_loc_2;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  // directionsDisplay.setDirections(result);
						  // console.log(result);

							// console.log(result.routes[0].legs[0].steps);
							// console.log(result.routes[0].legs[0].steps.length);

						var routeTwoSteps = result.routes[0].legs[0].steps;

						var routeTwoDuration = result.routes[0].legs;

						var travelDuration = [];

						for (i = 0; i < routeTwoDuration.length; i++) {
							routeTwoDurationValue = routeTwoDuration[i].duration.value;
							travelDuration.push(routeTwoDurationValue);
						}
						
						totalTravelTime.push(travelDuration);


						// console.log(routeTwoDuration);
						   
						   // var dur = document.getElementById('duration');
						   // dur.innerHTML = '<li>'+routeTwoDuration+'</li>';

						   var pathCoords = [];
						   
						   for (i = 0; i < routeTwoSteps.length; i++) {
							   startLatLng = {lat: result.routes[0].legs[0].steps[i].start_point.lat(), lng: result.routes[0].legs[0].steps[i].start_point.lng()};
							   endLatLng = {lat: result.routes[0].legs[0].steps[i].end_point.lat(), lng: result.routes[0].legs[0].steps[i].end_point.lng()};
							   pathCoords.push(startLatLng);
							   pathCoords.push(endLatLng);
						   }

						  pathTwo = new google.maps.Polyline({
						    path: pathCoords,
						    geodesic: true,
						    strokeColor: 'slateblue',
						    strokeOpacity: 0.6,
						    strokeWeight: 4
						  });
	  					 pathTwo.setMap(map);
						}
					});
				}

				function calcRouteThree() {
						var start = origin;
						var end = freq_loc_3;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  // directionsDisplay.setDirections(result);

					   		// console.log(result);
							// console.log(result.routes[0].legs[0].steps);
							// console.log(result.routes[0].legs[0].steps.length);

							var routeThreeSteps = result.routes[0].legs[0].steps;
							
							var routeThreeDuration = result.routes[0].legs;

							var travelDuration = [];

							for (i = 0; i < routeThreeDuration.length; i++) {
								routeThreeDurationValue = routeThreeDuration[i].duration.value;
								travelDuration.push(routeThreeDurationValue);
							}
							
							totalTravelTime.push(travelDuration);

						   var pathCoords = [];
						   
						   for (i = 0; i < routeThreeSteps.length; i++) {
							   startLatLng = {lat: result.routes[0].legs[0].steps[i].start_point.lat(), lng: result.routes[0].legs[0].steps[i].start_point.lng()};
							   endLatLng = {lat: result.routes[0].legs[0].steps[i].end_point.lat(), lng: result.routes[0].legs[0].steps[i].end_point.lng()};
							   pathCoords.push(startLatLng);
							   pathCoords.push(endLatLng);
						   }

						  pathThree = new google.maps.Polyline({
						    path: pathCoords,
						    geodesic: true,
						    strokeColor: 'cornflowerblue',
						    strokeOpacity: 0.6,
						    strokeWeight: 4
						  });
	  					 pathThree.setMap(map);

						}
					});
				}

				function calcRouteFour() {
						var start = origin;
						var end = freq_loc_4;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  // directionsDisplay.setDirections(result);

					   		// console.log(result);
							// console.log(result.routes[0].legs[0].steps);
							// console.log(result.routes[0].legs[0].steps.length);

							var routeFourSteps = result.routes[0].legs[0].steps;

							var routeFourDuration = result.routes[0].legs;

							var travelDuration = [];

							for (i = 0; i < routeFourDuration.length; i++) {
								routeFourDurationValue = routeFourDuration[i].duration.value;
								travelDuration.push(routeFourDurationValue);
							}
							
							totalTravelTime.push(travelDuration);

						   var pathCoords = [];
						   
						   for (i = 0; i < routeFourSteps.length; i++) {
							   startLatLng = {lat: result.routes[0].legs[0].steps[i].start_point.lat(), lng: result.routes[0].legs[0].steps[i].start_point.lng()};
							   endLatLng = {lat: result.routes[0].legs[0].steps[i].end_point.lat(), lng: result.routes[0].legs[0].steps[i].end_point.lng()};
							   pathCoords.push(startLatLng);
							   pathCoords.push(endLatLng);
						   }

						  pathFour = new google.maps.Polyline({
						    path: pathCoords,
						    geodesic: true,
						    strokeColor: 'teal',
						    strokeOpacity: 0.6,
						    strokeWeight: 4
						  });
	  					 pathFour.setMap(map);

						}
					});
				}

				function calcRouteFive() {
						var start = origin;
						var end = freq_loc_5;
						var request = {
						origin:start,
						destination:end,
						travelMode: google.maps.TravelMode.TRANSIT
						};
						directionsService.route(request, function(result, status) {
						if (status == google.maps.DirectionsStatus.OK) {
						  // directionsDisplay.setDirections(result);

					   		// console.log(result);
							// console.log(result.routes[0].legs[0].steps);
							// console.log(result.routes[0].legs[0].steps.length);

							var routeFiveSteps = result.routes[0].legs[0].steps;

							var routeFiveDuration = result.routes[0].legs;

							var travelDuration = [];

							for (i = 0; i < routeFiveDuration.length; i++) {
								routeFiveDurationValue = routeFiveDuration[i].duration.value;
								travelDuration.push(routeFiveDurationValue);
							}

							totalTravelTime.push(travelDuration);

						   var pathCoords = [];
						   
						   for (i = 0; i < routeFiveSteps.length; i++) {
							   startLatLng = {lat: result.routes[0].legs[0].steps[i].start_point.lat(), lng: result.routes[0].legs[0].steps[i].start_point.lng()};
							   endLatLng = {lat: result.routes[0].legs[0].steps[i].end_point.lat(), lng: result.routes[0].legs[0].steps[i].end_point.lng()};
							   pathCoords.push(startLatLng);
							   pathCoords.push(endLatLng);
						   }

						  pathFive = new google.maps.Polyline({
						    path: pathCoords,
						    geodesic: true,
						    strokeColor: 'navy',
						    strokeOpacity: 0.6,
						    strokeWeight: 4
						  });
	  					 pathFive.setMap(map);

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
