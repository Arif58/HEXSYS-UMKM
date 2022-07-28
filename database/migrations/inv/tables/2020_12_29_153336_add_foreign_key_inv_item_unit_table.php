<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInvItemUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv.inv_item_unit', function (Blueprint $table) {
            $table->foreign('item_cd')
            ->references('item_cd')
            ->on('inv.inv_item_master')
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
        Schema::table('inv.inv_item_unit', function (Blueprint $table) {
            $table->dropForeign(['item_cd']);
        });
    }
}
