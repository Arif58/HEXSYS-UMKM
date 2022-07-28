<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvFormulaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_formula_item', function (Blueprint $table) {
            $table->bigIncrements('formula_item_id');
            $table->string('item_cd');
            $table->string('formula_cd');
            $table->decimal('content',6)->nullable();
            $table->string('unit_cd')->nullable();
            $table->string('main_st',1)->default('0');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.inv_formula_item');
    }
}
