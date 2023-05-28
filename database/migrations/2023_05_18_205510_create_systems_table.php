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
		Schema::create('systems', function (Blueprint $table) {
			$table->tinyIncrements('id')->autoIncrement();
			$table->string('name', 50)->default('');
			$table->tinyInteger('companyId')->default(0)->unsigned();
      $table->date('releaseDate')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
			$table->softDeletes();

			$table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('systems');
	}
};