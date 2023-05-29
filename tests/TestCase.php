<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Generator;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, RefreshDatabase;

	private Generator $faker;

	public function setUp(): void 
	{
		parent::setUp();
		$this->faker = Factory::create();
	}


	public function __get($key)
	{
		return $this->faker;
	}
}