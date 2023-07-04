<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		DB::table('users')->insert([
			[
				'firstName' => 'Steve',
				'lastName' => 'Oman',
				'emailAddr' => 'stephen_oman145@yahoo.com',
				'userName' => 'PhantomWalrus',
				'password' => password_hash('Steve!23', PASSWORD_DEFAULT)
			],
			[
				'firstName' => 'Brock',
				'lastName' => 'Lessner',
				'emailAddr' => 'brock@yahoo.com',
				'userName' => 'RockCrusher',
				'password' => password_hash('Brock124#', PASSWORD_DEFAULT)
			],
			[
				'firstName' => 'Tiger',
				'lastName' => 'Woods',
				'emailAddr' => 'tiger@gmail.com',
				'userName' => 'GolfShot',
				'password' => password_hash('Tiger89%', PASSWORD_DEFAULT)
			],
			[
				'firstName' => 'Guy',
				'lastName' => 'Beahm',
				'emailAddr' => 'guy@midnightsociety.com',
				'userName' => 'DrDisrespect',
				'password' => password_hash('Soaring@42', PASSWORD_DEFAULT)
			],
			[
				'firstName' => 'Bert',
				'lastName' => 'Oman',
				'emailAddr' => 'bertus@yahoo.com',
				'userName' => 'Magab0b3r',
				'password' => password_hash('Bert387@!', PASSWORD_DEFAULT)
			]
		]);
	}
}