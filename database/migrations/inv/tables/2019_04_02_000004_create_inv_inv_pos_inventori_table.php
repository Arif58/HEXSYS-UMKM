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
			$table->text('address')->nullable();
            $table->string('region_prop',20)->nullable();
            $table->string('region_kab',20)->nullable();
            $table->string('region_kec',20)->nullable();
            $table->string('region_kel',20)->nullable();
            $table->string('postcode',6)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('fax',20)->nullable();
            $table->string('email',100)->nullable();
            $table->string('npwp',100)->nullable();
			$table->string('pic',200)->nullable();
			$table->string('pos_note',200)->nullable();
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
