<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetEkuitasProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ekuitas (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5));");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_ekuitas (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5))
			RETURNS table(
				coa_cd varchar(20),
				coa_nm varchar(100), 
				begin_debit numeric(19,2),
				begin_credit numeric(19,2),
				amount_month numeric(19,2),
				amount_ytd numeric(19,2)
			)
		AS
		$$
		BEGIN
			return query
			SELECT COA.coa_cd,COA.coa_nm,
			SUM(TOT.begin_debit) AS begin_debit,SUM(TOT.begin_credit) AS begin_credit,
			SUM(TOT.amount_month) AS amount_month,SUM(TOT.amount_ytd) AS amount_ytd
			FROM erp.gl_coa COA
			JOIN
			(	
				SELECT LEFT(COA.coa_cd,5)::varchar AS coa_cd,COA.coa_nm,
				BB.amount_debit AS begin_debit,BB.amount_credit AS begin_credit,
				TRX.total_amount AS amount_month,YTD.total_amount AS amount_ytd
				FROM erp.gl_coa COA
				LEFT JOIN
				(
				SELECT A.coa_cd,A.amount_debit,A.amount_credit
				FROM erp.gl_coa_begin_balance A
				WHERE A.comp_cd = p_pstrCompCd  
				AND A.balance_year=p_pintYear
				) AS BB ON COA.coa_cd=BB.coa_cd
				LEFT JOIN
				(
				SELECT B.coa_cd,SUM(B.trx_amount) AS total_amount
				FROM erp.gl_transaction A
				JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
				WHERE A.comp_cd = p_pstrCompCd  
				AND A.trx_year=p_pintYear AND A.trx_month = p_pintMonth
				AND A.post_st='1'
				GROUP BY B.coa_cd
				ORDER BY B.coa_cd
				) AS TRX ON COA.coa_cd=TRX.coa_cd
				LEFT JOIN
				(
				SELECT B.coa_cd,SUM(B.trx_amount) AS total_amount
				FROM erp.gl_transaction A
				JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
				WHERE A.comp_cd = p_pstrCompCd  
				AND A.trx_year=p_pintYear AND A.trx_month <= p_pintMonth
				AND A.post_st='1'
				GROUP BY B.coa_cd
				ORDER BY B.coa_cd
				) AS YTD ON COA.coa_cd=YTD.coa_cd
				WHERE COA.coa_tp_cd=p_pstrCoaTp
				ORDER BY COA.coa_cd
			) AS TOT ON COA.coa_cd=TOT.coa_cd
			GROUP BY COA.coa_cd,COA.coa_nm
			ORDER BY COA.coa_cd;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ekuitas (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5));");
    }
}
