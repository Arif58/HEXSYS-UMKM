<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPoReceiveItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv.po_receive_item', function (Blueprint $table) {
            $table->uuid("ri_cd")->primary();
            $table->string("ri_no",20)->nullable();
            $table->string("supplier_cd",20)->nullable();
            $table->string("principal_cd",20)->nullable();
            $table->string("invoice_no",20)->nullable();
            $table->integer("trx_year")->nullable();
            $table->integer("trx_month")->nullable();
            $table->datetime("trx_date")->nullable();
            $table->string("currency_cd",20)->nullable();
            $table->decimal("rate", 15, 2)->nullable();
            $table->decimal("total_price", 15, 2)->nullable();
			$table->decimal("total_discount", 15, 2)->nullable();
            $table->decimal("total_amount", 15, 2)->nullable();
			$table->string("vat_tp")->nullable();
            $table->decimal("percent_ppn",5,2)->nullable();
            $table->decimal("ppn",15,2)->nullable();
            $table->string("entry_by",20)->nullable();
            $table->datetime("entry_date")->default(DB::Raw("now()"));
            $table->text("note")->nullable();
            $table->string("ri_st",20)->nullable();
            $table->string("pos_cd",20)->nullable();
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
        Schema::dropIfExists('inv.po_receive_item');
    }
}
