<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpInvGetPoDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION inv.sp_inv_get_po_detail(p_param character varying, p_paramtp character varying)
            RETURNS TABLE(po_cd uuid, po_no character varying, po_st character varying, trx_date timestamp, tgl_trx character varying, supplier_cd character varying, supplier_nm character varying, supp_add text, deliv_addr text, deliv_date character varying, currency_cd character varying, entry_by character varying, percent_ppn numeric, total_price numeric, total_amount numeric, ppn numeric, note text, po_unit character varying, data_no integer, po_source character varying, popr_st character varying, dana_tp_nm character varying, discount_amount numeric, discount_percent numeric, data_10 character varying, data_11 character varying, data_12 character varying, data_20 character varying, data_21 character varying, data_22 character varying, data_30 character varying, data_31 character varying, data_32 character varying, item_cd character varying, item_nm character varying, item_desc character varying, assettp_cd character varying,assettp_desc character varying, unit_cd character varying, unit_nm character varying, quantity numeric, unit_price numeric, trx_amount numeric, info_note character varying)
            LANGUAGE plpgsql
			AS $$
            BEGIN
			    if p_paramTp = 'po_cd' then 
                    RETURN QUERY 
                    select 
                    po.po_cd,
                    po.po_no,
					po.po_st,
					po.trx_date,
                    fn_formatdate(po.trx_date) tgl_trx,
                    po.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    delivery_address deliv_addr,
                    fn_formatdate(delivery_datetime) as deliv_date,
                    po.currency_cd,
                    po.entry_by,
                    po.percent_ppn,
                    po.total_price,
                    po.total_amount,
                    po.ppn,
                    po.note,
					po.unit_cd as po_unit,
					po.data_no,po.po_source,po.popr_st,
					com.code_nm as data_tp_nm,
                    po.discount_amount,po.discount_percent,
					po.data_10,po.data_11,po.data_12,po.data_20,po.data_21,po.data_22,
					po.data_30,po.data_31,po.data_32,
					pod.item_cd,
                    CASE
				            WHEN pod.item_cd IS NULL THEN pod.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    pod.item_desc,
				    pod.assettp_cd,
				    pod.assettp_desc,
                    pod.unit_cd,
                    unit.unit_nm,
                    pod.quantity,
                    pod.unit_price,
                    pod.trx_amount,
					pod.info_note
                    from inv.po_purchase_order po
					left join public.com_code com on po.dana_tp=com.com_cd
                    join inv.po_po_detail pod on pod.po_cd=po.po_cd
                    left join inv.po_supplier supp on supp.supplier_cd=po.supplier_cd
                    left join inv.inv_item_master master on master.item_cd=pod.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=pod.unit_cd
                    WHERE po.po_cd=p_param::uuid;
                elseif p_paramTp = 'supplier_cd' then
                    RETURN QUERY 
                    select 
                    po.po_cd,
                    po.po_no,
					po.po_st,
					po.trx_date,
                    fn_formatdate(po.trx_date) tgl_trx,
                    po.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    delivery_address deliv_addr,
                    fn_formatdate(delivery_datetime) as deliv_date,
                    po.currency_cd,
                    po.entry_by,
                    po.percent_ppn,
                    po.total_price,
                    po.total_amount,
                    po.ppn,
                    po.note,
					po.unit_cd as po_unit,
					po.data_no,po.po_source,po.popr_st,
					com.code_nm as data_tp_nm,
                    po.discount_amount,po.discount_percent,
					po.data_10,po.data_11,po.data_12,po.data_20,po.data_21,po.data_22,
					po.data_30,po.data_31,po.data_32,
					pod.item_cd,
                    CASE
				            WHEN pod.item_cd IS NULL THEN pod.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    pod.item_desc,
				    pod.assettp_cd,
				    pod.assettp_desc,
                    pod.unit_cd,
                    unit.unit_nm,
                    pod.quantity,
                    pod.unit_price,
                    pod.trx_amount,
					pod.info_note
                    from inv.po_purchase_order po
					left join public.com_code com on po.dana_tp=com.com_cd
                    join inv.po_po_detail pod on pod.po_cd=po.po_cd
                    left join inv.po_supplier supp on supp.supplier_cd=po.supplier_cd
                    left join inv.inv_item_master master on master.item_cd=pod.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=pod.unit_cd
                    WHERE po.supplier_cd=p_param;
                else
                    RETURN QUERY 
                    select 
                    po.po_cd,
                    po.po_no,
					po.po_st,
					po.trx_date,
                    fn_formatdate(po.trx_date) tgl_trx,
                    po.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    delivery_address deliv_addr,
                    fn_formatdate(delivery_datetime) as deliv_date,
                    po.currency_cd,
                    po.entry_by,
                    po.percent_ppn,
                    po.total_price,
                    po.total_amount,
                    po.ppn,
                    po.note,
					po.unit_cd as po_unit,
					po.data_no,po.po_source,po.popr_st,
					com.code_nm as data_tp_nm,
                    po.discount_amount,po.discount_percent,
					po.data_10,po.data_11,po.data_12,po.data_20,po.data_21,po.data_22,
					po.data_30,po.data_31,po.data_32,
					pod.item_cd,
                    CASE
				            WHEN pod.item_cd IS NULL THEN pod.item_desc
				            ELSE master.item_nm
				        END AS item_nm,
				    pod.item_desc,
				    pod.assettp_cd,
				    pod.assettp_desc,
                    pod.unit_cd,
                    unit.unit_nm,
                    pod.quantity,
                    pod.unit_price,
                    pod.trx_amount,
					pod.info_note
                    from inv.po_purchase_order po
					left join public.com_code com on po.dana_tp=com.com_cd
                    join inv.po_po_detail pod on pod.po_cd=po.po_cd
                    left join inv.po_supplier supp on supp.supplier_cd=po.supplier_cd
                    left join inv.inv_item_master master on master.item_cd=pod.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=pod.unit_cd;
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
        DB::unprepared("DROP FUNCTION IF EXISTS inv.sp_inv_get_po_detail(p_param character varying, p_paramtp character varying)");
    }
}
