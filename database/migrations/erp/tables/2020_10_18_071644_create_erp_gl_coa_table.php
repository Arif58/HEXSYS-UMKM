<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_coa', function (Blueprint $table) {
            $table->string('coa_cd', 20)->primary();
            $table->string('comp_cd', 20)->nullable();
            $table->string('coa_tp_cd', 20)->nullable();
            $table->string('coa_nm', 200)->nullable();
            $table->string('curr_default', 20)->nullable();
            $table->string('coa_root', 20)->nullable();
            $table->string('coa_sub_st',1)->default('0');
            $table->string('revaluation_st',1)->default('0');
            $table->string('cost_allocation',1)->default('0');
            $table->string('tax_st',1)->default('0');
			$table->string('coa_group', 50)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('coa_tp_cd')
			->references('coa_tp_cd')
			->on('erp.gl_coa_type')
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
        Schema::dropIfExists('erp.gl_coa');
    }
}
