<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpInvGetRiDetailProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP FUNCTION IF EXISTS inv.sp_inv_get_ri_detail(character varying, character varying);
            CREATE OR REPLACE FUNCTION inv.sp_inv_get_ri_detail(p_param character varying, p_paramtp character varying)
            RETURNS TABLE(ri_cd uuid, ri_no character varying, po_cd uuid, tgl_trx character varying, trx_date timestamp, supplier_cd character varying, supplier_nm character varying, supp_add text, entry_by character varying, entry_date character varying, currency_cd character varying, pos_cd character varying, ppn numeric, percent_ppn numeric, total_price numeric, total_amount numeric, total_discount numeric, note text, item_cd character varying, item_nm character varying, item_desc character varying, assettp_cd character varying, assettp_desc character varying, unit_cd character varying, unit_nm character varying, quantity numeric, unit_price numeric, trx_amount numeric, discount_percent numeric, discount_amount numeric, batch_no character varying, faktur_no character varying, faktur_date character varying, expired_date character varying)
            LANGUAGE plpgsql
            AS $$
            BEGIN
                if p_paramTp = 'ri_cd' then 
                    RETURN QUERY 
                    select 
                    ri.ri_cd,
                    ri.ri_no,
                    rd.po_cd,
                    fn_formatdate(ri.trx_date) tgl_trx,
                    /*ri.trx_date as tgl_trx,*/
                    ri.trx_date,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.pos_cd,
                    coalesce(ri.ppn,0)::numeric,
                    coalesce(ri.percent_ppn,0)::numeric,
                    coalesce(ri.total_price,'0')::numeric,
                    coalesce(ri.total_amount,'0')::numeric,
                    coalesce(ri.total_discount,'0')::numeric,
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
                    coalesce(rd.discount_percent,0)::numeric,
                    coalesce(rd.discount_amount,0)::numeric,
                    coalesce(rd.batch_no,' ')::varchar,
                    coalesce(rd.faktur_no,' ')::varchar,
                    coalesce(fn_formatdate(rd.faktur_date),' ')::varchar,
                    coalesce(fn_formatdate(rd.expire_date),' ')::varchar
                    from inv.po_receive_item ri
                    join inv.po_receive_detail rd on rd.ri_cd=ri.ri_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
                    left join inv.inv_item_master master on master.item_cd=rd.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=rd.unit_cd
                    WHERE ri.ri_cd=p_param::uuid;
                elseif p_paramTp = 'supplier_cd' then
                    RETURN QUERY 
                    select 
                    ri.ri_cd,
                    ri.ri_no,
                    rd.po_cd,
                    fn_formatdate(ri.trx_date) tgl_trx,
                    /*ri.trx_date as tgl_trx,*/
                    ri.trx_date,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.pos_cd,
                    coalesce(ri.ppn,0)::numeric,
                    coalesce(ri.percent_ppn,0)::numeric,
                    coalesce(ri.total_price,'0')::numeric,
                    coalesce(ri.total_amount,'0')::numeric,
                    coalesce(ri.total_discount,'0')::numeric,
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
                    rd.discount_percent,
                    rd.discount_amount,
                    rd.batch_no,
                    rd.faktur_no,
                    fn_formatdate(rd.faktur_date),
                    fn_formatdate(rd.expire_date)
                    from inv.po_receive_item ri
                    join inv.po_receive_detail rd on rd.ri_cd=ri.ri_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
                    left join inv.inv_item_master master on master.item_cd=rd.item_cd
                    left join inv.inv_unit unit on unit.unit_cd=rd.unit_cd
                    WHERE ri.supplier_cd=p_param;
                else
                    RETURN QUERY 
                    select 
                    ri.ri_cd,
                    ri.ri_no,
                    rd.po_cd,
                    fn_formatdate(ri.trx_date) tgl_trx,
                    /*ri.trx_date as tgl_trx,*/
                    ri.trx_date,
                    ri.supplier_cd,
                    supp.supplier_nm,
                    supp.address as supp_add,
                    ri.entry_by,
                    fn_formatdate(ri.entry_date) as entry_date,
                    ri.currency_cd,
                    ri.pos_cd,
                    coalesce(ri.ppn,0)::numeric,
                    coalesce(ri.percent_ppn,0)::numeric,
                    coalesce(ri.total_price,'0')::numeric,
                    coalesce(ri.total_amount,'0')::numeric,
                    coalesce(ri.total_discount,'0')::numeric,
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
                    rd.discount_percent,
                    rd.discount_amount,
                    rd.batch_no,
                    rd.faktur_no,
                    fn_formatdate(rd.faktur_date),
                    fn_formatdate(rd.expire_date)
                    from inv.po_receive_item ri
                    join inv.po_receive_detail rd on rd.ri_cd=ri.ri_cd
                    left join inv.po_supplier supp on supp.supplier_cd=ri.supplier_cd
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
        DB::unprepared("DROP FUNCTION IF EXISTS inv.sp_inv_get_ri_detail(p_param character varying, p_paramtp character varying)");
    }
}
