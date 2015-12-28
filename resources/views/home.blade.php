@extends('application')

@section('content')
<style type="text/css">

	html {
		background-color: #183050;
		overflow: hidden;
	}	
	html, body { height: 100%; margin: 0; padding: 0; }
	
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
    	position: absolute;
    	left: initial !important;
	    right: -500px;
    	top: 10px !important;
    	height:50px;
    	width:450px;
    	opacity: 0;
    }
    	#search-btn {
	    	position: absolute;
	    	left: initial !important;
		    right: 10px !important;
	    	top: 10px !important;
	    	height:50px;
    	}

    	.fa-search {
    		font-size: 30px;
    	}

</style>

<div class="container-fluid" style="margin:0;padding:0;height:100%;">

	<input class="form-control" id="place-search-input" />
	<div id="map"></div>

	<div id="landing-page-wrapper">
		<div class="row">
			<span id="search-btn" class="btn btn-info btn-lg"><i class="fa fa-search"></i></span>
		</div>
		<div class="row text-center">
			<div class="col-xs-6 col-xs-offset-3">
				<img id="landing-page-logo" class="img-responsive" src="{{ asset('/images/tw_blue.png') }}"  />
			</div>
		</div>
	</div>
</div>


@endsection
