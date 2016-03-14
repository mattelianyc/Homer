@extends('application')

@section('content')

<div id="sidebar" class="container-fluid hidden-xs" style="margin:0;padding:0;padding-bottom:100px;height:100%;width:27%;background-color:#2C3E50;color:white;position:fixed;z-index: 100000;overflow-y:scroll;display:none;">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div id="primeLocation"></div>
			<div id="aptListings"></div>
		</div>
	</div>
	</div>
</div>

<div id="map-mobile" class="visible-xs"></div>

<div id="sidebarMobile" class="container-fluid visible-xs" style="margin:0;padding-bottom:100px;height:100%;width:100%;background-color:#2C3E50;color:white;position:inherit;z-index: 100000;display:none;">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div id="primeLocationMobile"></div>
			<div id="aptListingsMobile"></div>
		</div>
	</div>
</div>
@endsection