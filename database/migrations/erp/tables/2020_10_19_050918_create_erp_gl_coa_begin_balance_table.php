<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlCoaBeginBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_coa_begin_balance', function (Blueprint $table) {
            $table->uuid('gl_coa_begin_balance_id')->primary();
            $table->string('comp_cd',20)->nullable();
            $table->string('coa_cd',20)->nullable();
            $table->integer('balance_year')->nullable();
            $table->string('currency_cd',20)->nullable();
            $table->decimal('amount_debit',15,2)->nullable();
            $table->decimal('amount_credit',15,2)->nullable();
            $table->decimal('rate',9,2)->nullable();
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
        Schema::dropIfExists('erp.gl_coa_begin_balance');
    }
}
