<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('auth.menus', function (Blueprint $table) {
			$table->string('menu_cd',20);
            $table->string('menu_nm',100);
            $table->string('menu_no',10);
            $table->string('menu_root',20)->nullable();
            $table->integer('menu_level')->nullable();
            $table->string('menu_url',50)->nullable();
            $table->string('menu_image',100)->nullable();
			$table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();
            $table->primary('menu_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('menus');
    }
}
