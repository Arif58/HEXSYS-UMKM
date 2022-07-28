<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicComAgingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.com_aging_detail', function (Blueprint $table) {
            $table->uuid('com_aging_detail_id')->primary();
            $table->string('aging_cd',20);
            $table->integer('aging_no');
            $table->integer('value')->nullable();
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->foreign('aging_cd')
			->references('aging_cd')
			->on('public.com_aging')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public.com_aging_detail');
    }
}
