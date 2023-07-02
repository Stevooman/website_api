<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Company;
use App\Models\System;
use Illuminate\Http\Response;
use Tests\TestCase;

class SystemTest extends TestCase
{
  private const SYSTEMS_URI = 'api/v1/systems';
  /**
   * Tests the index function to see if it returns all data from systems.
   *
   * @return void
   */
	public function testIndexReturnsAllSystems(): void 
	{
		$this->get(self::SYSTEMS_URI)
			->assertStatus(Response::HTTP_OK)
			->assertJsonStructure([
				'*' => [
					'id', 'name', 'companyId', 'releaseDate', 'created_at',
          'updated_at', 'deleted_at'
				]
			]);
	}


  /**
   * Tests the showOne function to see if it returns correct data for 
   * a given system ID number.
   *
   * @return void
   */
	public function testShowOneReturnsOneSystemByIdAndItsCompanyInfo(): void 
	{
		$company = Company::create([
			'companyName' => $this->faker->name,
			'companyAddr' => $this->faker->address
		]);

		$system = System::create([
			'name' => $this->faker->name,
      'companyId' => $company->id,
			'releaseDate' => $this->faker->date('Y-m-d')
		]);

		$this->get(self::SYSTEMS_URI . "/$system->id")
			->assertStatus(Response::HTTP_OK)
			->assertJsonFragment([
				'id' => $system->id,
				'name' => $system->name,
				'releaseDate' => $system->releaseDate,
				'companyName' => $company->companyName,
				'companyAddr' => $company->companyAddr
			]);
	}


  /**
   * Tests the showDateRange function to see if it returns the 
   * correct number of JSON objects for a given date range
   * as well as the correct exact JSON data for another date range.
   *
   * @return void
   */
	public function testShowDateRangeReturnsSystemsReleasedBetweenCertainDates(): void 
	{
    $companyIds = [];
    $systemIds = [];
    $systemNames = [];

		for ($i = 0; $i < 10; $i++) {
			$company = Company::create([
				'companyName' => $this->faker->name,
				'companyAddr' => $this->faker->address
			]);
      array_push($companyIds, $company->id);

			$system = System::create([
				'name' => $this->faker->name,
				'companyId' => $companyIds[$i],
				'releaseDate' => "201$i-06-05"
			]);
      array_push($systemIds, $system->id);
      array_push($systemNames, $system->name);
		}

		$this->call('GET', 'api/v1/systemReleases', [
			'startDate' => '2012-01-01',
			'endDate' => '2014-01-01'
		])
		->assertStatus(Response::HTTP_OK)
		->assertJsonCount(2);



		$this->call('GET', 'api/v1/systemReleases', [
			'startDate' => '2012-01-01',
			'endDate' => '2016-01-01'
		])
			->assertExactJson([
				[
					'id' => $systemIds[2],
					'companyId' => $companyIds[2],
					'releaseDate' => '2012-06-05',
          'name' => $systemNames[2]
				],
				[
					'id' => $systemIds[3],
					'companyId' => $companyIds[3],
					'releaseDate' => '2013-06-05',
          'name' => $systemNames[3]
        ],
        [
          'id' => $systemIds[4],
          'companyId' => $companyIds[4],
          'releaseDate' => '2014-06-05',
          'name' => $systemNames[4]
        ],
        [
          'id' => $systemIds[5],
          'companyId' => $companyIds[5],
          'releaseDate' => '2015-06-05',
          'name' => $systemNames[5]
        ]
			]);
	}


  /**
   * Tests the create function to see if a system record is
   * created successfully.
   *
   * @return void
   */
  public function testSystemIsCreatedSuccessfully(): void 
  {
    $company = Company::create([
				'companyName' => $this->faker->name,
				'companyAddr' => $this->faker->address()
			]);

    $inputData = [
      'name' => $this->faker->name,
      'companyId' => $company->id,
      'releaseDate' => $this->faker->date
    ];

    $this->post(self::SYSTEMS_URI, $inputData)
      ->assertStatus(Response::HTTP_CREATED)
      ->assertExactJson([
        'status' => 'success'
      ]);
  }


  /**
   * Tests the update function to see if the record with the given
   * ID in the path is updated successfully.
   *
   * @return void
   */
  public function testSystemIsUpdatedSuccessfully(): void 
  {
    $company = Company::create([
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ]);

    $system = System::create([
      'name' => $this->faker->name,
      'companyId' => $company->id,
      'releaseDate' => $this->faker->date
    ]);

    $inputData = [
      'name' => $this->faker->name,
      'releaseDate' => $this->faker->date
    ];

    $this->put(self::SYSTEMS_URI . "/$system->id", $inputData)
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'updated' => 1
      ]);

    $this->assertDatabaseHas('systems', $inputData);
  }


  /**
   * Tests if the delete function successfully soft deletes a record
   * based on a given ID in the path.
   *
   * @return void
   */
  public function testSystemIsSoftDeletedSuccessfully(): void 
  {
    $company = Company::create([
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ]);

    $system = System::create([
      'name' => $this->faker->name,
      'companyId' => $company->id,
      'releaseDate' => $this->faker->date
    ]);

    $this->delete(self::SYSTEMS_URI . "/$system->id")
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'deleted' => 1
      ]);

    $this->assertSoftDeleted('systems', [
      'id' => $system->id,
      'name' => $system->name,
      'companyId' => $system->companyId,
      'releaseDate' => $system->releaseDate
    ]);
  }
}