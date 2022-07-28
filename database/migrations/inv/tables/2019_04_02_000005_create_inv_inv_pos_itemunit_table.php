<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvPosItemunitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_pos_itemunit', function (Blueprint $table) {
            $table->bigIncrements('positemunit_cd');
            $table->string('pos_cd',100);
            $table->string('item_cd',100);
            $table->string('unit_cd',20);
            $table->decimal('quantity',10,2);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('pos_cd')
            ->references('pos_cd')
            ->on('inv.inv_pos_inventori')
            ->onDelete('cascade');

            $table->foreign('item_cd')
            ->references('item_cd')
            ->on('inv.inv_item_master')
            ->onDelete('cascade');

            $table->foreign('unit_cd')
            ->references('unit_cd')
            ->on('inv.inv_unit')
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
        Schema::dropIfExists('inv.inv_pos_itemunit');
    }
}
