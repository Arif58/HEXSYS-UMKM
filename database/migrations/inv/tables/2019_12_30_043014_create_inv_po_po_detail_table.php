<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoPoDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_po_detail', function (Blueprint $table) {
            $table->uuid("po_po_detail_id")->primary();
            $table->uuid("po_cd")->nullable();
            $table->string("item_cd",20)->nullable();
			$table->string("item_desc",100)->nullable();
            $table->string("pr_cd",20)->nullable();
            $table->string("unit_cd",20)->nullable();
            $table->decimal("quantity", 10,2)->nullable();
            $table->decimal("unit_price", 15,2)->nullable();
            $table->decimal("trx_amount", 15,2)->nullable();
			$table->decimal("discount_amount", 15, 2)->nullable();
			$table->decimal("discount_percent", 5, 2)->nullable();
			$table->decimal("quantity_hs", 10,2)->nullable();
            $table->decimal("unit_price_hs", 15,2)->nullable();
            $table->decimal("trx_amount_hs", 15,2)->nullable();
			$table->string("assettp_cd",20)->nullable();
			$table->string("assettp_desc",100)->nullable();
			$table->string("info_note",100)->nullable();
            $table->string('created_by',20)->nullable()->comment('created_ colum is used for entry_ column');
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->foreign('po_cd')
            ->references('po_cd')
            ->on('inv.po_purchase_order')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            /* $table->foreign('item_cd')
            ->references('item_cd')
            ->on('inv.inv_item_master')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('unit_cd')
            ->references('unit_cd')
            ->on('inv.inv_unit')
            ->onUpdate('cascade')
            ->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.po_po_detail');
    }
}
