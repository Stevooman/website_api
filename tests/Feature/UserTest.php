<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{
  /**
   * Base endpoint URI's to the Users API.
   */
	private const USERS_URI = 'api/v1/users';
  private const UPDATE_EMAIL_URI = 'api/v1/email/users';
  private const UPDATE_PASSWORD_URI = 'api/v1/password/users';
  private const UPDATE_USERNAME_URI = 'api/v1/username/users';


	/**
	 * Tests the index method returns all records of users in the database.
	 *
	 * @return void
	 */
	public function testIndexReturnsAllUsers(): void 
	{
		$this->get(self::USERS_URI)
			->assertStatus(Response::HTTP_OK)
			->assertJsonStructure([
				'*' => [
					'id', 'firstName', 'lastName', 
					'emailAddr', 'email_verified_at', 'email_updated_at', 'password_updated_at', 
					'created_at', 'updated_at', 'deleted_at'
				]
			]);
	}



	/**
	 * Tests the showOne method returns first and last name, email address of a user by ID number.
	 *
	 * @return void
	 */
	public function testShowOneReturnsOneUserById(): void 
	{
		$password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
		$user = User::create([
			'firstName' => $this->faker->firstName,
			'lastName' => $this->faker->lastName,
			'emailAddr' => $this->faker->email,
			'userName' => $this->faker->firstName,
			'password' => $password,
			'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
		]);

		$this->get(self::USERS_URI . "/$user->id")
			->assertStatus(Response::HTTP_OK)
			->assertJsonFragment([
				'id' => $user->id,
				'firstName' => $user->firstName,
				'lastName' => $user->lastName,
				'emailAddr' => $user->emailAddr,
				'userName' => $user->userName,
				'email_verified_at' => $user->email_verified_at
			]);
	}



	/**
	 * Tests the create method successfully creates a new user record.
	 *
	 * @return void
	 */
	public function testUserIsCreatedSuccessfully(): void 
	{
		$password = password_hash($this->faker->password, PASSWORD_DEFAULT);
		$inputData = [
			'firstName' => $this->faker->firstName,
			'lastName' => $this->faker->lastName,
			'emailAddr' => $this->faker->email,
			'userName' => $this->faker->firstName,
			'password' => $password		
    ];

		$this->post(self::USERS_URI, $inputData)
			->assertStatus(Response::HTTP_CREATED)
			->assertExactJson([
				'status' => 'success'
			]);
	}



	/**
	 * Tests that a user's email is successfully updated.
	 *
	 * @return void
	 */
	public function testEmailIsUpdatedSuccessfully(): void 
	{
		$password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
		$user = User::create([
			'firstName' => $this->faker->firstName,
			'lastName' => $this->faker->lastName,
			'emailAddr' => $this->faker->email,
			'userName' => $this->faker->firstName,
			'password' => $password		
    ]);

		$inputData = [
			'emailAddr' => $this->faker->email		
    ];

		$this->put(self::UPDATE_EMAIL_URI . "/$user->id", $inputData)
			->assertStatus(Response::HTTP_OK)
			->assertExactJson([
				'updated' => 1
			]);

		$this->assertDatabaseHas('users', $inputData);
	}



  /**
   * Tests that a user's password is successfully updated.
   *
   * @return void
   */
  public function testPasswordIsUpdatedSuccessfully(): void
  {
    $oldPassword = password_hash($this->faker->password, PASSWORD_DEFAULT);
    $user = User::create([
      'firstName' => $this->faker->firstName,
      'lastName' => $this->faker->lastName,
      'emailAddr' => $this->faker->email,
      'userName' => $this->faker->firstName,
      'password' => $oldPassword
    ]);

    $newPassword = 'Anyone123@';

    $inputData = [
      'password' => $newPassword
    ];

    $this->put(self::UPDATE_PASSWORD_URI . "/$user->id", $inputData)
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'updated' => 1
      ]);

    $updated = User::where('id', $user->id)->first();
    $this->assertTrue(password_verify($newPassword, $updated->password));
  }



  /**
   * Tests that a user's username is successfully updated.
   *
   * @return void
   */
  public function testUsernameIsUpdatedSuccessfully(): void
  {
    $password = password_hash($this->faker->password, PASSWORD_DEFAULT);
    $user = User::create([
      'firstName' => $this->faker->firstName,
      'lastName' => $this->faker->lastName,
      'emailAddr' => $this->faker->email,
      'userName' => $this->faker->firstName,
      'password' => $password
    ]);

    $inputData = [
      'userName' => $this->faker->firstName
    ];

    $this->put(self::UPDATE_USERNAME_URI . "/$user->id", $inputData)
      ->assertStatus(Response::HTTP_OK)
      ->assertExactJson([
        'updated' => 1
      ]);

    $this->assertDatabaseHas('users', $inputData);
  }


	/**
	 * Tests the delete method successfully soft deletes a user record by ID.
	 *
	 * @return void
	 */
	public function testUserIsSoftDeletedSuccessfully(): void 
	{
		$password = password_hash($this->faker->password, PASSWORD_DEFAULT);
		$user = User::create([
			'firstName' => $this->faker->firstName,
			'lastName' => $this->faker->lastName,
			'emailAddr' => $this->faker->email,
			'userName' => $this->faker->firstName,
			'password' => $password,
			'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
		]);

		$this->delete(self::USERS_URI . "/$user->id")
			->assertStatus(Response::HTTP_OK)
			->assertExactJson([
				'deleted' => 1
			]);

		$this->assertSoftDeleted('users', [
			'id' => $user->id,
			'firstName' => $user->firstName,
			'lastName' => $user->lastName,
			'emailAddr' => $user->emailAddr,
			'userName' => $user->userName,
			'email_verified_at' => $user->email_verified_at
		]);
	}
}