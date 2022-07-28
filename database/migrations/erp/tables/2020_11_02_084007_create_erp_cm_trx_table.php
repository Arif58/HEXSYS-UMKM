<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpCmTrxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('erp.cm_trx', function (Blueprint $table) {
            $table->string('cm_cd',20)->primary();
            $table->string('comp_cd',20)->nullable();
            $table->string('cm_tp',20)->nullable();
            $table->string('cm_no',20)->nullable();
            $table->string('cm_source',5)->nullable();
            $table->string('cm_source_cd',20)->nullable();
            $table->string('vendor_cd',200)->nullable();
            $table->integer('trx_year')->nullable();
            $table->integer('trx_month')->nullable();
            $table->datetime('trx_date')->nullable();
            $table->string('journal_cd',20)->nullable();
            $table->integer('journal_seq')->nullable();
            $table->string('form_cd',20)->nullable();
            $table->string('pay_cd',20)->nullable();
            $table->decimal('total_debit',19,2)->nullable();
            $table->decimal('total_credit',19,2)->nullable();
            $table->string('entry_by',200)->nullable();
            $table->datetime('entry_date')->nullable();
            $table->string('approve_by',200)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->text('note')->nullable();
            $table->string('cm_st',1)->nullable();
			$table->string('unit_cd',20)->nullable();
            $table->integer('print_seq')->nullable();
			$table->string('reject_note',100)->nullable();
			$table->string('reject_by',100)->nullable();
			$table->decimal('data_amount_10',19,2)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('form_cd')
			->references('form_cd')
			->on('public.com_form')
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
        Schema::dropIfExists('erp.cm_trx');
    }
}
