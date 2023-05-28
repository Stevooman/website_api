<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('zelda_users', function (Blueprint $table) {
			$table->smallIncrements('id')->autoIncrement();
			$table->smallInteger('userId')->default(0)->unsigned();
			$table->tinyInteger('zGameId')->default(0)->unsigned();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

			$table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('zGameId')->references('id')->on('legend_of_zelda')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('zelda_users');
	}
};