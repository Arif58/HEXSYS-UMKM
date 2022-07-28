<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.inv_produksi', function (Blueprint $table) {
            $table->uuid("prod_cd")->primary();
            $table->string("prod_no",20)->nullable();
			$table->string("prod_item",20)->nullable();
			$table->decimal("quantity", 10,2)->nullable();
            $table->integer("trx_year")->nullable();
            $table->integer("trx_month")->nullable();
            $table->datetime("trx_date")->nullable();
            $table->text("note")->nullable();
            $table->string("prod_st",20)->nullable();
			$table->string("pos_cd",20)->nullable();
			$table->string("pos_source",20)->nullable();
            $table->string("entry_by",20)->nullable();
            $table->datetime("entry_date")->default(DB::Raw("now()"));
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
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
        Schema::dropIfExists('inv.inv_produksi');
    }
}
