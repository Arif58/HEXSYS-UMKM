<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvVwInvPoDetailView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_inv_po_detail
        AS SELECT 
            po.po_cd,
            po.po_no,
            public.fn_formatdate(po.trx_date) AS date_trx,
            po.supplier_cd,
            supp.supplier_nm,
            supp.address AS supplier_address,
            po.delivery_address AS delivery_address,
            public.fn_formatdate(po.delivery_datetime) AS delivery_date,
            po.currency_cd,
            po.percent_ppn,
            po.total_price,
            po.total_amount,
            po.ppn,
            po.note,
            po.po_st,
            pod.po_po_detail_id,
            pod.item_cd,
			--master.item_nm,
			case when pod.item_cd is null then pod.item_desc else master.item_nm end as item_nm,
			--case when coalesce(pod.item_cd,'')='' then pod.item_desc else master.item_nm end as item_nm,
			pod.item_desc,
			pod.assettp_cd,
			pod.assettp_desc,
            pod.unit_cd,
            unit.unit_nm,
            pod.quantity,
            pod.unit_price,
            pod.trx_amount,
			po.dana_tp,
			po.unit_cd as unit,
			po.po_tp,
			pod.info_note
        FROM inv.po_purchase_order po
            JOIN inv.po_po_detail pod ON pod.po_cd::text = po.po_cd::text
            LEFT JOIN inv.po_supplier supp ON supp.supplier_cd::text = po.supplier_cd::text
            LEFT JOIN inv.inv_item_master master ON master.item_cd::text = pod.item_cd::text
            LEFT JOIN inv.inv_unit unit ON unit.unit_cd::text = pod.unit_cd::text
			LEFT JOIN public.com_code com ON com.com_cd::text = po.dana_tp::text
			--LEFT JOIN erp.gl_cost_center cc ON cc.cc_cd::text = po.unit_cd::text;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP VIEW inv.vw_inv_po_detail");
    }
}
