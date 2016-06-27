<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" value="{{ csrf_token() }}">
	<title>Homer</title>

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
	<!-- <script src="{{ asset('js/charts.js') }}"></script> -->

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
	      <a class="navbar-brand" href="{{  action('HomeController@logout') }}">
	      	@if(Route::currentRouteName() == 'dovetail')
	      	<img id="homer-logo" class="img-responsive" src="{{ asset('/images/homer_logo.png') }}">
	      	@elseif(Route::currentRouteName() == 'home')
	      	<img id="homer-logo" class="img-responsive" src="{{ asset('/images/homer_logo_stacked.png') }}">
	      	@endif
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
	        <!-- <i id="resetPolylines" class="fa fa-remove" style="color:red;font-size: 35px"></i> -->
	      </ul>
	    </div>
	  </div>
	</nav>

	<div id="map-mobile" class="visible-xs"></div>

	@yield('content')

	<div id="map" class="hidden-xs"></div>

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

		$('#resetPolylines').click(function() {
			$(document).unbind();
			init();
		});

	});

	// initialize GMAP function

	var map;
	var mapMobile;

	var marker;
	var markerMobile;

	var workplaceMarker;
	var workplaceMarkerMobile;

	var markersArray = [];
	var markersArrayMobile = [];

	var originMarker;
	var originMarkerMobile;

	var infowindow;

	var workplaces;
	var frequentedLocations;
	var buildings;
	var apartments;

	var passage = [];
	var apartmentListings;
	
	// SVG PATH PROPERTIES
	// var lineSymbol = {
	//     path: 'M 0,-1 0,1',
	//     strokeOpacity: 1,
	//     scale: 3.69
	//   };


