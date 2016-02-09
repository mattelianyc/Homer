@extends('application')

@section('content')

<div class="container-fluid" style="margin:0;padding:0;height:100%;">

	<div id="user-info-modal">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Welcome!</h4>
	      </div>
	      <div class="modal-body">
	      	
		    <div class="page-header">
		      <h3><strong>Workplace</strong></h3>
		      <h4>1. Where do you commute to and from work?</h4>
		    </div>
	      	<div class="form-group">
	        	<input class="form-control" placeholder="Enter Work Address"></input>
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
						<div id="insert-freq-loc-before-marker"></div>
					</div>
				</div>
  			</div>

		    </div>

	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-xs-12">
	        		<a id="submit-user-info-btn" class="btn btn-success btn-block">Calculate</a>
	      		</div>
	      	</div>
	      </div>
	    </div>

	  </div>	
	</div>

	<div id="map"></div>


</div>


@endsection
