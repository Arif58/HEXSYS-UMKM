<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoPurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_purchase_request', function (Blueprint $table) {
            $table->uuid("pr_cd")->primary();
            $table->string("pr_no",20)->nullable();
            $table->string("supplier_cd",20)->nullable();
            $table->integer("trx_year")->nullable();
            $table->integer("trx_month")->nullable();
            $table->datetime("trx_date")->nullable();
            $table->string("entry_by",20)->nullable();
            $table->datetime("entry_date")->default(DB::Raw("now()"));
            $table->text("note")->nullable();
            $table->string("pr_st",20)->nullable();
			$table->string("pos_cd",20)->nullable();
			$table->string("pos_source",20)->nullable();
            $table->string('created_by',20)->nullable()->comment('created_ colum is used for entry_ column');
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            /*$table->foreign('supplier_cd')
            ->references('supplier_cd')
            ->on('inv.po_supplier')
            ->onUpdate('cascade')
            ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.po_purchase_request');
    }
}
