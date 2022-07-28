<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetLedgerDateProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ledger_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20));");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_ledger_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20))
				RETURNS table(
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
					SELECT B.coa_cd,
					A.trx_date, 
					B.cc_cd,
					A.journal_no,
					A.voucher_no,
					A.note AS journal_note,
					B.dc_value,
					B.trx_amount,COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_date::date between p_dateStart AND p_dateEnd
					--AND B.coa_cd BETWEEN p_pstrCoaCdStart AND p_pstrCoaCdEnd
					AND RPAD(REPLACE(B.coa_cd,'.',''), 6, '0') BETWEEN RPAD(REPLACE(p_pstrCoaCdStart,'.',''), 6, '0') AND RPAD(REPLACE(p_pstrCoaCdEnd,'.',''), 6, '9')
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					AND A.comp_cd = p_pstrCompCd
					ORDER BY A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart <> '' AND p_pstrCoaCdEnd = ''	
				THEN
					return query
					SELECT B.coa_cd,
					A.trx_date, 
					B.cc_cd,
					A.journal_no,
					A.voucher_no,
					A.note AS journal_note,
					B.dc_value,
					B.trx_amount,COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_date::date between p_dateStart AND p_dateEnd
					--AND B.coa_cd >= p_pstrCoaCdStart
					AND RPAD(REPLACE(B.coa_cd,'.',''), 6, '0') >= RPAD(REPLACE(p_pstrCoaCdStart,'.',''), 6, '0')
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					AND A.comp_cd = p_pstrCompCd
					ORDER BY A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd <> ''	
				THEN
					return query
					SELECT B.coa_cd,
					A.trx_date, 
					B.cc_cd,
					A.journal_no,
					A.voucher_no,
					A.note AS journal_note,
					B.dc_value,
					B.trx_amount,COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_date::date between p_dateStart AND p_dateEnd
					--AND B.coa_cd <= p_pstrCoaCdEnd
					AND RPAD(REPLACE(B.coa_cd,'.',''), 6, '0') <= RPAD(REPLACE(p_pstrCoaCdEnd,'.',''), 6, '9')
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					AND A.comp_cd = p_pstrCompCd
					ORDER BY A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				when p_pstrCoaCdStart = '' AND p_pstrCoaCdEnd = ''	
				THEN
					return query
					SELECT B.coa_cd,
					A.trx_date, 
					B.cc_cd,
					A.journal_no,
					A.voucher_no,
					A.note AS journal_note,
					B.dc_value,
					B.trx_amount,COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_date::date between p_dateStart AND p_dateEnd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					AND A.comp_cd = p_pstrCompCd
					ORDER BY A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
				else
					-- default 
					return query
					SELECT B.coa_cd,
					A.trx_date, 
					B.cc_cd,
					A.journal_no,
					A.voucher_no,
					A.note AS journal_note,
					B.dc_value,
					B.trx_amount,COM.code_nm AS dana_tp_nm
					FROM erp.gl_transaction A
					JOIN erp.gl_transaction_detail B ON A.trx_cd=B.trx_cd
					LEFT JOIN public.com_code COM ON B.dana_tp=COM.com_cd
					WHERE A.trx_date::date between p_dateStart AND p_dateEnd
					AND B.dana_tp LIKE '%'||p_pstrDanaTp||'%'
					AND A.comp_cd = p_pstrCompCd
					ORDER BY A.trx_date,A.journal_no,B.cc_cd,B.coa_cd;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_ledger_date (p_pstrCompCd Varchar(10), p_dateStart date, p_dateEnd date, p_pstrCoaCdStart Varchar(20), p_pstrCoaCdEnd Varchar(20), p_pstrDanaTp Varchar(20));");
    }
}
