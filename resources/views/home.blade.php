@extends('application')

@section('content')

<div class="container-fluid" style="margin:0;padding:0;height:100%;">

	<div id="user-info-modal">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Welcome!, {{ $new_temp_user['payload'] }}</h4>
	      </div>
	      <div class="modal-body">
	      	
		    <div class="page-header">
		      <h3><strong>Workplace</strong></h3>
		      <h4>1. Where do you commute to and from for work?</h4>
		    </div>
	      	<div class="form-group">
	        	<input id="workplace-search-input" class="form-control" placeholder="Enter Work Address"></input>
	      	</div>
      		<hr>

      		<div class="page-header">
      		  <h3><strong>Frequented Locations</strong></h3>
		      <h4>2. Where do spend the most time traveling to and from?</h4>
		    </div>

		    <div class="row">
		    	<div class="col-xs-12">
	      	  		<a id="add-freq-loc-input" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;  Add Frequented Location</a>
		    	</div>
		    	<hr>
		    </div>
			
    		<div id="freq-loc-input-wrapper">
				<div class="row">
		    		<div class="col-xs-12">
		    			<div id="input-group-1" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-1" class="form-control" placeholder="Enter Frequented Location Address">
		    				<span class="input-group-addon" onclick="$(this).parent().remove();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-2" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-2" class="form-control" placeholder="Enter Frequented Location Address">
		    				<span class="input-group-addon" onclick="$(this).parent().remove();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-3" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-3" class="form-control" placeholder="Enter Frequented Location Address">
		    				<span class="input-group-addon" onclick="$(this).parent().remove();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-4" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-4" class="form-control" placeholder="Enter Frequented Location Address">
		    				<span class="input-group-addon" onclick="$(this).parent().remove();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-5" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-5" class="form-control" placeholder="Enter Frequented Location Address">
		    				<span class="input-group-addon" onclick="$(this).parent().remove();"><i class="fa fa-minus"></i></span>
		    			</div>
						<!-- <div id="insert-freq-loc-before-marker"></div> -->
					</div>
				</div>
  			</div>

		    </div>

	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-xs-12">
	        		<a id="submit-user-info-btn" class="btn btn-success btn-block">Find your ideal apartment</a>
	      		</div>
	      	</div>
	      </div>
	    </div>

	  </div>	
	</div>

	<div id="map"></div>


</div>


@endsection
