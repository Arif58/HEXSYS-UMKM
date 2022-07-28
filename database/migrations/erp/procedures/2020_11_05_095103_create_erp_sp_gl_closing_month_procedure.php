<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlClosingMonthProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_closing_month (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int, p_pintMonth int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_closing_month (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int, p_pintMonth int)
                RETURNS Varchar(20)
            AS
            $$
            DECLARE v_strClosingCode Varchar(16);
                    v_intYearNext int;
                    v_intMonthNext int;
                    
                    v_strCurrDefault Varchar(10);
                    v_strCurrType Varchar(10);
                    v_strCoaFormat Varchar(20);
                    v_strCoaRetEarning Varchar(20);
                    v_strCoaRevGain Varchar(20);
                    v_strCoaRevLoss Varchar(20);
                    
                    v_numRetEarning Numeric(18,0);
                    v_numRevGain Numeric(18,0);
                    v_numRevLoss Numeric(18,0);
                    v_strResult varchar(20);
            BEGIN
                select concat(p_pstrCompCd,p_pintYear::varchar,lpad(p_pintMonth::varchar,2,'0')) into v_strClosingCode;

                IF p_pintMonth < 12
                THEN
                    v_intMonthNext := p_pintMonth + 1;
                    v_intYearNext := p_pintYear;
                    
                    UPDATE erp.gl_reference
                    SET ref_month=v_intMonthNext,
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear;
                ELSE
                    /*v_intMonthNext := 1;
                    v_intYearNext := p_pintYear + 1;
                
                    SELECT 
                    curr_default,
                    curr_tp,
                    account_format,
                    account_ret_earning,
                    account_rev_gain,
                    account_rev_loss 
                    INTO 
                    v_strCurrDefault, 
                    v_strCurrType, 
                    v_strCoaFormat, 
                    v_strCoaRetEarning, 
                    v_strCoaRevGain, 
                    v_strCoaRevLoss
                    FROM erp.gl_reference
                    WHERE ref_year=p_pintYear;
                
                    INSERT INTO erp.gl_reference (
						gl_reference_id,
                        comp_cd,
                        ref_year,
                        ref_month,
                        curr_default,
                        curr_tp,
                        account_format,
                        account_ret_earning,
                        account_rev_gain,
                        account_rev_loss,
                        ref_st,
                        created_by,
                        created_at
                    )VALUES (
						uuid_generate_v4(),
                        p_pstrCompCd,
                        v_intYearNext,
                        v_intMonthNext,
                        v_strCurrDefault,
                        v_strCoaRevGain,
                        v_strCoaFormat,
                        v_strCoaRetEarning,
                        v_strCurrType,
                        v_strCoaRevLoss,
                        '0',
                        p_pstrUserId,
                        NOW()
                    );
					
					UPDATE erp.gl_reference
                    SET ref_st='1',
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear
                    AND ref_month=p_pintmonth;*/
                
                	v_intMonthNext := 12;
                    v_intYearNext := p_pintYear;
                   
                   	UPDATE erp.gl_reference
                    SET ref_month=v_intMonthNext,
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear;
                END IF;

                select erp.fn_gl_get_returnearning(p_pstrCompCd,p_pintYear,p_pintMonth) into v_numRetEarning;
                select erp.fn_gl_get_revaluation(p_pstrCompCd,p_pintYear,p_pintMonth) into v_numRevGain;

                v_numRevLoss := 0;

                IF v_numRevGain < 0
                THEN
                    v_numRevLoss := v_numRevGain;
                    v_numRevGain := 0;
                END IF;

                DELETE FROM erp.gl_closing_month
                WHERE comp_cd=p_pstrCompCd
                AND closing_cd=v_strClosingCode;
                
                INSERT INTO erp.gl_closing_month (
                    comp_cd,
                    closing_cd,
                    ret_earning,
                    rev_gain,
                    rev_loss,
                    process_by,
                    process_date,
                    created_by,
                    created_at
                )VALUES (
                    p_pstrCompCd,
                    v_strClosingCode,
                    v_numRetEarning,
                    v_numRevGain,
                    v_numRevLoss,
                    p_pstrUserId,
                    NOW(),
                    p_pstrUserId,
                    NOW()
                );

                v_strResult := 'ok';

                RETURN v_strResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_closing_month (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int, p_pintMonth int);");
    }
}
