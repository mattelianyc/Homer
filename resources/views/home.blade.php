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


    	.fa-star, .fa-search, .fa-bars {
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
    		font-size: 30px;
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

   		#tab-content-wrapper {
   			padding: 5px 10px;
   		}

   	#sidebar {
   		display: none;
   		position: absolute;
   		background-color: white;
   		border-right: 2px solid #183050;
   		height: 100%;
   		width:84px;
   		z-index: 101;
   	}

    	#toggle-sidepanel-btn {
	    	position: absolute;
		    left: 10px;
	    	top: 10px !important;
	    	height:50px;
	    	background-color: #183050;
	    	border-color: #183050;
	    	color:#BBD5F8;
	    	z-index:99;
    	}

    	#home-sidebar-btn {
	    	position: absolute;
		    left: 10px;
	    	bottom: 10px !important;
	    	height:50px;
	    	z-index:102;
    	}

</style>

<div class="container-fluid" style="margin:0;padding:0;height:100%;">


	
	<a id="toggle-sidepanel-btn" class="btn btn-info btn-lg"><i class="fa fa-bars"></i></a>
	
	<div id="sidebar">
		<a id="home-sidebar-btn" class="btn btn-danger btn-lg"><i class="fa fa-power-off"></i></a>
	</div>

	<div id="bldg-details-panel">
		
		<div class="row">
			<div class="col-xs-10">
				<div id="bldg-details-header" class="pull-left"></div>
			</div>
			<div class="col-xs-2"></div>
		</div>

		<div class="row">
			<div class="col-xs-12">	
				<div class="row">
					<img class="img-responsive" src="{{ asset('/images/bldg-entrance.jpg') }}" style="padding:35px;">
				</div>
			</div>
		</div>

		<div class="row">

			<div id="tab-content-wrapper">
			  <ul class="nav nav-tabs">
			    <li class="active"><a data-toggle="tab" href="#reviews">Reviews</a></li>
			    <li><a data-toggle="tab" href="#about">About</a></li>
			    <li><a data-toggle="tab" href="#financials">Financials</a></li>
			    <li><a data-toggle="tab" href="#other">Other</a></li>
			  </ul>

			  <div class="tab-content">
			    <div id="reviews" class="tab-pane fade in active">
			      <div class="page-header">
			      	<h3>Reviews</h3>
			      </div>
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
			      <h3>About</h3>
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
			      <h3>Financials</h3>
			      <span>
			      	<i class="fa fa-usd"></i>
			      	<i class="fa fa-usd"></i>
			      	<i class="fa fa-usd"></i>
			      </span>
			    </div>
			    <div id="other" class="tab-pane fade">
			      <h3>Other</h3>
			      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			    </div>
			  </div>
				
			</div> <!-- end tab-content-wrapper -->
		</div> <!-- end row -->
	</div> <!-- end bldg-details-panel -->

	<input class="form-control" id="place-search-input" />
	<div id="map"></div>

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