if ($(window).width() > 600 ) {

	var init = function initialize() {

    	var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer(
		{
			suppressMarkers: false
		});
		var geocoder = new google.maps.Geocoder();
	    
	    // Create an array of styles.
		var styles = [
			{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":20},{"color":"#ececec"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ececec"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"lightness":21},{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#303030"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"geometry.stroke","stylers":[{"lightness":"-61"},{"gamma":"0.00"},{"visibility":"off"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#dadada"},{"lightness":17}]}
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


		// mapMobile = new google.maps.Map(document.getElementById('map-mobile'), mapOptionsMobile);
		map = new google.maps.Map(document.getElementById('map'), mapOptions);

		map.mapTypes.set('map_style', styledMap);
		map.setMapTypeId('map_style');

		directionsDisplay.setMap(map);

		// USER DESTINATION INPUT VAL'S W/ CORRESPONDING COORDS 
		var workplaceInput = document.getElementById('workplace-search-input');
		var workplaceCoordsInput = document.getElementById('workplace-coords-input');
		var freqLocInput1 = document.getElementById('freq-loc-input-1');
		var freqLocCoordsInput1 = document.getElementById('freq-loc-coords-input-1');
		var freqLocInput2 = document.getElementById('freq-loc-input-2');
		var freqLocCoordsInput2 = document.getElementById('freq-loc-coords-input-2');
		var freqLocInput3 = document.getElementById('freq-loc-input-3');
		var freqLocCoordsInput3 = document.getElementById('freq-loc-coords-input-3');

		// AUTOCOMPLETE BINDINGS
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
			// console.log(workplaceCoordsInput.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc1, 'place_changed', function() {

			var freqLoc1Coordinates = autocompleteFreqLoc1.getPlace();
			var freqLoc1Lat = freqLoc1Coordinates.geometry.location.lat();
			var freqLoc1Lng = freqLoc1Coordinates.geometry.location.lng();
			freqLocCoordsInput1.value = freqLoc1Lat+', '+freqLoc1Lng;
			// console.log(freqLocCoordsInput1.value);

		});
		google.maps.event.addListener(autocompleteFreqLoc2, 'place_changed', function() {
			
			var freqLoc2Coordinates = autocompleteFreqLoc2.getPlace();
			var freqLoc2Lat = freqLoc2Coordinates.geometry.location.lat();
			var freqLoc2Lng = freqLoc2Coordinates.geometry.location.lng();
			freqLocCoordsInput2.value = freqLoc2Lat+', '+freqLoc2Lng;
			// console.log(freqLocCoordsInput2.value);
		});
		google.maps.event.addListener(autocompleteFreqLoc3, 'place_changed', function() {
			
			var freqLoc3Coordinates = autocompleteFreqLoc3.getPlace();
			var freqLoc3Lat = freqLoc3Coordinates.geometry.location.lat();
			var freqLoc3Lng = freqLoc3Coordinates.geometry.location.lng();
			freqLocCoordsInput3.value = freqLoc3Lat+', '+freqLoc3Lng;
			// console.log(freqLocCoordsInput3.value);

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
		        [ {{ $fl->lat }}, {{ $fl->lng }}, "{{ $fl->title }}", "{{ $fl->address }}", "{{ $fl->city }}", "{{ $fl->state }}", "{{ $fl->weight }}" ], 
		    @endforeach
	    ];

		buildings = [
		    @foreach ($buildings as $b)
		        [ {{ $b->lat }}, {{ $b->lng }}, "{{ $b->title }}", "{{ $b->address }}", "{{ $b->city }}", "{{ $b->state }}", "{{ $b->zip }}", "{{ $b->country }}", "{{ $b->id }}" ], 
		    @endforeach
	    ];

		apartments = [
		    @foreach ($apartments as $a)
		        {id: "{{ $a->id }}", building_id: "{{ $a->building_id }}", unit: "{{ $a->unit }}", price: "{{ $a->price }}", bed: "{{ $a->bed }}", bath: "{{ $a->bath }}", sqft: "{{ $a->sqft }}"}, 
		    @endforeach
	    ];

		var service = new google.maps.DistanceMatrixService();

		var workplaceMarker = new google.maps.MarkerImage("http://walkersstuff.com/wp-content/uploads/2015/06/stepThree.png", null, null, null, new google.maps.Size(30,40));

		var destinationMarker = new google.maps.MarkerImage("http://www.envirovent.com/img/location-trade.png", null, null, null, new google.maps.Size(30,40));

		var mascot = new google.maps.MarkerImage("/images/cardinal-icon.png", null, null, null, new google.maps.Size(75,75));

	    for (i = 0; i < workplaces.length; i++) {

	        workplace = new google.maps.LatLng(workplaces[i][0], workplaces[i][1]);

	        workplaceMarker = new google.maps.Marker({
	            position: workplace,
	            map: map,
	            icon: destinationMarker
	        });

	        markersArray.push(workplaceMarker);
		
		  // infowindow = new google.maps.InfoWindow();
		  // infowindow.setContent('<div>'+workplaces[i][2]+'<br>'+workplaces[i][3]+', '+workplaces[i][4]+', '+workplaces[i][5]+'</div>');
		  // infowindow.open(map, marker);

	    }

	    var freqLoc;
	    var freqLocArray = [];
	    var freqLocWeights = [];

	    for (i = 0; i < frequentedLocations.length; i++) {

	    	freqLoc = new google.maps.LatLng(frequentedLocations[i][0], frequentedLocations[i][1]);

	        freqLocArray.push(freqLoc);
	        freqLocWeights.push(frequentedLocations[i][6]);

	        marker = new google.maps.Marker({
	            position: freqLoc,
	            map: map,
	            icon: destinationMarker,
	            zIndex: 100
	        }); 

	        markersArray.push(marker);

			// infowindow = new google.maps.InfoWindow();
	  		// infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
	        // infowindow.open(map, marker);

	    }
        

		var tripDuration = [];

    var pathWork;
    var pathOne;
    var pathTwo;
    var pathThree;

    var pathWorkMobile;
    var pathOneMobile;
    var pathTwoMobile;
    var pathThreeMobile;

    var workRouteDuration;
    var routeOneDuration;
    var routeTwoDuration;
    var routeThreeDuration;

    var callbackResponseArray = [];

		var sumOfDurationFromOrigins = [];
		var aggregateDurationArray = [];
		var sortedOriginsArray = [];

		var blackDoveDuration;
		var blackDoveId;

		var minimumTripDuration;
    var originArray = [];

    var activeBldgSelection;
    var activeBldgDetails;

    var aptCount;
		var aptPriceRangeMax;
		var aptPriceRangeMin;
		var aptPriceRange;

		var destinationsArray = [];

			destinationsArray.push(workplace);

			if (frequentedLocations.length === 1) {
	    	freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
				destinationsArray.push(freq_loc_1);
			} else if (frequentedLocations.length === 2) {
	    	freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    	freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
				destinationsArray.push(freq_loc_1);
				destinationsArray.push(freq_loc_2);
			} else if (frequentedLocations.length === 3) {
	    	freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
	    	freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
	    	freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());
				destinationsArray.push(freq_loc_1);
				destinationsArray.push(freq_loc_2);
				destinationsArray.push(freq_loc_3);
			}

	    for (var i = 0; i < buildings.length; i++) {

	    	originArray.push({
	    		id: buildings[i][8],
	    		lat: buildings[i][0], 
	    		lng: buildings[i][1], 
	    		title: buildings[i][2], 
	    		address: buildings[i][3]+', '+buildings[i][4]+', '+buildings[i][5]+' '+buildings[i][6]+', '+buildings[i][7]
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
	    		destinations: destinationsArray,
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, callback); 
	    
	    })();
		
    	// TEST NEW CALLBACK HANDLER

		var whiteDoveOrigins = [];

		function callback(response, status) {

			// console.log(callbackResponseArray[0] !== null);
			console.log(response != null);
			// if(response != null) {
				callbackResponseArray.push(response);
				// if(callbackResponseArray.originAddresses != null && typeof(callbackResponseArray.originAddresses) != undefined){
					for (var w = 0; w < callbackResponseArray[0].originAddresses.length; w++) {
						whiteDoveOrigins.push({id: originArray[w].id, title: originArray[w].title, address: originArray[w].address, lat: originArray[w].lat, lng: originArray[w].lng, elements: callbackResponseArray[0].rows[w].elements});
					}
				// }
			// }
			
			calculateTotalDurationFromOrigins();

		}

		function calculateTotalDurationFromOrigins() {
			
			var counter = 0;
			var totalDuration = 0;
			var intermediateDurationsArray = [];

			for (var idx = 0; idx < whiteDoveOrigins.length; idx++) {

				console.log(whiteDoveOrigins[idx]);

				whiteDoveOrigins[idx].elements.forEach(function(k,v){
					
					console.log(destinationsArray.length);

					if(v == 0){

						intermediateDurationsArray.push(((((k.duration.value * 5 * 52)/60)/60)*2));

							if((destinationsArray.length-1) === v ){
								for (var y = 0; y < intermediateDurationsArray.length; y++) {
								totalDuration += (intermediateDurationsArray[y]);
								}	

								sumOfDurationFromOrigins.push({originId: whiteDoveOrigins[counter].id, origin: whiteDoveOrigins[counter].address, originTitle: whiteDoveOrigins[counter].title, duration: parseInt(totalDuration), lat: whiteDoveOrigins[counter].lat, lng: whiteDoveOrigins[counter].lng});
								totalDuration=0;
								intermediateDurationsArray = [];
								counter++;
							}
					} else if(v == 1){

						intermediateDurationsArray.push(((((k.duration.value * freqLocWeights[0] * 52)/60)/60)*2));
							if((destinationsArray.length-1) === v ){
								for (var y = 0; y < intermediateDurationsArray.length; y++) {
							totalDuration += (intermediateDurationsArray[y]);
						}	

						sumOfDurationFromOrigins.push({originId: whiteDoveOrigins[counter].id, origin: whiteDoveOrigins[counter].address, originTitle: whiteDoveOrigins[counter].title, duration: parseInt(totalDuration), lat: whiteDoveOrigins[counter].lat, lng: whiteDoveOrigins[counter].lng});
						totalDuration=0;
						intermediateDurationsArray = [];
						counter++;
							}
					} else if(v == 2){

						intermediateDurationsArray.push(((((k.duration.value * freqLocWeights[1] * 52)/60)/60)*2));
							if((destinationsArray.length-1) === v ){
								for (var y = 0; y < intermediateDurationsArray.length; y++) {
									totalDuration += (intermediateDurationsArray[y]);
								}	

								sumOfDurationFromOrigins.push({originId: whiteDoveOrigins[counter].id, origin: whiteDoveOrigins[counter].address, originTitle: whiteDoveOrigins[counter].title, duration: parseInt(totalDuration), lat: whiteDoveOrigins[counter].lat, lng: whiteDoveOrigins[counter].lng});
								totalDuration=0;
								intermediateDurationsArray = [];
								counter++;
							}
					} else if(v == 3){
						
						intermediateDurationsArray.push(((((k.duration.value * freqLocWeights[2] * 52)/60)/60)*2));

						if((destinationsArray.length-1) === v ){
							for (var y = 0; y < intermediateDurationsArray.length; y++) {
									totalDuration += (intermediateDurationsArray[y]);
								}	

								sumOfDurationFromOrigins.push({originId: whiteDoveOrigins[counter].id, origin: whiteDoveOrigins[counter].address, originTitle: whiteDoveOrigins[counter].title, duration: parseInt(totalDuration), lat: whiteDoveOrigins[counter].lat, lng: whiteDoveOrigins[counter].lng});
								totalDuration=0;
								intermediateDurationsArray = [];
								counter++;
							}

					}

				});

			}

			console.log(sumOfDurationFromOrigins);

			aggregateDurationArray = [];

			for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
				aggregateDurationArray.push(sumOfDurationFromOrigins[i].duration);
			}

			orderListingsByDuration();

		};

		function orderListingsByDuration () {
			
			sortedOriginsArray = [];
			
			aggregateDurationArray.sort(function(a, b){return a-b});

			for (var x = 0; x < sumOfDurationFromOrigins.length; x++) {
				for (var y = 0; y < aggregateDurationArray.length; y++) {
					if(sumOfDurationFromOrigins[x].duration === aggregateDurationArray[y]) {
						sortedOriginsArray.push({id: sumOfDurationFromOrigins[x].originId, duration: aggregateDurationArray[y], address: sumOfDurationFromOrigins[x].origin, title: sumOfDurationFromOrigins[x].originTitle, lat: sumOfDurationFromOrigins[x].lat, lng: sumOfDurationFromOrigins[x].lng});
					}
				}
			}

			sortedOriginsArray.sort(function(a,b){return a.duration - b.duration});
			
			console.log(sortedOriginsArray[0]);

			blackDoveId = '1';
			theBlackDove = {lat: sortedOriginsArray[0].lat, lng: sortedOriginsArray[0].lng}; 
			blackDoveAddress = sortedOriginsArray[0].address;
			blackDoveTitle = sortedOriginsArray[0].title;
			blackDoveDuration = sortedOriginsArray[0].duration;

			
			dovetailor();

		}

		var dovetailor = function dovetailor () {

	        originMarker = new google.maps.Marker({
	            position: theBlackDove,
	            map: map,
	            flat: false,
	            icon: mascot
	        });				

	        markersArray.push(originMarker);

	        var service = new google.maps.DistanceMatrixService();
			
			service.getDistanceMatrix({
	    		origins: [theBlackDove],
	    		destinations: destinationsArray,
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, function (result, status) {

	    		var bounds = new google.maps.LatLngBounds();
				for (var i = 0; i < markersArray.length; i++) {
					bounds.extend(markersArray[i].getPosition());
				}				
				map.fitBounds(bounds);
				map.panBy(222, 0);

				calcRouteWork();
				calcRouteOne();
				calcRouteTwo();
				calcRouteThree();

				iwHello = new google.maps.InfoWindow();
			  	iwHello.setContent('<div><p>Hi, my name is Homer. Click me for more info</p></div>');
			    iwHello.open(map, originMarker);
			    setTimeout(function() {
			    	iwHello.close(map, originMarker);
				    google.maps.event.addListener(originMarker, 'click', function () {

					  	infowindow = new google.maps.InfoWindow();
					    infowindow.setContent('<div><p>I\'m an owl.  I\'m currently perched atop of <strong><i>the</i></strong> building with available apartment(s) which <strong>reduces your time in transit the most</strong>.  Not what you\'re looking for? I\'ve sorted all available listings on the market according to your travels.</p></div>');
					    infowindow.open(map, originMarker);

				    });
			    }, 6900);

	    	});

	        var mapCSS = document.getElementById('map').style;
    		mapCSS.right = 0;
    		mapCSS.top = 0;
    		mapCSS.width = '73%';

    		var sidebar = document.getElementById('sidebar').style;
    		var navbar = document.getElementById('navbar').style;
    		navbar.left = 0;
    		navbar.width = '27%';
    		sidebar.display = 'block';

			apartmentListings = document.getElementById('apartmentListings');			
			var listingDetails;
			

    		for (var i = 0; i < sortedOriginsArray.length; i++) {

	    			nu = document.createElement('div');
					var buildingIdAttr = document.createAttribute("building-id");       
					var commuteRankAttr = document.createAttribute("commute-rank");       
	    			nu.className = 'bldg-id-'+sortedOriginsArray[i].id+'';
					buildingIdAttr.value = ''+sortedOriginsArray[i].id+''; 
					commuteRankAttr.value = ''+i+''; 
					nu.setAttributeNode(buildingIdAttr);    
					nu.setAttributeNode(commuteRankAttr);    
					var commuteRank = nu.getAttribute('commute-rank');
					commuteRank++;

					Number.prototype.between = function (min, max) {
					    return this > min && this < max;
					};

					var suffix = function (commuteRank) {
						var lastDigit = commuteRank % 10;
						if(lastDigit===0){suffix='th';return suffix;}
							else if(lastDigit===1 && commuteRank != 11){suffix='st';return suffix;} 
								else if (lastDigit===2 && commuteRank != 12) {suffix='nd'; return suffix;}
									else if (lastDigit===3 && commuteRank != 13) {suffix='rd'; return suffix;}
										else if (3 < lastDigit < 10) {suffix='th'; return suffix;}
											else if (commuteRank.between(3,21)) {suffix='th'; return suffix;}
												else {console.log(suffix);}
					}

					nu.innerHTML = '<h2>'+'<span class="pull-right" style="font-size:36px;color:#2C3E50;position:relative;bottom:5px;text-shadow:white 2px 2px;">'+commuteRank+'<sup>'+suffix(commuteRank)+'</sup></span>'+sortedOriginsArray[i].title+'</h2><h4>'+sortedOriginsArray[i].address+'</h4><h4 style="pull-left"><strong style="font-size:30px;">'+sortedOriginsArray[i].duration+' </strong></h4><p style="font-size:18px;">hours per year in transit</p></h4>';

					nu.addEventListener('click', function () {
						activeBldgSelection = document.getElementById('active-bldg-selection');
						activeBldgSelection.innerHTML = '<h2>'+document.getElementById('bldg-title').innerHTML+'</h2><h4>'+document.getElementById('bldg-address').innerHTML+'</h4><h4><strong style="font-size:30px;">'+document.getElementById('bldg-duration').innerHTML+' </strong></h4><p style="font-size:18px;">hours per year in transit</p></h4><hr>';
						var apartmentListingsChildren = apartmentListings.childNodes;
						for (var ii = 0; ii < apartmentListingsChildren.length; ii++) {
							apartmentListingsChildren[ii].removeAttribute('id');
						}

					});
					apartmentListings.appendChild(nu);
					
					
	    	}

	    	var index = 0;
			apartmentListings.firstChild.id = 'active-bldg-selection';
			activeBldgSelection = document.getElementById('active-bldg-selection');
			for (var i = 0; i < apartments.length; i++) {
				if(activeBldgSelection.getAttribute('building-id') == apartments[i].building_id) {
					aptCount = apartments[i].building_id.length;
					if (aptCount>=2) {
						aptPriceRangeMin = Math.min(apartments[i].price);
						aptPriceRangeMax = Math.max(apartments[i].price);
						aptPriceRange = ''+aptPriceRangeMax+' - $'+aptPriceRangeMin+'';
					} else {
						aptPriceRange = ''+apartments[x].price+'';
						var aptCount = 1;
					}
				}
			}

			activeBldgSelection = document.getElementById('active-bldg-selection');
			activeBldgSelection.innerHTML = '<div id="active-selection" class="well" style=""><h3><strong id="bldg-title">'+'<span class="pull-right" style="font-size:42px;color:#2C3E50;position:relative;bottom:5px;text-shadow:white 2px 2px;">'+blackDoveId+'<sup>st</sup></span><br>'+sortedOriginsArray[0].title+'</strong></h3><h5 id="bldg-address">'+sortedOriginsArray[0].address+'</h5><img src="{{ asset("/images/bldg-thumb.jpg") }}" width="75%"/><h4><strong id="bldg-duration" style="font-size:30px;color:white;">'+sortedOriginsArray[0].duration+' </strong></h4><p style="font-size:18px;">hours per year in transit</p></h4><hr><div id="bldg-listings"></div>;'

			activeBldgDetails = document.getElementById('bldg-listings');
			activeBldgDetails.innerHTML = '<h4><strong style="font-size:24px;color:white;">'+aptCount+'</strong> available unit(s)</h4><h4><strong style="font-size:24px;color:white;">$'+aptPriceRangeMax+' - $'+aptPriceRangeMin+'</strong> per month</h4><i id="expand-apt-listings" class="fa fa-caret-up" style="font-size:36px;color:white;display:none;"></i><i id="collapse-apt-listings" class="fa fa-caret-down" style="font-size:36px;color:green;"></i></div><span id="listing-details"></span>';

					
			

			var apartmentListingsChildren = apartmentListings.childNodes;

			for (var i = 0; i < apartmentListingsChildren.length; i++) {

					apartmentListingsChildren[i].addEventListener('click', function () {


						this.id = 'active-bldg-selection';
						// var index = 0;
						activeBldgSelection = document.getElementById('active-bldg-selection');
						for (var x = 0; x < apartments.length; x++) {
							if(this.getAttribute('building-id') == apartments[x].building_id) {
								console.log(apartments[x].building_id);
								aptCount = apartments[x].building_id.length;
								if (aptCount>=2) {
								aptPriceRangeMin = Math.min(apartments[x].price);
								aptPriceRangeMax = Math.max(apartments[x].price);
								aptPriceRange = ''+aptPriceRangeMax+' - $'+aptPriceRangeMin+'';
								// index++;	
								} else {
								aptPriceRange = ''+apartments[x].price+'';
								var aptCount = 1;
								}
							}
						}
						if(aptCount == undefined){
							aptCount = 0;
						}

						activeBldgSelection.innerHTML = '<div id="active-selection" class="well"><h4 style="pull-left"><strong id="bldg-title">'+activeBldgSelection.childNodes[0].innerHTML+'</strong></h4><h5 id="bldg-address">'+activeBldgSelection.childNodes[1].innerHTML+'</h5><img src="{{ asset("/images/bldg-thumb.jpg") }}" width="75%"/><h4><strong id="bldg-duration" style="font-size:30px;color:white;">'+activeBldgSelection.childNodes[2].innerHTML+' </strong></h4><p style="font-size:18px;">hours per year in transit</p></h4><hr><div id="bldg-listings"></div></div>';

						activeBldgDetails = document.getElementById('bldg-listings');
						activeBldgDetails.innerHTML = '<h4><strong style="font-size:24px;color:white;">'+aptCount+'</strong> available unit(s)</h4><h4><strong style="font-size:24px;color:white;">$'+aptPriceRange+'</strong> per month</h4><i id="expand-apt-listings" class="fa fa-caret-up" style="font-size:36px;color:white;display:none;"></i><i id="collapse-apt-listings" class="fa fa-caret-down" style="font-size:36px;color:green;"></i></div><span id="listing-details"></span>';

					    listingDetails = document.getElementById('listing-details');
							
						for (var iii = 0; iii < apartments.length; iii++) {
							if(activeBldgSelection.getAttribute('building-id') == apartments[iii].building_id) {
								var apt = document.createElement('div');
								apt.innerHTML = "<hr><h4>"+apartments[iii].bed+" bed / "+apartments[iii].bath+" bath</h4><h4><strong>$"+apartments[iii].price+"</strong></h4><br><div class='row'><div class='col-xs-6'><ul><li>Unit "+apartments[iii].unit+"</li><li>"+apartments[iii].sqft+" sq/ft</li></ul></div><div class='col-xs-6'><img class='img-responsive' src='{{ asset('/images/studio-thumb.jpg') }}'></div></div>";
								listingDetails.appendChild(apt);
							}
							
						}

						listingDetails.style.display = 'none';

						this.addEventListener("click", function () {
							if(listingDetails.style.display == 'none'){
								listingDetails.style.display = 'block';
							}else{
								listingDetails.style.display = 'none';
							};
						});

						pigeons();

						commuteRank = this.getAttribute('commute-rank');
						// console.log(commuteRank);
						// console.log(sortedOriginsArray[commuteRank]);

						theBlackDove = {lat: sortedOriginsArray[commuteRank].lat, lng: sortedOriginsArray[commuteRank].lng}; 
						blackDoveAddress = sortedOriginsArray[commuteRank].address;
						blackDoveTitle = sortedOriginsArray[commuteRank].title;

				        originMarker = new google.maps.Marker({
				            position: theBlackDove,
				            map: map,
				            flat: false,
				            icon: mascot
				        });				

				        originMarker.setVisible(true);
				        markersArray.push(originMarker); 

						for (var ii = 0; ii < passage.length; ii++) {
							passage[ii].setMap(null);
						}
					});

			}

			// apartmentListings.firstChild.id = 'active-bldg-selection';
			// activeBldgSelection = document.getElementById('active-bldg-selection');

		};

		var pigeons = function pigeons () {

			for (var ii = 0; ii < passage.length; ii++) {
				passage[ii].setMap(null);
			}			

			for (var i = 0; i < markersArray.length; i++) {
				if (markersArray[i].icon.url == "/images/cardinal-icon.png") {
					markersArray[i].setMap(null);
				}
			}

			var service = new google.maps.DistanceMatrixService();
			
			service.getDistanceMatrix({
	    		origins: [theBlackDove],
	    		destinations: destinationsArray,
	    		travelMode: google.maps.TravelMode.TRANSIT,
	    	}, function (result, status) {

	        	var bounds = new google.maps.LatLngBounds();
				for (var i = 0; i < markersArray.length; i++) {
					bounds.extend(markersArray[i].getPosition());
				}

				map.fitBounds(bounds);
				map.panBy(222, 0);

				setTimeout(function() {

					setTimeout(function() {
						calcRouteWork();	
					}, 400);
					setTimeout(function() {
						calcRouteOne();
					}, 750);
					setTimeout(function() {
						calcRouteTwo();	
					}, 900);
					setTimeout(function() {
						calcRouteThree();	
					}, 1000);

				}, 200);
				
	    	});


		}
			
		function calcRouteWork() {
				var start = theBlackDove;
				var end = workplace;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT,
				transitOptions: {
						// departureTime: new Date(1459857600),
						 // modes: [google.maps.TransitMode.RAIL]
					}
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {

					console.log(result);

				   	var routeWorkOverviewPath = result.routes[0].overview_path;

				   	console.log(routeWorkOverviewPath);

					var pathCoords = [];

					var idx = 0;
				
					// pathCoords.push(theBlackDove);

					var animateLineDraw = window.setInterval(function() {	

						if (idx < routeWorkOverviewPath.length) {

							var routeLatLng = {lat: routeWorkOverviewPath[idx].lat(), lng: routeWorkOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathWork = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeWeight: 4,
								strokeColor: '#763A7A',
								strokeOpacity: 1,
								zIndex: 100,
							    map: map

							});
							pathWork.setMap(map);
							passage.push(pathWork);
							idx++

						} else {

							window.clearInterval(animateLineDraw);

							workplaceMarker.addListener('click', function() {

								workplaceMarker.setVisible(false);
								markersArray[1].setVisible(true);
								markersArray[2].setVisible(true);
								markersArray[3].setVisible(true);

								pathWork.setVisible(false);
								pathOne.setVisible(true);
								pathTwo.setVisible(true);
								pathThree.setVisible(true);

								directionsDisplay.setDirections(result);

							});				
						}		

					},1);
				}
			});
		}

		function calcRouteOne() {
				var start = theBlackDove;
				var end = freq_loc_1;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT,
				transitOptions: {
						// departureTime: new Date(1459857600),
						 // modes: [google.maps.TransitMode.RAIL]
					}
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {

					var routeOneOverviewPath = result.routes[0].overview_path;
					var routeOneSteps = result.routes[0].legs[0].steps;

					console.log(routeOneSteps);

					var pathCoords = [];

					var idx = 0;

					var animateLineDraw = window.setInterval(function() {		

						if (idx < routeOneOverviewPath.length) {

							var routeLatLng = {lat: routeOneOverviewPath[idx].lat(), lng: routeOneOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathOne = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeWeight: 4,
								strokeColor: '#FE6F69',
								strokeOpacity: 1,
								zIndex: 200,
								map: map

							});
							pathOne.setMap(map);
							passage.push(pathOne);
							idx++;

						} else {

							window.clearInterval(animateLineDraw);

							markersArray[1].addListener('click', function() {

								workplaceMarker.setVisible(true);
								markersArray[1].setVisible(false);
								markersArray[2].setVisible(true);
								markersArray[3].setVisible(true);

							    pathWork.setVisible(true);
							    pathOne.setVisible(false);
								pathTwo.setVisible(true);
								pathThree.setVisible(true);

								directionsDisplay.setDirections(result);

							});
						}

					},1);
				};
			});
		};

		function calcRouteTwo() {
				var start = theBlackDove;
				var end = freq_loc_2;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT,
				transitOptions: {
						// departureTime: new Date(1459857600),
						 // modes: [google.maps.TransitMode.RAIL]
					}
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {

					var routeTwoOverviewPath = result.routes[0].overview_path;

					var pathCoords = [];

					var idx = 0;

					var animateLineDraw = window.setInterval(function() {		

						if (idx < routeTwoOverviewPath.length) {

							var routeLatLng = {lat: routeTwoOverviewPath[idx].lat(), lng: routeTwoOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathTwo = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeWeight: 4,
								strokeColor: '#00b300',
								strokeOpacity: 1,
								zIndex: 300,
								map: map
							});
						  	pathTwo.setMap(map);
					  		passage.push(pathTwo);
							idx++;

						} else {

						  	window.clearInterval(animateLineDraw);
							 
							markersArray[2].addListener('click', function() {
								
								workplaceMarker.setVisible(true);
								markersArray[1].setVisible(true);
								markersArray[2].setVisible(false);
								markersArray[3].setVisible(true);

								pathWork.setVisible(true);
								pathOne.setVisible(true);
								pathTwo.setVisible(false);
								pathThree.setVisible(true);

								directionsDisplay.setDirections(result);

							});

						}
 

					},1);

				};
			});
		};

		function calcRouteThree() {
				var start = theBlackDove;
				var end = freq_loc_3;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT,
				transitOptions: {
						// departureTime: new Date(1459857600),
						 // modes: [google.maps.TransitMode.RAIL]
					}
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {

					var routeThreeOverviewPath = result.routes[0].overview_path;

					var pathCoords = [];
				   
					var idx = 0;

					var animateLineDraw = window.setInterval(function() {		
					
						if (idx < routeThreeOverviewPath.length) {

							var routeLatLng = {lat: routeThreeOverviewPath[idx].lat(), lng: routeThreeOverviewPath[idx].lng()};
							pathCoords.push(routeLatLng);
							pathThree = new google.maps.Polyline({
								path: pathCoords,
								geodesic: true,
								strokeWeight: 4,
								strokeColor: '#247BA0',
								strokeOpacity: 1,
								zIndex: 400,
								map: map
							});
							pathThree.setMap(map);
							passage.push(pathThree);
							idx++;

						} else {

							window.clearInterval(animateLineDraw);

							markersArray[3].addListener('click', function() {
								

								pathWork.setVisible(true);
								pathOne.setVisible(true);
								pathTwo.setVisible(true);
								pathThree.setVisible(false);

								workplaceMarker.setVisible(true);
								markersArray[1].setVisible(true);
								markersArray[2].setVisible(true);
								markersArray[3].setVisible(false);

								// originMarker.setVisible(false);
								
								directionsDisplay.setDirections(result);
							});
						}

					},1);
				};
			});
		}

	@endif
	
	}
}






