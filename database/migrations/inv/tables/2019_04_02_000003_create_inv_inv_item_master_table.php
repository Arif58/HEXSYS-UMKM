<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvItemMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_item_master', function (Blueprint $table) {
            $table->string('item_cd',100);
			$table->string('item_nm');
            $table->string('type_cd')->nullable();
            $table->string('unit_cd')->nullable();
            $table->string('barcode')->nullable();
            $table->string('currency_cd')->nullable();
            $table->decimal('item_price_buy',10,2)->nullable();
            $table->decimal('item_price',10,2)->nullable();
            $table->string('vat_tp')->nullable();
            $table->string('ppn')->nullable();
            $table->string('reorder_point')->nullable();
            $table->string('minimum_stock')->nullable();
            $table->string('maximum_stock')->nullable();
            $table->string('generic_st',1)->default('0');
            $table->string('active_st',1)->default('1');
            $table->string('inventory_st',1)->default('1');
            $table->string('principal_cd')->nullable();
            $table->string('item_root')->nullable();
            $table->string('golongan_cd')->nullable();
            $table->string('golongansub_cd')->nullable();
            $table->string('kategori_cd')->nullable();
			$table->longText('image')->nullable();
            $table->decimal('dosis',10,2)->nullable();
            $table->decimal('map_value',10,2)->nullable();
			$table->string('pos_cd', 20)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->primary('item_cd');
            $table->foreign('unit_cd')
            ->references('unit_cd')
            ->on('inv.inv_unit')
            ->onDelete('cascade');

            $table->foreign('type_cd')
            ->references('type_cd')
            ->on('inv.inv_item_type')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.inv_item_master');
    }
}
