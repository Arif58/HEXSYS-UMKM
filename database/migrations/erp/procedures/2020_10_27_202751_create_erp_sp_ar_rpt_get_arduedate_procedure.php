<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpArRptGetArduedateProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ar_rpt_get_arduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ar_rpt_get_arduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10))
                RETURNS table(
                    trx_date timestamp,
                    due_date timestamp,
                    invoice_no varchar(20),
                    total_amount numeric(19,2),
                    currency_cd varchar(20),
                    cust_cd varchar(20),
                    cust_nm varchar(200),
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
                erp.FN_FORMAT_TRXNO(v_strHeader,A.ar_no) AS invoice_no,
                A.total_amount,
                A.currency_cd,
                B.cust_cd,
                B.cust_nm,
                B.address
                FROM erp.ar_trx A
                LEFT JOIN public.com_customer B ON A.cust_cd=B.cust_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.due_date::date >= p_pdtDateStart::date
                AND A.due_date::date <= p_pdtDateEnd::date
                AND A.ar_st IN ('1','2','3')
                ORDER BY A.due_date,B.cust_cd,A.trx_date;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT * from erp.sp_ar_rpt_get_arduedate('MAIN','2020-10-01'::varchar,'2020-10-30'::varchar);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_ar_rpt_get_arduedate (p_pstrCompCd Varchar(10),p_pdtDateStart Varchar(10), p_pdtDateEnd Varchar(10));");
    }
}
