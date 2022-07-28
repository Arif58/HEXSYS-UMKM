<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlClosingMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_closing_month', function (Blueprint $table) {
            $table->string('closing_cd',200)->primary();
            $table->string('comp_cd',20)->nullable();
            $table->decimal('ret_earning',19,2)->nullable();
            $table->decimal('rev_gain',19,2)->nullable();
            $table->decimal('rev_loss',19,2)->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp.gl_closing_month');
    }
}
