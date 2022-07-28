<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicComSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.com_supplier', function (Blueprint $table) {
            $table->string('supplier_cd',20)->primary();
            $table->string('comp_cd',20);
            $table->string('supplier_nm',100)->nullable();
            $table->text('address')->nullable();
            $table->string('region_prop',20)->nullable();
            $table->string('region_kab',20)->nullable();
            $table->string('postcode',20)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('fax',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('npwp',100)->nullable();
            $table->string('nppkp',100)->nullable();
            $table->string('pkp_st',1)->nullable();
            $table->date('pkp_date')->nullable();
            $table->string('pic',20)->nullable();
            $table->string('ap_coa',20)->nullable();
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
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
        Schema::dropIfExists('public_com_supplier');
    }
}
