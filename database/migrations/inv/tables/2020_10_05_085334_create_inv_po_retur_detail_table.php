<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoReturDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_retur_detail', function (Blueprint $table) {
            $table->uuid('po_retur_detail_id')->nullable();
            $table->uuid('retur_cd')->nullable();
            $table->string('item_cd',20)->nullable();
			$table->string("item_desc",100)->nullable();
            $table->string('unit_cd',20)->nullable();
            $table->decimal('quantity',10,2)->nullable();
            $table->decimal('unit_price',15,2)->nullable();
            $table->decimal('trx_amount',15,2)->nullable();
            $table->string('faktur_no',20)->nullable();
            $table->date('faktur_date')->nullable();
            $table->string('note',500)->nullable();
			$table->string("assettp_cd",20)->nullable();
			$table->string("assettp_desc",100)->nullable();
            $table->string('created_by',20)->nullable()->comment('created_ colum is used for entry_ column');
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->foreign('retur_cd')
            ->references('retur_cd')
            ->on('inv.po_retur')
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
        Schema::dropIfExists('inv.po_retur_detail');
    }
}
