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
		width: 100%;
		position: absolute;
		z-index: 100;
	}	
		#landing-page-logo {
			margin:20px;
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
    		font-size: 24px !important;
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
    		font-size: 24px !important;
    	}
    	.fa-compress {
    		color: #d9534f;
    		font-size: 24px !important;
    	}

   	#bldg-details-panel {
   		position: absolute;
   		height: 100%;
   		width: 0;
   		z-index: 0;
   		background-color: white;
   		border-right: 2px solid #183050;
   		padding:30px;
   		padding-top: 15px !important;
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
		    left: 3px;
	    	top: 3px !important;
	    	background-color: white;
	    	border-color: white;
	    	color:#183050;
	    	z-index:99;
    	}

    	#home-sidebar-btn {
	    	position: absolute;
		    left: 3px;
	    	bottom: 3px !important;
	    	z-index:102;
	    	color: #d43f3a;
	    	background-color: white;
	    	border-color: white;
    	}

    	#collapse-sidepanel-btn, #expand-bldg-details-btn, #collapse-bldg-details-btn {
		    font-size: 24px !important;
    	}
		
		#collapse-bldg-details-btn{color:#d9534f; position: relative; left: 3px;}

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
   			margin-top: 10px;
   		}
   		.tab-content {
   			margin-top:15px;
   		}
   		.headline-review {	
   			text-align: center;
   		}
   		.headline-review > span > i {	
			font-size: 60px;
			padding: 0px 5px;
   		}
   		#donut-graphs {
   			height:420px;
   			overflow: hidden;
   		}

   		#bldg-street-view {
   			width: 100%;
    		height: 400px;
   		}
   		#street-view {
   			height: 350px;
   			width: 100% !important;
   		}
   		#bldg-address {
   			text-align: center;
   		}
	   		#bldg-address > h2 {
	   			margin-top: 0;
   			}
   		#bldg-address-and-street-view {
   			padding: 0px 15px;
   		}
</style>
<!-- SPLASH PAGE -->
<div id="landing-page-wrapper">
	<div class="row">
		<img id="landing-page-logo" class="animated pull-left" src="{{ asset('/images/tw_blue.png') }}" height="150" width="auto"  />
		<!-- <span id="search-btn" class="btn btn-info btn-lg"><i class="fa fa-search"></i></span> -->
	</div>
	<div class="row">
	</div>
		<div class="col-xs-12">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							<div class="panel-heading">Login</div>
							<div class="panel-body">
								@if (count($errors) > 0)
									<div class="alert alert-danger">
										<strong>Whoops!</strong> There were some problems with your input.<br><br>
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif

							<form class="form-horizontal" role="form" method="POST" action="/auth/login">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<div class="form-group">
									<label class="col-md-4 control-label">E-Mail Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" name="email" value="{{ old('email') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> Remember Me
											</label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
											Login
										</button>

										<a href="/password/email">Forgot Your Password?</a>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>


@endsection
