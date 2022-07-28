<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicComAktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.com_aktivitas', function (Blueprint $table) {
            $table->string('aktivitas_cd',20);
            $table->string('aktivitas_nm',200)->nullable();
			$table->string('aktivitas_tp', 20)->nullable();
			$table->string('standar_tp', 20)->nullable();
			$table->string('note',500)->nullable();
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->primary('aktivitas_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public.com_aktivitas');
    }
}
