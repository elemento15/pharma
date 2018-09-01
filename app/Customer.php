<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $guarded = ['id','balance'];
	protected $appends = ['balance'];

	public function getBalanceAttribute()
	{
		$paid = 0;
		$cotizations = Cotization::where('customer_id', $this->id)
		                         ->where('status', 'N')
		                         ->get();

		foreach ($cotizations as $key => $item) {
			$paid += $item->balance;
		}

		return $paid;
	}
}
