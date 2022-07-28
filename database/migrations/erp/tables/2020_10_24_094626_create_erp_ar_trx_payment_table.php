<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpArTrxPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.ar_trx_payment', function (Blueprint $table) {
            $table->uuid('ar_trx_payment_id')->primary();
            $table->string('ar_cd',20);
            $table->string('invoice_no',20)->nullable();
            $table->integer('trx_year')->nullable();
            $table->integer('trx_month')->nullable();
            $table->datetime('trx_date')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->string('currency_cd',20)->nullable();
            $table->decimal('rate',19,2)->nullable();
            $table->decimal('trx_amount',19,2)->nullable();
            $table->decimal('ppn',19,2)->nullable();
            $table->string('cheque_no',20)->nullable();
            $table->datetime('cheque_date')->nullable();
            $table->text('note')->nullable();
            $table->string('dc_value',1)->nullable();
            $table->string('coa_cd',20)->nullable();
            $table->string('entry_by',200)->nullable();
            $table->datetime('entry_date')->nullable();
            $table->string('approve_by',200)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->integer('print_seq')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('ar_cd')
			->references('ar_cd')
			->on('erp.ar_trx')
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
        Schema::dropIfExists('erp.ar_trx_payment');
    }
}
