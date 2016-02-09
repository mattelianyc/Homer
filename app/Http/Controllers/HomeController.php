<?php namespace App\Http\Controllers;

use Auth;
use Session;
use Redirect;
use Illuminate\Http\Request as Request;

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

		$session = Session::all();
		$temp_user = TempUser::where('payload', '=', $request->get('temp_user_id'))->get();

		if($temp_user) {

			$new_temp_user = new TempUser;
			$new_temp_user['payload'] = $session['_token'];
			$new_temp_user->save();


			$new_workplace = new Workplace($request->all());
			$new_workplace['temp_user_id'] = $new_temp_user['payload'];
	        $new_workplace->save();

		} else {

			$temp_user = TempUser::where('payload', '=', $request->get('temp_user_id'))->first();
			// dd($temp_user);
			$new_workplace = new Workplace($request->all());
			$new_workplace['temp_user_id'] = $temp_user['payload'];
	        $new_workplace->save();

		}



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
