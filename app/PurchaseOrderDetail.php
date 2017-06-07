<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model {

	protected $guarded = ['id'];

	public function purchase_order()
	{
		return $this->belongsTo('App\PurchaseOrder');
	}

	public function product()
	{
		return $this->belongsTo('App\Product');
	}

}
