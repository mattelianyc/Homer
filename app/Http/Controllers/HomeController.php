<?php namespace App\Http\Controllers;

use Auth;
use Session;
use Redirect;
use Illuminate\Http\Request as Request;
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

		$workplace_coordinates = Input::get('workplace_coords');
		$freqLoc1_coordinates = Input::get('freq_loc_coords_1');
		$freqLoc2_coordinates = Input::get('freq_loc_coords_2');
		$freqLoc3_coordinates = Input::get('freq_loc_coords_3');

		$workplaceArray = explode(', ', $workplace);
		$freqLoc1Array = explode(', ', $freqLoc1);
		$freqLoc2Array = explode(', ', $freqLoc2);
		$freqLoc3Array = explode(', ', $freqLoc3);

		$workplace_CoordsArray = explode(', ', $workplace_coordinates);
		$FL1_coords_array = explode(', ', $freqLoc1_coordinates);
		$FL2_coords_array = explode(', ', $freqLoc2_coordinates);
		$FL3_coords_array = explode(', ', $freqLoc3_coordinates);

		array_push($workplaceArray, $workplace_CoordsArray);
		array_push($freqLoc1Array, $FL1_coords_array);
		array_push($freqLoc2Array, $FL2_coords_array);
		array_push($freqLoc3Array, $FL3_coords_array);

		// $session = Session::all();
		// $temp_user = TempUser::where('payload', '=', $request->get('temp_user_id'))->get();

		// if($temp_user) {

		// 	$new_temp_user = new TempUser;
		// 	$new_temp_user['payload'] = $session['_token'];
		// 	$new_temp_user->save();


		// 	$new_workplace = new Workplace($request->all());
		// 	$new_workplace['temp_user_id'] = $new_temp_user['payload'];
	 //        $new_workplace->save();

		// } else {

		// 	$temp_user = TempUser::where('payload', '=', $request->get('temp_user_id'))->first();
		// 	// dd($temp_user);
		// 	$new_workplace = new Workplace($request->all());
		// 	$new_workplace['temp_user_id'] = $temp_user['payload'];
	 //        $new_workplace->save();

		// }



	        return Redirect::to('home');
	}

	public function frequentedLocations(Request $request) {

		if ($request->isMethod('post')){    
            return response()->json(['response' => 'This is post method']); 
        }

        return response()->json(['response' => 'This is get method']);

	}

	public function logout()
	{
		Auth::logout();	
		Session::flush();
		return Redirect::to('home');
	}


}
