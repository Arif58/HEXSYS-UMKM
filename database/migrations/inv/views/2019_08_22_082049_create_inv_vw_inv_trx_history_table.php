<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvVwInvTrxHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_inv_trx_history
            AS SELECT move.inv_item_move_id,
            move.pos_cd,
            pos.pos_nm,
            move.move_tp,
            move.item_cd,
            master.item_nm,
            move.trx_datetime,
            move.old_stock AS stok_awal,
            move.trx_qty AS jumlah_trx,
            move.new_stock AS stok_akhir,
            movetp.code_nm AS trx_tp,
            move.note AS catatan,
            master.unit_cd AS unit
           FROM inv.inv_item_move move
             JOIN com_code movetp ON movetp.com_cd::text = move.move_tp::text
             JOIN inv.inv_item_master master ON master.item_cd::text = move.item_cd::text
             join inv.inv_pos_inventori pos on pos.pos_cd=move.pos_cd
          ORDER BY move.trx_datetime, move.pos_cd DESC;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::Unprepared("drop VIEW inv.vw_inv_trx_history");
    }
}
