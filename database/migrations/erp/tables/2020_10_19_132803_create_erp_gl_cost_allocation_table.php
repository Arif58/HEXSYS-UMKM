<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlCostAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_cost_allocation', function (Blueprint $table) {
            $table->uuid('gl_cost_allocation_id')->primary();
            $table->string('coa_cd',20)->nullable();
            $table->string('cc_to',20)->nullable();
            $table->string('cc_from',20)->nullable();
            $table->string('comp_cd',20)->nullable();
            $table->decimal('fix_value',10,2)->nullable();
            $table->decimal('variable_value',10,2)->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp.gl_cost_allocation');
    }
}
