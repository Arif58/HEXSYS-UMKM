<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_opname', function (Blueprint $table) {
            $table->uuid('inv_opname_id')->primary()->default(DB::Raw("uuid_generate_v4()"));
            $table->string('trx_no')->nullable();
            $table->string('trx_nm')->nullable();
            $table->integer('trx_year')->nullable();
            $table->integer('trx_month')->nullable();
            $table->string('pos_cd')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->text('note')->nullable();
            $table->string('trx_st')->default('0');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('inv.inv_opname');
    }
}
