<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_transaction', function (Blueprint $table) {
            $table->string('trx_cd',20)->primary();
            $table->string('comp_cd',20)->nullable();
            $table->string('gl_source',5)->nullable();
            $table->string('gl_source_cd',20)->nullable();
            $table->integer('trx_year')->nullable();
            $table->integer('trx_month')->nullable();
            $table->string('journal_no',50)->nullable();
            $table->string('journal_cd',20)->nullable();
            $table->integer('journal_seq')->nullable();
            $table->date('trx_date')->nullable();
            $table->text('note')->nullable();
            $table->decimal('total_debit',19,2)->nullable();
            $table->decimal('total_credit',19,2)->nullable();
            $table->string('reverse_st',1)->default("0");
            $table->string('post_st',1)->default("0");
            $table->string('entry_by',200)->nullable();
            $table->datetime('entry_date')->nullable();
            $table->string('post_by',200)->nullable();
            $table->datetime('post_date')->nullable();
            $table->string('approve_by',200)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
            $table->string('journal_tp',2)->nullable();
			$table->string('voucher_no',50)->nullable();
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
        Schema::dropIfExists('erp.gl_transaction');
    }
}
