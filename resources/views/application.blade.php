<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TenantWire</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Would Recommend This Building', 29],
          ['Would NOT Recommend This Building', 71]
        ]);

        var options = {
          pieHole: 0.4,
          legend: 'none',
          width: 487.5,
          height: 650,
          pieSliceText: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Approve of Management', 54],
          ['Do NOT Approve of Management', 46]
        ]);

        var options = {
          pieHole: 0.4,
          legend: 'none',
          width: 487.5,
          height: 650,
          pieSliceText: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_two'));
        chart.draw(data, options);
      }
    </script>

    <!-- ANALYTICS BLDG PAGE CHART -->
    <script type="text/javascript">
	    google.load('visualization', '1.1', {packages: ['line']});
	    google.setOnLoadCallback(drawChart);

	    function drawChart() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('date', 'Year');
	      data.addColumn('number', 'Average Rent');
	      data.addRows([
	        [new Date(2013, 12, 1),  4000],
	        [new Date(2014, 12, 1), 4500],
	        [new Date(2015, 12, 1), 5000]
	      ]);

	      var options = {
	        chart: {
	          title: 'Rent History',
	          subtitle: 'in US skrilla'
	        },
	        width: 900,
	        height: 500,
	        axes: {
	          x: {
	            0: {side: 'bottom'}
	          },
	          y: {
	          	1: {side: 'left'}
	          }
	        },
	        legend: { position: "none" }
	      };

	      var chart = new google.charts.Line(document.getElementById('line_top_x'));
	      chart.draw(data, options);
	    }
  	</script>

  	<!-- FINANCIAL TAB BAR CHART -->
  	<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 450,
        height: 250,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>

