<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model {

	protected $table = 'workplaces';

	protected $fillable = ['address', 'city', 'state', 'lat', 'lng'];

	public function tempuser()
	{
        return $this->belongsTo('TempUser');
	}

}
