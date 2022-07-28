<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\posort\Facades\Schema;

class CreateInvVwInvProdDetailView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_inv_prod_detail
        AS SELECT 
            prod.prod_cd,
            prod.prod_no,
			prod.prod_item,
            prodit.item_nm as prod_item_nm,
            public.fn_formatdate(prod.trx_date) AS date_trx,
            prod.pos_cd,
            pos.pos_nm,
            prod.note,
            prod.prod_st,
            proddt.prod_detail_id,
            proddt.item_cd,
            master.item_nm,
            proddt.unit_cd,
            unit.unit_nm,
            proddt.quantity,
			proddt.pos_source,
			ps.pos_nm as pos_source_nm
        FROM inv.inv_produksi prod
			JOIN inv.inv_item_master prodit ON prod.prod_item = prodit.item_cd
            LEFT JOIN inv.inv_pos_inventori pos ON pos.pos_cd = prod.pos_cd
            JOIN inv.inv_produksi_detail proddt ON proddt.prod_cd = prod.prod_cd
            JOIN inv.inv_item_master master ON master.item_cd = proddt.item_cd
            JOIN inv.inv_unit unit ON unit.unit_cd = proddt.unit_cd
			LEFT JOIN inv.inv_pos_inventori ps ON proddt.pos_source = ps.pos_cd;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP VIEW inv.vw_inv_prod_detail");
    }
}
