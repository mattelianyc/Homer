<?php namespace App\Http\Controllers;

use Auth;
use Session;
use Redirect;

use App\Apartment as Apartment;
use App\Workplace as Workplace;
use App\FrequentedLocation as FrequentedLocation;

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
	 *
	 * @return Response
	 */
	public function index()
	{
		$apartments = Apartment::all();
		$workplaces = Workplace::all();
		$frequented_locations = FrequentedLocation::all();


	$aptArray;
	$wpArray;
	$flArray;


	foreach ($apartments as $apt) {
		array_push(array($apt->lat, $apt->lng, $apt->title, $apt->address, $apt->city, $apt->state), $aptArray);
	}

	// dd($apartments);

	foreach ($workplaces as $wp) {
		array_push(array($wp->lat, $wp->lng, $wp->title, $wp->address, $wp->city, $wp->state), $wpArray);
	}

    foreach ($frequented_locations as $fl) {
    	array_push(array($fl->lat, $fl->lng, $fl->title, $fl->address, $fl->city, $fl->state), $flArray);    
    }


		return view('home')->with(compact('aptArray', 'wpArray', 'flArray'));
	}

	public function logout()
	{
		Auth::logout();	
		Session::flush();
		return Redirect::to('home');
	}


}
