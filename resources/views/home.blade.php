@extends('application')

@section('content')
<style type="text/css">

	@font-face {
	  font-family: 'manifesto';
	  src: url('../fonts/ChaletParisNineteenSixty.otf');
	}
	@font-face {
	  font-family: 'manifesto-bold';
	  src: url('../fonts/Chalet-New-York-Nineteen-Sixty.otf');
	}

	html {
		background-color: #183050;
		overflow: hidden;
	}	
	html, body { height: 100%; margin: 0; padding: 0; }
	
	nav {
			margin-bottom: 0 !important;
			background-color: rgba(0,0,0,0);
			position: absolute !important;
		}

	* {
		font-family: 'manifesto';
	}

	h1,h2,h3,h4,strong {
		font-family: 'manifesto-bold';
	}
	h1 {
		color:#183050;
	}
	strong,
	li > a {
		font-size:16px;
		color:#183050;
	}
	#landing-page-wrapper {
		background-color: #183050;
		height: 100%;
		position: absolute;
		z-index: 100;
	}	
		#landing-page-logo {
			position: relative;
			top:100px;
		}

    #map { height: 100%; width: 100%; position: absolute; opacity:0; z-index: 10;}

    #place-search-input {
    	font-family: manifesto;
    	position: absolute;
    	left: initial !important;
	    right: -500px;
    	top: 10px !important;
    	height:50px;
    	width:500px;
    	opacity: 0;
    	border: 2px solid #183050;
    	font-size:21px;
    }
    	#search-btn {
	    	position: absolute;
	    	left: initial !important;
		    right: 10px !important;
	    	top: 10px !important;
	    	height:50px;
	    	background-color: white;
	    	border-color: #BBD5F8;
	    	color: #183050;
    	}

    	.fa-bars {
    		font-size: 24px !important;
    	}
    	.fa-star, .fa-search {
    		font-size: 30px;
    	}
    	.fa-star {
    		color:goldenrod;	
			font-size: 48px;	
    	}
    	.fa-usd {
    		color:darkgreen;
			font-size: 48px;	
    	}
    	.fa-power-off {
    		font-size: 24px !important;
    	}
    	.fa-compress {
    		color: #d9534f;
    		font-size: 24px !important;
    	}

   	#bldg-details-panel {
   		position: absolute;
   		height: 100%;
   		width: 0;
   		z-index: 0;
   		background-color: white;
   		border-right: 2px solid #183050;
   		padding:30px;
   		padding-top: 15px !important;
   		overflow-y:scroll;
   		overflow-x:hidden;
   	}

   	#sidebar {
   		opacity: 1;
   		position: absolute;
   		background-color: white;
   		border-right: 2px solid #183050;
   		height: 100%;
   		width:64px;
   		z-index: 99999;
   	}

    	#toggle-sidepanel-btn {
	    	position: absolute;
		    left: 3px;
	    	top: 3px !important;
	    	background-color: white;
	    	border-color: white;
	    	color:#183050;
	    	z-index:99;
    	}

    	#home-sidebar-btn {
	    	position: absolute;
		    left: 3px;
	    	bottom: 3px !important;
	    	z-index:102;
	    	color: #d43f3a;
	    	background-color: white;
	    	border-color: white;
    	}

    	#collapse-sidepanel-btn, #expand-bldg-details-btn, #collapse-bldg-details-btn {
		    font-size: 24px !important;
    	}
		
		#collapse-bldg-details-btn{color:#d9534f; position: relative; left: 3px;}

		#collapse-sidepanel-btn{color:#d9534f;}
		#expand-bldg-details-btn{color:#5cb85c;}
    	
    	#bldg-details-header {
    		position: relative;
    		bottom: 4px;
    		text-align: center;
    	}
	    	#bldg-details-header > h2 {
	    	    position: relative;
	    		bottom: 10px;
	    	}


	    /*SIDE-PANEL TAB CONTENT*/
   		
   		.nav-center {
   			text-align: center;
   		}
   		ul.nav {
   			display: inline-block;
   		}
   		li {
   			display: inline;
   		}
   		a {
   			float: left;
   		}
   		#tab-content-wrapper {
   			margin-top: 10px;
   		}
   		.tab-content {
   			margin-top:15px;
   		}
   		.headline-review {	
   			text-align: center;
   		}
   		.headline-review > span > i {	
			font-size: 60px;
			padding: 0px 5px;
   		}
   		#donut-graphs {
   			height:420px;
   			overflow: hidden;
   		}

   		#bldg-street-view {
   			width: 100%;
    		height: 400px;
   		}
   		#street-view {
   			height: 350px;
   			width: 100% !important;
   		}
   		#bldg-address {
   			text-align: center;
   		}
	   		#bldg-address > h2 {
	   			margin-top: 0;
   			}
   		#bldg-address-and-street-view {
   			padding: 0px 15px;
   		}
