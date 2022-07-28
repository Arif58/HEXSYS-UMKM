<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetNeracaProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_neraca (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
        DB::unprepared("
		CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_neraca (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int)
		RETURNS table(
			coa_cd varchar(20),
			coa_nm varchar(100),
			coa_tp_cd varchar(20),
			begin_debit numeric(19,2),
			begin_credit numeric(19,2),
			amount_debit numeric(19,2),
			amount_credit numeric(19,2),
			amount_debit_ytd numeric(19,2),
			amount_credit_ytd numeric(19,2)
		)
		AS
		$$
			BEGIN
				RETURN QUERY
				SELECT LEFT(TOT.coa_cd,5)::varchar AS coa_cd,TCOA.coa_nm,TCOA.coa_tp_cd,
				SUM(TOT.begin_debit) AS begin_debit,SUM(TOT.begin_credit) AS begin_credit,
				SUM(TOT.amount_debit) AS amount_debit,SUM(TOT.amount_credit) AS amount_credit,
				SUM(TOT.amount_debit_ytd) AS amount_debit_ytd,SUM(TOT.amount_credit_ytd) AS amount_credit_ytd
				FROM
				(
					SELECT COA.coa_cd,COA.coa_nm,COA.coa_tp_cd,
					BB.amount_debit AS begin_debit,BB.amount_credit AS begin_credit,
					DB.amount_debit,CR.amount_credit,DYTD.amount_debit_ytd,CYTD.amount_credit_ytd
					FROM erp.gl_coa COA
					LEFT JOIN
					(
					SELECT A.coa_cd,A.amount_debit,A.amount_credit
					FROM erp.gl_coa_begin_balance A
					WHERE A.balance_year=p_pintYear
					AND A.comp_cd = p_pstrCompCd
					) AS BB ON COA.coa_cd=BB.coa_cd
					LEFT JOIN
					( 
					SELECT B.coa_cd,SUM(B.trx_amount) AS amount_debit
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					WHERE A.trx_year=p_pintYear AND A.trx_month=p_pintMonth
					AND B.dc_value='D'
					AND A.comp_cd = p_pstrCompCd
					GROUP BY B.coa_cd
					) AS DB ON COA.coa_cd=DB.coa_cd
					LEFT JOIN
					(
					SELECT B.coa_cd,SUM(B.trx_amount) AS amount_credit
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					WHERE A.trx_year=p_pintYear AND A.trx_month=p_pintMonth
					AND B.dc_value='C'
					AND A.comp_cd = p_pstrCompCd
					GROUP BY B.coa_cd
					) AS CR ON COA.coa_cd=CR.coa_cd
					LEFT JOIN
					( 
					SELECT B.coa_cd,SUM(B.trx_amount) AS amount_debit_ytd
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					WHERE A.trx_year=p_pintYear AND A.trx_month<=p_pintMonth
					AND B.dc_value='D'
					AND A.comp_cd = p_pstrCompCd
					GROUP BY B.coa_cd
					) AS DYTD ON COA.coa_cd=DYTD.coa_cd
					LEFT JOIN
					( 
					SELECT B.coa_cd,SUM(B.trx_amount) AS amount_credit_ytd
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					WHERE A.trx_year=p_pintYear AND A.trx_month<=p_pintMonth
					AND B.dc_value='C'
					AND A.comp_cd = p_pstrCompCd
					GROUP BY B.coa_cd
					) AS CYTD ON COA.coa_cd=CYTD.coa_cd
					WHERE COA.coa_tp_cd IN ('1','2','3')
					ORDER BY coa_cd
				) AS TOT LEFT JOIN erp.gl_coa TCOA ON LEFT(TOT.coa_cd,5)=TCOA.coa_cd
				GROUP by LEFT(TOT.coa_cd,5),TCOA.coa_nm,TCOA.coa_tp_cd
				ORDER BY coa_cd;
			END;
		$$ 
		LANGUAGE plpgsql;
        ");
    }
	
	//--Using table gl_posting_month
	/* public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_neraca (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
        DB::unprepared("
		CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_neraca (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int)
		RETURNS table(
			coa_cd varchar(20),
			coa_nm varchar(100),
			coa_tp_cd varchar(20),
			begin_debit numeric(19,2),
			begin_credit numeric(19,2),
			amount_debit numeric(19,2),
			amount_credit numeric(19,2),
			amount_debit_ytd numeric(19,2),
			amount_credit_ytd numeric(19,2)
		)
		AS
		$$
			DECLARE v_strPostingCd Varchar(30);
					v_strPostingCdBegin Varchar(30);
					
			BEGIN
				v_strPostingCdBegin := p_pstrCompCd || p_pintYear::varchar || '01';
				v_strPostingCd := p_pstrCompCd || p_pintYear::varchar || LPAD(p_pintMonth::varchar, 2, '0');
				
				return query
				SELECT LEFT(TOT.coa_cd,5)::varchar AS coa_cd,TCOA.coa_nm,TCOA.coa_tp_cd,
				SUM(TOT.begin_debit) AS begin_debit,SUM(TOT.begin_credit) AS begin_credit,
				SUM(TOT.amount_debit) AS amount_debit,SUM(TOT.amount_credit) AS amount_credit,
				SUM(TOT.amount_debit_ytd) AS amount_debit_ytd,SUM(TOT.amount_credit_ytd) AS amount_credit_ytd
				FROM
				(
					SELECT COA.coa_cd,COA.coa_nm,COA.coa_tp_cd,
					BB.amount_debit AS begin_debit,BB.amount_credit AS begin_credit,
					DB.amount_debit,CR.amount_credit,DYTD.amount_debit_ytd,CYTD.amount_credit_ytd
					FROM erp.gl_coa COA
					LEFT JOIN
					(
					SELECT A.coa_cd,A.amount_debit,A.amount_credit
					FROM erp.gl_coa_begin_balance A
					WHERE A.balance_year=p_pintYear
					) AS BB ON COA.coa_cd=BB.coa_cd
					LEFT JOIN
					( 
					SELECT B.coa_cd,SUM(B.total_amount) AS amount_debit
					FROM erp.gl_posting_month B WHERE B.posting_cd=v_strPostingCd AND B.dc_value='D'
					GROUP BY B.coa_cd
					) AS DB ON COA.coa_cd=DB.coa_cd
					LEFT JOIN
					(SELECT C.coa_cd,SUM(C.total_amount) AS amount_credit
					FROM erp.gl_posting_month C WHERE C.posting_cd=v_strPostingCd AND C.dc_value='C'
					GROUP BY C.coa_cd
					) AS CR ON COA.coa_cd=CR.coa_cd
					LEFT JOIN
					( 
					SELECT D.coa_cd,SUM(D.total_amount) AS amount_debit_ytd
					FROM erp.gl_posting_month D WHERE (D.posting_cd>=v_strPostingCdBegin AND D.posting_cd<=v_strPostingCd) AND D.dc_value='D'
					GROUP BY D.coa_cd
					) AS DYTD ON COA.coa_cd=DYTD.coa_cd
					LEFT JOIN
					( 
					SELECT E.coa_cd,SUM(E.total_amount) AS amount_credit_ytd
					FROM erp.gl_posting_month E WHERE (E.posting_cd>=v_strPostingCdBegin AND E.posting_cd<=v_strPostingCd) AND E.dc_value='C'
					GROUP BY E.coa_cd
					) AS CYTD ON COA.coa_cd=CYTD.coa_cd
					WHERE COA.coa_tp_cd IN ('1','2','3')
					ORDER BY coa_cd
				) AS TOT LEFT JOIN erp.gl_coa TCOA ON LEFT(TOT.coa_cd,5)=TCOA.coa_cd
				GROUP by LEFT(TOT.coa_cd,5),TCOA.coa_nm,TCOA.coa_tp_cd
				ORDER BY coa_cd;
			END;
		$$ 
		LANGUAGE plpgsql;
        ");
    } */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_neraca (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
    }
}
