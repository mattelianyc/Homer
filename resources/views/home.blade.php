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
	}	

    #map { height: 800px; width: 100%; }
    
</style>

<div id="map-container" class="container-fluid" style="display:none;">
	<div class="row">
		<div id="map"></div>
	</div>
</div>

<div class="container-fluid" style="margin:0;padding:0;height:100%;">
	<div id="landing-page-wrapper">
		<div class="row text-center">
			<div class="col-xs-6 col-xs-offset-3">
				<img id="landing-page-logo" class="img-responsive" src="{{ asset('/images/tw_blue.png') }}"  />
			</div>
		</div>
	</div>
</div>


@endsection
