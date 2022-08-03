<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoPurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_purchase_order', function (Blueprint $table) {
            $table->uuid("po_cd")->primary();
            $table->string("po_no",20)->nullable();
            $table->string("supplier_cd",20)->nullable();
            $table->string("invoice_no",20)->nullable();
            $table->integer("trx_year")->nullable();
            $table->integer("trx_month")->nullable();
            $table->datetime("trx_date")->nullable();
            $table->string("top_cd",20)->nullable();
            $table->string("currency_cd",20)->nullable();
            $table->decimal("rate", 15, 2)->nullable();
            $table->decimal("total_price", 15, 2)->nullable();
            $table->decimal("total_amount", 15, 2)->nullable();
			$table->decimal("discount_amount", 15, 2)->nullable();
			$table->decimal("discount_percent", 5, 2)->nullable();
			$table->decimal("addcost_amount", 10, 2)->nullable();
            $table->string("vat_tp")->nullable();
            $table->decimal("percent_ppn", 5,2)->nullable();
            $table->decimal("ppn", 15, 2)->nullable();
            $table->text("delivery_address")->nullable();
            $table->datetime("delivery_datetime")->nullable();
            $table->string("entry_by",20)->nullable();
            $table->datetime("entry_date")->default(DB::Raw("now()"));
			$table->string('approve_by',100)->nullable();
            $table->datetime('approve_date')->nullable();
            $table->integer('approve_no')->nullable();
			$table->string('reject_note',100)->nullable();
			$table->string('reject_by',100)->nullable();
            $table->text("note")->nullable();
            $table->string("po_st",20)->nullable();
			$table->string('dana_tp',20)->nullable();
			$table->string('po_tp',20)->nullable();
			$table->string("po_source",20)->nullable();
			$table->integer("data_no")->nullable();
			$table->string('unit_cd',20)->nullable();
			$table->string("popr_st",2)->nullable();
            $table->string('aktivitas_cd',20)->nullable();
			$table->string('aktivitas_tp',20)->nullable();
			$table->string('invoice_st',2)->nullable();
			$table->string('asset_st',2)->nullable();
			$table->string('data_10',100)->nullable();
			$table->string('data_11',100)->nullable();
			$table->string('data_12',100)->nullable();
			$table->string('data_20',50)->nullable();
			$table->string('data_21',50)->nullable();
			$table->string('data_22',50)->nullable();
			$table->string('data_30',100)->nullable();
			$table->string('data_31',100)->nullable();
			$table->string('data_32',100)->nullable();
			$table->string('data_40',50)->nullable();
			$table->string('data_41',50)->nullable();
			$table->string('data_42',50)->nullable();
			$table->string('pos_cd', 20)->nullable();
			$table->string('created_by',20)->nullable()->comment('created_ column is used for entry_ column');
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            /* $table->foreign('supplier_cd')
            ->references('supplier_cd')
            ->on('inv.po_supplier')
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
        Schema::dropIfExists('inv.po_purchase_order');
    }
}
