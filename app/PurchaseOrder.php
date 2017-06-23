<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model {

	protected $guarded = ['id'];

	public function purchase_order_details()
	{
		return $this->hasMany('App\PurchaseOrderDetail');
	}

	public function vendor()
	{
		return $this->belongsTo('App\Vendor');
	}

	public function status()
	{
		return $this->belongsTo('App\Status');
	}

}
