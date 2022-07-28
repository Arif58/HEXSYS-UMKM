<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoReturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_retur', function (Blueprint $table) {
            $table->uuid("retur_cd")->primary();
            $table->string("retur_no",20)->nullable();
            $table->string("supplier_cd",20)->nullable();
            $table->string("principal_cd",20)->nullable();
            $table->integer("trx_year")->nullable();
            $table->integer("trx_month")->nullable();
            $table->datetime("trx_date")->nullable();
            $table->string("currency_cd",20)->nullable();
            $table->decimal("rate",15,2)->nullable();
            $table->decimal("total_price",15,2)->nullable();
            $table->decimal("total_amount",15,2)->nullable();
            $table->string("vat_tp",20)->nullable();
            $table->decimal("percent_ppn",5,2)->nullable();
            $table->decimal("ppn",15,2)->nullable();
            $table->datetime('retur_datetime')->nullable();
            $table->text("note")->nullable();
            $table->string("entry_by",20)->nullable();
            $table->datetime("entry_date")->default(DB::Raw("now()"));
            $table->string("retur_st",20)->nullable();
			$table->string('pos_cd', 20)->nullable();
            $table->string('created_by',20)->nullable()->comment('created_ colum is used for entry_ column');
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
        Schema::dropIfExists('inv.po_retur');
    }
}