// MOBILE




// if ($(window).width() < 600 ) {

//  var init = function minitialize() {

//     	var directionsService = new google.maps.DirectionsService;
// 		var directionsDisplay = new google.maps.DirectionsRenderer(
// 		{
// 			suppressMarkers: true
// 		});
// 		var geocoder = new google.maps.Geocoder();
	    
// 		var styles = [
// 			{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":20},{"color":"#ececec"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ececec"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"lightness":21},{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#303030"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"geometry.stroke","stylers":[{"lightness":"-61"},{"gamma":"0.00"},{"visibility":"off"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#dadada"},{"lightness":17}]}
// 		];

// 		var styledMapMobile = new google.maps.StyledMapType(styles, {name: "Styled Map"});

// 		var mapOptions = {
// 			center: {lat:40.72, lng: -73.978},
// 			zoom: 13,
// 			scrollwheel: true,
// 			mapTypeControl: false,
// 			mapTypeControlOptions: {
// 			  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
// 			}
// 		};

// 		mapMobile = new google.maps.Map(document.getElementById('map-mobile'), mapOptions);

// 		mapMobile.mapTypes.set('map_style', styledMapMobile);
// 		mapMobile.setMapTypeId('map_style');

// 		directionsDisplay.setMap(mapMobile);

// 		var workplaceInput = document.getElementById('workplace-search-input');
// 		var freqLocInput1 = document.getElementById('freq-loc-input-1');
// 		var freqLocInput2 = document.getElementById('freq-loc-input-2');
// 		var freqLocInput3 = document.getElementById('freq-loc-input-3');

