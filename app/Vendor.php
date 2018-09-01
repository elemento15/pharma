<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model {

	protected $guarded = ['id','balance'];
	protected $appends = ['balance'];

	public function getBalanceAttribute()
	{
		$paid = 0;
		$orders = PurchaseOrder::where('vendor_id', $this->id)
		                       ->where('status', 'N')
		                       ->get();

		foreach ($orders as $key => $item) {
			$paid += $item->balance;
		}

		return $paid;
	}
}
