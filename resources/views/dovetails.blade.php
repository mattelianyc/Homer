@extends('application')

@section('content')

<div class="container-fluid" style="margin:0;padding:0;height:100%;width:100%;">
		<div class="row">
			<div class="col-xs-12">
					<div class="col-xs-9"></div>
					<div class="col-xs-3">
						<img class="img-responsive" src="{{ asset('images/dovetail_logo_1.png') }}" style="position:absolute;z-index:999999;margin:10px;padding-right:35px;" />
					</div>
			</div>
		</div>	
</div>
<!-- <div class="container-fluid" style="margin:0;padding:0;height:100%;width:20%;background-color:white;position:fixed;z-index: 100000">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="pull-right">
			<ul id="duration" class="list-unstyled">
			</ul>
			</div>
		</div>
	</div>
	</div>
</div> -->

@endsection