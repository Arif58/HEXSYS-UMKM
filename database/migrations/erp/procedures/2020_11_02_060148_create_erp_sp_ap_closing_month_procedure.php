<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpApClosingMonthProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_closing_month (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrUserId Varchar(20), p_pstrUserNm Varchar(100));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_ap_closing_month (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrUserId Varchar(20), p_pstrUserNm Varchar(100))
                RETURNS Varchar(20)
            AS
            $$
                DECLARE v_strResult Varchar(20);
                v_strClosingCode Varchar(16);
                v_intYearNext int;
                v_intMonthNext int;
                v_strCurrDefault Varchar(10);
                v_strCurrType Varchar(10);
                v_strApApprovalCode Varchar(10);
                v_strAgingCodeWD Varchar(10);
                v_strAgingCodeOD Varchar(10);
            BEGIN

                SELECT erp.FN_AR_GET_CLOSING_CD(p_pstrCompCd,p_pintYear,p_pintMonth,'1') into v_strClosingCode;
                IF p_pintMonth < 12
                THEN
                    v_intMonthNext := p_pintMonth + 1;
                    v_intYearNext := p_pintYear;
                    
                    UPDATE erp.ap_reference
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
                    ap_approval_cd,
                    aging_cd_wd,
                    aging_cd_od 
                    INTO 
                    v_strCurrDefault, 
                    v_strCurrType, 
                    v_strApApprovalCode, 
                    v_strAgingCodeWD, 
                    v_strAgingCodeOD
                    FROM erp.ap_reference
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear;
                
                    INSERT INTO erp.ap_reference (
						ap_reference_id,
                        comp_cd,
                        ref_year,
                        ref_month,
                        curr_default,
                        curr_tp,
                        ap_approval_cd,
                        aging_cd_wd,
                        aging_cd_od,
                        ref_st,
                        created_by,
                        created_at
                    ) VALUES (
						uuid_generate_v4(),
                        p_pstrCompCd,
                        v_intYearNext,
                        v_intMonthNext,
                        v_strCurrDefault,
                        v_strCurrType,
                        v_strApApprovalCode,
                        v_strAgingCodeWD,
                        v_strAgingCodeOD,
                        '0',
                        p_pstrUserId,
                        NOW()
                    );
					
					UPDATE erp.ap_reference
                    SET ref_st='1',
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear
                    AND ref_month=p_pintmonth;*/
                
                	v_intMonthNext := 12;
                    v_intYearNext := p_pintYear;
                   
                   	UPDATE erp.ap_reference
                    SET ref_month=v_intMonthNext,
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear;
                END IF;

                DELETE FROM erp.ap_closing
                WHERE comp_cd=p_pstrCompCd
                AND closing_cd=v_strClosingCode;
                
                INSERT INTO erp.ap_closing (
                    comp_cd,
                    closing_cd,
                    process_by,
                    process_date,
                    closing_tp,
                    created_by,
                    created_at
                ) VALUES (
                    p_pstrCompCd,
                    v_strClosingCode,
                    p_pstrUserNm,
                    NOW(),
                    '1',
                    p_pstrUserId,
                    NOW()
                );

                v_strResult := 'ok';

                RETURN v_strResult;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");
        // DB::unprepared("SELECT erp.sp_ap_closing_month('MAIN',".date('Y').", ".date('m').",'super','super admin');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_ap_closing_month (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrUserId Varchar(20), p_pstrUserNm Varchar(100));");
    }
}
