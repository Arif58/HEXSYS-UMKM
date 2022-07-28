<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpInvGetProdDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION inv.sp_inv_get_prod_detail(p_param character varying)
            RETURNS TABLE(prod_cd uuid, prod_no character varying, prod_item character varying, prod_item_nm character varying, prod_quantity numeric, tgl_trx character varying, entry_by character varying, pos_cd character varying, pos_nm character varying, note text, prod_st character varying, item_cd character varying, item_nm character varying, unit_cd character varying, unit_nm character varying, quantity numeric, pos_source character varying, pos_source_nm character varying)
            LANGUAGE plpgsql
            AS $$
            BEGIN
				RETURN QUERY
				SELECT 
				prod.prod_cd,
				prod.prod_no,
				prod.prod_item,
				prodit.item_nm as prod_item_nm,
				prod.quantity as prod_quantity,
				public.fn_formatdate(prod.trx_date) AS date_trx,
				prod.entry_by,
                prod.pos_cd,
				pos.pos_nm,
				prod.note,
				prod.prod_st,
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
				LEFT JOIN inv.inv_pos_inventori ps ON proddt.pos_source = ps.pos_cd
				WHERE prod.prod_cd=p_param::uuid;
            END;
            $$
            ;

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS inv.sp_inv_get_prod_detail(p_param character varying)");
    }
}