</style>

<div class="container-fluid" style="margin:0;padding:0;height:100%;">
	
	<div id="sidebar">
		<a id="toggle-sidepanel-btn" class="btn btn-info btn-lg"><i class="fa fa-bars"></i></a>
		<a href="{{ action('HomeController@logout') }}" id="home-sidebar-btn" class="btn btn-danger btn-lg"><i class="fa fa-power-off"></i></a>
		<div class="clearfix"></div>
	</div>

	<div id="bldg-details-panel">
		<div class="row">
			<div class="col-xs-12" style="position:inherit;z-index:1000000">
				<div class="row" style="margin-bottom:5px;">	
					<a id="collapse-sidepanel-btn" class="btn pull-left">
						<span><i class="fa fa-chevron-left"></i> <p style="display:inline;position:relative;left:4px;bottom:2px">sidebar</p></span>
					</a>
					<a id="expand-bldg-details-btn" class="btn pull-right">
						<span><p style="display:inline;position:relative;right:4px;bottom:2px">more info</p> <i class="fa fa-expand"></i></span>
					</a>
					<a id="collapse-bldg-details-btn" class="btn pull-left" style="display:none;">
						<span><i class="fa fa-compress"></i> <p style="display:inline;position:relative;left:4px;bottom:2px">minify</p></span>
					</a>
				</div>
			</div>
		</div>

		<div id="analytics-page-wrapper">

			<div id="analytics-page-header" style="position:relative;z-index:100;">
				
				<div class="row">
					<div id="bldg-address-and-street-view" class="col-xs-12">
						
						<div class="col-xs-12">
							<div id="bldg-address">
								<div id="bldg-details-header"></div>
							</div>
						</div>

						<div class="col-xs-12" style="padding:0;">
							<div id="street-view"></div>
						</div>

					</div>
					<!-- sidebar display none -->
					<div id="bldg-facts" style="display:none;">
						<div class="headline-review">
							<span>
					      		<i class="fa fa-star"></i>
					      		<i class="fa fa-star"></i>
					      		<i class="fa fa-star" style="color:gray;"></i>
					      		<i class="fa fa-star" style="color:gray;"></i>
					      		<i class="fa fa-star" style="color:gray;"></i>
					      	</span>
							<h3>10 Reviews – 5 Ratings</h3>
							<h3>20 Posted Rents – 3 Expiring Leases</h3>
						</div>

						<div class="page-header">
							<h3>Building Facts</h3>	
						</div>
						<p>81 Units</p>
						<p>6 Stories</p>
						<p>Built in 2013</p>
						<p>Doorman</p>
						<p>2 Elevators</p>
						<p>Gym</p>
						<p>On-Site Laundry</p>
						<p>Communal Terrace</p>
					</div>

					<hr>
	
				</div>

			</div>


			<div id="donut-graphs" style="display:none;">
				<div class="row">
					<div id="data-visualization" style="position:relative;bottom:112px;z-index:10;">
						<div class="col-xs-12">
							<div class="row text-center">
								<div class="col-xs-1"></div>
								<div class="col-xs-5">
									<div id="donutchart" style="width: 900px; height: 500px;"></div>
								</div>
								<div class="col-xs-5">
									<div id="donutchart_two" style="width: 900px; height: 500px;"></div>
								</div>
								<div class="col-xs-1"></div>
							</div>
						</div>
					</div>
				</div>	
			</div>

			<div id="user-reviews" style="display:none;">

					<hr>

				<div class="row">
					<h1>“Beware! This place has roaches”</h1>

					<strong>Pros</strong>
					<p>The terrace is awesome in the summer, as it is so rare to find quality outdoor space in NYC. Doormen are friendly and helpful. The place is newly renovated and looks very classy at first glance.</p>

					<strong>Cons</strong>
					<p>One word: ROACHES! This place has a perpetual roach problem that management has not been able to fix. Not that they have really tried though…whenever I try to call them, they either don’t pick up the phone or are very snappy and rude. The lease also has some BS clause allowing them to kick out tenants with 3-months’ notice for any reason. God help you if the management or landlord doesn’t like you. I have heard they use this lease very often to their advantage if someone makes too much noise or complains. Living here is probably not worth the trouble.</p>

					<strong>Advice to Future Tenants</strong>
					<p>Read your lease very carefully! In fact, spend the money to get a lawyer to read through it and explain it to you, and you might be able to get that stupid 3 month part removed. If not though, the roaches will drive you crazy. Plan on hiring your own exterminator, or else just find another place to live.</p>
				</div>
				<div class="row">
					<a class="btn btn-info"><i class="fa fa-plus"></i> See More Reviews</a>
				</div>
			</div>

			<div id="rent-price-line-graph" style="display:none;">
				<div class="row">

					<hr>

					<div class="col-xs-8" style="overflow:scroll;">
						<div id="line_top_x"></div>
					</div>

					<div class="col-xs-4">
						<div class="page-header">
							<h3>Configuration</h3>
						</div>
						<ul class="list-group">
						  <li class="list-group-item">2Br/2Ba</li>
						  <li class="list-group-item">3Br/2Ba</li>
						  <li class="list-group-item">4Br/3Ba</li>
						</ul>
					</div>

				</div>

				<div class="row">

					<hr>

					<div class="col-xs-6">
						<div class="page-header">
							<h3>Past 12 Months</h3>
						</div>
						<strong>Average Rent:</strong><p style="display:inline;">$5,232/mo</p><br>
						<strong>Highest Rent:</strong><p style="display:inline;">$6,100/mo</p><br>
						<strong>Lowest Rent:</strong><p style="display:inline;">$4,650/mo</p><br>
					</div>
					<div class="col-xs-6"></div>

				</div>

			</div>

		</div> <!-- end analytics page wrapper -->

		<div class="row">

			<div id="tab-content-wrapper">
				<div class="col-xs-12">	
					<div class="nav-center">
					  <ul class="nav nav-tabs">
					    <li class="active"><a data-toggle="tab" href="#reviews"><strong>Reviews</strong></a></li>
					    <li><a data-toggle="tab" href="#financials"><strong>Financials</strong></a></li>
					    <li><a data-toggle="tab" href="#about"><strong>About</strong></a></li>
					    <li><a data-toggle="tab" href="#other"><strong>Other</strong></a></li>
					  </ul>
					</div>

				  <div class="tab-content">
				    <div id="reviews" class="tab-pane fade in active">
				      <div class="well">
				      	<h4>Value</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				      <div class="well">
				      	<h4>Management</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				      <div class="well">
				      	<h4>Cleanliness</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				      <div class="well">
				      	<h4>Amenities</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				      <div class="well">
				      	<h4>Location</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				      <div class="well">
				      	<h4>Neighbors</h4>
				      	<span>
				      		<i class="fa fa-star"></i>
				      		<i class="fa fa-star"></i>
				      	</span>
				      </div>
				    </div>
				    <div id="financials" class="tab-pane fade">
				      <div id="barchart_values" style="width: 450px; height: 250px;"></div>
				    </div>
				    <div id="about" class="tab-pane fade">
				      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				      Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
				      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br><br>
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				      Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
				      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
				      </p>
				    </div>
				    <div id="other" class="tab-pane fade">
				      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				    </div>
				  </div>
					
				</div> <!-- end tab-content-wrapper -->
			</div>
		</div> <!-- end row -->
	</div> <!-- end bldg-details-panel -->

	<!-- GMAP -->
	<input class="form-control" id="place-search-input" type="text" />
	<div id="map"></div>

</div>


@endsection
