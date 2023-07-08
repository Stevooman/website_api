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
   * Tests that the show by User ID function returns correct Zelda user data.
   *
   * @return void
   */
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



  /**
   * Tests the create function to see if a zelda user record is created successfully.
   *
   * @return void
   */
  private function testZeldaUserIsCreatedSuccessfully(): void 
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

    $user = User::create([
      'firstName' => $this->faker->firstName,
      'lastName' => $this->faker->lastName,
      'emailAddr' => $this->faker->email,
      'userName' => $this->faker->firstName,
      'password' => 'BlahBlah34@',
      'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
    ]);

    $inputData = [
      'userId' => $user->id,
      'zGameId' => $zeldaGame->id
    ];

    $this->post(self::USERS_URI . '/LoZ', $inputData)
      ->assertStatus(Response::HTTP_CREATED)
      ->assertExactJson([
        'status' => 'success'
      ]);
  }



  /**
   * Tests if the delete function successfully soft deletes a record based on a given ID and user ID.
   *
   * @return void
   */
  private function testZeldaUserIsSoftDeletedSuccessfully(): void 
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

    $user = User::create([
      'firstName' => $this->faker->firstName,
      'lastName' => $this->faker->lastName,
      'emailAddr' => $this->faker->email,
      'userName' => $this->faker->firstName,
      'password' => 'BlahBlah34@',
      'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
    ]);

    $zelUser = ZeldaUser::create([
      'userId' => $user->id,
      'zGameId' => $zeldaGame->id
    ]);

    $this->delete(self::USERS_URI . "/$user->id" . '/LoZ')
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'deleted' => 1
      ]);

    $this->assertSoftDeleted('zelda_users', [
      'id' => $zelUser->id,
      'userId' => $zelUser->userId,
      'zGameId' => $zelUser->zGameId
    ]);
  }
}