<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvItemGolonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_item_golongan', function (Blueprint $table) {
            $table->string('golongan_cd',20)->primary(); 
            $table->string('golongan_nm',100)->nullable(); 
            $table->string('root_cd',100)->nullable();
            $table->string('type_cd',100)->nullable(); 
            $table->string('level_no',100)->nullable();
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
        Schema::dropIfExists('inv.inv_item_golongan');
    }
}
