<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model {

	protected $guarded = ['id'];

	public function purchase_order_details()
	{
		return $this->hasMany('App\PurchaseOrderDetail');
		
	}

}
