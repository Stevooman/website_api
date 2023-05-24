<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('systems')->insert([
      [
        'name' => 'Nintendo Entertainment System',
        'companyId' => 1,
        'releaseDate' => '1983-07-15'
      ],
      [
        'name' => 'Super Nintendo Entertainment System',
        'companyId' => 1,
        'releaseDate' => '1990-11-21'
      ],
      [
        'name' => 'Nintendo 64',
        'companyId' => 1,
        'releaseDate' => '1996-06-23'
      ],
      [
        'name' => 'PlayStation',
        'companyId' => 2,
        'releaseDate' => '1994-12-03'
      ],
      [
        'name' => 'Xbox',
        'companyId' => 3,
        'releaseDate' => '2001-11-15'
      ],
      [
        'name' => 'GameCube',
        'companyId' => 1,
        'releaseDate' => '2001-09-14'
      ],
      [
        'name' => 'Nintendo 3DS',
        'companyId' => 1,
        'releaseDate' => '2011-02-26'
      ],
      [
        'name' => 'Nintendo DS',
        'companyId' => 1,
        'releaseDate' => '2004-11-21'
      ],
      [
        'name' => 'Sega Genesis',
        'companyId' => 7,
        'releaseDate' => '1988-10-29'
      ],
      [
        'name' => 'Game Boy',
        'companyId' => 1,
        'releaseDate' => '1988-10-29'
      ],
      [
        'name' => 'Game Boy Color',
        'companyId' => 1,
        'releaseDate' => '1997-10-01'
      ],
      [
        'name' => 'Game Boy Advance',
        'companyId' => 1,
        'releaseDate' => '2000-09-17'
      ],
      [
        'name' => 'Nintendo Switch',
        'companyId' => 1,
        'releaseDate' => '2017-03-14'
      ]
    ]);
  }
}
