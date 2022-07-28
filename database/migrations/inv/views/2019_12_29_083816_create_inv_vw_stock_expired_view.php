<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvVwStockExpiredView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_stock_expired
        AS SELECT 
            batch.item_cd,
            master.item_nm,
            tipe.type_nm AS jenis,
            satuan.unit_nm AS satuan,
            public.fn_formatdatetime(move.trx_datetime) AS tanggal_masuk,
            public.fn_formatdate(batch.expire_date) AS tanggal_expired
        FROM inv.inv_batch_item batch
            JOIN inv.inv_item_move move ON move.inv_item_move_id = batch.batch_no
            JOIN inv.inv_item_master master ON master.item_cd::text = batch.item_cd::text
            JOIN inv.inv_item_type tipe ON tipe.type_cd::text = master.type_cd::text
            JOIN inv.inv_unit satuan ON satuan.unit_cd::text = master.unit_cd::text
        ORDER BY master.item_nm;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP VIEW inv.vw_stock_expired");
    }
}
