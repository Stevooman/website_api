<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use app\Models\User;

class UserTest extends TestCase
{
	private const USERS_URI = 'api/v1/users';



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
					'emailAddr', 'email_verified_at', 
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
			'firstName' => $this->faker->firstName(),
			'lastName' => $this->faker->lastName(),
			'emailAddr' => $this->faker->email(),
			'userName' => $this->faker->userName(),
			'password' => $password,
			'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
		]);

		$this->get(self::USERS_URI . "/$user->id")
			->assertStatus(Response::HTTP_OK)
			->assertExactJson([
				'id' => $user->id,
				'firstName' => $user->firstName,
				'lastName' => $user->lastName,
				'emailAddr' => $user->emailAddr,
				'userName' => $user->userName,
				'password' => $password,
				'email_verified_at' => $user->email_verified_at,
				'created_at' => $user->created_at,
				'updated_at' => $user->updated_at,
				'deleted_at' => $user->deleted_at
			]);
	}



	/**
	 * Tests the create method successfully creates a new user record.
	 *
	 * @return void
	 */
	public function testUserIsCreatedSuccessfully(): void 
	{
		$password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
		$inputData = [
			'firstName' => $this->faker->firstName(),
			'lastName' => $this->faker->lastName(),
			'emailAddr' => $this->faker->email(),
			'userName' => $this->faker->userName(),
			'password' => $password,
			'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
		];

		$this->post(self::USERS_URI, $inputData)
			->assertStatus(Response::HTTP_CREATED)
			->assertExactJson([
				'status' => 'success'
			]);
	}



	/**
	 * Tests the update method successfully updates a user's email, username, and/or password by ID.
	 *
	 * @return void
	 */
	public function testUserIsUpdatedSuccessfully(): void 
	{
		$password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
		$user = User::create([
			'firstName' => $this->faker->firstName(),
			'lastName' => $this->faker->lastName(),
			'emailAddr' => $this->faker->email(),
			'userName' => $this->faker->userName(),
			'password' => $password,
			'email_verified_at' => $this->faker->date('Y-m-d H:i:s')
		]);

		$inputData = [
			'userName' => $this->faker->userName(),
			'emailAddr' => $this->faker->email(),
			'password' => password_hash($this->faker->password(), PASSWORD_DEFAULT)
		];

		$this->put(self::USERS_URI . "/$user->id", $inputData)
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
		$password = password_hash($this->faker->password(), PASSWORD_DEFAULT);
		$user = User::create([
			'firstName' => $this->faker->firstName(),
			'lastName' => $this->faker->lastName(),
			'emailAddr' => $this->faker->email(),
			'userName' => $this->faker->userName(),
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
			'firstname' => $user->firstname,
			'lastName' => $user->lastName,
			'emailAddr' => $user->emailAddr,
			'userName' => $user->userName,
			'password' => $user->password,
			'email_verified_at' => $user->email_verified_at
		]);
	}
}