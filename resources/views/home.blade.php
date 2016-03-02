@extends('application')

@section('content')

<div class="container-fluid" style="margin:0;padding:0;height:100%;">


	<div id="user-info-modal">
	  <div class="modal-dialog">
		{!! Form::open(['action' => 'HomeController@workplace', 'id' => 'csrf_token()']) !!}
		<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" id="token" name="temp_user_id" value="{{ csrf_token() }}">
	    <!-- Modal content-->
	    <div class="modal-content">

	      <div class="modal-body">
	      	
		    <div class="page-header">
		      <h3><strong>Workplace</strong></h3>
		      <h4>Where do you commute to and from for work?</h4>
		    </div>
	      	<div class="form-group">
	        	<input id="workplace-search-input" class="form-control" placeholder="Enter Work Address" name="workplace_address">
	        	<input type="hidden" id="workplace-coords-input" name="workplace_coords">
	      	</div>
      		<hr>

      		<div class="page-header">
      		  <h3><strong>Frequented Locations</strong></h3>
		      <h4>Where else do you often travel to and from?</h4>
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
		    				<input id="freq-loc-input-1" class="form-control" placeholder="Enter Frequented Location Address" name="freq_loc_address_1">
		    				<input type="hidden" id="freq-loc-coords-input-1" name="freq_loc_coords_1">
		    				<span class="input-group-addon" onclick="$(this).parent().hide();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-2" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-2" class="form-control" placeholder="Enter Frequented Location Address" name="freq_loc_address_2">
		    				<input type="hidden" id="freq-loc-coords-input-2" name="freq_loc_coords_2">
		    				<span class="input-group-addon" onclick="$(this).parent().hide();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-3" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-3" class="form-control" placeholder="Enter Frequented Location Address" name="freq_loc_address_3">
		    				<input type="hidden" id="freq-loc-coords-input-3" name="freq_loc_coords_3">
		    				<span class="input-group-addon" onclick="$(this).parent().hide();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<!-- <div id="input-group-4" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-4" class="form-control" placeholder="Enter Frequented Location Address" name="freq_loc_address_4">
		    				<input type="hidden" id="freq-loc-coords-input-4" name="freq_loc_coords_4">
		    				<span class="input-group-addon" onclick="$(this).parent().hide();"><i class="fa fa-minus"></i></span>
		    			</div>
		    			<div id="input-group-5" class="input-group" style="display:none;">
		    				<input id="freq-loc-input-5" class="form-control" placeholder="Enter Frequented Location Address" name="freq_loc_address_5">
		    				<input type="hidden" id="freq-loc-coords-input-5" name="freq_loc_coords_5">
		    				<span class="input-group-addon" onclick="$(this).parent().hide();"><i class="fa fa-minus"></i></span>
		    			</div> -->
					</div>
				</div>
  			</div>

		    </div>

	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-xs-12">
	        		<button id="submit-user-info-btn" type="submit" class="btn btn-success btn-block">Find your ideal apartment</button>
	      		</div>
	      	</div>
	      </div>
	    </div>
       {!! Form::close() !!}
	  </div>	
	</div>

</div>


@endsection
