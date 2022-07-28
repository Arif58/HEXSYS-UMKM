<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlGetClosingyearStatusProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_closingyear_status (p_pstrCompCd Varchar(10), p_pintYear int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_get_closingyear_status (p_pstrCompCd Varchar(10), p_pintYear int)
                RETURNS int
            AS
            $$
            DECLARE v_intResult int;
                    v_intMaxClosingMonth int;
                    v_intMaxTrxMonth int;

            BEGIN
                SELECT MAX(RIGHT(A.closing_cd,2))
                into v_intMaxClosingMonth
                FROM erp.gl_closing_month A
                WHERE A.comp_cd=p_pstrCompCd
                AND SUBSTRING(A.closing_cd,length(p_pstrCompCd)+1,4)::integer=p_pintYear;
    
                SELECT MAX(A.trx_month)
                into v_intMaxTrxMonth
                FROM erp.gl_transaction A
                WHERE A.comp_cd=p_pstrCompCd
                AND A.trx_year=p_pintYear;
                                
                IF v_intMaxClosingMonth = 12 THEN
                    v_intResult := 0;
                ELSE
                	IF v_intMaxClosingMonth >= v_intMaxTrxMonth THEN
	                    v_intResult := 0;
	                ELSE		
	                    v_intResult := 1;
	                END IF;
                END IF;

                RETURN v_intResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        DB::unprepared("SELECT erp.sp_gl_get_closingyear_status('MAIN','2020'::int);");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_closingyear_status (p_pstrCompCd Varchar(10), p_pintYear int);");
    }
}
