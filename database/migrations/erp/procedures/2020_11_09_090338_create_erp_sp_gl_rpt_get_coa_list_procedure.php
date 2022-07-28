<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetCoaListProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_coa_list (p_pstrCompCd Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_coa_list (p_pstrCompCd Varchar(10))
                RETURNS table(
                    coa_cd varchar(20),
                    coa_nm varchar(200),
                    head_desc text,
                    coa_level int,
					coa_tp_nm character varying,
					coa_root_nm character varying,
					coa_group_nm character varying
                )
            AS
            $$
            DECLARE v_intBlank int;
            BEGIN
                v_intBlank := 5;

				return query
				SELECT A.coa_cd,concat(REPEAT(' ',5 * erp.fn_gl_get_levelcoa(p_pstrCompCd,A.coa_cd)), A.coa_nm)::varchar as coa_nm,
				case when A.coa_sub_st = '1' then 'HEADER' when A.coa_sub_st = '0' then 'DETAIL' else '' end as head_desc,
				erp.fn_gl_get_levelcoa(p_pstrCompCd,A.coa_cd) as coa_level,
				B.coa_tp_nm,C.coa_nm as coa_root_nm,COM.code_nm as coa_group_nm
				FROM erp.gl_coa A
				JOIN erp.gl_coa_type B ON A.coa_tp_cd=B.coa_tp_cd
				LEFT JOIN erp.gl_coa C ON A.coa_root=C.coa_cd
				LEFT JOIN public.com_code COM ON A.coa_group=COM.com_cd
				WHERE A.comp_cd=p_pstrCompCd
				ORDER BY A.coa_tp_cd, A.coa_cd, A.coa_nm;

            END;
            $$
            LANGUAGE plpgsql;
        ");

        DB::unprepared("SELECT * from erp.sp_gl_rpt_get_coa_list('MAIN');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_coa_list (p_pstrCompCd Varchar(10));");
    }
}
