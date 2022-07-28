<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnCmGetClosingCdFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.fn_cm_get_closing_cd (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int,p_pstrCloseType char(1));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_cm_get_closing_cd (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int,p_pstrCloseType char(1))
                RETURNS Varchar(20)
            AS
            $$
                DECLARE v_strResult Varchar(20);
            BEGIN
            
                case p_pstrCloseType
                when '1' THEN
                    /*--Monthly--*/
                    v_strResult := p_pstrCompCd || p_pintYear::varchar || LPAD(p_pintMonth::varchar,2,'0');
                when '2' THEN
                    /*--Yearly--*/
                    v_strResult := p_pstrCompCd || p_pintYear::varchar;
                else
                    v_strResult := p_pstrCompCd ;
                end case;
                            
                RETURN v_strResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT erp.fn_cm_get_closing_cd('MAIN',".date('Y').", ".date('m').",'1');");
        // DB::unprepared("SELECT erp.fn_cm_get_closing_cd('MAIN',".date('Y').", ".date('m').",'2');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.fn_cm_get_closing_cd (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int,p_pstrCloseType char(1));");
    }
}
