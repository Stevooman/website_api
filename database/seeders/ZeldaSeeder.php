<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZeldaSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		DB::table('zelda_games')->insert([
			[
        'systemId' => 13,
        'title' => 'Breath of the Wild'
      ],
      [
        'systemId' => 13,
        'title' => 'Tears of the Kingdom'
      ],
      [
        'systemId' => 3,
        'title' => 'Majora\'s Mask'
      ],
      [
        'systemId' => 12,
        'title' => 'The Minish Cap'
      ],
      [
        'systemId' => 6,
        'title' => 'The Wind Waker'
      ]
		]);



    // Zelda Users
    DB::table('zelda_users')->insert([
      [
        'userId' => 1,
        'zGameId' => 3,

      ],
      [
        'userId' => 3,
        'zGameId' => 1,

      ],
      [
        'userId' => 2,
        'zGameId' => 2,

      ],
      [
        'userId' => 5,
        'zGameId' => 4,

      ],
      [
        'userId' => 3,
        'zGameId' => 4,

      ],
      [
        'userId' => 1,
        'zGameId' => 5,

      ]
    ]);
	}
}