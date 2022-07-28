<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetLabarugiProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_labarugi (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5));");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_labarugi (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5))
				RETURNS table(
					coa_cd varchar(20),
					coa_nm varchar(100), 
					amount_month numeric(19,2),
					amount_ytd numeric(19,2)
				)
		AS
		$$
		BEGIN
			return query
			/* SELECT TOT.coa_cd,TCOA.coa_nm,SUM(TOT.total_amount) AS total_amount
			FROM
			(
				SELECT LEFT(B.coa_cd,5)::varchar AS coa_cd,SUM(B.trx_amount) AS total_amount
				FROM erp.gl_transaction A
				JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
				JOIN erp.gl_coa C ON B.coa_cd=C.coa_cd
				WHERE A.comp_cd = p_pstrCompCd 
				AND A.trx_year = p_pintYear AND A.trx_month = p_pintMonth
				AND C.coa_tp_cd=p_pstrCoaTp
				AND A.post_st='1'
				GROUP BY B.coa_cd
				ORDER BY B.coa_cd
			) AS TOT LEFT JOIN erp.gl_coa TCOA ON TOT.coa_cd=TCOA.coa_cd
			GROUP by TOT.coa_cd,TCOA.coa_nm
			ORDER BY TOT.coa_cd; */
			SELECT COA.coa_cd,COA.coa_nm,TRX.total_amount AS amount_month,YTD.amount_ytd
			FROM erp.gl_coa COA
			JOIN
			(
			SELECT TOT.coa_cd,TCOA.coa_nm,SUM(TOT.total_amount) AS total_amount
				FROM
				(
					SELECT LEFT(B.coa_cd,5)::varchar AS coa_cd,
					SUM(
					(CASE
						WHEN C.coa_tp_cd='4'
						THEN 
							(CASE
							WHEN B.dc_value='C'
							THEN B.trx_amount
							WHEN B.dc_value='D'
							THEN B.trx_amount*(-1)
							END)
						WHEN C.coa_tp_cd='5'
						then
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
					AND A.trx_year = p_pintYear AND A.trx_month = p_pintMonth
					AND C.coa_tp_cd=p_pstrCoaTp
					AND A.post_st='1'
					GROUP BY B.coa_cd
					ORDER BY B.coa_cd
				) AS TOT LEFT JOIN erp.gl_coa TCOA ON TOT.coa_cd=TCOA.coa_cd
				GROUP by TOT.coa_cd,TCOA.coa_nm
				ORDER BY TOT.coa_cd
			) AS TRX ON COA.coa_cd=TRX.coa_cd
			LEFT JOIN
			(
			SELECT TOT.coa_cd,TCOA.coa_nm,SUM(TOT.total_amount) AS amount_ytd
				FROM
				(
					SELECT LEFT(B.coa_cd,5)::varchar AS coa_cd,
					SUM(
					(CASE
						WHEN C.coa_tp_cd='4'
						THEN 
							(CASE
							WHEN B.dc_value='C'
							THEN B.trx_amount
							WHEN B.dc_value='D'
							THEN B.trx_amount*(-1)
							END)
						WHEN C.coa_tp_cd='5'
						then
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
					AND A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND C.coa_tp_cd=p_pstrCoaTp
					AND A.post_st='1'
					GROUP BY B.coa_cd
					ORDER BY B.coa_cd
				) AS TOT LEFT JOIN erp.gl_coa TCOA ON TOT.coa_cd=TCOA.coa_cd
				GROUP by TOT.coa_cd,TCOA.coa_nm
				ORDER BY TOT.coa_cd
			) AS YTD ON COA.coa_cd=YTD.coa_cd;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_labarugi (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaTp Varchar(5));");
    }
}
