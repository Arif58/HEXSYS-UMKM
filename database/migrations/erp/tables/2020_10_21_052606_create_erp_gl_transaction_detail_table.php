<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_transaction_detail', function (Blueprint $table) {
            $table->uuid('gl_transaction_detail_id')->primary();
            $table->integer('trx_item_seq')->nullable();
            $table->string('trx_cd',20)->nullable();
            $table->string('coa_cd',20)->nullable();
            $table->string('cc_cd',20)->nullable();
			$table->string('subunit_tp',20)->nullable();
			$table->string('dana_tp',20)->nullable();
			$table->string('standar_tp',20)->nullable();
            $table->string('dc_value',1)->nullable();
            $table->decimal('trx_amount',19,2)->nullable();
            $table->string('currency_cd',20)->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->text('note')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('erp.gl_transaction_detail');
    }
}
