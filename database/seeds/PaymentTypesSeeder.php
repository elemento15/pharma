<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\PaymentType;

class PaymentTypesSeeder extends Seeder {

	/**
	 * Admin User
	 */
	public function run()
	{
		$types = [
			[
				'name' => 'Efectivo',
				'code' => 'EFE'
			],[
				'name' => 'Tarjeta de Débito',
				'code' => 'TD'
			],[
				'name' => 'Tarjeta de Crédito',
				'code' => 'TC'
			]
		];

		foreach ($types as $item) {
			PaymentType::create($item);
		}

	}
}