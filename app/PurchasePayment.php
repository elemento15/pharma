<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model {

	protected $guarded = ['id'];

	public $timestamps = false;

	public function purchase_order()
	{
		return $this->belongsTo('App\PurchaseOrder');
	}

	public function payment()
	{
		return $this->belongsTo('App\Payment');
	}

}
