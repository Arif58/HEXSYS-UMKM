<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGetCompTrxheaderFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.fn_get_comp_trxheader (p_pstrCompCd varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_get_comp_trxheader (p_pstrCompCd varchar(10))
                RETURNS Varchar(20)
            AS
            $$
                DECLARE v_strResult Varchar(20);
            BEGIN
                SELECT trx_header
                FROM public.com_company
                into v_strResult
                WHERE comp_cd=p_pstrCompCd;

                RETURN v_strResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        DB::unprepared("SELECT erp.fn_get_comp_trxheader('MAIN');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.fn_get_comp_trxheader (p_pstrCompCd varchar(10));");
    }
}
