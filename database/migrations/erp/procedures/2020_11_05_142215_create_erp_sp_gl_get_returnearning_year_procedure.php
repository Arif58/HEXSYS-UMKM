<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlGetReturnearningYearProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_returnearning_year (p_pstrCompCd Varchar(10), p_pintYear int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_get_returnearning_year (p_pstrCompCd Varchar(10), p_pintYear int)
                RETURNS table(
                    ret_return_earning numeric(18,0),
                    ret_account_ret_earning varchar(20),
                    ret_account_earning_name varchar(100),
                    ret_dc_value varchar(100),
                    ret_account_journal_ret_earning varchar(20),
                    ret_account_journal_earning_name varchar(100)
                )
            AS
            $$
            DECLARE v_strClosingCd Varchar(16);
                    v_strCoaRetEarning Varchar(20);
                    v_strCoaRetEarningName Varchar(100);
                    v_strCoaDC Varchar(100);
                    
                    v_strCoaJournalRetEarn Varchar(20);
                    v_strCoaJournalRetEarnName Varchar(100);

            BEGIN
                v_strClosingCd := concat(p_pstrCompCd,p_pintYear::varchar);
	
                SELECT 
                A.account_ret_earning,
                B.coa_nm,
                C.dc_value 
                INTO 
                v_strCoaRetEarning, 
                v_strCoaRetEarningName, 
                v_strCoaDC
                FROM erp.gl_reference A
                LEFT JOIN erp.gl_coa B ON A.account_ret_earning=B.coa_cd
                LEFT JOIN erp.gl_coa_type C ON B.coa_tp_cd=C.coa_tp_cd
                WHERE A.comp_cd=p_pstrCompCd
	            AND A.ref_year=p_pintYear;

                SELECT 
                A.account_ret_earning,
                B.coa_nm 
                INTO 
                v_strCoaJournalRetEarn, 
                v_strCoaJournalRetEarnName
                FROM erp.gl_reference A
                LEFT JOIN erp.gl_coa B ON A.account_ret_earning=B.coa_cd
                WHERE A.comp_cd=p_pstrCompCd
                AND A.ref_year=(SELECT MIN(ref_year) FROM erp.gl_reference
                WHERE comp_cd=p_pstrCompCd AND ref_st<>'1');

                RETURN query 
                SELECT
                coalesce(SUM(ret_earning),0) AS return_earning,
                v_strCoaRetEarning AS account_ret_earning,
                v_strCoaRetEarningName AS account_earning_name,
                v_strCoaDC AS dc_value,
                v_strCoaJournalRetEarn AS account_journal_ret_earning,
                v_strCoaJournalRetEarnName AS account_journal_earning_name
                FROM erp.gl_closing_month
                WHERE comp_cd=p_pstrCompCd
                AND closing_cd ILIKE ''|| v_strClosingCd ||'%';

            END;
            $$ 
            LANGUAGE plpgsql;
        ");

        DB::unprepared("SELECT * from erp.sp_gl_get_returnearning_year('MAIN','2020'::int);");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_get_returnearning_year (p_pstrCompCd Varchar(10), p_pintYear int);");
    }
}
