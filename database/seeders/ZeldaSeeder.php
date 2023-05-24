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
		DB::table('legend_of_zelda')->insert([
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
	}
}