<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpArProcessApprovalProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists erp.sp_ar_process_approval(p_pstrCompCd Varchar(10),p_pstrRoleCd Varchar(20),p_pstrTrxCd Varchar(20),p_pstrUserId Varchar(20),p_pstrUserNm Varchar(100)); ");
        DB::unprepared("
        CREATE OR REPLACE FUNCTION erp.sp_ar_process_approval(p_pstrCompCd Varchar(10),p_pstrRoleCd Varchar(20),p_pstrTrxCd Varchar(20),p_pstrUserId Varchar(20),p_pstrUserNm Varchar(100)) 
            RETURNS varchar
        AS $$
            DECLARE v_strTrxApprovalCode Varchar(100);
            v_strApproval Varchar(100);
            v_strApprovalType Varchar(100);
            v_intApprovalOrder int;
            v_intApprovalNo int;
            v_intTotalApproval int;
            v_intTotalApprovalDone int;
            v_strApprovalStatus Varchar(100);

            v_strJournalCd Varchar(100);
            v_strNpm Varchar(100);
            v_strNppd Varchar(100);
            v_intTrxYear int;
            v_intTrxMonth int;

        BEGIN

            v_strTrxApprovalCode := 'AR' || p_pstrTrxCd;
            
            SELECT ar_approval_cd
            INTO v_strApproval
            FROM erp.ar_reference
            WHERE comp_cd=p_pstrCompCd
            AND ref_year=(SELECT MAX(ref_year) FROM erp.ar_reference
            WHERE comp_cd=p_pstrCompCd AND ref_st<>'1');
            
            SELECT coalesce(COUNT(A.approval_cd), 0) 
            INTO v_intTotalApproval
            FROM public.com_approval A
            JOIN public.com_approval_detail B ON A.approval_cd=B.approval_cd
            WHERE A.approval_cd=v_strApproval;
            
            SELECT A.approval_tp,B.approval_order 
            INTO v_strApprovalType, v_intApprovalOrder
            FROM public.com_approval A
            JOIN public.com_approval_detail B ON A.approval_cd=B.approval_cd
            WHERE A.approval_cd=v_strApproval
            AND B.role_cd=p_pstrRoleCd;

            /* BEGIN TRANSACTION */
            
            CASE v_strApprovalType
            WHEN 'APPROVAL_TP_01' THEN
                v_intApprovalNo := 0;
                v_strApprovalStatus := '3';
            WHEN 'APPROVAL_TP_02' THEN
                v_intApprovalNo := v_intTotalApproval - v_intTotalApprovalDone;
                    
                SELECT COALESCE(COUNT(A.trx_cd),0) 
                INTO v_intTotalApprovalDone
                FROM public.trx_approval A
                WHERE A.trx_cd=v_strTrxApprovalCode;
                
                IF v_intTotalApprovalDone < v_intTotalApproval-1
                THEN
                    v_strApprovalStatus := '2';
                ELSE
                    v_strApprovalStatus := '3';
                END IF;
            WHEN 'APPROVAL_TP_03' THEN
                v_intApprovalNo := v_intApprovalOrder;
                    
                SELECT COALESCE(COUNT(A.trx_cd),0) 
                INTO v_intTotalApprovalDone
                FROM public.trx_approval A
                WHERE A.trx_cd=v_strTrxApprovalCode;
                
                IF v_intTotalApprovalDone = v_intApprovalOrder-1
                THEN
                    IF v_intTotalApprovalDone < v_intTotalApproval-1
                    THEN
                        v_strApprovalStatus := '2';
                    ELSE
                        v_strApprovalStatus := '3';
                    END IF;
                END IF;
            ELSE
                -- v_intApprovalNo := 0;
                -- v_strApprovalStatus := '0';
            END CASE;
            
            --return v_intApprovalNo::varchar;

            UPDATE erp.ar_trx
            SET ar_st=v_strApprovalStatus,
            approve_by=p_pstrUserNm,
            approve_date=NOW(),
            approve_no=v_intApprovalNo
            WHERE ar_cd=p_pstrTrxCd;
                
            IF EXISTS (SELECT trx_cd FROM public.trx_approval WHERE trx_cd=v_strTrxApprovalCode AND approve_no=v_intApprovalNo) THEN
                UPDATE public.trx_approval
                SET approve_by=p_pstrUserNm,
                    approve_date=NOW(),
                    updated_by=p_pstrUserId,
                    updated_at=NOW()
                WHERE trx_cd=v_strTrxApprovalCode
                AND approve_no=v_intApprovalNo;
            ELSE
                -- return v_intApprovalNo::varchar;
                INSERT INTO public.trx_approval (
                    trx_approval_id,
                    trx_cd,
                    approve_no,
                    approve_by,
                    approve_date,
                    updated_by,
                    updated_at
                ) VALUES (
                    public.uuid_generate_v4(),
                    v_strTrxApprovalCode,
                    v_intApprovalNo,
                    p_pstrUserNm,
                    NOW(),
                    p_pstrUserId,
                    NOW()
                );
            END IF; 

            return 'berhasil'::varchar;
        END;
        $$ LANGUAGE plpgsql;

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION if exists erp.sp_ar_process_approval(p_pstrCompCd Varchar(10),p_pstrRoleCd Varchar(20),p_pstrTrxCd Varchar(20),p_pstrUserId Varchar(20),p_pstrUserNm Varchar(100)); ");
    }
}
