<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpCmRptGetVoucherProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_cm_rpt_get_voucher (p_pstrCompCd Varchar(10), p_pstrTrxCd varchar(20));");
        DB::unprepared("
        CREATE OR REPLACE FUNCTION erp.sp_cm_rpt_get_voucher (p_pstrCompCd Varchar(10), p_pstrTrxCd varchar(20))
                RETURNS table(
                    r_trx_no varchar,
                    r_trx_date timestamp,
                    r_trx_note text,
                    r_coa_cd varchar(20),
                    r_coa_desc text,
                    r_currency_cd varchar(20),
                    r_trx_amount numeric(19,2),
                    r_rate numeric(19,2),
                    r_dc_value varchar(20),
                    r_total_debit numeric(19,2),
                    r_total_credit numeric(19,2),
                    r_entry_by varchar(200),
                    r_approve_by varchar(20),
                    r_vendor_nm varchar(20),
                    r_trx_name text
                )
            AS
            $$
            BEGIN
                return query SELECT 
                A.cm_no AS trx_no,
                A.trx_date,
                A.note AS trx_note,
                B.coa_cd,
                B.note AS coa_desc,
                B.currency_cd,
                B.trx_amount,
                B.rate, 
                B.dc_value,
                A.total_debit,
                A.total_credit,
                A.entry_by,
                A.approve_by,
                CASE WHEN A.cm_tp='2' THEN C.cust_nm
                ELSE
                    CASE WHEN A.cm_tp='3' THEN D.supplier_nm
                    ELSE vendor_cd
                    END
                END AS vendor_nm,
                CASE WHEN A.cm_tp='2' THEN 'TRANSAKSI CASH IN'
                ELSE
                    CASE WHEN A.cm_tp='3' THEN 'TRANSAKSI CASH OUT'
                    ELSE 'TRANSAKSI PETTY CASH'
                    END
                END AS trx_name
                FROM erp.cm_trx A
                LEFT JOIN public.com_customer C ON A.vendor_cd=C.cust_cd
                LEFT JOIN public.com_supplier D ON A.vendor_cd=D.supplier_cd
                JOIN erp.cm_trx_detail B ON A.cm_cd = B.cm_cd;
            --    WHERE A.comp_cd = p_pstrCompCd
            --    AND A.cm_cd = p_pstrTrxCd;
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
        DB::unprepared("DROP function if exists erp.sp_cm_rpt_get_voucher (p_pstrCompCd Varchar(10), p_pstrTrxCd varchar(20));");
    }
}
