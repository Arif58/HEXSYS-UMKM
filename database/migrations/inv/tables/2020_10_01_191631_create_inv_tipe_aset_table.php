<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvTipeAsetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inv.trx_tipe_aset', function(Blueprint $table)
		{
			$table->string('asettp_cd', 100)->primary('trx_tipe_aset_pkey');
			$table->string('asettp_no', 20)->nullable();
			$table->string('asettp_nm', 200)->nullable();
			$table->string('asettp_root', 100)->nullable();
			$table->integer('asettp_level')->nullable();
			$table->integer('masa_manfaat')->nullable();
			$table->integer('nilai_kapitalisasi')->nullable();
			$table->text('note')->nullable();
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
		Schema::drop('inv.trx_tipe_aset');
	}

}
