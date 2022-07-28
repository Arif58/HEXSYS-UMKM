<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlGetCoaBeginbalanceProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS erp.sp_gl_get_coa_beginbalance (p_pstrCompCd Varchar(10), p_pintYear int)");
        DB::unprepared("
        CREATE OR REPLACE FUNCTION erp.sp_gl_get_coa_beginbalance (p_pstrCompCd Varchar(10), p_pintYear int)
        RETURNS table (
            gl_coa_begin_balance_id uuid,
            coa_cd varchar(20),
            coa_nm varchar(2000),
            coa_tp_nm varchar(200),
            curr_default varchar(20),
            curr_default_nm varchar(2000),
            level_coa int,
            coa_sub_st varchar(1),
            amount_debit numeric,
            amount_credit numeric
        )
        LANGUAGE plpgsql
        AS $$
            DECLARE v_intBlank int;
            BEGIN
            v_intBlank := 5;
            
            IF EXISTS (SELECT A.coa_cd FROM erp.gl_coa_begin_balance A WHERE A.comp_cd=p_pstrCompCd AND A.balance_year=p_pintYear)
            THEN
                return query 
                SELECT 
                C.gl_coa_begin_balance_id,
                A.coa_cd,
                concat(REPEAT('&nbsp;',5 * erp.FN_GL_GET_LEVELCOA(p_pstrCompCd,A.coa_cd)), A.coa_nm)::Varchar AS coa_nm,
                B.coa_tp_nm,
                A.curr_default,
                D.currency_cd as curr_default_nm,
                erp.FN_GL_GET_LEVELCOA(p_pstrCompCd,A.coa_cd) AS level_coa,
                A.coa_sub_st,
                coalesce(C.amount_debit, 0) * coalesce(C.rate, 0) AS amount_debit,
                coalesce(C.amount_credit, 0) * coalesce(C.rate, 0) AS amount_credit
                FROM erp.gl_coa A
                JOIN public.com_currency D ON A.curr_default=D.currency_cd
                JOIN erp.gl_coa_type B ON A.coa_tp_cd=B.coa_tp_cd
                LEFT JOIN erp.gl_coa_begin_balance C ON A.coa_cd=C.coa_cd 
                    AND (C.balance_year=p_pintYear OR C.balance_year IS NULL)
                WHERE A.comp_cd=p_pstrCompCd
				/*AND (coalesce(C.amount_debit, 0)<>0 OR coalesce(C.amount_credit, 0)<>0)*/
                ORDER BY A.coa_tp_cd,A.coa_cd,A.coa_nm;
            ELSE
                return query 
                SELECT 
                C.gl_coa_begin_balance_id,
                A.coa_cd,
                concat(REPEAT('&nbsp;',5 * erp.FN_GL_GET_LEVELCOA(p_pstrCompCd,A.coa_cd)), A.coa_nm)::Varchar AS coa_nm,
                B.coa_tp_nm,
                A.curr_default,
                D.currency_cd as curr_default_nm,
                erp.FN_GL_GET_LEVELCOA(p_pstrCompCd,A.coa_cd) AS level_coa,
                A.coa_sub_st,
                0::numeric AS amount_debit,
                0::numeric AS amount_credit
                FROM erp.gl_coa A
                JOIN public.com_currency D ON A.curr_default=D.currency_cd
                JOIN erp.gl_coa_type B ON A.coa_tp_cd=B.coa_tp_cd
                LEFT JOIN erp.gl_coa_begin_balance C ON A.coa_cd=C.coa_cd 
                    AND (C.balance_year=p_pintYear OR C.balance_year IS NULL)
                WHERE A.comp_cd=p_pstrCompCd
				ORDER BY A.coa_tp_cd,A.coa_cd,A.coa_nm;
            END IF;
        END;
        $$;
        ");

        // DB::unprepared("select * from erp.sp_gl_get_coa_beginbalance('MAIN',2020);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS erp.sp_gl_get_coa_beginbalance (p_pstrCompCd Varchar(10), p_pintYear int)");
    }
}
