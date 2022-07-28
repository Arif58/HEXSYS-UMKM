<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvVwInvTrxInventoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP VIEW IF EXISTS inv.vw_inv_trx_inventory;
            CREATE OR REPLACE VIEW inv.vw_inv_trx_inventory
            AS SELECT pos_item.item_cd,
                master.item_nm,
                master.item_price AS harga,
                satuan.unit_cd,
                satuan.unit_nm AS satuan,
                concat(satuan2.unit_cd, '-', satuan2.unit_nm)::character varying AS satuan_default,
                jenis.type_nm AS jenis,
                pos_item.quantity AS stok,
                pos_item.pos_cd
            FROM inv.inv_pos_itemunit pos_item
                JOIN inv.inv_item_master master ON master.item_cd::text = pos_item.item_cd::text
                JOIN inv.inv_unit satuan ON satuan.unit_cd::text = pos_item.unit_cd::text
                JOIN inv.inv_unit satuan2 ON satuan2.unit_cd::text = master.unit_cd::text
                JOIN inv.inv_item_type jenis ON jenis.type_cd::text = master.type_cd::text;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop view inv.vw_inv_trx_inventory");
    }
}
