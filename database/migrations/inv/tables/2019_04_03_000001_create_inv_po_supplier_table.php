<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvPoSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_supplier', function (Blueprint $table) {
            $table->string('supplier_cd',20);
            $table->string('supplier_nm',255);
            $table->text('address')->nullable();
            $table->string('region_prop',20)->nullable();
            $table->string('region_kab',20)->nullable();
            $table->string('postcode',6)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('fax',20)->nullable();
            $table->string('email',100)->nullable();
            $table->string('npwp',100)->nullable();
			$table->string('pic',200)->nullable();
			$table->string('supplier_note',200)->nullable();
			$table->string('pos_cd', 20)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->primary('supplier_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.po_supplier');
    }
}
