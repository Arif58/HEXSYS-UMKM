<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlClosingYearProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_closing_year (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_closing_year (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int)
                RETURNS Varchar(20)
            AS
            $$
            DECLARE v_strClosingCd Varchar(16);
                    v_intYearNext int;
                    
                    v_numRetEarning Numeric(18,0);
                    v_numRevGain Numeric(18,0);
                    v_numRevLoss Numeric(18,0);
                    v_strResult Varchar(20);
            BEGIN
                --select concat(p_pstrCompCd,p_pintYear::varchar,lpad(p_pintYear::varchar,2,'0')) into v_strClosingCd;
                select concat(p_pstrCompCd,p_pintYear::varchar) into v_strClosingCd;
                v_intYearNext := p_pintYear + 1;

                DELETE FROM erp.gl_closing_year
                WHERE comp_cd=p_pstrCompCd
                AND closing_cd=v_strClosingCd;

                SELECT 
                SUM(ret_earning),
                SUM(rev_gain),
                SUM(rev_loss) 
                INTO 
                v_numRetEarning, 
                v_numRevGain, 
                v_numRevLoss
                FROM erp.gl_closing_month
                WHERE comp_cd=p_pstrCompCd
                AND closing_cd ILIKE ''|| v_strClosingCd ||'%';

                INSERT INTO erp.gl_closing_year (
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
                    v_strClosingCd,
                    v_numRetEarning,
                    v_numRevGain,
                    v_numRevLoss,
                    p_pstrUserId,
                    NOW(),
                    p_pstrUserId,
                    NOW()
                );
				
				/*--Set Next Year Reference--*/
                IF NOT EXISTS (SELECT A.ref_year FROM erp.gl_reference A WHERE A.comp_cd=p_pstrCompCd AND A.ref_year=v_intYearNext)
                THEN
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
						journal_approval_cd,
						posting_approval_cd,
						closing_approval_cd,
                        ref_st,
                        created_by,
                        created_at
                    )
                    SELECT 
                    public.uuid_generate_v4(),
                    comp_cd,
                    ref_year + 1, 
                    1 AS ref_month,
                    curr_default,
                    curr_tp,
                    account_format,
                    account_ret_earning,
                    account_rev_gain,
                    account_rev_loss,
					journal_approval_cd,
					posting_approval_cd,
					closing_approval_cd,
                    '0' AS ref_st,
                    p_pstrUserId AS created_by,
                    NOW() AS created_at
                    FROM erp.gl_reference
                    WHERE comp_cd=p_pstrCompCd
                    AND ref_year=p_pintYear;
                END IF;

                UPDATE erp.gl_reference
                SET ref_st='1',
                created_by=p_pstrUserId,
                created_at=NOW()
                WHERE comp_cd=p_pstrCompCd
                AND ref_year=p_pintYear;
				
				/*--Set Next Year COA Begin Balance | Reset COA(Income/Expense)--*/
				IF NOT EXISTS (SELECT A.balance_year FROM erp.gl_coa_begin_balance A WHERE A.comp_cd=p_pstrCompCd AND A.balance_year=v_intYearNext)
                THEN
                    INSERT INTO erp.gl_coa_begin_balance (
                        gl_coa_begin_balance_id,
                        comp_cd,
                        coa_cd,
                        balance_year,
                        currency_cd,
                        amount_debit,
                        amount_credit,
                        rate,
                        created_by,
                        created_at
                    )
                    SELECT 
                    public.uuid_generate_v4(),
                    comp_cd,
                    coa_cd,
                    balance_year + 1,
                    currency_cd,
                    amount_debit,
                    amount_credit,
                    public.fn_get_rate(currency_cd) AS rate,
                    p_pstrUserId AS created_by,
                    NOW() AS created_at
                    FROM erp.gl_coa_begin_balance
                    WHERE comp_cd=p_pstrCompCd
                    AND balance_year=p_pintYear;
                END IF;
				
				UPDATE erp.gl_coa_begin_balance
                SET amount_debit=0,
                amount_credit=0,
                rate=public.fn_get_rate(currency_cd),
                created_by=p_pstrUserId,created_at=NOW()
                WHERE comp_cd=p_pstrCompCd
                AND balance_year=v_intYearNext
                --AND erp.fn_gl_get_coa_tp_cd(p_pstrCompCd,coa_cd) IN ('4','5');
				AND coa_cd IN (SELECT coa_cd FROM erp.gl_coa WHERE comp_cd=p_pstrCompCd AND coa_tp_cd IN ('4','5'));
				
				/*--Set Return Earning--*/
				--CALL erp.sp_gl_set_returnearning (p_pstrCompCd,p_pintYear,v_intYearNext,v_numRetEarning);
				
				/*--Set Next Year Cost Center Begin Balance--*/
                IF NOT EXISTS (SELECT A.balance_year FROM erp.gl_cost_center_begin_balance A WHERE A.comp_cd=p_pstrCompCd AND A.balance_year=v_intYearNext)
                THEN
                    INSERT INTO erp.gl_cost_center_begin_balance (
                        gl_cost_center_begin_balance_id,
                        comp_cd,
                        coa_cd,
                        cc_cd,
                        balance_year,
                        currency_cd,
                        amount_debit,
                        amount_credit,
                        rate,
                        created_by,
                        created_at
                    )
                    SELECT 
                    public.uuid_generate_v4(),
                    comp_cd,
                    coa_cd,
                    cc_cd,
                    balance_year + 1,
                    currency_cd,
                    amount_debit,
                    amount_credit,
                    public.fn_get_rate(currency_cd) AS rate,
                    p_pstrUserId AS created_by,
                    NOW() AS created_at
                    FROM erp.gl_cost_center_begin_balance
                    WHERE comp_cd=p_pstrCompCd
                    AND balance_year=p_pintYear;
                END IF;
				
				/*--Set Header Faktur--*/
				/*--Header Faktur : ABC.000.YY.00000001; ABC=Kode Perusahaan;YY=Tahun Pajak;00000001=Seq.No--*/
				/*UPDATE erp.tax_header
				SET tax_header=concat('010.000-',p_pstrCompCd,v_intYearNext::varchar,lpad(v_intYearNext::varchar,2,'0'))
				WHERE comp_cd=p_pstrCompCd;*/
				
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
        DB::unprepared("DROP function if exists erp.sp_gl_closing_year (p_pstrCompCd Varchar(10), p_pstrUserId Varchar(20), p_pintYear int);");
    }
}
