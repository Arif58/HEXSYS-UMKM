<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicFnGetRateFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists public.fn_get_rate(p_pstrCurrencyCd varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION public.fn_get_rate(p_pstrCurrencyCd varchar(10))
                RETURNS numeric(18,0)
                LANGUAGE plpgsql
            AS $$
                DECLARE v_numResult numeric(18,0);
            BEGIN

                if p_pstrCurrencyCd = 'IDR' then
                    v_numResult := 1;
                else
                    select current_rate into v_numResult
                    from public.com_currency where currency_cd = p_pstrCurrencyCd;
                end if;
                
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
        DB::unprepared("DROP FUNCTION if exists public.fn_get_rate(p_pstrCurrencyCd varchar(10));");
    }
}
