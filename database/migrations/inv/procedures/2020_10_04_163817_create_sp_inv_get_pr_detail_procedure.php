<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpInvGetPrDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION inv.sp_inv_get_pr_detail(p_param character varying, p_paramtp character varying)
            RETURNS TABLE(pr_cd uuid, pr_no character varying, tgl_trx character varying, supplier_cd character varying, supplier_nm character varying, supp_add text, entry_by character varying, note text, item_cd character varying, item_nm character varying, unit_cd character varying, unit_nm character varying, quantity numeric, info_st character varying, info_note character varying)
            LANGUAGE plpgsql
            AS $$
            BEGIN
                if p_paramTp = 'pr_cd' then 
                    RETURN QUERY 
                    select 
                    pr.pr_cd,
                    pr.pr_no,
                    fn_formatdate(trx_date) tgl_trx,
                    pr.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    pr.entry_by,
                    pr.note,
                    prd.item_cd,
                    master.item_nm,
                    prd.unit_cd,
                    unit.unit_nm,
                    prd.quantity,
					CASE
					WHEN prd.info_st='1'
					THEN
						'Reject'::varchar
					ELSE
						''::varchar
					END AS info_st,
					prd.info_note
                    from inv.po_purchase_request pr
                    left join inv.po_supplier supp on supp.supplier_cd=pr.supplier_cd
                    join inv.po_pr_detail prd on prd.pr_cd=pr.pr_cd
                    join inv.inv_item_master master on master.item_cd=prd.item_cd
                    join inv.inv_unit unit on unit.unit_cd=prd.unit_cd
                    WHERE pr.pr_cd=p_param::uuid;
                elseif p_paramTp = 'supplier_cd' then
                    RETURN QUERY 
                    select 
                    pr.pr_cd,
                    pr.pr_no,
                    fn_formatdate(trx_date) tgl_trx,
                    pr.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    fn_formatdate(delivery_datetime) as deliv_date,
                    pr.entry_by,
                    pr.note,
                    prd.item_cd,
                    master.item_nm,
                    prd.unit_cd,
                    unit.unit_nm,
                    prd.quantity,
					CASE
					WHEN prd.info_st='1'
					THEN
						'Reject'::varchar
					ELSE
						''::varchar
					END AS info_st,
					prd.info_note
                    from inv.po_purchase_request pr
                    left join inv.po_supplier supp on supp.supplier_cd=pr.supplier_cd
                    join inv.po_pr_detail prd on prd.pr_cd=pr.pr_cd
                    join inv.inv_item_master master on master.item_cd=prd.item_cd
                    join inv.inv_unit unit on unit.unit_cd=prd.unit_cd
                    WHERE pr.supplier_cd=p_param;
                else
                    RETURN QUERY 
                    select 
                    pr.pr_cd,
                    pr.pr_no,
                    fn_formatdate(trx_date) tgl_trx,
                    pr.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    pr.currency_cd,
                    pr.entry_by,
                    pr.note,
                    prd.item_cd,
                    master.item_nm,
                    prd.unit_cd,
                    unit.unit_nm,
                    prd.quantity,
					CASE
					WHEN prd.info_st='1'
					THEN
						'Reject'::varchar
					ELSE
						''::varchar
					END AS info_st,
					prd.info_note
                    from inv.po_purchase_request pr
                    left join inv.po_supplier supp on supp.supplier_cd=pr.supplier_cd
                    join inv.po_pr_detail prd on prd.pr_cd=pr.pr_cd
                    join inv.inv_item_master master on master.item_cd=prd.item_cd
                    join inv.inv_unit unit on unit.unit_cd=prd.unit_cd;
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
        DB::unprepared("DROP FUNCTION IF EXISTS inv.sp_inv_get_pr_detail(p_param character varying, p_paramtp character varying)");
    }
}