// 		var workplaceCoordsInput = document.getElementById('workplace-coords-input');
// 		var freqLocCoordsInput1 = document.getElementById('freq-loc-coords-input-1');
// 		var freqLocCoordsInput2 = document.getElementById('freq-loc-coords-input-2');
// 		var freqLocCoordsInput3 = document.getElementById('freq-loc-coords-input-3');

// 		// Create the autocomplete helper, and associate it with
// 		// an HTML text input box.
// 		var autocompleteWorkplace = new google.maps.places.Autocomplete(workplaceInput);
// 		var autocompleteFreqLoc1 = new google.maps.places.Autocomplete(freqLocInput1);
// 		var autocompleteFreqLoc2 = new google.maps.places.Autocomplete(freqLocInput2);
// 		var autocompleteFreqLoc3 = new google.maps.places.Autocomplete(freqLocInput3);

// 		autocompleteWorkplace.bindTo('bounds', mapMobile);
// 		autocompleteFreqLoc1.bindTo('bounds', mapMobile);
// 		autocompleteFreqLoc2.bindTo('bounds', mapMobile);
// 		autocompleteFreqLoc3.bindTo('bounds', mapMobile);

// 		google.maps.event.addListener(autocompleteWorkplace, 'place_changed', function() {

// 			var workplaceCoordinates = autocompleteWorkplace.getPlace();
// 			var wpLat = workplaceCoordinates.geometry.location.lat();
// 			var wpLng = workplaceCoordinates.geometry.location.lng();
			
