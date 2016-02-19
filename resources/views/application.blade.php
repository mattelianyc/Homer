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
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,500' rel='stylesheet' type='text/css'>

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

	<nav class="navbar">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> 
	      </button>
	      <img class="navbar-brand img-responsive" src="{{ asset('/images/dovetail_logo_1_white.svg') }}" style="padding:15px;height:80px;">
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <!-- <li class="active"><a href="#">Home</a></li>
	        <li><a href="#">Page 1</a></li>
	        <li><a href="#">Page 2</a></li> 
	        <li><a href="#">Page 3</a></li>  -->
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#"><span class=""></span> Sign Up</a></li>
	        <li><a href="#"><span class=""></span> Login</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>

	@yield('content')

	<div id="map"></div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/calculateAjax.js') }}"></script>
<script>
	

	var theBlackDove;
	var whiteDoves;
	var greyDoves;
	var pigeons;

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

	var workplaces;
	var frequentedLocations;
	var apartmentBuildings;


    function initialize() {

    	var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		var geocoder = new google.maps.Geocoder();
	    // Create an array of styles.
		  var styles = [
		    {
		      stylers: [
		        { hue: "#2C3E50" },
		        { saturation: 50 }
		      ]
		    },
		    {
		    	featureType: "poi",
		    	elementType: "all",
		    	stylers: [
		    	{color: '#2980B9'},
		        { lightness: 80 },
		    	{saturation: -30 },
		    	{visibility: "off"}
		    	]
		    },{
		      featureType: "road.arterial",
		      elementType: "geometry.stroke",
		      stylers: [
		        {color: '#2C3E50'},
		    	{saturation: 30 },
		        { visibility: "off" }
		      ]
		    },{
		      featureType: "road.highway",
		      elementType: "geometry",
		      stylers: [
		        { lightness: 100 },
		        { color: "#2980B9" },
		        { visibility: "off" }
		      ]
		    },{
		      featureType: "transit",
		      elementType: "labels.text",
		      stylers: [
		        { lightness: 100 },
		        { color: '#E74C3C' },
		        { visibility: "off" }
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
			var wpLat = workplaceCoordinates.geometry.location.lat();
			var wpLng = workplaceCoordinates.geometry.location.lng();
			
			workplaceCoordsInput.value = wpLat+', '+wpLng;
			console.log(workplaceCoordsInput.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc1, 'place_changed', function() {

			var freqLoc1Coordinates = autocompleteFreqLoc1.getPlace();
			var freqLoc1Lat = freqLoc1Coordinates.geometry.location.lat();
			var freqLoc1Lng = freqLoc1Coordinates.geometry.location.lng();
			
			freqLocCoordsInput1.value = freqLoc1Lat+', '+freqLoc1Lng;
			console.log(freqLocCoordsInput1.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc2, 'place_changed', function() {
			
			var freqLoc2Coordinates = autocompleteFreqLoc2.getPlace();
			var freqLoc2Lat = freqLoc2Coordinates.geometry.location.lat();
			var freqLoc2Lng = freqLoc2Coordinates.geometry.location.lng();
			
			freqLocCoordsInput2.value = freqLoc2Lat+', '+freqLoc2Lng;
			console.log(freqLocCoordsInput2.value);
		});
		google.maps.event.addListener(autocompleteFreqLoc3, 'place_changed', function() {
			
			var freqLoc3Coordinates = autocompleteFreqLoc3.getPlace();
			var freqLoc3Lat = freqLoc3Coordinates.geometry.location.lat();
			var freqLoc3Lng = freqLoc3Coordinates.geometry.location.lng();
			
			freqLocCoordsInput3.value = freqLoc3Lat+', '+freqLoc3Lng;
			console.log(freqLocCoordsInput3.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc4, 'place_changed', function() {
			
			var freqLoc4Coordinates = autocompleteFreqLoc4.getPlace();
			var freqLoc4Lat = freqLoc4Coordinates.geometry.location.lat();
			var freqLoc4Lng = freqLoc4Coordinates.geometry.location.lng();
			
			freqLocCoordsInput4.value = freqLoc4Lat+', '+freqLoc4Lng;
			console.log(freqLocCoordsInput4.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc5, 'place_changed', function() {

			var freqLoc5Coordinates = autocompleteFreqLoc5.getPlace();
			var freqLoc5Lat = freqLoc5Coordinates.geometry.location.lat();
			var freqLoc5Lng = freqLoc5Coordinates.geometry.location.lng();
			
			freqLocCoordsInput5.value = freqLoc5Lat+', '+freqLoc5Lng;
			console.log(freqLocCoordsInput5.value);

		});


	@if(Route::currentRouteName() == 'dovetail')

		var service = new google.maps.DistanceMatrixService();
	
		var infowindow = new google.maps.InfoWindow();
		marker = new google.maps.Marker({
			map: map
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});


		// PULL WORKPLACES / FREQUENTED LOCATIONS / APARTMENT BUILDINGS FROM DB

		workplaces = [
		    @foreach ($workplace as $wp)
		        [ {{ $wp->lat }}, {{ $wp->lng }}, "{{ $wp->title }}", "{{ $wp->address }}", "{{ $wp->city }}", "{{ $wp->state }}" ]    
		    @endforeach
	    ];

		frequentedLocations = [
		    @foreach ($frequented_locations as $fl)
		        [ {{ $fl->lat }}, {{ $fl->lng }}, "{{ $fl->title }}", "{{ $fl->address }}", "{{ $fl->city }}", "{{ $fl->state }}" ], 
		    @endforeach
	    ];

		apartmentBuildings = [
		    @foreach ($apt_bldgs as $ab)
		        [ {{ $ab->lat }}, {{ $ab->lng }}, "{{ $ab->title }}", "{{ $ab->address }}", "{{ $ab->city }}", "{{ $ab->state }}", "{{ $ab->zip }}", "{{ $ab->country }}" ], 
		    @endforeach
	    ];

	    var workplace = new google.maps.LatLng(workplaces[0][0], workplaces[0][1]);

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

	    var freqLocArray = [];
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

	    var callbackResponse = [];
		var tripDuration = [];
	    
	    var origins = [];

	    var apartmentProximity = [];

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

	    var callbackResponseArray = [];
		var sumOfDurationFromOrigins = [];

		var minimumTripDuration;

	    freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
	    freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());
	    freq_loc_4 = new google.maps.LatLng(freqLocArray[3].lat(), freqLocArray[3].lng());
	    freq_loc_5 = new google.maps.LatLng(freqLocArray[4].lat(), freqLocArray[4].lng());

	    var originArray = [];

	    for (var i = 0; i < apartmentBuildings.length; i++) {

	    	originArray.push({
	    		lat: apartmentBuildings[i][0], 
	    		lng: apartmentBuildings[i][1], 
	    		title: apartmentBuildings[i][2], 
	    		address: apartmentBuildings[i][3]+', '+apartmentBuildings[i][4]+', '+apartmentBuildings[i][5]+' '+apartmentBuildings[i][6]+', '+apartmentBuildings[i][7]
	    	});

	    }

	    console.log(originArray); 

	    var service = new google.maps.DistanceMatrixService();

	    whiteDoves = [];

	    (function serv() {

		    for (var i = 0; i < originArray.length; i++) {
		    	whiteDoves.push({lat: originArray[i].lat, lng: originArray[i].lng}); 
	    	}

	    	service.getDistanceMatrix(
	    	{
	    		origins: whiteDoves,
	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3, freq_loc_4, freq_loc_5],
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, callback); 
	    
	    })();
		
    	// TEST NEW CALLBACK HANDLER

		var whiteDoveOrigins = [];

		function callback(response, status) {

			callbackResponseArray.push(response);
			console.log(callbackResponseArray);
			
			var intermediateDurationsObject;
			var counter = 0;

			var elementsArray = [];
			whiteDoveOrigins = [];

			var totalDuration = 0;
			var intermediateDurationsArray = [];
			
			for (var w = 0; w < callbackResponseArray[0].originAddresses.length; w++) {
				whiteDoveOrigins.push({address: callbackResponseArray[0].originAddresses[w], elements: callbackResponseArray[0].rows[w].elements});
			}

			// console.log(whiteDoveOrigins);

			for (var idx = 0; idx < whiteDoveOrigins.length; idx++) {

				whiteDoveOrigins[idx].elements.forEach(function(k,v){
					if(v == 5){
						for (var y = 0; y < intermediateDurationsArray.length; y++) {
							totalDuration += (intermediateDurationsArray[y]);
						}	
						sumOfDurationFromOrigins.push({origin: whiteDoveOrigins[counter].address, duration: totalDuration});
						totalDuration=0;
						intermediateDurationsArray = [];
						counter++;
					} else {
						intermediateDurationsArray.push(k.duration.value);
					} 
				});

			}
			console.log(sumOfDurationFromOrigins);

			findMinDurationOrigin();

		};


		var simArray = [];

		function findMinDurationOrigin(dovetails) {

			var aggregateDurationArray = [];

			Array.min = function(){
				for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
					aggregateDurationArray.push(sumOfDurationFromOrigins[i].duration);
				}
				// console.log(aggregateDurationArray);
			    return Math.min.apply(Math, aggregateDurationArray);
			};
			minimumTripDuration = Array.min(aggregateDurationArray);
			// console.log(minimumTripDuration);

			for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
				if(sumOfDurationFromOrigins[i].duration === minimumTripDuration) {
					// console.log(sumOfDurationFromOrigins[i]);
					theBlackDove = sumOfDurationFromOrigins[i].origin;
				};
			 } 

			 for (var i = 0; i < originArray.length; i++) {
			 	
			 	var a = theBlackDove;
			 	var b = originArray[i].address;
				var zip_a = theBlackDove.match(/\b\d{5}\b/g);
				var zip_b = originArray[i].address.match(/\b\d{5}\b/g);

			    var equivalency_fullstr = 0;
			    var minLength = (a.length > b.length) ? b.length : a.length;    
			    var maxLength = (a.length < b.length) ? b.length : a.length;    
			    for(var k = 0; k < minLength; k++) {
			        if(a[k] == b[k]) {
			            equivalency_fullstr++;
			        }
			    }

			    var weight_address = equivalency_fullstr / maxLength;

			    var equivalency_zip = 0;
			    var minLengthZip = (zip_a.length > zip_b.length) ? zip_b.length : zip_a.length;    
			    var maxLengthZip = (zip_a.length < zip_b.length) ? zip_b.length : zip_a.length;  

			    for(var kk = 0; kk < minLengthZip; kk++) {
			        if(zip_a[kk] == zip_b[kk]) {
			            equivalency_zip++;
			        }
			    }
			    
			    var weight_zip = equivalency_zip / maxLengthZip;

			    simArray.push({ whiteDoves: originArray[i], weight: ((weight_address * 100) + (weight_zip * 100)) });

			 }


			 var weightArray = [];

			 Array.max = function(){
				for (var i = 0; i < simArray.length; i++) {
					weightArray.push(simArray[i].weight);
				}
			    return Math.max.apply(Math, weightArray);
			};

			maxWeight = Array.max(weightArray);
			// console.log(maxWeight);

			for (var i = 0; i < simArray.length; i++) {
				if(simArray[i].weight === maxWeight) {
	    			theBlackDove = {lat: simArray[i].whiteDoves.lat, lng: simArray[i].whiteDoves.lng}; 
				}
			}

			var service = new google.maps.DistanceMatrixService();
			service.getDistanceMatrix({
	    		origins: [theBlackDove],
	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3, freq_loc_4, freq_loc_5],
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, function (result, status) {

				calcRouteWork();
				calcRouteOne();
				calcRouteTwo();
				calcRouteThree();
				calcRouteFour();
				calcRouteFive();

	    	});
		

		}


		function calcRouteWork() {
				var start = theBlackDove;
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

				  // console.log(workRouteDuration);

				}
			});
		}

		function calcRouteOne() {
				var start = theBlackDove;
				var end = freq_loc_1;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				  // directionsDisplay.setDirections(result);

				   console.log(result);

					// console.log(result.routes[0].legs[0].steps);
					// console.log(result.routes[0].legs[0].steps.length);

				   var routeOneSteps = result.routes[0].legs[0].steps;
				   
				   var routeOneDuration = result.routes[0].legs;
				   
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
				    strokeColor: 'purple',
				    strokeOpacity: 1.0,
				    strokeWeight: 4
				  });
					 pathOne.setMap(map);
				}
			});
		}

		function calcRouteTwo() {
				var start = theBlackDove;
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
				    strokeColor: 'orange',
				    strokeOpacity: 1.0,
				    strokeWeight: 4
				  });
					 pathTwo.setMap(map);
				}
			});
		}

		function calcRouteThree() {
				var start = theBlackDove;
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
				    strokeColor: 'red',
				    strokeOpacity: 1.0,
				    strokeWeight: 4
				  });
					 pathThree.setMap(map);

				}
			});
		}

		function calcRouteFour() {
				var start = theBlackDove;
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
				    strokeColor: 'maroon',
				    strokeOpacity: 1.0,
				    strokeWeight: 4
				  });
					 pathFour.setMap(map);

				}
			});
		}

		function calcRouteFive() {
				var start = theBlackDove;
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
				    strokeColor: 'darkgreen',
				    strokeOpacity: 1.0,
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
