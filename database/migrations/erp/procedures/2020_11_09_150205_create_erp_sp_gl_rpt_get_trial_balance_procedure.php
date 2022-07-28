<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetTrialBalanceProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_trial_balance (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_trial_balance (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20))
                RETURNS table(
                    r_coa_cd varchar(20),
                    r_coa_nm varchar(200),
                    r_dc_value varchar(20),
                    r_trx_amount numeric(19,2)
                )
            AS
            $$
            BEGIN
                case
                when p_pstrCoaCdStart <> '' AND p_pstrCoaCdEnd <> ''
                THEN
                    return query
                    SELECT A.coa_cd, 
                    coa.coa_nm,
                    A.dc_value,
                    A.total_amount
                    FROM erp.gl_posting_month A
                    JOIN erp.gl_transaction_detail C ON A.coa_cd=C.coa_cd
                    JOIN erp.gl_transaction B ON B.trx_cd=C.trx_cd
                    join erp.gl_coa as coa on coa.coa_cd = A.coa_cd
                    WHERE B.trx_year = p_pintYear AND B.trx_month = p_pintMonth
                    AND A.coa_cd BETWEEN p_pstrCoaCdStart AND p_pstrCoaCdEnd
                    AND A.comp_cd = p_pstrCompCd
                    ORDER BY A.coa_cd;
                when p_pstrCoaCdStart <> '' AND p_pstrCoaCdEnd = ''	
                THEN
                    return query
                    SELECT A.coa_cd, 
                    coa.coa_nm,
                    A.dc_value,
                    A.total_amount
                    FROM erp.gl_posting_month A
                    JOIN erp.gl_transaction_detail C ON A.coa_cd=C.coa_cd
                    JOIN erp.gl_transaction B ON B.trx_cd=C.trx_cd
                    join erp.gl_coa as coa on coa.coa_cd = A.coa_cd
                    WHERE B.trx_year = p_pintYear AND B.trx_month = p_pintMonth
                    AND A.coa_cd >= p_pstrCoaCdStart
                    AND A.comp_cd = p_pstrCompCd
                    ORDER BY A.coa_cd;
                when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd <> ''	
                THEN
                    return query
                    SELECT A.coa_cd, 
                    coa.coa_nm,
                    A.dc_value,
                    A.total_amount
                    FROM erp.gl_posting_month A
                    JOIN erp.gl_transaction_detail C ON A.coa_cd=C.coa_cd
                    JOIN erp.gl_transaction B ON B.trx_cd=C.trx_cd
                    join erp.gl_coa as coa on coa.coa_cd = A.coa_cd
                    WHERE B.trx_year = p_pintYear AND B.trx_month = p_pintMonth
                    AND A.coa_cd <= p_pstrCoaCdEnd
                    AND A.comp_cd = p_pstrCompCd
                    ORDER BY A.coa_cd;
                when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd = ''	
                THEN
                    return query
                    SELECT A.coa_cd, 
                    coa.coa_nm,
                    A.dc_value,
                    A.total_amount
                    FROM erp.gl_posting_month A
                    JOIN erp.gl_transaction_detail C ON A.coa_cd=C.coa_cd
                    JOIN erp.gl_transaction B ON B.trx_cd=C.trx_cd
                    join erp.gl_coa as coa on coa.coa_cd = A.coa_cd
                    WHERE B.trx_year = p_pintYear AND B.trx_month = p_pintMonth
                    AND A.comp_cd = p_pstrCompCd
                    ORDER BY A.coa_cd;
                else
                    -- default 
                    SELECT A.coa_cd, 
                    coa.coa_nm,
                    A.dc_value,
                    A.total_amount
                    FROM erp.gl_posting_month A
                    JOIN erp.gl_transaction_detail C ON A.coa_cd=C.coa_cd
                    JOIN erp.gl_transaction B ON B.trx_cd=C.trx_cd
                    join erp.gl_coa as coa on coa.coa_cd = A.coa_cd
                    WHERE B.trx_year = p_pintYear AND B.trx_month = p_pintMonth
                    AND A.comp_cd = p_pstrCompCd
                    ORDER BY A.coa_cd;
                END case;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");

        //DB::unprepared("SELECT * from erp.sp_gl_rpt_get_trial_balance('HEXSYS', date_part('year', now())::int, date_part('month', now())::int, ''::varchar, ''::varchar);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_trial_balance (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20));");
    }
}
