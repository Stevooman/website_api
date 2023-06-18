<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

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
					'id', 'firstName', 'lastName', 'emailAddr', 
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
		
	}



	/**
	 * Tests the create method successfully creates a new user record.
	 *
	 * @return void
	 */
	public function testUserIsCreatedSuccessfully(): void 
	{

	}



	/**
	 * Tests the update method successfully updates a user's email, username, and/or password.
	 *
	 * @return void
	 */
	public function testUserIsUpdatedSuccessfully(): void 
	{

	}



	/**
	 * Tests the delete method successfully soft deletes a user record by ID.
	 *
	 * @return void
	 */
	public function testUserIsSoftDeletedSuccessfully(): void 
	{

	}
}