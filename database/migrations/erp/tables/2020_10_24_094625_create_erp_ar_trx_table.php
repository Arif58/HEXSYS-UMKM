<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpArTrxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.ar_trx', function (Blueprint $table) {
            $table->string('ar_cd',20)->primary();
            $table->string('comp_cd',20)->nullable();
            $table->string('ar_no',20)->nullable();
            $table->string('ar_source',5)->nullable();
            $table->string('ar_source_cd',20)->nullable();
            $table->string('cust_cd',20)->nullable();
            $table->string('invoice_no',20)->nullable();
            $table->integer('trx_year')->nullable();
            $table->integer('trx_month')->nullable();
            $table->datetime('trx_date')->nullable();
            $table->datetime('due_date')->nullable();
            $table->string('form_cd',20)->nullable();
            $table->string('top_cd',20)->nullable();
            $table->string('currency_cd',20)->nullable();
            $table->decimal('rate',19,2)->nullable();
            $table->decimal('total_price',19,2)->nullable();
            $table->decimal('freight_cost',19,2)->nullable();
            $table->decimal('total_discount',19,2)->nullable();
            $table->decimal('total_amount',19,2)->nullable();
            $table->decimal('percent_ppn',19,2)->nullable();
            $table->decimal('ppn',19,2)->nullable();
            $table->string('entry_by',200)->nullable();
            $table->datetime('entry_date')->nullable();
            $table->string('approve_by',200)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->text('note')->nullable();
            $table->string('ar_st',1)->nullable();
			$table->string('unit_cd',20)->nullable();
            $table->integer('print_seq')->nullable();
            $table->string('vat_tp',20)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
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
        Schema::dropIfExists('erp.ar_trx');
    }
}
