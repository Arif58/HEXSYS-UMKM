<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicTrxApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.trx_approval', function (Blueprint $table) {
            $table->uuid('trx_approval_id')->primary();
            $table->string('trx_cd',200);
            $table->bigInteger('approve_no')->default(0);
            $table->string('approve_by',20);
            $table->datetime('approve_date')->default(DB::Raw('CURRENT_TIMESTAMP'));
			$table->string('approval_1',50);
			$table->string('approval_2',50);
			$table->string('approval_3',50);
			$table->string('approval_4',50);
			$table->string('approval_st',10);
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
        Schema::dropIfExists('public.trx_approval');
    }
}