// 			workplaceCoordsInput.value = wpLat+', '+wpLng;
// 			console.log(workplaceCoordsInput.value);

// 		});
// 		google.maps.event.addListener(autocompleteFreqLoc1, 'place_changed', function() {

// 			var freqLoc1Coordinates = autocompleteFreqLoc1.getPlace();
// 			var freqLoc1Lat = freqLoc1Coordinates.geometry.location.lat();
// 			var freqLoc1Lng = freqLoc1Coordinates.geometry.location.lng();
			
// 			freqLocCoordsInput1.value = freqLoc1Lat+', '+freqLoc1Lng;
// 			console.log(freqLocCoordsInput1.value);

// 		});
// 		google.maps.event.addListener(autocompleteFreqLoc2, 'place_changed', function() {
			
// 			var freqLoc2Coordinates = autocompleteFreqLoc2.getPlace();
// 			var freqLoc2Lat = freqLoc2Coordinates.geometry.location.lat();
// 			var freqLoc2Lng = freqLoc2Coordinates.geometry.location.lng();
			
// 			freqLocCoordsInput2.value = freqLoc2Lat+', '+freqLoc2Lng;
// 			console.log(freqLocCoordsInput2.value);
// 		});
// 		google.maps.event.addListener(autocompleteFreqLoc3, 'place_changed', function() {
			
// 			var freqLoc3Coordinates = autocompleteFreqLoc3.getPlace();
// 			var freqLoc3Lat = freqLoc3Coordinates.geometry.location.lat();
// 			var freqLoc3Lng = freqLoc3Coordinates.geometry.location.lng();
			
// 			freqLocCoordsInput3.value = freqLoc3Lat+', '+freqLoc3Lng;
// 			console.log(freqLocCoordsInput3.value);

// 		});


// 	@if(Route::currentRouteName() == 'dovetail')

// 		// PULL WORKPLACES / FREQUENTED LOCATIONS / APARTMENT BUILDINGS FROM DB

// 		workplaces = [
// 		    @foreach ($workplace as $wp)
// 		        [ {{ $wp->lat }}, {{ $wp->lng }}, "{{ $wp->title }}", "{{ $wp->address }}", "{{ $wp->city }}", "{{ $wp->state }}" ]    
// 		    @endforeach
// 	    ];

// 		frequentedLocations = [
// 		    @foreach ($frequented_locations as $fl)
// 		        [ {{ $fl->lat }}, {{ $fl->lng }}, "{{ $fl->title }}", "{{ $fl->address }}", "{{ $fl->city }}", "{{ $fl->state }}" ], 
// 		    @endforeach
// 	    ];

// 		buildings = [
// 		    @foreach ($buildings as $b)
// 		        [ {{ $b->lat }}, {{ $b->lng }}, "{{ $b->title }}", "{{ $b->address }}", "{{ $b->city }}", "{{ $b->state }}", "{{ $b->zip }}", "{{ $b->country }}" ], 
// 		    @endforeach
// 	    ];


// 		var service = new google.maps.DistanceMatrixService();

// 		var workplaceMarker = new google.maps.MarkerImage("http://walkersstuff.com/wp-content/uploads/2015/06/stepThree.png", null, null, null, new google.maps.Size(20,20));

