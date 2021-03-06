

	// initialize GMAP function
	// initialize GMAP function
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
	    center: {lat:40.75, lng: -73.978},
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

	  var input = /** @type {HTMLInputElement} */(
	      document.getElementById('place-search-input'));

	  // Create the autocomplete helper, and associate it with
	  // an HTML text input box.
	  var autocomplete = new google.maps.places.Autocomplete(input);
	  autocomplete.bindTo('bounds', map);

	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	  var infowindow = new google.maps.InfoWindow();
	  marker = new google.maps.Marker({
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

	    if($('#analytics-page-wrapper').css('display') == 'none') {
		 		$('#analytics-page-wrapper').fadeIn();
		 	}  

	 	if($('#tab-content-wrapper').css('display') == 'none') {
	 		$('#tab-content-wrapper').fadeIn();
	 	}  
		    		
		$('#map').animate({width: '100%', left: '0'}, 150, function () {
    		
    		$('#bldg-details-panel').animate({width: '33.33%'}, 300, function () {
	    		$('#bldg-details-panel').css('z-index', '100000');
		    	$('#bldg-address').html('<h2>'+place.name+'</h2><h4>'+place.formatted_address+'</h4>');	
		    	google.maps.event.trigger(panorama, 'resize');	
    		});

    	});

		$('#map').animate({width: '66.66%', left: '33.33%'}, 150, function () {
			map.panBy(100,0);
		});

	    if($("#bldg-details-panel").css('width') == '62px') {

		    $('#bldg-details-panel').animate({width: '33.33%'}, 300, function () {
		    	$('#bldg-details-panel').css('z-index', '100000');
		    	$('#bldg-address').html('<h2>'+place.name+'</h2><h4>'+place.formatted_address+'</h4>');	
		    });
    		$('#map').animate({width: '66.66%', left: '33.33%'}, 150, function () {
    			map.panBy(100,0);
    		});

	    } else {
	    	$('#bldg-details-panel').animate({width: '0%'}, 300, function () {
			    $('#bldg-details-panel').css('z-index', '100000');
			   	$('#bldg-address').html('<h2>'+place.name+'</h2><h4>'+place.formatted_address+'</h4>');	
			});

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
	    infowindow.setContent('<div><strong>'+place.name+'</strong><br><br>'+'<p>'+place.formatted_address+'</p></div><strong>'+marker.place.location.lat()+'</strong><br><strong>'+marker.place.location.lng()+'</strong>');
	    infowindow.open(map, marker);
	  
	  panorama = new google.maps.StreetViewPanorama(
      document.getElementById('street-view'),
      {
        position: {lat: marker.place.location.lat(), lng: marker.place.location.lng()},
        pov: {heading: 165, pitch: 0},
        zoom: 0
      });
	 });


	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA
	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA
	// LOAD APT/WORKPLACE/FREQUENTED.LOCATION DATA

		var apartments = [
		    @foreach ($apartments as $apt)
		        [ {{ $apt->lat }}, {{ $apt->lng }}, "{{ $apt->title }}", "{{ $apt->address }}", "{{ $apt->city }}", "{{ $apt->state }}" ],     
		    @endforeach
	    ];

		var workplaces = [
		    @foreach ($workplaces as $wp)
		        [ {{ $wp->lat }}, {{ $wp->lng }}, "{{ $wp->title }}", "{{ $wp->address }}", "{{ $wp->city }}", "{{ $wp->state }}" ]    
		    @endforeach
	    ];

		var frequentedLocations = [
		    @foreach ($frequented_locations as $fl)
		        [ {{ $fl->lat }}, {{ $fl->lng }}, "{{ $fl->title }}", "{{ $fl->address }}", "{{ $fl->city }}", "{{ $fl->state }}" ]    
		    @endforeach
	    ];

	    var apartment;

	    var home = new google.maps.LatLng(apartments[0][0], apartments[0][1]);
	    var work = new google.maps.LatLng(workplaces[0][0], workplaces[0][1]);
	    console.log(home.lat()+', '+home.lng());
	    console.log(work.lat()+', '+work.lng());

	    for (i = 0; i < apartments.length; i++) {

	        apartment = new google.maps.LatLng(apartments[i][0], apartments[i][1]);

			// console.log(apartment);
	        var marker = new google.maps.Marker({
	            position: apartment,
	            map: map,
	        });

	        marker.setVisible(true); 

	        infowindow.setContent('<div>'+apartments[i][2]+'<br>'+apartments[i][3]+', '+apartments[i][4]+', '+apartments[i][5]+'</div>');
	        infowindow.open(map, marker);
	    }
	
	    var workplace;

	    for (i = 0; i < workplaces.length; i++) {

	        workplace = new google.maps.LatLng(workplaces[i][0], workplaces[i][1]);

			// console.log(workplace);
	        var marker = new google.maps.Marker({
	            position: workplace,
	            map: map,
	        });

	        marker.setVisible(true); 

	        infowindow.setContent('<div>'+workplaces[i][2]+'<br>'+workplaces[i][3]+', '+workplaces[i][4]+', '+workplaces[i][5]+'</div>');
	        infowindow.open(map, marker);

	    }

	    var freqLoc;

	    for (i = 0; i < frequentedLocations.length; i++) {

	        freqLoc = new google.maps.LatLng(frequentedLocations[i][0], frequentedLocations[i][1]);

			// console.log(workplace);
	        var marker = new google.maps.Marker({
	            position: freqLoc,
	            map: map,
	        });

	        marker.setVisible(true); 

	        infowindow.setContent('<div>'+frequentedLocations[i][2]+'<br>'+frequentedLocations[i][3]+', '+frequentedLocations[i][4]+', '+frequentedLocations[i][5]+'</div>');
	        infowindow.open(map, marker);

	    }

	// var home = new google.maps.LatLng(55.930385, -3.118425);

	// var destinationA = "Stockholm, Sweden";


	var service = new google.maps.DistanceMatrixService();
	service.getDistanceMatrix(
	{
	origins: [home],
	destinations: [work],
	travelMode: google.maps.TravelMode.TRANSIT,
	}, callback);

	function callback(response, status) {
		console.log(response);
		console.log(status);
		calcRoute();
	}
	function calcRoute() {
				var start = home;
				var end = work;
				var request = {
				origin:start,
				destination:end,
				travelMode: google.maps.TravelMode.TRANSIT
				};
				directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				  directionsDisplay.setDirections(result);
				}
			});
		}
	}

	

	google.maps.event.addDomListener(document, 'load', initialize);

	</script>