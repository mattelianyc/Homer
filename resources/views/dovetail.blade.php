@extends('application')

@section('content')

<div id="sidebar" class="container-fluid hidden-xs" style="margin:0;padding:0 2px 0 2px;padding-bottom:100px;height:100%;width:27%;background-color:white;color:#2C3E50;position:fixed;z-index: 100000;overflow-y:scroll;overflow-x:hidden;display:none;">
		<!-- <div class="col-xs-12"> -->
			<div id="apartmentListings"></div>
		<!-- </div> -->
	</div>
</div>

<div id="sidebarMobile" class="container-fluid visible-xs" style="margin:0;padding:0;padding-bottom:100px;height:100%;width:100%;background-color:#2C3E50;color:white;position:inherit;z-index: 100000;display:none;">
	<div class="col-xs-12">
		<div id="primeLocationMobile"></div>
		<div id="aptListingsMobile"></div>
	</div>
</div>
@endsection