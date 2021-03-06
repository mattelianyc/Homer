<?php namespace App\Http\Controllers;

use Auth;
use Session;
use Redirect;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response as Response;

use Input;

use App\Workplace as Workplace;
use App\FrequentedLocation as FrequentedLocation;
use App\TempUser as TempUser;
use App\Building as Building;
use App\Apartment as Apartment;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }

	/**
	 * Show the application dashboard to the user.
	 * @param  Request  $request
     * @param  int  $id
	 * @return Response
	 */
	public function index(Request $request)
	{
		$workplaces = Workplace::all();
		$frequented_locations = FrequentedLocation::all();

		$session = Session::get('_token');

		return view('home')->with(compact('workplaces', 'frequented_locations', 'session'));

	}

	/**
	 * Show the application dashboard to the user.
	 * @param  Request  $request
	 * @return Response
	 */
	public function workplace(Request $request) {

		$session = Session::all();

		$temp_user = new TempUser;
		$temp_user['payload'] = $session['_token'];
		$temp_user->save();

		$workplace = Input::get('workplace_address');
		$freqLoc1 = Input::get('freq_loc_address_1');
		$freqLoc2 = Input::get('freq_loc_address_2');
		$freqLoc3 = Input::get('freq_loc_address_3');

		$workplace_coordinates = Input::get('workplace_coords');
		$freqLoc1_coordinates = Input::get('freq_loc_coords_1');
		$freqLoc2_coordinates = Input::get('freq_loc_coords_2');
		$freqLoc3_coordinates = Input::get('freq_loc_coords_3');


		$f1_weight = Input::get('flw1');
		$f2_weight = Input::get('flw2');
		$f3_weight = Input::get('flw3');

		$workplaceArray = explode(', ', $workplace);
		$freqLoc1Array = explode(', ', $freqLoc1);
		$freqLoc2Array = explode(', ', $freqLoc2);
		$freqLoc3Array = explode(', ', $freqLoc3);

		$workplace_CoordsArray = explode(', ', $workplace_coordinates);
		$FL1_coords_array = explode(', ', $freqLoc1_coordinates);
		$FL2_coords_array = explode(', ', $freqLoc2_coordinates);
		$FL3_coords_array = explode(', ', $freqLoc3_coordinates);

		array_push($workplaceArray, $workplace_CoordsArray);
		
		if (!empty($freqLoc1)) {
		
			array_push($freqLoc1Array, $FL1_coords_array);

			if(sizeof($freqLoc1Array) === 4) {
				$freqLoc1 = new FrequentedLocation;
				$freqLoc1['temp_user_id'] = $temp_user['payload'];
				$freqLoc1['title'] = $freqLoc1Array[0];
				$freqLoc1['address'] = $freqLoc1Array[0];
				$freqLoc1['city'] = "new york";
				$freqLoc1['state'] = $freqLoc1Array[1];
				$freqLoc1['country'] = $freqLoc1Array[2];
				$freqLoc1['lat'] = $freqLoc1Array[3][0];
				$freqLoc1['lng'] = $freqLoc1Array[3][1];
				$freqLoc1['weight'] = $f1_weight;
		        $freqLoc1->save();
			} elseif (sizeof($freqLoc1Array) === 5) {
				$freqLoc1 = new FrequentedLocation;
				$freqLoc1['temp_user_id'] = $temp_user['payload'];
				$freqLoc1['title'] = $freqLoc1Array[0];
				$freqLoc1['address'] = $freqLoc1Array[0];
				$freqLoc1['city'] = $freqLoc1Array[1];
				$freqLoc1['state'] = $freqLoc1Array[2];
				$freqLoc1['country'] = $freqLoc1Array[3];
				$freqLoc1['lat'] = $freqLoc1Array[4][0];
				$freqLoc1['lng'] = $freqLoc1Array[4][1];
				$freqLoc1['weight'] = $f1_weight;
		        $freqLoc1->save();
			} elseif (sizeof($freqLoc1Array) === 6) {
				$freqLoc1 = new FrequentedLocation;
				$freqLoc1['temp_user_id'] = $temp_user['payload'];
				$freqLoc1['title'] = $freqLoc1Array[0];
				$freqLoc1['address'] = $freqLoc1Array[1];
				$freqLoc1['city'] = $freqLoc1Array[2];
				$freqLoc1['state'] = $freqLoc1Array[3];
				$freqLoc1['country'] = $freqLoc1Array[4];
				$freqLoc1['lat'] = $freqLoc1Array[5][0];
				$freqLoc1['lng'] = $freqLoc1Array[5][1];
				$freqLoc1['weight'] = $f1_weight;
		        $freqLoc1->save();
			}

		}
		if (!empty($freqLoc2)) {
			array_push($freqLoc2Array, $FL2_coords_array);
			if(sizeof($freqLoc2Array) === 4) {
				$freqLoc2 = new FrequentedLocation;
				$freqLoc2['temp_user_id'] = $temp_user['payload'];
				$freqLoc2['title'] = $freqLoc2Array[0];
				$freqLoc2['address'] = $freqLoc2Array[0];
				$freqLoc2['city'] = "new york";
				$freqLoc2['state'] = $freqLoc2Array[1];
				$freqLoc2['country'] = $freqLoc2Array[2];
				$freqLoc2['lat'] = $freqLoc2Array[3][0];
				$freqLoc2['lng'] = $freqLoc2Array[3][1];
				$freqLoc2['weight'] = $f2_weight;
		        $freqLoc2->save();
			} elseif (sizeof($freqLoc2Array) === 5) {
				$freqLoc2 = new FrequentedLocation;
				$freqLoc2['temp_user_id'] = $temp_user['payload'];
				$freqLoc2['title'] = $freqLoc2Array[0];
				$freqLoc2['address'] = $freqLoc2Array[0];
				$freqLoc2['city'] = $freqLoc2Array[1];
				$freqLoc2['state'] = $freqLoc2Array[2];
				$freqLoc2['country'] = $freqLoc2Array[3];
				$freqLoc2['lat'] = $freqLoc2Array[4][0];
				$freqLoc2['lng'] = $freqLoc2Array[4][1];
				$freqLoc2['weight'] = $f2_weight;
		        $freqLoc2->save();
			} elseif (sizeof($freqLoc2Array) === 6) {
				$freqLoc2 = new FrequentedLocation;
				$freqLoc2['temp_user_id'] = $temp_user['payload'];
				$freqLoc2['title'] = $freqLoc2Array[0];
				$freqLoc2['address'] = $freqLoc2Array[1];
				$freqLoc2['city'] = $freqLoc2Array[2];
				$freqLoc2['state'] = $freqLoc2Array[3];
				$freqLoc2['country'] = $freqLoc2Array[4];
				$freqLoc2['lat'] = $freqLoc2Array[5][0];
				$freqLoc2['lng'] = $freqLoc2Array[5][1];
				$freqLoc2['weight'] = $f2_weight;
		        $freqLoc2->save();
			}
			
		}
		if (!empty($freqLoc3)) {
			array_push($freqLoc3Array, $FL3_coords_array);
			
			if(sizeof($freqLoc3Array) === 4) {
				$freqLoc3 = new FrequentedLocation;
				$freqLoc3['temp_user_id'] = $temp_user['payload'];
				$freqLoc3['title'] = $freqLoc3Array[0];
				$freqLoc3['address'] = $freqLoc3Array[0];
				$freqLoc3['city'] = "new york";
				$freqLoc3['state'] = $freqLoc3Array[1];
				$freqLoc3['country'] = $freqLoc3Array[2];
				$freqLoc3['lat'] = $freqLoc3Array[3][0];
				$freqLoc3['lng'] = $freqLoc3Array[3][1];
				$freqLoc3['weight'] = $f3_weight;
		        $freqLoc3->save();
			} elseif (sizeof($freqLoc3Array) === 5) {
				$freqLoc3 = new FrequentedLocation;
				$freqLoc3['temp_user_id'] = $temp_user['payload'];
				$freqLoc3['title'] = $freqLoc3Array[0];
				$freqLoc3['address'] = $freqLoc3Array[0];
				$freqLoc3['city'] = $freqLoc3Array[1];
				$freqLoc3['state'] = $freqLoc3Array[2];
				$freqLoc3['country'] = $freqLoc3Array[3];
				$freqLoc3['lat'] = $freqLoc3Array[4][0];
				$freqLoc3['lng'] = $freqLoc3Array[4][1];
				$freqLoc3['weight'] = $f3_weight;
		        $freqLoc3->save();
			} elseif (sizeof($freqLoc3Array) === 6) {
				$freqLoc3 = new FrequentedLocation;
				$freqLoc3['temp_user_id'] = $temp_user['payload'];
				$freqLoc3['title'] = $freqLoc3Array[0];
				$freqLoc3['address'] = $freqLoc3Array[1];
				$freqLoc3['city'] = $freqLoc3Array[2];
				$freqLoc3['state'] = $freqLoc3Array[3];
				$freqLoc3['country'] = $freqLoc3Array[4];
				$freqLoc3['lat'] = $freqLoc3Array[5][0];
				$freqLoc3['lng'] = $freqLoc3Array[5][1];
				$freqLoc3['weight'] = $f3_weight;
		        $freqLoc3->save();
			}
		}

		// array_push($freqLoc4Array, $FL4_coords_array);
		// array_push($freqLoc5Array, $FL5_coords_array);

		// dd(sizeof($workplaceArray));
		// dd($freqLoc1Array.'      '.$freqLoc2Array.'      '.$freqLoc3Array);

		if(sizeof($workplaceArray) === 4) {
			$new_workplace = new Workplace;
			$new_workplace['temp_user_id'] = $temp_user['payload'];
			$new_workplace['title'] = $workplaceArray[0];
			$new_workplace['address'] = $workplaceArray[0];
			$new_workplace['city'] = "new york";
			$new_workplace['state'] = $workplaceArray[1];
			$new_workplace['country'] = $workplaceArray[2];
			$new_workplace['lat'] = $workplaceArray[3][0];
			$new_workplace['lng'] = $workplaceArray[3][1];
	        $new_workplace->save();
		} elseif (sizeof($workplaceArray) === 5) {
			$new_workplace = new Workplace;
			$new_workplace['temp_user_id'] = $temp_user['payload'];
			$new_workplace['title'] = $workplaceArray[0];
			$new_workplace['address'] = $workplaceArray[0]; 
			$new_workplace['city'] = $workplaceArray[1];
			$new_workplace['state'] = $workplaceArray[2];
			$new_workplace['country'] = $workplaceArray[3];
			$new_workplace['lat'] = $workplaceArray[4][0];
			$new_workplace['lng'] = $workplaceArray[4][1];
	        $new_workplace->save();
		} elseif (sizeof($workplaceArray) === 6) {
			$new_workplace = new Workplace;
			$new_workplace['temp_user_id'] = $temp_user['payload'];
			$new_workplace['title'] = $workplaceArray[0];
			$new_workplace['address'] = $workplaceArray[1]; 
			$new_workplace['city'] = $workplaceArray[2];
			$new_workplace['state'] = $workplaceArray[3];
			$new_workplace['country'] = $workplaceArray[4];
			$new_workplace['lat'] = $workplaceArray[5][0];
			$new_workplace['lng'] = $workplaceArray[5][1];
	        $new_workplace->save();
		}

    return Redirect::route('dovetail', array('id' => $temp_user['payload']));

	}



	public function dovetail(Request $request, $id) {

		$workplace = Workplace::where('temp_user_id','=',$id)->get();
		$frequented_locations = FrequentedLocation::where('temp_user_id','=',$id)->get();
		$buildings = Building::all();
		$apartments = Apartment::all();

		return view('dovetail')->with(compact('workplace', 'frequented_locations', 'buildings', 'apartments'));
	}

	public function logout()
	{
		Auth::logout();	
		Session::flush();
		return Redirect::to('home');
	}


}
