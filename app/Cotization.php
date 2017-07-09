<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotization extends Model {

	protected $guarded = ['id'];

	public function cotization_details()
	{
		return $this->hasMany('App\CotizationDetail');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function status()
	{
		return $this->belongsTo('App\Status');
	}

}
