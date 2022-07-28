<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnArGetTrxNoFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.fn_ar_get_trx_no (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_ar_get_trx_no (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int)
            RETURNS Varchar(20)
            AS
            $$
                DECLARE v_strResult Varchar(20);
                v_strSeqType char(1);
                v_intTotalTrx int;
            BEGIN
            
                v_strSeqType := '1';
                
                case v_strSeqType 
                    when '1' THEN
                /*--Monthly--*/
                    SELECT MAX(RIGHT(ar_cd,6)::int) + 1
                    into v_intTotalTrx
                    FROM erp.ar_trx
                    WHERE comp_cd=p_pstrCompCd
                    AND trx_year=p_pintYear
                    AND trx_month=p_pintMonth;
                when '2' THEN
                /*--Yearly--*/
                    SELECT MAX(RIGHT(ar_cd,6)::int) + 1
                    into v_intTotalTrx
                    FROM erp.ar_trx
                    WHERE comp_cd=p_pstrCompCd
                    AND trx_year=p_pintYear;
                ELSE
                /*--Continuously--*/
                    SELECT MAX(RIGHT(ar_cd,6)::int) + 1
                    into v_intTotalTrx
                    FROM erp.ar_trx
                    WHERE comp_cd=p_pstrCompCd;
                END CASE;
                                    
                IF v_intTotalTrx IS NULL THEN
                        v_intTotalTrx := 1;
                END IF;
                            
                v_strResult := LPAD(right(p_pintYear::varchar,2),2,'0') ||LPAD(p_pintMonth::varchar,2,'0') || LPAD(v_intTotalTrx::varchar,6,'0');
                            
                    RETURN v_strResult::varchar;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        DB::unprepared("SELECT erp.fn_ar_get_trx_no('MAIN',".date('Y').", ".date('m').");");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.fn_ar_get_trx_no (p_pstrCompCd varchar(10),p_pintYear int,p_pintMonth int);");

    }
}
