<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpBudgetPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.budget_plan', function (Blueprint $table) {
            $table->uuid('budgetplan_cd')->primary();
            $table->string('comp_cd',20)->nullable();
            $table->integer('budget_year')->nullable();
            $table->integer('budget_month')->nullable();
            $table->string('budget_cd',200)->nullable();
            $table->string('dept_cd',100)->nullable();
            $table->decimal('amount',19,2)->nullable();
			$table->string('currency_cd',20)->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->string('approve_by',200)->nullable();
            $table->string('trx_st',20)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->text('note')->nullable();
			$table->string('cc_cd',20)->nullable();
			$table->string('subunit_tp',20)->nullable();
			$table->string('dana_tp',20)->nullable();
			$table->string('standar_tp',20)->nullable();
			$table->string('aktivitas_tp',20)->nullable();
			$table->string('aktivitas_cd',20)->nullable();
			$table->string('unit_cd',20)->nullable();
			$table->string('reject_note',100)->nullable();
			$table->string('reject_by',100)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('budget_cd')
			->references('coa_cd')
			->on('erp.gl_coa')
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
        Schema::dropIfExists('erp.budget_plan');
    }
}
