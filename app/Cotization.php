<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotization extends Model {

	protected $guarded = ['id','balance'];
	protected $appends = ['balance'];

	public function cotization_details()
	{
		return $this->hasMany('App\CotizationDetail');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function cotization_payments()
	{
		return $this->hasMany('App\CotizationPayment');
	}

	public function getBalanceAttribute()
	{
		$paid = 0;
		
		if ($this->status != 'C') {
			foreach ($this->cotization_payments as $item) {
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
