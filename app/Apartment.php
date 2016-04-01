<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model {

	protected $table = 'apartments';

	public function building()
	{
        return $this->belongsTo('Building');
	}

}
