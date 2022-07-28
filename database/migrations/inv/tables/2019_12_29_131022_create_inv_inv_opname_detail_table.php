<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvOpnameDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_opname_detail', function (Blueprint $table) {
            $table->uuid('inv_opname_detail_id')->primary()->default(DB::Raw("uuid_generate_v4()"));
            $table->uuid('inv_opname_id')->nullable();
            $table->string('item_cd')->nullable();
            $table->string('unit_cd')->nullable();
            $table->decimal('quantity_real',10,2)->default(0);
            $table->decimal('quantity_system',10,2)->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('inv_opname_id')
            ->references('inv_opname_id')
            ->on('inv.inv_opname')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('item_cd')
            ->references('item_cd')
            ->on('inv.inv_item_master')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('unit_cd')
            ->references('unit_cd')
            ->on('inv.inv_unit')
            ->onUpdate('cascade')
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
        Schema::dropIfExists('inv.inv_opname_detail');
    }
}
