<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
/**
 * Run the database seeds.
 */
  public function run(): void
  {
    DB::table('companies')->insert([
      [
        'companyName' => 'Nintendo',
        'companyAddr' => '123 Kyoto St, Japan'
      ],
      [
        'companyName' => 'Sony',
        'companyAddr' => '455 42nd St, Tokyo, Japan'
      ],
      [
        'companyName' => 'Microsoft',
        'companyAddr' => '1611 First St, San Francisco, CA 97455'
      ],
      [
        'companyName' => 'EA Games',
        'companyAddr' => '1400 South 1st, Los Angeles, CA 76643'
      ],
      [
        'companyName' => 'Ubisoft',
        'companyAddr' => '243 33rd St, Las Vegas, NV 80042'
      ],
      [
        'companyName' => 'Epic Games',
        'companyAddr' => '123 Industrial Ave, Durham, NC 80634'
      ],
      [
        'companyName' => 'Sega',
        'companyAddr' => '206 Park Ave, New York, NY 27811'
      ]
    ]);
  }
}
