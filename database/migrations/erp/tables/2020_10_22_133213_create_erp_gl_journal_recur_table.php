<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpGlJournalRecurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp.gl_journal_recur', function (Blueprint $table) {
            $table->string('recur_cd',20)->primary();
            $table->string('comp_cd',20)->nullable();
            $table->string('recur_no',200)->nullable();
            $table->string('journal_cd',20)->nullable();
            $table->text('note')->nullable();
            $table->decimal('total_debit',19,2)->nullable();
            $table->decimal('total_credit',19,2)->nullable();
            $table->datetime('start_valid')->nullable();
            $table->datetime('end_valid')->nullable();
            $table->datetime('due_date')->nullable();
            $table->integer('freq_month')->nullable();
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
        Schema::dropIfExists('erp.gl_journal_recur');
    }
}
