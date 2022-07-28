<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpArRptGetAragingProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ar_rpt_get_araging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ar_rpt_get_araging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int)
                RETURNS table(
                    trx_date timestamp,
                    due_date timestamp,
                    trx_no varchar(20),
                    invoice_no varchar(20),
                    total_amount numeric(19,2),
                    currency_cd varchar(20),
                    cust_cd varchar(20),
                    cust_nm varchar(200),
                    address text,
                    duedate_status int
                )
            AS
            $$
                DECLARE v_strHeader Varchar(20);
                v_dtDate Timestamp;

            BEGIN
                SELECT erp.fn_get_comp_trxheader(p_pstrCompCd) into v_strHeader;
                v_dtDate := NOW();

                return query
                SELECT 
                A.trx_date,
                A.due_date,
                A.ar_no as trx_no,
                erp.FN_FORMAT_TRXNO(v_strHeader,A.ar_no) AS invoice_no,
                A.total_amount,
                A.currency_cd,
                B.cust_cd,
                B.cust_nm,
                B.address,
                DATE_PART('day', now()::date - A.due_date)::int AS duedate_status
                FROM erp.ar_trx A
                LEFT JOIN public.com_customer B ON A.cust_cd=B.cust_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear
                AND A.trx_month=p_pintMonth
                AND A.ar_st IN ('1','2','3')
                ORDER BY A.cust_cd,A.ar_no,A.trx_date;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT * from erp.sp_ar_rpt_get_araging('MAIN','2020'::int,'10'::int);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_ar_rpt_get_araging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int);");
    }
}
