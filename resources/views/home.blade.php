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
    		font-size: 18px;
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
    		font-size: 18px;
    	}
    	.fa-compress {
    		font-size: 24px !important;
    		color: #d9534f;
    	}

   	#bldg-details-panel {
   		position: absolute;
   		height: 100%;
   		width: 0;
   		z-index: 0;
   		background-color: white;
   		border-right: 2px solid #183050;
   		padding:30px;
   		overflow-y:scroll;
   		overflow-x:hidden;
   	}

   	#sidebar {
   		display: none;
   		position: absolute;
   		background-color: white;
   		border-right: 2px solid #183050;
   		height: 100%;
   		width:64px;
   		z-index: 99999;
   	}

    	#toggle-sidepanel-btn {
	    	position: absolute;
		    left: 6px;
	    	top: 6px !important;
	    	background-color: white;
	    	border-color: white;
	    	color:#183050;
	    	z-index:99;
    	}

    	#home-sidebar-btn {
	    	position: absolute;
		    left: 6px;
	    	bottom: 6px !important;
	    	z-index:102;
	    	color: #d43f3a;
	    	background-color: white;
	    	border-color: white;
    	}

    	#collapse-sidepanel-btn, #expand-bldg-details-btn, #collapse-bldg-details-btn {
	    	padding: 12px 18px;
		    font-size: 24px;
		    line-height: 1;
    	}
		
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
   			padding: 5px 10px;
   		}
   		.tab-content {
   			margin-top:15px;
   		}
</style>

<div class="container-fluid" style="margin:0;padding:0;height:100%;">
	
	<div id="sidebar">
		<a id="toggle-sidepanel-btn" class="btn btn-info btn-lg"><i class="fa fa-bars"></i></a>
		<a id="home-sidebar-btn" class="btn btn-danger btn-lg"><i class="fa fa-power-off"></i></a>
		<div class="clearfix"></div>
	</div>

	<div id="bldg-details-panel">
		<div class="row">
			<div class="col-xs-12" style="position:inherit;z-index:1000000">
				<div class="row">	
					<a id="collapse-sidepanel-btn" class="btn pull-left">
						<i class="fa fa-chevron-left"></i>
					</a>
					<a id="expand-bldg-details-btn" class="btn pull-right">
						<i class="fa fa-expand"></i>
					</a>
					<a id="collapse-bldg-details-btn" class="btn pull-right" style="display:none;">
						<i class="fa fa-compress"></i>
					</a>
				</div>
			</div>
		
			<div id="bldg-header" class="col-xs-12">
				<div id="bldg-details-header"></div>
			</div>

			<div id="data-visualization" style="display:none;">
				<div class="col-xs-8">
					<div class="row text-center">
						<h1>DATA VISUALIZATION</h1>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div id="donutchart" style="width: 100%; height: auto;"></div>
						</div>
						<div class="col-xs-6">
							<div id="donutchart_two" style="width: 100%; height: auto;"></div>
						</div>
					</div>
				</div>
			</div>

		</div>	

		<div class="row">

			<div id="tab-content-wrapper">
				
				<div class="nav-center">
				  <ul class="nav nav-tabs">
				    <li class="active"><a data-toggle="tab" href="#reviews"><strong>Reviews</strong></a></li>
				    <li><a data-toggle="tab" href="#about"><strong>About</strong></a></li>
				    <li><a data-toggle="tab" href="#financials"><strong>Financials</strong></a></li>
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
			    <div id="financials" class="tab-pane fade">
			      <span>
			      	<i class="fa fa-usd"></i>
			      	<i class="fa fa-usd"></i>
			      	<i class="fa fa-usd"></i>
			      </span>
			    </div>
			    <div id="other" class="tab-pane fade">
			      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			    </div>
			  </div>
				
			</div> <!-- end tab-content-wrapper -->
		</div> <!-- end row -->
	</div> <!-- end bldg-details-panel -->

	<!-- GMAP -->
	<input class="form-control" id="place-search-input" />
	<div id="map"></div>

	<!-- SPLASH PAGE -->
	<div id="landing-page-wrapper">
		<div class="row">
			<span id="search-btn" class="btn btn-info btn-lg"><i class="fa fa-search"></i></span>
		</div>
		<div class="row text-center">
			<div class="col-xs-6 col-xs-offset-3">
				<img id="landing-page-logo" class="img-responsive animated" src="{{ asset('/images/tw_blue.png') }}"  />
			</div>
		</div>
	</div>
</div>


@endsection
