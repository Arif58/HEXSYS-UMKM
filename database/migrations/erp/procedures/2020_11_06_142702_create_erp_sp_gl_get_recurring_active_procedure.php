<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlGetRecurringActiveProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_recurring_active (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_get_recurring_active (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int)
                RETURNS table(
                    recur_cd varchar(20),
                    journal_cd varchar(20),
                    recur_no varchar(200),
                    journal_note text,
                    start_valid timestamp,
                    end_valid timestamp,
                    due_date timestamp,
                    freq_month int,
                    coa_cd varchar(20),
                    detail_note text,
                    dc_value varchar(1),
                    cc_cd varchar(20),
                    currency_cd varchar(20),
                    trx_amount numeric(19,2),
                    rate numeric(19,2)
                )
            AS
            $$

            BEGIN
                Return Query 
                SELECT 
                A.recur_cd,
                A.journal_cd,
                A.recur_no,
                A.note AS journal_note,
                A.start_valid,
                A.end_valid,
                A.due_date,
                A.freq_month,
                B.coa_cd,
                B.note AS detail_note,
                B.dc_value,
                B.cc_cd,
                B.currency_cd,
                B.trx_amount,
                B.rate
                FROM erp.gl_journal_recur A
                JOIN erp.gl_journal_recur_detail B ON A.recur_cd=B.recur_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND (
                    date_part('year',A.start_valid)::int = p_pintYear 
                    OR date_part('year',A.end_valid)::int =p_pintYear
                )
                AND (
                    p_pintMonth between date_part('month',A.start_valid)::int AND date_part('month',A.end_valid)::int
                )
                AND erp.fn_gl_get_recurring_freq(p_pstrCompCd,A.recur_cd,p_pintYear,p_pintMonth)='0'
                ORDER BY 
                A.recur_cd,
                B.trx_item_seq;

            END;
            $$ 
            LANGUAGE plpgsql;
        ");

        DB::unprepared("SELECT * from erp.sp_gl_get_recurring_active('MAIN','2020'::int, '11'::int);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_recurring_active (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
    }
}
