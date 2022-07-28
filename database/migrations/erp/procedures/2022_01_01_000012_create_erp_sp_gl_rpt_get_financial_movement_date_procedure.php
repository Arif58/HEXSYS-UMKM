<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetFinancialMovementDateProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_financial_movement_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrDanaTp Varchar(20));");
        DB::unprepared("
		CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_financial_movement_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrDanaTp Varchar(20))
		RETURNS table(
			coa_cd varchar(20),
			coa_nm varchar(100),
			amount_debit numeric(19,2),
			amount_credit numeric(19,2),
			amount_trx numeric(19,2)
		)
		AS
		$$
		BEGIN
			return query
			select COA.coa_cd,COA.coa_nm,
			coalesce(DB.amount_debit,0) as amount_debit,coalesce(CR.amount_credit,0) as amount_credit,
			coalesce(DB.amount_debit,0) - coalesce(CR.amount_credit,0) as amount_trx
			from erp.gl_coa COA
			left join
			(
				select B.coa_cd,
				sum(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as amount_debit
				from erp.gl_transaction A
				join erp.gl_transaction_detail B on A.trx_cd=B.trx_cd
				where B.dc_value='D'
				and A.comp_cd = p_pstrCompCd  
				and A.trx_date::date between p_dateStart AND p_dateEnd
				and A.post_st='1'
				and B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
				group by B.coa_cd,B.dc_value
			) as DB ON COA.coa_cd=DB.coa_cd
			left join
			(
				select B.coa_cd,
				sum(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as amount_credit
				from erp.gl_transaction A
				join erp.gl_transaction_detail B on A.trx_cd=B.trx_cd
				where B.dc_value='C'
				and A.comp_cd = p_pstrCompCd  
				and A.trx_date::date between p_dateStart AND p_dateEnd
				and A.post_st='1'
				and B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
				group by B.coa_cd,B.dc_value
			) as CR ON COA.coa_cd=CR.coa_cd
			where COA.coa_cd in ('11.04.01','11.04.02','11.04.03','11.04.04','11.04.05','11.04.06','11.04.07','11.04.08','11.04.09','11.04.10','11.04.11','11.04.12','11.04.14')
			union
			select '11.04.13' as coa_cd,'Pajak' as coa_nm,
			sum(TAX.amount_debit) as amount_debit, sum(TAX.amount_credit) as amount_credit,
			sum(TAX.amount_trx) as amount_trx
			from(
				select COA.coa_cd,COA.coa_nm,
				coalesce(DB.amount_debit,0) as amount_debit,coalesce(CR.amount_credit,0) as amount_credit,
				coalesce(DB.amount_debit,0) - coalesce(CR.amount_credit,0) as amount_trx
				from erp.gl_coa COA
				left join
				(
					select B.coa_cd,
					sum(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as amount_debit
					from erp.gl_transaction A
					join erp.gl_transaction_detail B on A.trx_cd=B.trx_cd
					where B.dc_value='D'
					and A.comp_cd = p_pstrCompCd  
					and A.trx_date::date between p_dateStart AND p_dateEnd
					and A.post_st='1'
					and B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					group by B.coa_cd,B.dc_value
				) as DB ON COA.coa_cd=DB.coa_cd
				left join
				(
					select B.coa_cd,
					sum(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as amount_credit
					from erp.gl_transaction A
					join erp.gl_transaction_detail B on A.trx_cd=B.trx_cd
					where B.dc_value='C'
					and A.comp_cd = p_pstrCompCd  
					and A.trx_date::date between p_dateStart AND p_dateEnd
					and A.post_st='1'
					and B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					group by B.coa_cd,B.dc_value
				) as CR ON COA.coa_cd=CR.coa_cd
				--where COA.coa_cd in ('11.04.13','20.01.14','20.01.15')
				where COA.coa_cd in ('20.01.14','20.01.15')
			) as TAX
			order by coa_cd;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_financial_movement_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrDanaTp Varchar(20));");
    }
}
