<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvInvPosInventoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_pos_inventori', function (Blueprint $table) {
            $table->string('pos_cd',20);
            $table->string('pos_nm',100);
            $table->string('pos_root',20)->nullable();
            $table->string('description',200)->nullable();
            $table->string('unit_link',30)->nullable();
            $table->string('postrx_st',10)->nullable();
			$table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
			$table->timestamps();

            $table->primary('pos_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv.inv_pos_inventori');
    }
}