</head>
<body>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<script>

	$(document).ready(function () {

		$('#landing-page-logo').addClass('rollIn');

		$('#home-sidebar-btn').click(function () {
			
			$('#map').animate({opacity: 0}, 800, function () {
				$('#landing-page-wrapper').css('z-index', '10000');
				$('#toggle-sidepanel-btn').css('z-index', '10');
			});
			
			$('#landing-page-wrapper').animate({opacity: 1}, 800, function () {
				$('#landing-page-logo').removeClass('rollOut');
				$('#landing-page-logo').addClass('rollIn');	
			});
			
			$('#place-search-input').animate({
				right: '+=-510'
			}, 600, function () {});

		});

		$('#place-search-input').animate({
			position: 'absolute',
	    	left: 'initial !important',
		    right: '500px !important',
	    	top: '10px !important',
	    	height:'50px',
	    	opacity: 1
		}, 400, function () {});

		$('#place-search-input').animate({
			right: '+=510'
		}, 600, function () {});
		
		$('#map').animate({opacity: 1}, 1000, function () {
			$('#map').css('z-index', '100');
		});

		 $('#toggle-sidepanel-btn').click(function () {
		 	
		 	$('#sidebar').css('display','none');

		 	if($('#analytics-page-wrapper').css('display') == 'none') {
		 		$('#analytics-page-wrapper').fadeIn();
		 	}  

		 	if($('#tab-content-wrapper').css('display') == 'none') {
		 		$('#tab-content-wrapper').fadeIn();
		 	}  
		 	
		 	$('#analytics-page-wrapper, #tab-content-wrapper').fadeIn();
			
		 	// console.log($('#sidebar').css('border-right'));
	    	if ($("#bldg-details-panel").css('width') == '62px') {
				
		    	$('#bldg-details-panel').animate({width: '33.33%'}, 300, function () {});
	    		$('#map').animate({width: '66.66%', left: '33.33%'}, 150, function () {});

	    	} else {

		    	$('#bldg-details-panel').animate({width: '0'}, 300, function () {
			    	$('#bldg-details-panel').css('z-index', '0');
			    });
	    		$('#map').animate({width: '100%', left: '0'}, 150, function () {});
	    		
	    	}

	    });

		 $('#collapse-sidepanel-btn').click(function () {

		 	$('#sidebar').css('display','block');

		 	$('#analytics-page-wrapper, #tab-content-wrapper').fadeOut();

	    	$('#bldg-details-panel').animate({width: '0'}, 300, function () {
		    	$('#bldg-details-panel').css('z-index', '0');
		    	$('#analytics-panel').css('z-index', '0');

		    });
    		$('#map').animate({width: '100%', left: '0'}, 150, function () {
    			google.maps.event.trigger(map, 'resize');
    		});

		 });

		 $('#expand-bldg-details-btn').click(function () {
		 	
		 	$('#bldg-details-panel').css('z-index', '100000');

		 	$('#bldg-details-panel').animate({width: '100%'}, 300, function () {
		 		
		 		$('#tab-content-wrapper').css('display', 'none');
		 		$('#collapse-sidepanel-btn').css('display', 'none');
		 		$('#analytics-page-wrapper').addClass('container');


		 		$('#bldg-facts').fadeIn();
		 		$('#donut-graphs').fadeIn();
		 		$('#user-reviews').fadeIn();
		 		$('#bldg-facts').fadeIn();
		 		$('#rent-price-line-graph').fadeIn();


		 		$('#bldg-address-and-street-view').removeClass('col-xs-12');
		 		$('#bldg-address-and-street-view').addClass('col-xs-7');
		 		$('#bldg-address-and-street-view').css('padding', '0px 30px;');

		 		$('#bldg-facts').addClass('col-xs-5');

		 		$('#bldg-details-header').css('max-height', '500px').css('overflow', 'hidden');

		 		$('#expand-bldg-details-btn').css('display', 'none');
		 		$('#collapse-bldg-details-btn').css('display', 'block');
		 		
		 		$('#tab-content-wrapper').css('width', '33.33%');
		 		$('#bldg-address').css('width', '100%').css('text-align', 'center');

		 	});

	 		if(panorama){
		 		$('#street-view').animate({opacity: 1}, 100, function () {
		 			$('#street-view').css('width', '520px').css('height', '420px');
		 			google.maps.event.trigger(panorama, 'resize');	
		 		});
	 		} else {
	 			return;
 			}

		 });

		 $('#collapse-bldg-details-btn').click(function () { 
 			
 			if(panorama){
		 		$('#street-view').animate({opacity: 1}, 10, function () {
 					google.maps.event.trigger(panorama, 'resize');	
	 			});
 			}	

		
		 	$('#collapse-bldg-details-btn').css('display', 'none');
		 	$('#collapse-sidepanel-btn').fadeIn();
		 	$('#tab-content-wrapper').css('display', 'block');
		 	$('#analytics-page-wrapper').removeClass('container');

			$('#bldg-facts').fadeOut();
			$('#donut-graphs').fadeOut();
		 	$('#user-reviews').fadeOut();
			$('#rent-price-line-graph').fadeOut();

		 	$('#bldg-address-and-street-view').addClass('col-xs-12');
		 	$('#bldg-address-and-street-view').removeClass('col-xs-7');
		 	$('#bldg-address-and-street-view').css('padding', '0px 15px;');

		 	$('#street-view').css('width', '480px').css('height', '360px');
	 		$('#bldg-facts').removeClass('col-xs-5');	 		

		 	$('#bldg-details-panel').animate({width: '33.33%'}, 300, function () {
		 		
		 		$('#expand-bldg-details-btn').css('display', 'block');
		 		$('#collapse-bldg-details-btn').css('display', 'none');
		 		
		 		$('#tab-content-wrapper').css('width', '100%');
		 		$('#bldg-address').css('width', '100%');
			
			});
		 });

	});

	</script>

	<script>

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

		// var apartments = [
		//     @foreach ($apartments as $apt)
		//         [ {{ $apt->lat }}, {{ $apt->lng }}, "{{ $apt->title }}", "{{ $apt->address }}", "{{ $apt->city }}", "{{ $apt->state }}" ],     
		//     @endforeach
	 //    ];

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

	  //   var home = new google.maps.LatLng(apartments[0][0], apartments[0][1]);
	  //   var work = new google.maps.LatLng(workplaces[0][0], workplaces[0][1]);
	  //   console.log(home.lat()+', '+home.lng());
	  //   console.log(work.lat()+', '+work.lng());

	  //   for (i = 0; i < apartments.length; i++) {

	  //       apartment = new google.maps.LatLng(apartments[i][0], apartments[i][1]);

			// // console.log(apartment);
	  //       var marker = new google.maps.Marker({
	  //           position: apartment,
	  //           map: map,
	  //       });

	  //       marker.setVisible(true); 

	  //       infowindow.setContent('<div>'+apartments[i][2]+'<br>'+apartments[i][3]+', '+apartments[i][4]+', '+apartments[i][5]+'</div>');
	  //       infowindow.open(map, marker);
	  //   }
	
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

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqOQUEpaayq3Z0N4u2wtCu-i1npOoJzM&callback=initialize&libraries=places">
    </script>

</body>
</html>
