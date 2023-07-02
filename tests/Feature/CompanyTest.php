<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Company;

class CompanyTest extends TestCase
{
  private const COMPANIES_URI = 'api/v1/companies';

  public function testIndexReturnsAllCompaniesInTable(): void 
  {
    $this->get(self::COMPANIES_URI)
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        '*' => [
          'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
        ]
      ]);
  }



  public function testShowOneReturnsOneCompanyById(): void 
  {
    $company = Company::create([
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ]);
    
    $this->get(self::COMPANIES_URI . "/$company->id")
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonFragment([
        'id' => $company->id,
        'companyName' => $company->companyName,
        'companyAddr' => $company->companyAddr,
        'active' => 1
      ]);
  }



  public function testShowAllActiveReturnsActiveCompanies(): void 
  {
    $this->get('api/v1/activeCompanies')
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        '*' => [
          'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
        ]
        ]);

    $response = $this->get('api/v1/activeCompanies');
    $json = $response->json();
    foreach ($json as $j) {
      $this->assertSame(1, $j['active']);
    }
  }



  public function testCompanyIsCreatedSuccessfully(): void 
  {
    $inputData = [
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address(),
      'active' => 1
    ];

    $this->post(self::COMPANIES_URI, $inputData)
      ->assertStatus(Response::HTTP_CREATED)
      ->assertExactJson([
        'status' => 'success'
      ]);

    $this->assertDatabaseHas('companies', $inputData);
  }



  public function testCompanyIsUpdatedSuccessfully(): void 
  {
    $company = Company::create([
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ]);

    $inputData = [
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ];

    $this->put(self::COMPANIES_URI . "/$company->id", $inputData)
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'updated' => 1
      ]);

    $this->assertDatabaseHas('companies', $inputData);
  }



  public function testCompanyIsSoftDeletedSuccessfully(): void 
  {
    $company = Company::create([
      'companyName' => $this->faker->name,
      'companyAddr' => $this->faker->address
    ]);

    $this->delete(self::COMPANIES_URI . "/$company->id")
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'deleted' => 1
      ]);

    $this->assertSoftDeleted('companies', [
      'id' => $company->id, 
      'companyName' => $company->companyName,
      'companyAddr' => $company->companyAddr
    ]);
  }
}
