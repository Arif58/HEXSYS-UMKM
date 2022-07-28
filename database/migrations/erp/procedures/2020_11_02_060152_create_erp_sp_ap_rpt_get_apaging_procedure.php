<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpApRptGetApagingProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_apaging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ap_rpt_get_apaging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int)
                RETURNS table(
                    trx_date timestamp,
                    due_date timestamp,
                    trx_no varchar(20),
                    invoice_no varchar(20),
                    total_amount numeric(19,2),
                    currency_cd varchar(20),
                    supplier_cd varchar(20),
                    supplier_nm varchar(200),
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
                A.ap_no as trx_no,
                erp.FN_FORMAT_TRXNO(v_strHeader,A.ap_no) AS invoice_no,
                A.total_amount,
                A.currency_cd,
                B.supplier_cd,
                B.supplier_nm,
                B.address,
                DATE_PART('day', now()::date - A.due_date)::int AS duedate_status
                FROM erp.ap_trx A
                LEFT JOIN public.com_supplier B ON A.supplier_cd=B.supplier_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear
                AND A.trx_month=p_pintMonth
                AND A.ap_st IN ('1','2','3')
                ORDER BY A.supplier_cd,A.ap_no,A.trx_date;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT * from erp.sp_ap_rpt_get_apaging('MAIN','2020'::int,'10'::int);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_rpt_get_apaging (p_pstrCompCd Varchar(10),p_pintYear int,p_pintMonth int);");
    }
}
