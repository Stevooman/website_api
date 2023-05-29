<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class CompanyTest extends TestCase
{

  public function testIndexReturnsAllCompaniesInTable(): void 
  {
    $this->get('api/v1/companies')
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        '*' => [
          'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
        ]
      ]);
  }



  public function testShowOneReturnsOneCompanyById(): void 
  {
    $this->get('api/v1/companies/2')
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
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
  }
}
