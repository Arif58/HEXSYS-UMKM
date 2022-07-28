<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpApRptGetArtrxProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_artrx (p_pstrCompCd Varchar(10),p_pstrTrxCd Varchar(20));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ap_rpt_get_artrx (p_pstrCompCd Varchar(10),p_pstrTrxCd Varchar(20))
                RETURNS table(
                    trx_cd varchar(20),
                    trx_date timestamp,
                    due_date timestamp,
                    trx_no varchar(20),
                    invoice_no varchar(20),
                    currency_cd varchar(20),
                    top_nm varchar(200),
                    total_price numeric(19,2),
                    total_discount numeric(19,2),
                    freight_cost numeric(19,2),
                    ppn numeric(19,2),
                    total_amount numeric(19,2),
                    note text,
                    entry_by varchar(20),
                    approve_by varchar(200),
                    cust_nm varchar(200),
                    address text,
                    vat_nm text
                )
            AS
            $$
            BEGIN

                return query
                SELECT 
                A.ap_cd AS trx_cd,
                A.trx_date,
                A.due_date,
                A.ap_no AS trx_no,
                A.invoice_no,
                A.currency_cd,
                C.top_nm,
                A.total_price,
                A.total_discount,
                A.freight_cost,
                A.ppn,
                A.total_amount,
                A.note AS note,
                A.entry_by,
                A.approve_by,
                B.cust_nm,
                B.address,
                CASE WHEN A.vat_tp='VAT_TP_1' THEN 'Include' ELSE '' END AS vat_nm
                FROM erp.ap_trx A 
                LEFT JOIN public.com_customer B ON A.cust_cd=B.cust_cd
                LEFT JOIN public.com_payment_type C ON A.top_cd=C.top_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.ap_cd=p_pstrTrxCd;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT * from erp.sp_ap_rpt_get_artrx('MAIN','MAIN2010000002'::varchar);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_artrx (p_pstrCompCd Varchar(10),p_pstrTrxCd Varchar(20));");
    }
}
