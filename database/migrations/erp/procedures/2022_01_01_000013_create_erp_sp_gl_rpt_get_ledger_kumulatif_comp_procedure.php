<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetLedgerKumulatifCompProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ledger_kumulatif_comp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20));");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_ledger_kumulatif_comp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20))
				RETURNS table(
					r_group_coa varchar(20),
					r_group_coa_nm varchar(100),
					r_coa_cd varchar(20),
					r_trx_date date, 
					r_cc_cd varchar(20),
					r_journal_no varchar(20),
					r_voucher_no varchar(20),
					r_journal_note text,
					r_dc_value varchar(20),
					r_trx_amount numeric(19,2),
					r_dana_tp_nm varchar(100)
				)
			AS
			$$
			BEGIN
				case
				when p_pstrCoaCdStart <> '' AND p_pstrCoaCdEnd <> ''
				THEN
					return query
					SELECT CG.code_value as group_coa,
					CG.code_nm as group_coa_nm,
					B.coa_cd, A.trx_date, B.cc_cd, A.journal_no,A.voucher_no,
					A.note AS journal_note, B.dc_value,
					SUM(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as trx_amount,
					COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					JOIN erp.gl_coa COA ON B.coa_cd=COA.coa_cd
					JOIN public.com_code CG ON COA.coa_group=CG.com_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND CG.code_value BETWEEN p_pstrCoaCdStart AND p_pstrCoaCdEnd
					AND A.comp_cd = p_pstrCompCd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					GROUP BY CG.code_value,CG.code_nm,B.coa_cd,A.trx_date,B.cc_cd,
					A.journal_no,A.voucher_no,A.note,B.dc_value,COM.code_nm
					ORDER BY CG.code_value,A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart <> '' AND p_pstrCoaCdEnd = ''	
				THEN
					return query
					SELECT CG.code_value as group_coa,
					CG.code_nm as group_coa_nm,
					B.coa_cd, A.trx_date, B.cc_cd, A.journal_no,A.voucher_no,
					A.note AS journal_note, B.dc_value,
					SUM(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as trx_amount,
					COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					JOIN erp.gl_coa COA ON B.coa_cd=COA.coa_cd
					JOIN public.com_code CG ON COA.coa_group=CG.com_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND CG.code_value >= p_pstrCoaCdStart
					AND A.comp_cd = p_pstrCompCd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					GROUP BY CG.code_value,CG.code_nm,B.coa_cd,A.trx_date,B.cc_cd,
					A.journal_no,A.voucher_no,A.note,B.dc_value,COM.code_nm
					ORDER BY CG.code_value,A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd <> ''	
				THEN
					return query
					SELECT CG.code_value as group_coa,
					CG.code_nm as group_coa_nm,
					B.coa_cd, A.trx_date, B.cc_cd, A.journal_no,A.voucher_no,
					A.note AS journal_note, B.dc_value,
					SUM(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as trx_amount,
					COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					JOIN erp.gl_coa COA ON B.coa_cd=COA.coa_cd
					JOIN public.com_code CG ON COA.coa_group=CG.com_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND CG.code_value <= p_pstrCoaCdEnd
					AND A.comp_cd = p_pstrCompCd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					GROUP BY CG.code_value,CG.code_nm,B.coa_cd,A.trx_date,B.cc_cd,
					A.journal_no,A.voucher_no,A.note,B.dc_value,COM.code_nm
					ORDER BY CG.code_value,A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd = ''	
				THEN
					return query
					SELECT CG.code_value as group_coa,
					CG.code_nm as group_coa_nm,
					B.coa_cd, A.trx_date, B.cc_cd, A.journal_no,A.voucher_no,
					A.note AS journal_note, B.dc_value,
					SUM(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as trx_amount,
					COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					JOIN erp.gl_coa COA ON B.coa_cd=COA.coa_cd
					JOIN public.com_code CG ON COA.coa_group=CG.com_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND A.comp_cd = p_pstrCompCd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					GROUP BY CG.code_value,CG.code_nm,B.coa_cd,A.trx_date,B.cc_cd,
					A.journal_no,A.voucher_no,A.note,B.dc_value,COM.code_nm
					ORDER BY CG.code_value,A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				else
					-- default 
					return query
					SELECT CG.code_value as group_coa,
					CG.code_nm as group_coa_nm,
					B.coa_cd, A.trx_date, B.cc_cd, A.journal_no,A.voucher_no,
					A.note AS journal_note, B.dc_value,
					SUM(coalesce(B.trx_amount,0) * coalesce(B.rate,1)) as trx_amount,
					COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					JOIN erp.gl_coa COA ON B.coa_cd=COA.coa_cd
					JOIN public.com_code CG ON COA.coa_group=CG.com_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_year = p_pintYear AND A.trx_month <= p_pintMonth
					AND A.comp_cd = p_pstrCompCd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					GROUP BY CG.code_value,CG.code_nm,B.coa_cd,A.trx_date,B.cc_cd,
					A.journal_no,A.voucher_no,A.note,B.dc_value,COM.code_nm
					ORDER BY CG.code_value,A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				END case;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ledger_kumulatif_comp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20));");
    }
}
