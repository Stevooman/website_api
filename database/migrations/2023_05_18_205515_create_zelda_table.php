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
		Schema::create('legend_of_zelda', function (Blueprint $table) {
			$table->tinyIncrements('id')->autoIncrement();
			$table->tinyInteger('systemId')->default(0)->unsigned();
			$table->string('title', 40)->default('');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

			$table->foreign('systemId')->references('id')->on('systems')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('legend_of_zelda');
	}
};