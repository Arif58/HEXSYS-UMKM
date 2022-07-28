<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvItemMoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_item_move', function (Blueprint $table) {
            $table->bigIncrements('inv_item_move_id');
            $table->string('pos_cd');
            $table->string('pos_destination')->nullable();
            $table->string('item_cd');
            $table->string('trx_by');
            $table->datetime('trx_datetime');
            $table->decimal('trx_qty',10,2)->nullable();
            $table->decimal('old_stock',10,2)->nullable();
            $table->decimal('new_stock',10,2)->nullable();
            $table->string('purpose')->nullable();
            $table->string('vendor')->nullable();
            $table->string('move_tp')->nullable();
            $table->string('note')->nullable();
            $table->string('unit_cd')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.inv_item_move');
    }
}
