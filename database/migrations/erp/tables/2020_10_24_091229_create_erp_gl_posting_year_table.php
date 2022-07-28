<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlPostingYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_posting_year', function (Blueprint $table) {
            $table->string('posting_cd',20)->primary();
            $table->string('coa_cd',20)->nullable();
            $table->string('dc_value',1)->nullable();
            $table->string('comp_cd',20)->nullable();
            $table->string('currency_cd',20)->nullable();
            $table->decimal('total_amount',19,2)->nullable();
            $table->string('process_by',200)->nullable();
            $table->datetime('process_date')->nullable();
            $table->string('approve_by',200)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('coa_cd')
			->references('coa_cd')
			->on('erp.gl_coa')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('currency_cd')
			->references('currency_cd')
			->on('public.com_currency')
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
        Schema::dropIfExists('erp.gl_posting_year');
    }
}
