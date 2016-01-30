<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Apartment as Apartment;

class ApartmentsController extends Controller {

	public function index() {

		$apts = Apartment::all()
		dd($apts);

	}

}
