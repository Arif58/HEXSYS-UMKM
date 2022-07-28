<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvFnPoGetGroupApprovalStFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION if exists inv.fn_po_get_group_approval_st(p_pstrcompcd character varying, p_pstrrolecd character varying, p_pstrtrxcd character varying);");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION inv.fn_po_get_group_approval_st(p_pstrcompcd character varying, p_pstrrolecd character varying, p_pstrtrxcd character varying)
                RETURNS integer
                LANGUAGE plpgsql
            AS $$
                DECLARE v_intResult int;
                v_strApproval Varchar(20);
                v_strApprovalType Varchar(20);
                v_intApprovalOrder int;
				v_intApprovalCurrent int;
                v_strTrxCd Varchar;
				v_strApprovalSt Varchar;
            BEGIN

                SELECT configuration_value
				FROM auth.configurations
				INTO v_strApproval
				WHERE configuration_cd='APPROVAL_PO';
                
                SELECT 
                A.approval_tp,
                B.approval_order 
                INTO 
                v_strApprovalType, 
                v_intApprovalOrder
                FROM public.com_approval A
                JOIN public.com_approval_detail B ON A.approval_cd=B.approval_cd
                WHERE A.approval_cd=v_strApproval
                AND B.role_cd=p_pstrRoleCd;

                v_strTrxCd := 'PO' || p_pstrTrxCd;

                IF v_strApprovalType IS NULL THEN
                    v_intResult := 0;
                ELSE
                    CASE v_strApprovalType
                    WHEN 'APPROVAL_TP_01' THEN 
                    /*--Substitusi--*/
                        v_intResult := 1;
                    WHEN 'APPROVAL_TP_02' THEN 
                    /*--Paralel--*/
                        v_intResult := 1;
                    WHEN 'APPROVAL_TP_03' THEN 
                    /*--Hirarki--*/
                        IF NOT EXISTS(SELECT A.approve_no FROM public.trx_approval A WHERE A.trx_cd=v_strTrxCd) THEN
                            IF (v_intApprovalOrder >1) THEN
								v_intResult := 0;
							ELSE
								v_intResult := 1;
							END IF;
                        ELSE
                        	SELECT max(A.approve_no) INTO v_intApprovalCurrent FROM public.trx_approval A WHERE A.trx_cd=v_strTrxCd;
                        	
                        	IF (v_intApprovalCurrent <> v_intApprovalOrder-1) THEN
								v_intResult := 0;
							ELSE
								v_intResult := 1;
							END IF;
							
							SELECT coalesce(A.approval_st,'0') INTO v_strApprovalSt
                            FROM public.trx_approval A WHERE A.trx_cd=v_strTrxCd
                            AND A.approve_no=v_intApprovalCurrent;
							/*IF (v_intApprovalCurrent = v_intApprovalOrder AND v_strApprovalSt='1') THEN
								v_intResult := 1;
							END IF;*/
                            IF (v_strApprovalSt='1') THEN
								IF (v_intApprovalCurrent = v_intApprovalOrder) THEN
									v_intResult := 1;
								ELSE
									v_intResult := 0;
								END IF;
							END IF;
                        END IF;
                    ELSE
                        v_intResult := 0;
                    END CASE;
                END IF;
                
                RETURN v_intResult;

            END;
            $$;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_fn_po_get_group_approval_st_function');
    }
}