// 		var destinationMarker = new google.maps.MarkerImage("http://www.envirovent.com/img/location-trade.png", null, null, null, new google.maps.Size(24,30));

// 		var mascot = new google.maps.MarkerImage("/images/cardinal-icon.png", null, null, null, new google.maps.Size(60,60));

// 	    for (i = 0; i < workplaces.length; i++) {

// 	        workplace = new google.maps.LatLng(workplaces[i][0], workplaces[i][1]);

// 	        workplaceMarkerMobile = new google.maps.Marker({
// 	            position: workplace,
// 	            map: mapMobile,
// 	            icon: destinationMarker
// 	        });

// 	        markersArrayMobile.push(workplaceMarkerMobile);
		
// 			// infowindow = new google.maps.InfoWindow();
// 	  //       infowindow.setContent('<div>'+workplaces[i][2]+'<br>'+workplaces[i][3]+', '+workplaces[i][4]+', '+workplaces[i][5]+'</div>');
// 	  //       infowindow.open(map, marker);
// 	    }

// 	    var freqLocArray = [];
// 	    var freqLoc;

// 	    for (i = 0; i < frequentedLocations.length; i++) {

// 	    	freqLoc = new google.maps.LatLng(frequentedLocations[i][0], frequentedLocations[i][1]);

// 	        freqLocArray.push(freqLoc);

// 	        markerMobile = new google.maps.Marker({
// 	            position: freqLoc,
// 	            map: mapMobile,
// 	            icon: destinationMarker,
// 	            zIndex: 100
// 	        }); 

// 	        markersArrayMobile.push(markerMobile);

// 			// infowindow = new google.maps.InfoWindow();
// 	  //       infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
// 	  //       // infowindow.open(map, marker);
// 	    }

// 		var tripDuration = [];

// 	    var pathWork;
// 	    var pathOne;
// 	    var pathTwo;
// 	    var pathThree;

// 	    var pathWorkMobile;
// 	    var pathOneMobile;
// 	    var pathTwoMobile;
// 	    var pathThreeMobile;

// 	    var workRouteDuration;
// 	    var routeOneDuration;
// 	    var routeTwoDuration;
// 	    var routeThreeDuration;

// 	    var callbackResponseArray = [];

// 		var sumOfDurationFromOrigins = [];
// 		var aggregateDurationArray = [];
// 		var sortedOriginsArray = [];

// 		var blackDoveDuration;

// 		var minimumTripDuration;
// 	    var originArray = [];


// 	    freq_loc_1 = new google.maps.LatLng(freqLocArray[0].lat(), freqLocArray[0].lng());
// 	    freq_loc_2 = new google.maps.LatLng(freqLocArray[1].lat(), freqLocArray[1].lng());
// 	    freq_loc_3 = new google.maps.LatLng(freqLocArray[2].lat(), freqLocArray[2].lng());
	    

// 	    for (var i = 0; i < buildings.length; i++) {

// 	    	originArray.push({
// 	    		lat: buildings[i][0], 
// 	    		lng: buildings[i][1], 
// 	    		title: buildings[i][2], 
// 	    		address: buildings[i][3]+', '+buildings[i][4]+', '+buildings[i][5]+' '+buildings[i][6]+', '+buildings[i][7]
// 	    	});

// 	    }

// 	    var service = new google.maps.DistanceMatrixService();

// 	    whiteDoves = [];

// 	    (function serv() {

// 		    for (var i = 0; i < originArray.length; i++) {
// 		    	console.log(originArray[i]);
// 		    	whiteDoves.push({lat: originArray[i].lat, lng: originArray[i].lng}); 
// 	    	}

// 	    	service.getDistanceMatrix(
// 	    	{
// 	    		origins: whiteDoves,
// 	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3],
// 	    		travelMode: google.maps.TravelMode.TRANSIT,
// 	    	}, callback); 
	    
// 	    })();
		
//     	// TEST NEW CALLBACK HANDLER

// 		var whiteDoveOrigins = [];

// 		function callback(response, status) {

// 			callbackResponseArray.push(response);
// 			console.log(callbackResponseArray);

// 			for (var w = 0; w < callbackResponseArray[0].originAddresses.length; w++) {
// 				whiteDoveOrigins.push({title: originArray[w].title, address: originArray[w].address, elements: callbackResponseArray[0].rows[w].elements});
// 			}

// 			calculateTotalDurationFromOrigins();
// 			pathThreeMobile
// 		}

// 		function calculateTotalDurationFromOrigins() {
			
// 			var counter = 0;
// 			var totalDuration = 0;
// 			var intermediateDurationsArray = [];

// 			for (var idx = 0; idx < whiteDoveOrigins.length; idx++) {

// 				console.log(whiteDoveOrigins[idx]);

// 				whiteDoveOrigins[idx].elements.forEach(function(k,v){
					
// 					if(v == 0){

// 						intermediateDurationsArray.push((((k.duration.value * 5 * 52)/60)/60));

// 					} else if(v == 1){

// 						intermediateDurationsArray.push((((k.duration.value * 1 * 52)/60)/60));

// 					} else if(v == 2){

// 						intermediateDurationsArray.push((((k.duration.value * 1 * 52)/60)/60));

// 					} else if(v == 3){
						
// 						intermediateDurationsArray.push((((k.duration.value * 1 * 52)/60)/60));

// 						for (var y = 0; y < intermediateDurationsArray.length; y++) {
// 							totalDuration += (intermediateDurationsArray[y]);
// 						}	

// 						sumOfDurationFromOrigins.push({origin: whiteDoveOrigins[counter].address, originTitle: whiteDoveOrigins[counter].title, duration: parseInt(totalDuration)});
// 						totalDuration=0;
// 						intermediateDurationsArray = [];
// 						counter++;

// 					}

// 				});

// 			}

// 			console.log(sumOfDurationFromOrigins);

// 			findMinDurationOrigin();

// 		};

// 		function findMinDurationOrigin() {

// 			aggregateDurationArray = [];

// 			Array.min = function(){
// 				for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
// 					aggregateDurationArray.push(sumOfDurationFromOrigins[i].duration);
// 				}
// 			    return Math.min.apply(Math, aggregateDurationArray);
// 			};
// 			minimumTripDuration = Array.min(aggregateDurationArray);

// 			for (var i = 0; i < sumOfDurationFromOrigins.length; i++) {
// 				if(sumOfDurationFromOrigins[i].duration === minimumTripDuration) {
// 					theBlackDove = sumOfDurationFromOrigins[i].origin;
// 					blackDoveDuration = sumOfDurationFromOrigins[i].duration;
// 				};
// 			 }

// 			 orderListingsByDuration();

// 		}

// 		function orderListingsByDuration () {
			
// 			sortedOriginsArray = [];
			
// 			aggregateDurationArray.sort(function(a, b){return a-b});

// 			for (var x = 0; x < sumOfDurationFromOrigins.length; x++) {
// 				for (var y = 0; y < aggregateDurationArray.length; y++) {
// 					if(sumOfDurationFromOrigins[x].duration === aggregateDurationArray[y]) {
// 						sortedOriginsArray.push({duration: aggregateDurationArray[y], address: sumOfDurationFromOrigins[x].origin, title: sumOfDurationFromOrigins[x].originTitle});
// 					}
// 				}
// 			}

// 			sortedOriginsArray.sort(function(a,b){return a.duration - b.duration});
// 			console.log(sortedOriginsArray);
			
// 			findMatchingDatabaseRecord();

// 		}

// 		function findMatchingDatabaseRecord() {

// 			var simArray = [];

// 			 for (var i = 0; i < originArray.length; i++) {
			 	
// 			 	var a = theBlackDove;
// 			 	var b = originArray[i].address;
// 				var zip_a = theBlackDove.match(/\b\d{5}\b/g);
// 				var zip_b = originArray[i].address.match(/\b\d{5}\b/g);

