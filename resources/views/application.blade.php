<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TenantWire</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
		
		body {

		}

		nav {
			margin-bottom: 0 !important;
			background-color: rgba(0,0,0,0);
			position: absolute !important;
		}

	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<!-- <div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">TenantWire</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="/auth/login">Login</a></li>
					<li><a href="/auth/register">Register</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> hello world <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/auth/logout">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div> -->
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<script>

	$(document).ready(function () {

		$('#search-btn').click(function () {
			$('#place-search-input').animate({
				position: 'absolute',
		    	left: 'initial !important',
			    right: '500px !important',
		    	top: '10px !important',
		    	height:'50px',
		    	opacity: 1
			}, 500, function () {});
			$('#place-search-input').animate({
				right: '+=510'
			}, 750, function () {});
			$('#landing-page-wrapper').animate({opacity: 0}, 1000, function () {
				$('#landing-page-wrapper').css('z-index', '10');
			});
			$('#map').animate({opacity: 1}, 1000, function () {
				$('#map').css('z-index', '100');
			});
			
		});

	});
	</script>
	
    <script type="text/javascript">

    function initialize() {
	  var mapOptions = {
	    center: {lat:40.75, lng: -73.978},
	    zoom: 13,
	    scrollwheel: false
	  };
	  var map = new google.maps.Map(document.getElementById('map'),
	    mapOptions);

	  var input = /** @type {HTMLInputElement} */(
	      document.getElementById('place-search-input'));

	  // Create the autocomplete helper, and associate it with
	  // an HTML text input box.
	  var autocomplete = new google.maps.places.Autocomplete(input);
	  autocomplete.bindTo('bounds', map);

	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	  var infowindow = new google.maps.InfoWindow();
	  var marker = new google.maps.Marker({
	    map: map
	  });
	  google.maps.event.addListener(marker, 'click', function() {
	    infowindow.open(map, marker);
	  });

	  // Get the full place details when the user selects a place from the
	  // list of suggestions.
	  google.maps.event.addListener(autocomplete, 'place_changed', function() {
	    infowindow.close();
	    var place = autocomplete.getPlace();
	    if (!place.geometry) {
	      return;
	    }

	    if (place.geometry.viewport) {
	      map.fitBounds(place.geometry.viewport);
	    } else {
	      map.setCenter(place.geometry.location);
	      map.setZoom(17);
	    }

	    // Set the position of the marker using the place ID and location.
	    marker.setPlace(/** @type {!google.maps.Place} */ ({
	      placeId: place.place_id,
	      location: place.geometry.location
	    }));
	    marker.setVisible(true);

	    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
	        'Place ID: ' + place.place_id + '<br>' +
	        place.formatted_address + '</div>');
	    infowindow.open(map, marker);
	  });
	}

	// Run the initialize function when the window has finished loading.
	google.maps.event.addDomListener(window, 'load', initialize);

 //    function initialize() {
	//   var nyc = new google.maps.LatLng(40.75, -73.978);

	//   var map = new google.maps.Map(document.getElementById('map'), {
	//     center: nyc,
	//     zoom: 15,
	//     scrollwheel: false
	//   });

	//   // Specify location, radius and place types for your Places API search.
	//   var request = {
	//     location: nyc,
	//     radius: '1000',
	//     types: ['store']
	//   };

	//   // Create the PlaceService and send the request.
	//   // Handle the callback with an anonymous function.
	//   var service = new google.maps.places.PlacesService(map);
	//   service.nearbySearch(request, function(results, status) {
	//     if (status == google.maps.places.PlacesServiceStatus.OK) {
	//       for (var i = 0; i < results.length; i++) {
	//         var place = results[i];
	//         // If the request succeeds, draw the place location on
	//         // the map as a marker, and register an event to handle a
	//         // click on the marker.
	//         var marker = new google.maps.Marker({
	//           map: map,
	//           position: place.geometry.location
	//         });
	//       }
	//     }
	//   });
	// }

	// Run the initialize function when the window has finished loading.
	// google.maps.event.addDomListener(document, 'load', initialize);
	
	// function initMap() {
	//   map = new google.maps.Map(document.getElementById('map'), {
	//     center: {lat: 40.75, lng: -73.978},
	//     zoom: 13
	//   });
	// }

    </script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqOQUEpaayq3Z0N4u2wtCu-i1npOoJzM&callback=initialize&libraries=places">
    </script>

<!-- <script src="{{ asset('/javascript/main.js') }}"></script> -->

</body>
</html>
