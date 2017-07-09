<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizationDetail extends Model {

	protected $guarded = ['id'];

	public function cotization()
	{
		return $this->belongsTo('App\Cotization');
	}

	public function product()
	{
		return $this->belongsTo('App\Product');
	}

}
