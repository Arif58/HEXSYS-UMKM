<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnFormatTrxnoFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.fn_format_trxno(p_pstrTrxHeader Varchar(6),p_pstrTrxNo Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_format_trxno(p_pstrTrxHeader Varchar(6),p_pstrTrxNo Varchar(10))
                RETURNS Varchar(20)
            AS
            $$
            DECLARE v_strResult Varchar(20);
                    v_strMonth Varchar(2);
                    v_strYear Varchar(2);
                    v_intNo int;
            BEGIN
                v_strMonth  := SUBSTRING(p_pstrTrxNo,3,2);
                v_strYear   := LEFT(p_pstrTrxNo,2);
                
                IF p_pstrTrxHeader='' OR p_pstrTrxHeader IS NULL THEN
                    v_strResult := p_pstrTrxNo;
                ELSE
                    IF v_strMonth ~ '^[0-9\.]+$' AND v_strYear ~ '^[0-9\.]+$' AND RIGHT(p_pstrTrxNo,6) ~ '^[0-9\.]+$'
                    THEN
                        v_intNo     := RIGHT(p_pstrTrxNo,6)::int;
                        v_strResult := LPAD(v_intNo::varchar,3,'0') || '/' || p_pstrTrxHeader || '/' || v_strMonth || v_strYear;
                    ELSE
                        v_strResult := p_pstrTrxNo;
                    END IF;
                END IF;

                RETURN v_strResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        DB::unprepared("SELECT erp.fn_format_trxno('MAIN','2010000002');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.fn_format_trxno(p_pstrTrxHeader Varchar(6),p_pstrTrxNo Varchar(10));");
    }
}
