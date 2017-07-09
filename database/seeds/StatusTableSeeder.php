<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Status;

class StatusTableSeeder extends Seeder {

	/**
	 * Statuses for Purchase Orders
	 */
	public function run()
	{
		$status = [
			['name' => 'Nueva',     'type' => 'PO',  'is_default' => 1, 'is_final' => 0],
			['name' => 'Pendiente', 'type' => 'PO',  'is_default' => 0, 'is_final' => 0],
			['name' => 'Terminada', 'type' => 'PO',  'is_default' => 0, 'is_final' => 1],
			['name' => 'Nueva',     'type' => 'COT', 'is_default' => 1, 'is_final' => 0],
			['name' => 'Pendiente', 'type' => 'COT', 'is_default' => 0, 'is_final' => 0],
			['name' => 'Terminada', 'type' => 'COT', 'is_default' => 0, 'is_final' => 1]
		];

		foreach ($status as $item) {
			Status::create([
				'name'       => $item['name'],
				'type'       => $item['type'],
				'is_default' => $item['is_default'],
				'is_final'   => $item['is_final']
			]);
		}
	}

}