// 			    var equivalency_fullstr = 0;
// 			    var equivalency_zip = 0;
			    
// 			    var minLength = (a.length > b.length) ? b.length : a.length;    
// 			    var maxLength = (a.length < b.length) ? b.length : a.length;    
// 			    var minLengthZip = (zip_a.length > zip_b.length) ? zip_b.length : zip_a.length;    
// 			    var maxLengthZip = (zip_a.length < zip_b.length) ? zip_b.length : zip_a.length;  

// 			    for(var k = 0; k < minLength; k++) {
// 			        if(a[k] == b[k]) {
// 			            equivalency_fullstr++;
// 			        }
// 			    }
// 			    for(var kk = 0; kk < minLengthZip; kk++) {
// 			        if(zip_a[kk] == zip_b[kk]) {
// 			            equivalency_zip++;
// 			        }
// 			    }
			    
// 			    var weight_address = equivalency_fullstr / maxLength;
// 			    var weight_zip = equivalency_zip / maxLengthZip;

// 			    simArray.push({ whiteDoves: originArray[i], weight: ((weight_address * 100) + (weight_zip * 100)) });

// 			 }

// 			 var weightArray = [];

// 			 Array.max = function(){
// 				for (var i = 0; i < simArray.length; i++) {
// 					weightArray.push(simArray[i].weight);
// 				}
// 			    return Math.max.apply(Math, weightArray);
// 			};

// 			maxWeight = Array.max(weightArray);
// 			console.log(maxWeight);

// 			for (var i = 0; i < simArray.length; i++) {
// 				if(simArray[i].weight === maxWeight) {
// 					console.log(simArray[i]);
// 	    			theBlackDove = {lat: simArray[i].whiteDoves.lat, lng: simArray[i].whiteDoves.lng}; 
// 	    			blackDoveAddress = simArray[i].whiteDoves.address;
// 	    			blackDoveTitle = simArray[i].whiteDoves.title;
// 				}
// 			}

// 			dovetailor();

// 		}

// 		function dovetailor () {

// 			var service = new google.maps.DistanceMatrixService();

// 	        originMarkerMobile = new google.maps.Marker({
// 	            position: theBlackDove,
// 	            map: mapMobile,
// 	            flat: false,
// 	            icon: mascot
// 	        });

// 	        markersArrayMobile.push(originMarkerMobile);

// 	        var mapMobileCSS = document.getElementById('map-mobile').style;
// 	        mapMobileCSS.height = '400px';
//     		mapMobileCSS.width = '100%';

//     		var sidebar = document.getElementById('sidebar').style;
//     		var navbar = document.getElementById('navbar').style;
//     		navbar.left = 0;
//     		sidebar.display = 'block';

//     		var primeLocationMobile = document.getElementById('primeLocationMobile');
// 			var apartmentListingsMobile = document.getElementById('apartmentListingsMobile');

//     		primeLocationMobile.innerHTML = '<div id="active-bldg-selection-mobile" class="well"><h3><strong>'+blackDoveTitle+'</strong></h3><h5>'+blackDoveAddress+'</h5><hr><img src="{{ asset("/images/bldg-thumb.jpg") }}" width="75%"/><h4><hr><strong style="font-size:30px;color:white;">'+blackDoveDuration+' </strong><p style="font-size:18px;display:inline;">hours per year in transit</p></h4><hr><div id="bldg-listings-mobile"><h4><strong style="font-size:24px;color:white;">3</strong> available units</h4><h4><strong style="font-size:24px;color:white;">$1500 - $3250</strong> per month</h4><i id="expand-bldg-listings-mobile" class="fa fa-caret-down" style="font-size:36px;"></i><i id="collapse-bldg-listings-mobile" class="fa fa-caret-up" style="font-size:36px;color:white;display:none;"></i></div><div id="listing-details-mobile"></div></div><hr>';

// 	    	primeLocationMobile.style.color = 'white';

// 	    	var expandBldgListingsMobile = document.getElementById('expand-bldg-listings-mobile');

// 	    	var collapseBldgListingsMobile = document.getElementById('collapse-bldg-listings-mobile');

// 			var listingDetailsMobile = document.getElementById('listing-details-mobile');

// 			expandBldgListingsMobile.addEventListener('click', function() {

// 				this.style.display = 'none';
// 				collapseBldgListingsMobile.style.display = 'block';

// 				listingDetailsMobile.innerHTML = "<hr><h4>Studio</h4><h4><strong>$1500</strong></h4><br><div class='row'><div class='col-xs-6'><ul><li>Furnished</li><li>Newly-Renovated</li></ul></div><div class='col-xs-6'><img class='img-responsive' src='{{ asset('/images/studio-thumb.jpg') }}'></div></div><hr><h4>One Bedroom</h4><h4><strong>$2000</strong></h4><br><div class='row'><div class='col-xs-6'><ul><li>In-Unit Laundry</li><li>Dogs OK</li></ul></div><div class='col-xs-6'><img class='img-responsive' src='{{ asset('/images/1br-thumb.jpg') }}'></div></div><hr><h4>Two Bedroom</h4><h4><strong>$3250</strong></h4><br><div class='row'><div class='col-xs-6'><ul><li>Balcony</li><li>Dishwasher</li><li>360&deg; Views</li></ul></div><div class='col-xs-6'><img class='img-responsive' src='{{ asset('/images/2br-thumb.jpg') }}'></div></div>";
// 				listingDetailsMobile.style.display = 'block';
// 				// this.style.height = '100%';
// 			});

// 			collapseBldgListingsMobile.addEventListener('click', function() {
// 				this.style.display = 'none';
// 				expandBldgListingsMobile.style.display = 'block';
// 				listingDetailsMobile.style.display = 'none';
// 			});

//     		for (var idx = 1; idx < sortedOriginsArray.length; idx++) {
//     			var nutwo = document.createElement('div');
// 				nutwo.innerHTML = '<h2>'+sortedOriginsArray[idx].title+'</h2><h4>'+sortedOriginsArray[idx].address+'</h4><h4><strong style="font-size:30px;">'+sortedOriginsArray[idx].duration+' </strong><p style="font-size:18px;">hours per year in transit</p></h4><hr>';
// 				apartmentListingsMobile.appendChild(nutwo);
// 	    	}


// 			service.getDistanceMatrix({
// 	    		origins: [theBlackDove],
// 	    		destinations: [workplace, freq_loc_1, freq_loc_2, freq_loc_3],
// 	    		travelMode: google.maps.TravelMode.TRANSIT,
// 	    	}, function (result, status) {

// 	    		var bounds = new google.maps.LatLngBounds();

// 				for (var i = 0; i < markersArrayMobile.length; i++) {
// 					bounds.extend(markersArrayMobile[i].getPosition());
// 				}

// 				mapMobile.fitBounds(bounds);
// 				mapMobile.panBy(0, 80);

// 				calcRouteWork();


// 					calcRouteOne();


// 					calcRouteTwo();


// 					calcRouteThree();


// 	    	});

// 		}

// 		function calcRouteWork() {
// 				var start = theBlackDove;
// 				var end = workplace;
// 				var request = {
// 				origin:start,
// 				destination:end,
// 				travelMode: google.maps.TravelMode.TRANSIT,
// 				transitOptions: {
// 						// departureTime: new Date(1467777755501)
// 					}
// 				};
// 				directionsService.route(request, function(result, status) {
// 				if (status == google.maps.DirectionsStatus.OK) {

// 					console.log(result);

// 				   	var routeWorkOverviewPath = result.routes[0].overview_path;

// 					var pathCoords = [];

// 					var idx = 0;
				
// 					// pathCoords.push(theBlackDove);

// 					var animateLineDraw = window.setInterval(function() {	

