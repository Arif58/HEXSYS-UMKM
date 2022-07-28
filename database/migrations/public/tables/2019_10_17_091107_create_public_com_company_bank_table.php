<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicComCompanyBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.com_company_bank', function (Blueprint $table) {
            $table->uuid('com_company_bank_id')->primary();
            $table->string('comp_cd', 20);
            $table->string('account_cd', 20)->unique();
            $table->string('bank_cd', 20)->nullable();
            $table->string('branch_nm', 200)->nullable();
            $table->string('account_nm', 200)->nullable();
            $table->string('account_no', 20)->nullable();
            $table->string('currency_cd', 20)->nullable();
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->foreign('comp_cd')
			->references('comp_cd')
			->on('public.com_company')
			->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('bank_cd')
			->references('bank_cd')
			->on('public.com_bank')
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
        Schema::dropIfExists('erp.com_company_bank');
    }
}
