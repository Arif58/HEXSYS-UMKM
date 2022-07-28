<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('public.com_code', function (Blueprint $table) {
            $table->string('com_cd',20);
            $table->string('code_nm',100);
            $table->string('code_group',20);
            $table->string('code_value',100)->nullable();
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->primary('com_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('com_code');
    }
}
