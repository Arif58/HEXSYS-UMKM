<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetJournalDocProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_journal_doc (p_pstrCompCd Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_journal_doc (p_pstrCompCd Varchar(10))
                RETURNS table(
                    comp_cd varchar,
                    journal_cd varchar,
                    journal_nm varchar,
                    seq_tp varchar,
                    form_nm varchar,
                    form_file varchar
                )
            AS
            $$
            BEGIN
                return query
                SELECT 
                A.comp_cd,
                A.journal_cd,
                A.journal_nm,
                A.seq_tp,
                B.form_nm,
                B.form_file
                FROM erp.gl_journal_doc A
                LEFT JOIN public.com_form B ON A.form_cd=B.form_cd
                AND A.comp_cd=p_pstrCompCd;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");

        DB::unprepared("SELECT * from erp.sp_gl_rpt_get_journal_doc('MAIN');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_journal_doc (p_pstrCompCd Varchar(10));");
    }
}
