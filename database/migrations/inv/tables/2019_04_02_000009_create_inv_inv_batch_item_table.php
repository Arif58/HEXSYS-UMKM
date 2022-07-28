<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvBatchItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_batch_item', function (Blueprint $table) {
            $table->bigInteger('batch_no'); 
            $table->string('item_cd');
            $table->integer('trx_qty')->nullable(); 
            $table->string('batch_no_start')->nullable();
            $table->string('batch_no_end')->nullable();
            $table->date('expire_date')->nullable(); 
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('batch_no')
            ->references('inv_item_move_id')
            ->on('inv.inv_item_move')
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
        Schema::dropIfExists('inv.inv_batch_item');
    }
}
