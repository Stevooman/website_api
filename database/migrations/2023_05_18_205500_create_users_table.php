<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates a users table in the database. This table contains basic information fields, 
 * such as first and last name, email address, and a username/password. Password is 
 * encrypted before being added to the database. Soft deletes are also enabled.
 */
return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('users', function (Blueprint $table) {
			$table->smallIncrements('id')->autoIncrement();
			$table->string('firstName', 20)->default('');
			$table->string('lastName', 25)->default('');
			$table->string('emailAddr', 30)->default('');
			$table->string('userName', 20)->default('');
			$table->string('password', 255)->default('');
      $table->timestamp('email_verified_at')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
			$table->softDeletes();
    });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
	}
};