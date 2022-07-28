<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpCmTrxDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.cm_trx_detail', function (Blueprint $table) {
            $table->uuid('cm_transaction_detail_id')->primary();
            $table->string('cm_cd',20)->nullable();
            $table->integer('cm_seq')->nullable();
            $table->string('coa_cd',20)->nullable();
            $table->string('cc_cd',20)->nullable();
			$table->string('subunit_tp',20)->nullable();
			$table->string('dana_tp',20)->nullable();
			$table->string('standar_tp',20)->nullable();
			$table->string('aktivitas_cd',20)->nullable();
			$table->string('aktivitas_item',20)->nullable();
			$table->string('aktivitas_tp',20)->nullable();
			$table->string('cmcash_tp',20)->nullable();
            $table->string('dc_value',1)->nullable();
            $table->decimal('trx_amount',19,2)->nullable();
			$table->string('currency_cd',20)->nullable();
            $table->decimal('rate',19,2)->nullable();
            $table->decimal('trx_amount_real',19,2)->nullable();
            $table->integer('item_jumlah')->nullable();
			$table->decimal('item_amount',19,2)->nullable();
            $table->text('note')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('cm_cd')
			->references('cm_cd')
			->on('erp.cm_trx')
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
        Schema::dropIfExists('erp.cm_trx_detail');
    }
}
