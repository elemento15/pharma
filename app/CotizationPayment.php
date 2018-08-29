<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizationPayment extends Model {

	protected $guarded = ['id'];

	public $timestamps = false;

	public function cotization()
	{
		return $this->belongsTo('App\Cotization');
	}

	public function payment()
	{
		return $this->belongsTo('App\Payment');
	}

}
