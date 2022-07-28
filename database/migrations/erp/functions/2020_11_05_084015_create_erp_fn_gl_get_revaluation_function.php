<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetRevaluationFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_revaluation(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_gl_get_revaluation(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int)
                RETURNS numeric(18,0)
                LANGUAGE plpgsql
            AS $$
                DECLARE v_numResult numeric(18,0);
            BEGIN

                SELECT 
                coalesce(SUM(coalesce(B.trx_amount,0) * coalesce(cc.current_rate,0) - coalesce(B.trx_amount,0) * coalesce(B.rate,0) ),0) AS total_amount
                into v_numResult
                FROM erp.gl_transaction A
                JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
                JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd
                left join public.com_currency cc on B.currency_cd = cc.currency_cd 
                WHERE A.post_st='1'
                AND B.currency_cd<>'IDR'
                AND C.revaluation_st='1'
                AND A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear
                AND A.trx_month=p_pintMonth;
                
                RETURN v_numResult;

            END;
            $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_revaluation(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");
    }
}
