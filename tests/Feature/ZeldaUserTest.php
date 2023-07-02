<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

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
}