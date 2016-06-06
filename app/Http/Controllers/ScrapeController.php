<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapeController extends Controller {

	public function get_scrape_data () {
		$client = new Client();
		$priceArray = [];
	 	for ($i=1000; $i < 1080; $i++) { 
			$crawler = $client->request('GET', 'http://nymag.streeteasy.com/nyc/building/'+$i+'');
			$url = $crawler->filter('tbody > tr > td')->eq($i)->first();
			array_push($priceArray, $url);
		}
		
		dump($priceArray);	
		
		
	}

}
