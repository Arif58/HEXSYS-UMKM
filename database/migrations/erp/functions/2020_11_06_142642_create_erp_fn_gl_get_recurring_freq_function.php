<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetRecurringFreqFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_recurring_freq(p_pstrCompCd varchar(10),p_pstrRecurCode varchar(15),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.fn_gl_get_recurring_freq(p_pstrCompCd varchar(10),p_pstrRecurCode varchar(15),p_pintYear int,p_pintMonth int)
                RETURNS char(1)
                LANGUAGE plpgsql
            AS $$
            DECLARE v_strResult char(1);
                    v_intRecurFreq int;
                    v_intMonthStartValid int;
                    v_intMonthEndValid int;
                    v_intYearStartValid int;
                    v_intYearEndValid int;
                    
                    v_intMonthLast int;
                    v_intTotalTrx int;
            BEGIN

                SELECT 
                freq_month,
                date_part('month',start_valid)::int,
                date_part('month',end_valid)::int,
                date_part('year',start_valid)::int,
                date_part('year',end_valid)::int 
                INTO 
                v_intRecurFreq, 
                v_intMonthStartValid, 
                v_intMonthEndValid, 
                v_intYearStartValid, 
                v_intYearEndValid
                FROM erp.gl_journal_recur
                WHERE comp_cd=p_pstrCompCd
                AND recur_cd=p_pstrRecurCode;
                
                IF v_intRecurFreq = 1 THEN
                    v_strResult := '0';
                ELSE
                    IF p_pintMonth - v_intRecurFreq < 1 THEN
                        v_intMonthLast := 1;
                    ELSE
                        v_intMonthLast := p_pintMonth - v_intRecurFreq;
                    END IF;
                    
                    SELECT COUNT(trx_cd)
                    into v_intTotalTrx
                    FROM erp.gl_transaction
                    WHERE comp_cd=p_pstrCompCd
                    AND trx_year = p_pintYear
                    AND trx_month <= p_pintMonth
                    AND (v_intMonthLast >= trx_month AND (p_pintMonth-1) <= trx_month)
                    AND journal_tp='3'
                    AND gl_source_cd=p_pstrRecurCode;
                    
                    IF v_intTotalTrx = 0 THEN
                        v_strResult := '0';
                    ELSE
                        v_strResult := '1';
                    END IF;
                END IF;
                

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
        DB::unprepared("DROP FUNCTION if exists erp.fn_gl_get_recurring_freq(p_pstrCompCd varchar(10),p_pstrRecurCode varchar(15),p_pintYear int,p_pintMonth int);");
    }
}
