<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{

  public function testIndexReturnsAllCompaniesInTable(): void 
  {
    $this->get('api/v1/companies')
      ->assertStatus(200)
      ->assertJsonStructure([
        '*' => [
          'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
        ]
      ]);
  }



  public function testShowOneCompanyById(): void 
  {
    $this->get('api/v1/companies/2')
      ->assertStatus(200)
      ->assertJsonStructure([
        'id', 'companyName', 'companyAddr', 'active', 'created_at', 'updated_at', 'deleted_at'
      ]);
  }
}
