<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\ZeldaGame;
use App\Models\ZeldaUser;
use App\Models\Company;
use App\Models\System;
use App\Models\User;

class ZeldaUserTest extends TestCase
{
	/**
	 * Base endpoint URI's
	 */
	private const USERS_URI = 'api/v1/users';



	/**
	 * Tests the index method shows all records of Zelda users in the database.
	 *
	 * @return void
	 */
	public function testIndexShowsAllZeldaUserInfo(): void 
	{
		$this->get(self::USERS_URI . '/LoZ')
			->assertStatus(Response::HTTP_OK)
			->assertJsonStructure([
				'*' => [
					'id', 'userId', 'firstName', 'lastName', 
					'zGameId', 'title', 'created_at', 'updated_at', 
					'deleted_at'
				]
			]);
	}



  public function testShowByUserIdReturnsOneRecord(): void 
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

    $zeldaGame = ZeldaGame::create([
      'systemId' => $system->id,
      'title' => $this->faker->word()
    ]);

    $password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
    $user = User::create([
      'firstName' => $this->faker->firstName,
      'lastName' => $this->faker->lastName,
      'emailAddr' => $this->faker->email,
      'userName' => $this->faker->firstName,
      'password' => $password,
      'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
    ]);

    $zUser = ZeldaUser::create([
      'userId' => $user->id,
      'zGameId' => $zeldaGame->id
    ]);

    $this->get(self::USERS_URI . "/$user->id" . '/LoZ')
      ->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'id', 'userId', 'firstName', 'lastName', 
        'zGameId', 'title', 'created_at', 'updated_at', 'deleted_at'
      ]);
  }
}