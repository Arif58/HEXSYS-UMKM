<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\posort\Facades\Schema;

class CreateInvVwInvPrDetailView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_inv_pr_detail
        AS SELECT 
            pr.pr_cd,
            pr.pr_no,
            public.fn_formatdate(pr.trx_date) AS date_trx,
            pr.pos_cd,
            pos.pos_nm,
            pr.note,
            pr.pr_st,
            prd.po_pr_detail_id,
            prd.item_cd,
            master.item_nm,
            prd.unit_cd,
            unit.unit_nm,
            prd.quantity,
			prd.pos_source,
			ps.pos_nm as pos_source_nm,
			prd.info_st,
			prd.info_note
        FROM inv.po_purchase_request pr
            /* LEFT JOIN inv.inv_pos_inventori pos ON pos.pos_cd::text = pr.pos_cd::text
            JOIN inv.po_pr_detail prd ON prd.pr_cd::text = pr.pr_cd::text
            JOIN inv.inv_item_master master ON master.item_cd::text = prd.item_cd::text
            JOIN inv.inv_unit unit ON unit.unit_cd::text = prd.unit_cd::text
			LEFT JOIN inv.inv_pos_inventori ps ON prd.pos_source::text = ps.pos_cd::text */
			LEFT JOIN inv.inv_pos_inventori pos ON pos.pos_cd = pr.pos_cd
            JOIN inv.po_pr_detail prd ON prd.pr_cd = pr.pr_cd
            JOIN inv.inv_item_master master ON master.item_cd = prd.item_cd
            JOIN inv.inv_unit unit ON unit.unit_cd = prd.unit_cd
			LEFT JOIN inv.inv_pos_inventori ps ON prd.pos_source = ps.pos_cd;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP VIEW inv.vw_inv_pr_detail");
    }
}
