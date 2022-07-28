<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetFinancialPeriodeDateProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_financial_periode_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaStart Varchar(20), p_pstrCoaEnd Varchar(20), p_pstrDanaTp Varchar(20));");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_financial_periode_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaStart Varchar(20), p_pstrCoaEnd Varchar(20), p_pstrDanaTp Varchar(20))
			RETURNS table(
				com_cd varchar(20),
				code_nm varchar(100),
				account_cd varchar(20),
				begin_debit numeric(19,2),
				begin_credit numeric(19,2),
				amount_month numeric(19,2),
				amount_ytd numeric(19,2)
			)
		AS
		$$
		BEGIN
			return query
			SELECT CG.com_cd,CG.code_nm,CG.code_value as account_cd,
			SUM(TOT.begin_debit) AS begin_debit,SUM(TOT.begin_credit) AS begin_credit,
			SUM(TOT.amount_month) AS amount_month,SUM(TOT.amount_ytd) AS amount_ytd
			FROM public.com_code CG
			LEFT JOIN erp.gl_coa COA on CG.com_cd=COA.coa_group
			LEFT JOIN
			(	
				SELECT COA.coa_cd,COA.coa_nm,
				BB.amount_debit AS begin_debit,BB.amount_credit AS begin_credit,
				TRX.total_amount AS amount_month,YTD.total_amount AS amount_ytd
				FROM erp.gl_coa COA
				LEFT JOIN
				(
				SELECT A.coa_cd,A.amount_debit,A.amount_credit
				FROM erp.gl_coa_begin_balance A
				WHERE A.comp_cd = p_pstrCompCd  
				AND A.balance_year=EXTRACT(year FROM p_dateStart)
				) AS BB ON COA.coa_cd=BB.coa_cd
				LEFT JOIN
				(
				SELECT B.coa_cd,
				--SUM(B.trx_amount) AS total_amount
				SUM(
				(CASE
					WHEN C.coa_tp_cd IN ('1','5')
					THEN
						(CASE
						WHEN B.dc_value='C'
						THEN B.trx_amount*(-1)
						WHEN B.dc_value='D'
						THEN B.trx_amount
						END)
					END)
				) AS total_amount
				FROM erp.gl_transaction A
				JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
				JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd
				WHERE A.comp_cd = p_pstrCompCd  
				AND A.trx_date::date between p_dateStart AND p_dateEnd
				AND A.post_st='1'
				AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
				GROUP BY B.coa_cd
				ORDER BY B.coa_cd
				) AS TRX ON COA.coa_cd=TRX.coa_cd
				LEFT JOIN
				(
				SELECT B.coa_cd,
				--SUM(B.trx_amount) AS total_amount
				SUM(
				(CASE
					WHEN C.coa_tp_cd IN ('1','5')
					THEN
						(CASE
						WHEN B.dc_value='C'
						THEN B.trx_amount*(-1)
						WHEN B.dc_value='D'
						THEN B.trx_amount
						END)
					END)
				) AS total_amount
				FROM erp.gl_transaction A
				JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
				JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd
				WHERE A.comp_cd = p_pstrCompCd  
				--AND A.trx_date::date between p_dateStart AND p_dateEnd
				AND A.trx_year=EXTRACT(year FROM p_dateStart) AND A.trx_date::date < p_dateStart
				AND A.post_st='1'
				AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
				GROUP BY B.coa_cd
				ORDER BY B.coa_cd
				) AS YTD ON COA.coa_cd=YTD.coa_cd
				ORDER BY COA.coa_cd
			) AS TOT ON COA.coa_cd=TOT.coa_cd
			WHERE CG.code_group='COA_GROUP'
			AND (CASE
				WHEN p_pstrCoaStart<>'' AND p_pstrCoaEnd<>''
				THEN CG.code_value BETWEEN p_pstrCoaStart AND p_pstrCoaEnd
				WHEN p_pstrCoaStart='' AND p_pstrCoaEnd<>''
				THEN CG.code_value<=p_pstrCoaEnd
				WHEN p_pstrCoaStart<>'' AND p_pstrCoaEnd=''
				THEN CG.code_value>=p_pstrCoaStart
				ELSE
					1=1
				END)
			GROUP BY CG.com_cd,CG.code_nm,CG.code_value
			ORDER BY CG.code_value;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_financial_periode_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaStart Varchar(20), p_pstrCoaEnd Varchar(20), p_pstrDanaTp Varchar(20));");
    }
}
