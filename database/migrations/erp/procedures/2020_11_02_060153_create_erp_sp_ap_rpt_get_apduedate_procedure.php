<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpApRptGetApduedateProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_apduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ap_rpt_get_apduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10))
                RETURNS table(
                    trx_date timestamp,
                    due_date timestamp,
                    invoice_no varchar(20),
                    total_amount numeric(19,2),
                    currency_cd varchar(20),
                    supplier_cd varchar(20),
                    supplier_nm varchar(200),
                    address text
                )
            AS
            $$
                DECLARE v_strHeader Varchar(20);
            BEGIN
                SELECT erp.fn_get_comp_trxheader(p_pstrCompCd) into v_strHeader;

                return query
                SELECT 
                A.trx_date,
                A.due_date,
                erp.FN_FORMAT_TRXNO(v_strHeader,A.ap_no) AS invoice_no,
                A.total_amount,
                A.currency_cd,
                B.supplier_cd,
                B.supplier_nm,
                B.address
                FROM erp.ap_trx A
                LEFT JOIN public.com_supplier B ON A.supplier_cd=B.supplier_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.due_date::date >= p_pdtDateStart::date
                AND A.due_date::date <= p_pdtDateEnd::date
                AND A.ap_st IN ('1','2','3')
                ORDER BY A.due_date,B.supplier_cd,A.trx_date;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT * from erp.sp_ap_rpt_get_arduedate('MAIN','2020-10-01'::varchar,'2020-10-30'::varchar);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_apduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10));");
    }
}
