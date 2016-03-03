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

	<nav id="navbar" class="navbar">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> 
	      </button>
	      <a class="navbar-brand" href="/home">
	      	<img class="img-responsive" src="{{ asset('/images/dovetail_logo_1_white.svg') }}" style="width: 200px; height: auto;">
	      </a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <!-- <li class="active"><a href="#">Home</a></li>
	        <li><a href="#">Page 1</a></li>
	        <li><a href="#">Page 2</a></li> 
	        <li><a href="#">Page 3</a></li>  -->
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <!-- <li><a href="#"><span class=""></span> Sign Up</a></li>
	        <li><a href="#"><span class=""></span> Login</a></li> -->
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

	var blackDoveAddress;
	var blackDoveTitle;

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
	var markersArray = [];

	var infowindow;

	var workplaces;
	var frequentedLocations;
	var apartmentBuildings;


    function initialize() {

    	var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		var geocoder = new google.maps.Geocoder();
	    
	    // Create an array of styles.
		var styles = [
			{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"off"},{"hue":"#ff0000"},{"saturation":"94"},{"lightness":"88"},{"weight":"3.01"},{"invert_lightness":true}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#ffffff"},{"visibility":"on"}]}
		];

		// Create a new StyledMapType object, passing it the array of styles,
		// as well as the name to be displayed on the map type control.
		var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

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


	@if(Route::currentRouteName() == 'dovetail')

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


		var service = new google.maps.DistanceMatrixService();

		// var freqLocMarker = new google.maps.MarkerImage("http://www.clker.com/cliparts/8/6/U/z/k/o/google-maps-marker-for-residencelamontagne-hi.png", null, null, null, new google.maps.Size(20,35));
		var destinationMarker = new google.maps.MarkerImage("http://www.mdbarry.com/girlsinstem/graphics/m2.png", null, null, null, new google.maps.Size(27,45));
		// var destinationMarker = '/images/markers/yellow_MarkerX.png';
		var mascot = new google.maps.MarkerImage("/images/cardinal-icon.png", null, null, null, new google.maps.Size(100,100));

	    for (i = 0; i < workplaces.length; i++) {

	        workplace = new google.maps.LatLng(workplaces[i][0], workplaces[i][1]);

	        marker = new google.maps.Marker({
	            position: workplace,
	            map: map,
	            icon: destinationMarker
	        });

	        markersArray.push(marker);
		
			infowindow = new google.maps.InfoWindow();
	        infowindow.setContent('<div>'+workplaces[i][2]+'<br>'+workplaces[i][3]+', '+workplaces[i][4]+', '+workplaces[i][5]+'</div>');
	        // infowindow.open(map, marker);
	    }

	    var freqLocArray = [];
	    var freqLoc;

	    for (i = 0; i < frequentedLocations.length; i++) {

	    	freqLoc = new google.maps.LatLng(frequentedLocations[i][0], frequentedLocations[i][1]);

	        freqLocArray.push(freqLoc);

	        marker = new google.maps.Marker({
	            position: freqLoc,
	            map: map,
	            icon: destinationMarker
	        }); 

	        markersArray.push(marker);

			infowindow = new google.maps.InfoWindow();
	        infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
	        // infowindow.open(map, marker);
	    }

	    var callbackResponse = [];
		var tripDuration = [];

	    var pathWork;
	    var pathOne;
	    var pathTwo;
	    var pathThree;

	    var workRouteDuration;
	    var routeOneDuration;
	    var routeTwoDuration;
	    var routeThreeDuration;

	    var callbackResponseArray = [];
		var sumOfDurationFromOrigins = [];
		var blackDoveDuration;

		var minimumTripDuration;
	    var originArray = [];


	    freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
	    freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());
	    

	    for (var i = 0; i < apartmentBuildings.length; i++) {

	    	originArray.push({
	    		lat: apartmentBuildings[i][0], 
	    		lng: apartmentBuildings[i][1], 
	    		title: apartmentBuildings[i][2], 
	    		address: apartmentBuildings[i][3]+', '+apartmentBuildings[i][4]+', '+apartmentBuildings[i][5]+' '+apartmentBuildings[i][6]+', '+apartmentBuildings[i][7]
	    	});

	    }

	    var service = new google.maps.DistanceMatrixService();

	    whiteDoves = [];

	    (function serv() {

		    for (var i = 0; i < originArray.length; i++) {
		    	console.log(originArray[i]);
		    	whiteDoves.push({lat: originArray[i].lat, lng: originArray[i].lng}); 
	    	}

	    	service.getDistanceMatrix(
	    	{
	    		origins: whiteDoves,
	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3],
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, callback); 
	    
	    })();
		
    	// TEST NEW CALLBACK HANDLER

		var whiteDoveOrigins = [];

		function callback(response, status) {

			callbackResponseArray.push(response);
			console.log(callbackResponseArray);

			for (var w = 0; w < callbackResponseArray[0].originAddresses.length; w++) {
				whiteDoveOrigins.push({address: callbackResponseArray[0].originAddresses[w], elements: callbackResponseArray[0].rows[w].elements});
			}

			calculateTotalDurationFromOrigins();

		}

		function calculateTotalDurationFromOrigins() {
			
			var counter = 0;
			var totalDuration = 0;
			var intermediateDurationsArray = [];

			for (var idx = 0; idx < whiteDoveOrigins.length; idx++) {

				console.log(whiteDoveOrigins[idx]);

				whiteDoveOrigins[idx].elements.forEach(function(k,v){
					
					if(v == 0){

						intermediateDurationsArray.push(((k.duration.value * 5 * 52)/60));

					} else if(v == 1){

						intermediateDurationsArray.push(((k.duration.value * 3 * 52)/60));

					} else if(v == 2){

						intermediateDurationsArray.push(((k.duration.value * 1 * 52)/60));

					} else if(v == 3){
						
						intermediateDurationsArray.push(((k.duration.value * 0.25 * 52)/60));

						for (var y = 0; y < intermediateDurationsArray.length; y++) {
							totalDuration += (intermediateDurationsArray[y]);
						}	

						sumOfDurationFromOrigins.push({origin: whiteDoveOrigins[counter].address, duration: totalDuration});
						totalDuration=0;
						intermediateDurationsArray = [];
						counter++;

					}

				});

			}

			console.log(sumOfDurationFromOrigins);

			findMinDurationOrigin();

		};

		function findMinDurationOrigin() {

			var aggregateDurationArray = [];

			Array.min = function(){
				for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
					aggregateDurationArray.push(sumOfDurationFromOrigins[i].duration);
				}
			    return Math.min.apply(Math, aggregateDurationArray);
			};
			minimumTripDuration = Array.min(aggregateDurationArray);

			for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
				if(sumOfDurationFromOrigins[i].duration === minimumTripDuration) {
					theBlackDove = sumOfDurationFromOrigins[i].origin;
					blackDoveDuration = sumOfDurationFromOrigins[i].duration;
				};
			 }

			 findMatchingDatabaseRecord();
		}

		function findMatchingDatabaseRecord() {

			var simArray = [];

			 for (var i = 0; i < originArray.length; i++) {
			 	
			 	var a = theBlackDove;
			 	var b = originArray[i].address;
				var zip_a = theBlackDove.match(/\b\d{5}\b/g);
				var zip_b = originArray[i].address.match(/\b\d{5}\b/g);

			    var equivalency_fullstr = 0;
			    var equivalency_zip = 0;
			    
			    var minLength = (a.length > b.length) ? b.length : a.length;    
			    var maxLength = (a.length < b.length) ? b.length : a.length;    
			    var minLengthZip = (zip_a.length > zip_b.length) ? zip_b.length : zip_a.length;    
			    var maxLengthZip = (zip_a.length < zip_b.length) ? zip_b.length : zip_a.length;  

			    for(var k = 0; k < minLength; k++) {
			        if(a[k] == b[k]) {
			            equivalency_fullstr++;
			        }
			    }
			    for(var kk = 0; kk < minLengthZip; kk++) {
			        if(zip_a[kk] == zip_b[kk]) {
			            equivalency_zip++;
			        }
			    }
			    
			    var weight_address = equivalency_fullstr / maxLength;
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
			console.log(maxWeight);

			for (var i = 0; i < simArray.length; i++) {
				if(simArray[i].weight === maxWeight) {
					console.log(simArray[i]);
	    			theBlackDove = {lat: simArray[i].whiteDoves.lat, lng: simArray[i].whiteDoves.lng}; 
	    			blackDoveAddress = simArray[i].whiteDoves.address;
	    			blackDoveTitle = simArray[i].whiteDoves.title;
				}
			}

			dovetailor();

		}

		function dovetailor () {

			var service = new google.maps.DistanceMatrixService();

	        var originMarker = new google.maps.Marker({
	            position: theBlackDove,
	            map: map,
	            flat: false,
	            icon: mascot
	        });

	        // infowindow = new google.maps.InfoWindow();

	        // infowindow.setContent('<div><p>ice like winnipeg</p></div>');
	        // infowindow.open(map, originMarker);

	        var mapCSS = document.getElementById('map').style;
	    		mapCSS.right = 0;
	    		mapCSS.top = 0;
	    		mapCSS.width = '73%';

    		var sidebar = document.getElementById('sidebar').style;
    		var navbar = document.getElementById('navbar').style;
    		navbar.left = 0;
    		sidebar.display = 'block';
    		navbar.width = '27%';

    		document.getElementById('blackDoveDetails').innerHTML = '<h3>'+blackDoveTitle+'</h3><h4>'+blackDoveAddress+'</h4><h4><strong style="font-size:30px;">'+blackDoveDuration+' </strong><p style="font-size:18px;">minutes per year in transit</p></h4><hr>';

			service.getDistanceMatrix({
	    		origins: [theBlackDove],
	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3],
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, function (result, status) {

	    		var bounds = new google.maps.LatLngBounds();
				for (var i = 0; i < markersArray.length; i++) {
				 bounds.extend(markersArray[i].getPosition());
				}

				map.fitBounds(bounds);
				map.panBy(222, 0);

				calcRouteWork();
				setTimeout(function() {
					calcRouteOne();
				}, 1000);
				setTimeout(function() {
					calcRouteTwo();
				}, 2000);
				setTimeout(function() {
					calcRouteThree();
				}, 3000);

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
				   	
					// directionsDisplay.setDirections(result);

				   	var routeWorkOverviewPath = result.routes[0].overview_path;

					var pathCoords = [];

					var idx = 0;
				
					pathCoords.push(theBlackDove);

					var animateLineDraw = window.setInterval(function() {	

						if (idx < routeWorkOverviewPath.length) {
							var routeLatLng = {lat: routeWorkOverviewPath[idx].lat(), lng: routeWorkOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathWork = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeColor: '#3498DB',
								strokeOpacity: 0.5,
								strokeWeight: 3.5
							});
							pathWork.setMap(map);
							idx++;

						} else {
						  window.clearInterval(animateLineDraw);
						  
						}

					}, 40);
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

					console.log(result);

					var routeOneOverviewPath = result.routes[0].overview_path;
					var routeOneSteps = result.routes[0].legs[0].steps;

					console.log(routeOneSteps);

					var pathCoords = [];

					var idx = 0;

					pathCoords.push(theBlackDove);

					var animateLineDraw = window.setInterval(function() {
						
						if (idx < routeOneOverviewPath.length) {
							var routeLatLng = {lat: routeOneOverviewPath[idx].lat(), lng: routeOneOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathOne = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeColor: '#3498DB',
								strokeOpacity: 0.5,
								strokeWeight: 3.5
							});
							pathOne.setMap(map);
							idx++;
						} else {
						  window.clearInterval(animateLineDraw);
						  
						}

					}, 30);
						


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

					var routeTwoOverviewPath = result.routes[0].overview_path;

					var pathCoords = [];

					var idx = 0;

					pathCoords.push(theBlackDove);

					var animateLineDraw = window.setInterval(function() {
						
						if (idx < routeTwoOverviewPath.length) {
							var routeLatLng = {lat: routeTwoOverviewPath[idx].lat(), lng: routeTwoOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathTwo = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeColor: '#3498DB',
								strokeOpacity: 0.5,
								strokeWeight: 3.5
							});
							pathTwo.setMap(map);
							idx++;
						} else {
						  window.clearInterval(animateLineDraw);
						  
						}

					}, 20);

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

			   		// console.log(result);

					var routeThreeOverviewPath = result.routes[0].overview_path;

					var pathCoords = [];
				   
					var idx = 0;

					pathCoords.push(theBlackDove);

					var animateLineDraw = window.setInterval(function() {
						
						if (idx < routeThreeOverviewPath.length) {
							var routeLatLng = {lat: routeThreeOverviewPath[idx].lat(), lng: routeThreeOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathThree = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeColor: '#3498DB',
								strokeOpacity: 0.5,
								strokeWeight: 3.5
							});
							pathThree.setMap(map);
							idx++;
						} else {
						  	window.clearInterval(animateLineDraw);
						}

					}, 10);

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
