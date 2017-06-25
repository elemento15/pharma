<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPrice extends Model {

	protected $guarded = ['id'];

	public function vendor()
	{
		return $this->belongsTo('App\Vendor');
	}

	public function product()
	{
		return $this->belongsTo('App\Product');
	}

}
