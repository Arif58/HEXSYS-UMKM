<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetCoaTpCdFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists public.fn_gl_get_coa_tp_cd(p_pstrCompCd varchar(10), p_pstrCoaCd varchar(20));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION public.fn_gl_get_coa_tp_cd(p_pstrCompCd varchar(10), p_pstrCoaCd varchar(20))
                RETURNS varchar(20)
                LANGUAGE plpgsql
            AS $$
                DECLARE v_strResult varchar(20);
            BEGIN

                SELECT coa_tp_cd
                into v_strResult
                FROM erp.gl_coa
                WHERE comp_cd=p_pstrCompCd
                AND coa_cd=p_pstrCoaCd;
                
                RETURN v_strResult;
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
        DB::unprepared("DROP FUNCTION if exists public.fn_gl_get_coa_tp_cd(p_pstrCompCd varchar(10), p_pstrCoaCd varchar(20));");
    }
}
