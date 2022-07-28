<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicTrxFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('public.trx_file', function(Blueprint $table)
		{
			$table->uuid('trx_file_id')->primary();
			$table->string('trx_cd',200);
			$table->string('file_nm', 100)->nullable();
			$table->string('file_tp', 20)->nullable();
			$table->string('file_path', 1000)->nullable();
			$table->string('note', 100)->nullable();
			$table->string('created_by', 255)->nullable();
			$table->string('updated_by', 255)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('public.trx_file');
	}

}
