<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class ScrapeController extends Controller {

	public function get_scrape_data () {

	$client = new Client();
	$crawler = new Crawler();
	

	$bldg_id;
	$bldg_address;
	$bldg_coordinates;

	$listing_id;
	$listing_status;
	$listing_details;

	$nodeValues = [];
	$bldgNodeValues = [];

	

	
	for ($i=40; $i < 50; $i++) { 

		$crawler = $client->request('GET', 'http://nymag.streeteasy.com/nyc/building/'+$i+'');
		
			// building address

			$bldg_address = $crawler->filter('.main-info > .subtitle')->text();
			dump($bldg_address);
			
			// building coordinates
		
			// $bldg_coordinates = $crawler->filter('meta[name="geo.position"]')->attr('content');
			// dump($bldg_coordinates);

			// $nodeValues = $crawler->filter('.building-pages > tbody > tr')->each(function ($node, $i) {
			// 	$listing_id[$i] = $node->attr("id");
			// 	$listing_status[$i] = $node->attr("data-gtm-track");
			// 	$listing_details[$i] = $node->children()->first()->html();

			// 	// if($listing_status[$i] !== 'active-sales'){
			// 	// }
				
			// 	dump($i.'|'.$listing_id[$i].': '.$listing_status[$i].'--'.$listing_details[$i]);

			// });

	  }

  }
}


