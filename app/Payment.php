<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

	protected $guarded = ['id'];

	public function type()
	{
		return $this->belongsTo('App\PaymentType', 'payment_type_id');
	}

	public function cotization_payments()
	{
		return $this->hasMany('App\CotizationPayment');
	}

	public function purchase_payments()
	{
		return $this->hasMany('App\PurchasePayment');
	}

}