// 						if (idx < routeWorkOverviewPath.length) {
// 							var routeLatLng = {lat: routeWorkOverviewPath[idx].lat(), lng: routeWorkOverviewPath[idx].lng()};
// 							pathCoords.push(routeLatLng);
// 							pathWorkMobile = new google.maps.Polyline({
// 								path: pathCoords,
// 								geodesic: true,
// 								strokeColor: 'red',
// 								strokeOpacity: 0.6,
// 								strokeWeight: 4
// 							});
// 							idx++;

// 						} else {

// 							pathWorkMobile.setMap(mapMobile);

// 							window.clearInterval(animateLineDraw);


// 							google.maps.event.addListener(workplaceMarkerMobile, 'click', function() {

								
// 								// workplaceMarker.setVisible(false);
// 								// markersArray[1].setVisible(true);
// 								// markersArray[2].setVisible(true);
// 								// markersArray[3].setVisible(true);

// 								pathWork.setVisible(false);
// 								pathOne.setVisible(true);
// 								pathTwo.setVisible(true);
// 								pathThree.setVisible(true);

// 								directionsDisplay.setDirections(result);

// 							});
							
// 						}

// 					}, 1);
// 				}
// 			});
// 		}

// 		function calcRouteOne() {
// 				var start = theBlackDove;
// 				var end = freq_loc_1;
// 				var request = {
// 				origin:start,
// 				destination:end,
// 				travelMode: google.maps.TravelMode.TRANSIT,
// 				transitOptions: {
// 						// departureTime: new Date(1467777755501)
// 					}
// 				};
// 				directionsService.route(request, function(result, status) {
// 				if (status == google.maps.DirectionsStatus.OK) {

// 					var routeOneOverviewPath = result.routes[0].overview_path;
// 					var routeOneSteps = result.routes[0].legs[0].steps;

// 					console.log(routeOneSteps);

// 					var pathCoords = [];

// 					var idx = 0;

// 					// pathCoords.push(theBlackDove);

// 					var animateLineDraw = window.setInterval(function() {
						
// 						if (idx < routeOneOverviewPath.length) {
// 							var routeLatLng = {lat: routeOneOverviewPath[idx].lat(), lng: routeOneOverviewPath[idx].lng()};
// 							pathCoords.push(routeLatLng);
// 							pathOneMobile = new google.maps.Polyline({
// 								path: pathCoords,
// 								geodesic: true,
// 								strokeColor: 'blueviolet',
// 								strokeOpacity: 0.6,
// 								strokeWeight: 4
// 							});
// 							idx++;

// 						} else {
							
// 							pathOneMobile.setMap(mapMobile);

// 							window.clearInterval(animateLineDraw);


// 							google.maps.event.addListener(markersArrayMobile[1], 'click', function() {

// 								// workplaceMarker.setVisible(true);
// 								// markersArrayMobile[1].setVisible(false);
// 								// markersArrayMobile[2].setVisible(true);
// 								// markersArrayMobile[3].setVisible(true);

// 							    pathWork.setVisible(true);
// 							    pathOne.setVisible(false);
// 								pathTwo.setVisible(true);
// 								pathThree.setVisible(true);

// 								directionsDisplay.setDirections(result);

// 							});
// 						}

// 					}, 1);
						


// 				}
// 			});
// 		}

// 		function calcRouteTwo() {
// 				var start = theBlackDove;
// 				var end = freq_loc_2;
// 				var request = {
// 				origin:start,
// 				destination:end,
// 				travelMode: google.maps.TravelMode.TRANSIT,
// 				transitOptions: {
// 						// departureTime: new Date(1467777755501)
// 					}
// 				};
// 				directionsService.route(request, function(result, status) {
// 				if (status == google.maps.DirectionsStatus.OK) {

// 					var routeTwoOverviewPath = result.routes[0].overview_path;

// 					var pathCoords = [];

// 					var idx = 0;

// 					// pathCoords.push(theBlackDove);

// 					var animateLineDraw = window.setInterval(function() {
						
// 						if (idx < routeTwoOverviewPath.length) {
// 							var routeLatLng = {lat: routeTwoOverviewPath[idx].lat(), lng: routeTwoOverviewPath[idx].lng()};
// 							pathCoords.push(routeLatLng);
// 							pathTwoMobile = new google.maps.Polyline({
// 								path: pathCoords,
// 								geodesic: true,
// 								strokeColor: 'purple',
// 								strokeOpacity: 0.6,
// 								strokeWeight: 4
// 							});
// 							idx++;

// 						} else {

// 							pathTwoMobile.setMap(mapMobile);

// 						  window.clearInterval(animateLineDraw);
						  
// 									google.maps.event.addListener(markersArrayMobile[2], 'click', function() {
									
// 									// workplaceMarker.setVisible(true);
// 									// markersArrayMobile[1].setVisible(true);
// 									// markersArrayMobile[2].setVisible(false);
// 									// markersArrayMobile[3].setVisible(true);

// 									pathWork.setVisible(true);
// 									pathOne.setVisible(true);
// 									pathTwo.setVisible(false);
// 									pathThree.setVisible(true);

// 									directionsDisplay.setDirections(result);

// 								});

// 						}

// 					}, 1);

// 				}
// 			});
// 		}

// 		function calcRouteThree() {
// 				var start = theBlackDove;
// 				var end = freq_loc_3;
// 				var request = {
// 				origin:start,
// 				destination:end,
// 				travelMode: google.maps.TravelMode.TRANSIT,
// 				transitOptions: {
// 						// departureTime: new Date(1467777755501)
// 					}
// 				};
// 				directionsService.route(request, function(result, status) {
// 				if (status == google.maps.DirectionsStatus.OK) {

// 					var routeThreeOverviewPath = result.routes[0].overview_path;

// 					var pathCoords = [];
				   
// 					var idx = 0;

// 					// pathCoords.push(theBlackDove);

// 					var animateLineDraw = window.setInterval(function() {
						
// 						if (idx < routeThreeOverviewPath.length) {
// 							var routeLatLng = {lat: routeThreeOverviewPath[idx].lat(), lng: routeThreeOverviewPath[idx].lng()};
// 							pathCoords.push(routeLatLng);
// 							pathThreeMobile = new google.maps.Polyline({
// 								path: pathCoords,
// 								geodesic: true,
// 								strokeColor: 'violet',
// 								strokeOpacity: 0.6,
// 								strokeWeight: 4
// 							});
// 							idx++;

// 						} else {

// 							pathThreeMobile.setMap(mapMobile);

// 							window.clearInterval(animateLineDraw);

// 							google.maps.event.addListener(markersArrayMobile[3], 'click', function() {
								
// 								// workplaceMarker.setVisible(true);
// 								// markersArrayMobile[1].setVisible(true);
// 								// markersArrayMobile[2].setVisible(true);
// 								// markersArrayMobile[3].setVisible(false);

// 								pathWork.setVisible(true);
// 								pathOne.setVisible(true);
// 								pathTwo.setVisible(true);
// 								pathThree.setVisible(false);
								
// 								directionsDisplay.setDirections(result);

// 							});
						  	
// 						  	// infowindow = new google.maps.InfoWindow();
// 						   //  infowindow.setContent('<div><p>Hi, my name is Homer.  I\'m a fucking owl.  I\'m currently perched atop of the <strong><i>only</i></strong> building with available apartment(s) which reduces your time in transit the most.  Not what you\'re looking for? I\'ve sorted all available listings on the market according to your travels.  I\'m a badass owl.</p></div>');
// 						   //  infowindow.open(mapMobile, originMarkerMobile);

// 							};
						

// 					}, 1);

// 				}
// 			});
// 		}

// 	@endif

// 	}
// }
</script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqOQUEpaayq3Z0N4u2wtCu-i1npOoJzM&callback=init&libraries=places">
    </script>

</body>
</html>
