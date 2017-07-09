<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class UserAdminSeeder extends Seeder {

	/**
	 * Admin User
	 */
	public function run()
	{
		User::create([
			'name' => 'Administrador',
			'email' => 'admin@example.com',
			'password' => Hash::make('administrator')
		]);
	}
}
