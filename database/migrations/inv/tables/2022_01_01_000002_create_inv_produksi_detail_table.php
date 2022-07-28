<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvProduksiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_produksi_detail', function (Blueprint $table) {
            $table->uuid("prod_detail_id")->primary();
            $table->uuid("prod_cd")->nullable();
            $table->string("item_cd",20)->nullable();
            $table->string("unit_cd",20)->nullable();
            $table->decimal("quantity", 10,2)->nullable();
			$table->string("pos_source",20)->nullable();
			$table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->foreign('prod_cd')
            ->references('prod_cd')
            ->on('inv.inv_produksi')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('item_cd')
            ->references('item_cd')
            ->on('inv.inv_item_master')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            /* $table->foreign('unit_cd')
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
        Schema::dropIfExists('inv.inv_produksi_detail');
    }
}
