<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

use DB;

class ScrapeController extends Controller {

	public function get_scrape_data () {

	$client = new Client();
	$crawler = new Crawler();
	

	$bldg_id;
	$bldg_address;
	$bldg_address_array = [];
	$bldg_coordinates;

	$listing_id;
	$listing_status;
	$listing_details;

	$nodeValues = [];
	$bldgNodeValues = [];


	for ($i=100; $i < 2500; $i++) { 

		$crawler = $client->request('GET', 'http://nymag.streeteasy.com/nyc/building/'+$i+'');
		
			// building address

			$bldg_address = $crawler->filter('.main-info > .subtitle')->text();
			$bldg_address_array = explode(',', $bldg_address);
			$bldg_address_array[4] = "USA";
			// building coordinates
			$bldg_coordinates = $crawler->filter('meta[name="geo.position"]')->attr('content');
			$bldg_coordinates_array = explode(';', $bldg_coordinates);
			$bldg_lat = $bldg_coordinates_array[0];
			$bldg_lng = $bldg_coordinates_array[1];

			// dump($bldg_coordinates_array);

			DB::insert('insert into buildings (title,address,city,state,zip,country,lat,lng) values (?,?,?,?,?,?,?,?)',[$bldg_address_array[0], $bldg_address_array[0], $bldg_address_array[1], $bldg_address_array[2], $bldg_address_array[3], $bldg_address_array[4], $bldg_coordinates_array[0], $bldg_coordinates_array[1]]);


			// $nodeValues = $crawler->filter('.building-pages > tbody > tr')->each(function ($node, $i) {
			// 	$listing_id[$i] = $node->attr("id");
			// 	$listing_status[$i] = $node->attr("data-gtm-track");
			// 	$listing_details[$i] = $node->children()->first()->html();

			// 	// if($listing_status[$i] !== 'active-sales'){
			// 	// }
				
			// 	dump($i.'|'.$listing_id[$i].': '.$listing_status[$i].'--'.$listing_details[$i]);

			// });

	  $i = $i + 100;
	  }

  }
}


