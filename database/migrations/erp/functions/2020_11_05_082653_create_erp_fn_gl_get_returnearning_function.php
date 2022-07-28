<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetReturnearningFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_returnearning(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_gl_get_returnearning(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int)
                RETURNS numeric(18,0)
                LANGUAGE plpgsql
            AS $$
                DECLARE v_numResult numeric(18,0);
                        v_strCoaRetEarning Varchar(20);
                        v_numIncome numeric(18,0);
                        v_numExpense numeric(18,0);
            BEGIN

                SELECT coalesce(SUM(B.trx_amount * B.rate),0)
                into v_numIncome
                FROM erp.gl_transaction A
                JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
                JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd AND C.coa_tp_cd='4'
                WHERE A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear
                AND A.trx_month=p_pintMonth;
                
                SELECT coalesce(SUM(B.trx_amount * B.rate),0)
                into v_numExpense
                FROM erp.gl_transaction A
                JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
                JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd AND C.coa_tp_cd='5'
                WHERE A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear
                AND A.trx_month=p_pintMonth;
                            
                v_numResult := v_numIncome - v_numExpense;

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
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_returnearning(p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");
    }
}
