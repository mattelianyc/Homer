<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Goutte;

class ScrapeController extends Controller {

	public function get_scrape_data () {

		$priceArray = [];
		// for ($i=1; $i < 25; $i++) { 
			$crawler = Goutte::request('GET', 'http://nymag.streeteasy.com/nyc/building/100');
			$url = $crawler->filter('.MostViewedItemText-price')->first();
			array_push($priceArray, $url);
		// }
		
		
		dump($priceArray);	
	}

}
