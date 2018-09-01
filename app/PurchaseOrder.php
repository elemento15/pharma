<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model {

	protected $guarded = ['id','balance'];
	protected $appends = ['balance'];

	public function purchase_order_details()
	{
		return $this->hasMany('App\PurchaseOrderDetail');
	}

	public function vendor()
	{
		return $this->belongsTo('App\Vendor');
	}

	public function purchase_payments()
	{
		return $this->hasMany('App\PurchasePayment');
	}

	public function getBalanceAttribute()
	{
		$paid = 0;
		
		if ($this->status != 'C') {
			foreach ($this->purchase_payments as $item) {
				if ($item->payment->active) {
					$paid += $item->amount;
				}
			}

			return $this->total - $paid;
		} else {
			return 0;
		}
	}

}
