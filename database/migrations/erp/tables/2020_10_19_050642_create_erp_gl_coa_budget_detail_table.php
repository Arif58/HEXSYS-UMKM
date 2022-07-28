<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlCoaBudgetDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_coa_budget_detail', function (Blueprint $table) {
            $table->uuid('gl_coa_budget_detail_id')->primary();
            $table->string('coa_budget_cd',20)->nullable();
            $table->integer('budget_month')->nullable();
            $table->decimal('amount_debit',15,2)->nullable();
            $table->decimal('amount_credit',15,2)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('coa_budget_cd')
			->references('coa_budget_cd')
			->on('erp.gl_coa_budget')
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
        Schema::dropIfExists('erp.gl_coa_budget_detail');
    }
}
