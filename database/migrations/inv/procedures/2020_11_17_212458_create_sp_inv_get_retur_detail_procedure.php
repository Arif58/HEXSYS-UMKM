<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpInvGetReturDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION inv.sp_inv_get_retur_detail(p_param character varying, p_paramtp character varying)
            RETURNS TABLE(retur_cd uuid, retur_no character varying, tgl_trx character varying, supplier_cd character varying, supplier_nm character varying, supp_add text, principal_cd character varying, principal_nm character varying, entry_by character varying, entry_date character varying, currency_cd character varying, ppn numeric, percent_ppn numeric, total_price numeric, total_amount numeric, note text, item_cd character varying, item_nm character varying, item_desc character varying, assettp_cd character varying, assettp_desc character varying, unit_cd character varying, unit_nm character varying, quantity numeric, unit_price numeric, trx_amount numeric, faktur_no character varying, faktur_date character varying)
            -- ri_cd character varying,
            LANGUAGE plpgsql
            AS $$
            BEGIN
                if p_paramTp = 'retur_cd' then 
                    RETURN QUERY 
                    select 
                    ri.retur_cd,
                    ri.retur_no,
                    -- rd.ri_cd,
                    fn_formatdate(trx_date::date) tgl_trx,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.principal_cd,
                    principal.principal_nm,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.ppn,
                    ri.percent_ppn,
                    ri.total_price,
                    ri.total_amount,
                    ri.note,
                    rd.item_cd,
                    CASE
				            WHEN rd.item_cd IS NULL THEN rd.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    rd.item_desc,
                    rd.assettp_cd,
				    rd.assettp_desc,
                    rd.unit_cd,
                    unit.unit_nm,
                    rd.quantity,
                    rd.unit_price,
                    rd.trx_amount,
                    rd.faktur_no,
                    fn_formatdate(rd.faktur_date)
                    from inv.po_retur ri
                    join inv.po_retur_detail rd on rd.retur_cd=ri.retur_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
                    left join inv.po_principal principal on principal.principal_cd=ri.principal_cd
                    left join inv.inv_item_master master on master.item_cd=rd.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=rd.unit_cd
                    WHERE ri.retur_cd=p_param::uuid;
                elseif p_paramTp = 'supplier_cd' then
                    RETURN QUERY 
                    select 
                    ri.retur_cd,
                    ri.retur_no,
                    -- rd.ri_cd,
                    fn_formatdate(trx_date::date) tgl_trx,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.principal_cd,
                    principal.principal_nm,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.ppn,
                    ri.percent_ppn,
                    ri.total_price,
                    ri.total_amount,
                    ri.note,
                    rd.item_cd,
                    CASE
				            WHEN rd.item_cd IS NULL THEN rd.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    rd.item_desc,
                    rd.assettp_cd,
				    rd.assettp_desc,
                    rd.unit_cd,
                    unit.unit_nm,
                    rd.quantity,
                    rd.unit_price,
                    rd.trx_amount,
                    rd.faktur_no,
                    fn_formatdate(rd.faktur_date)
                    from inv.po_retur ri
                    join inv.po_retur_detail rd on rd.retur_cd=ri.retur_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
                    left join inv.po_principal principal on principal.principal_cd=ri.principal_cd
                    left join inv.inv_item_master master on master.item_cd=rd.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=rd.unit_cd
                    WHERE ri.supplier_cd=p_param;
                else
                    RETURN QUERY 
                    select 
                    ri.retur_cd,
                    ri.retur_no,
                    -- rd.ri_cd,
                    fn_formatdate(trx_date) tgl_trx,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.principal_cd,
                    principal.principal_nm,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.ppn,
                    ri.percent_ppn,
                    ri.total_price,
                    ri.total_amount,
                    ri.note,
                    rd.item_cd,
                    CASE
				            WHEN rd.item_cd IS NULL THEN rd.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    rd.item_desc,
                    rd.assettp_cd,
				    rd.assettp_desc,
                    rd.unit_cd,
                    unit.unit_nm,
                    rd.quantity,
                    rd.unit_price,
                    rd.trx_amount,
                    rd.faktur_no,
                    fn_formatdate(rd.faktur_date)
                    from inv.po_retur ri
                    join inv.po_retur_detail rd on rd.retur_cd=ri.retur_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
                    left join inv.po_principal principal on principal.principal_cd=ri.principal_cd
                    left join inv.inv_item_master master on master.item_cd=rd.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=rd.unit_cd;
                END if;
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
        DB::unprepared("DROP FUNCTION IF EXISTS inv.sp_inv_get_retur_detail(p_param character varying, p_paramtp character varying)");
    }
}
