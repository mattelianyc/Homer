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

		$session = Session::all();

		return view('home')->with(compact('workplaces', 'frequented_locations', 'session'));

	}

	/**
	 * Show the application dashboard to the user.
	 * @param  Request  $request
	 * @return Response
	 */
	public function workplace(Request $request) {

		$workplace = Input::get('workplace_address');
		$freqLoc1 = Input::get('freq_loc_address_1');
		$freqLoc2 = Input::get('freq_loc_address_2');
		$freqLoc3 = Input::get('freq_loc_address_3');
		$freqLoc4 = Input::get('freq_loc_address_4');
		$freqLoc5 = Input::get('freq_loc_address_5');

		$workplace_coordinates = Input::get('workplace_coords');
		$freqLoc1_coordinates = Input::get('freq_loc_coords_1');
		$freqLoc2_coordinates = Input::get('freq_loc_coords_2');
		$freqLoc3_coordinates = Input::get('freq_loc_coords_3');
		$freqLoc4_coordinates = Input::get('freq_loc_coords_4');
		$freqLoc5_coordinates = Input::get('freq_loc_coords_5');

		$workplaceArray = explode(', ', $workplace);
		$freqLoc1Array = explode(', ', $freqLoc1);
		$freqLoc2Array = explode(', ', $freqLoc2);
		$freqLoc3Array = explode(', ', $freqLoc3);
		$freqLoc4Array = explode(', ', $freqLoc4);
		$freqLoc5Array = explode(', ', $freqLoc5);

		$workplace_CoordsArray = explode(', ', $workplace_coordinates);
		$FL1_coords_array = explode(', ', $freqLoc1_coordinates);
		$FL2_coords_array = explode(', ', $freqLoc2_coordinates);
		$FL3_coords_array = explode(', ', $freqLoc3_coordinates);
		$FL4_coords_array = explode(', ', $freqLoc4_coordinates);
		$FL5_coords_array = explode(', ', $freqLoc5_coordinates);

		array_push($workplaceArray, $workplace_CoordsArray);
		array_push($freqLoc1Array, $FL1_coords_array);
		array_push($freqLoc2Array, $FL2_coords_array);
		array_push($freqLoc3Array, $FL3_coords_array);
		array_push($freqLoc4Array, $FL4_coords_array);
		array_push($freqLoc5Array, $FL5_coords_array);

		// dd(sizeof($workplaceArray));
		// dd($freqLoc1Array);
		// dd($freqLoc2Array);
		// dd($freqLoc3Array);

		$session = Session::all();


		$temp_user = new TempUser;
		$temp_user['payload'] = $session['_token'];
		$temp_user->save();

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
	        $freqLoc1->save();
		}

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
	        $freqLoc2->save();
		}
		
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
	        $freqLoc3->save();
		}		

		if(sizeof($freqLoc4Array) === 4) {
			$freqLoc4 = new FrequentedLocation;
			$freqLoc4['temp_user_id'] = $temp_user['payload'];
			$freqLoc4['title'] = $freqLoc4Array[0];
			$freqLoc4['address'] = $freqLoc4Array[0];
			$freqLoc4['city'] = "new york";
			$freqLoc4['state'] = $freqLoc4Array[1];
			$freqLoc4['country'] = $freqLoc4Array[2];
			$freqLoc4['lat'] = $freqLoc4Array[3][0];
			$freqLoc4['lng'] = $freqLoc4Array[3][1];
	        $freqLoc4->save();
		} elseif (sizeof($freqLoc4Array) === 5) {
			$freqLoc4 = new FrequentedLocation;
			$freqLoc4['temp_user_id'] = $temp_user['payload'];
			$freqLoc4['title'] = $freqLoc4Array[0];
			$freqLoc4['address'] = $freqLoc4Array[0];
			$freqLoc4['city'] = $freqLoc4Array[1];
			$freqLoc4['state'] = $freqLoc4Array[2];
			$freqLoc4['country'] = $freqLoc4Array[3];
			$freqLoc4['lat'] = $freqLoc4Array[4][0];
			$freqLoc4['lng'] = $freqLoc4Array[4][1];
	        $freqLoc4->save();
		} elseif (sizeof($freqLoc4Array) === 6) {
			$freqLoc4 = new FrequentedLocation;
			$freqLoc4['temp_user_id'] = $temp_user['payload'];
			$freqLoc4['title'] = $freqLoc4Array[0];
			$freqLoc4['address'] = $freqLoc4Array[1];
			$freqLoc4['city'] = $freqLoc4Array[2];
			$freqLoc4['state'] = $freqLoc4Array[3];
			$freqLoc4['country'] = $freqLoc4Array[4];
			$freqLoc4['lat'] = $freqLoc4Array[5][0];
			$freqLoc4['lng'] = $freqLoc4Array[5][1];
	        $freqLoc4->save();
		}		
		if(sizeof($freqLoc5Array) === 4) {
			$freqLoc5 = new FrequentedLocation;
			$freqLoc5['temp_user_id'] = $temp_user['payload'];
			$freqLoc5['title'] = $freqLoc5Array[0];
			$freqLoc5['address'] = $freqLoc5Array[0];
			$freqLoc5['city'] = "new york";
			$freqLoc5['state'] = $freqLoc5Array[1];
			$freqLoc5['country'] = $freqLoc5Array[2];
			$freqLoc5['lat'] = $freqLoc5Array[3][0];
			$freqLoc5['lng'] = $freqLoc5Array[3][1];
	        $freqLoc5->save();
		} elseif (sizeof($freqLoc5Array) === 5) {
			$freqLoc5 = new FrequentedLocation;
			$freqLoc5['temp_user_id'] = $temp_user['payload'];
			$freqLoc5['title'] = $freqLoc5Array[0];
			$freqLoc5['address'] = $freqLoc5Array[0];
			$freqLoc5['city'] = $freqLoc5Array[1];
			$freqLoc5['state'] = $freqLoc5Array[2];
			$freqLoc5['country'] = $freqLoc5Array[3];
			$freqLoc5['lat'] = $freqLoc5Array[4][0];
			$freqLoc5['lng'] = $freqLoc5Array[4][1];
	        $freqLoc5->save();
		} elseif (sizeof($freqLoc5Array) === 6) {
			$freqLoc5 = new FrequentedLocation;
			$freqLoc5['temp_user_id'] = $temp_user['payload'];
			$freqLoc5['title'] = $freqLoc5Array[0];
			$freqLoc5['address'] = $freqLoc5Array[1];
			$freqLoc5['city'] = $freqLoc5Array[2];
			$freqLoc5['state'] = $freqLoc5Array[3];
			$freqLoc5['country'] = $freqLoc5Array[4];
			$freqLoc5['lat'] = $freqLoc5Array[5][0];
			$freqLoc5['lng'] = $freqLoc5Array[5][1];
	        $freqLoc5->save();
		}



        // return response()->json(['response' => $new_workplace]);
        return Redirect::route('dovetail', array('id' => $temp_user['payload']));

	}



	public function dovetail(Request $request, $id) {

		$workplace = Workplace::where('temp_user_id','=',$id)->get();
		$frequented_locations = FrequentedLocation::where('temp_user_id','=',$id)->get();

		return view('dovetails')->with(compact('workplace', 'frequented_locations'));
	}

	public function logout()
	{
		Auth::logout();	
		Session::flush();
		return Redirect::to('home');
	}


}
