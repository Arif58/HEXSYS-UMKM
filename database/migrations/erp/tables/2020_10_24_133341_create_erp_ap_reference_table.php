<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpApReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.ap_reference', function (Blueprint $table) {
            $table->uuid('ap_reference_id')->primary();
            $table->integer('ref_year');
            $table->integer('ref_month');
            $table->string('comp_cd',20);
            $table->string('curr_default',20)->nullable();
            $table->string('curr_tp',20)->nullable();
            $table->string('journal_st',1)->nullable();
            $table->string('ref_st',1)->nullable();
            $table->string('ap_approval_cd',20)->nullable();
            $table->string('aging_cd_wd',20)->nullable();
            $table->string('aging_cd_od',20)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
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
        Schema::dropIfExists('erp.ap_reference');
    }
}
