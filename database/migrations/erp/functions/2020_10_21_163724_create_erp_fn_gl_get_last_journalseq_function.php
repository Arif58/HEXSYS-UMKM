<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetLastJournalseqFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.fn_gl_get_last_journalseq (p_pstrCompCd varchar(10),p_strJournalDoc varchar(10),p_pintYear int,p_pintMonth int);");
        DB::unprepared("
        CREATE OR REPLACE FUNCTION erp.fn_gl_get_last_journalseq (p_pstrCompCd varchar(10),p_strJournalDoc varchar(10),p_pintYear int,p_pintMonth int)
        RETURNS int
        AS
        $$
                DECLARE v_intResult int;
                v_strSeqType char(1);
                v_intTotalJournal int;
        BEGIN
        
            SELECT seq_tp into v_strSeqType FROM erp.gl_journal_doc WHERE comp_cd=p_pstrCompCd AND journal_cd=p_strJournalDoc;
            
            case v_strSeqType when '1' THEN
                /*--Monthly--*/
                SELECT journal_seq + 1
                into v_intTotalJournal
                FROM erp.gl_transaction
                WHERE comp_cd=p_pstrCompCd
                AND trx_year=p_pintYear
                AND journal_cd=p_strJournalDoc
                AND trx_month=p_pintMonth
				ORDER BY journal_seq DESC LIMIT 1;
            when '2' THEN
            /*--Yearly--*/
                SELECT journal_seq + 1
                into v_intTotalJournal
                FROM erp.gl_transaction
                WHERE comp_cd=p_pstrCompCd
                AND journal_cd=p_strJournalDoc
                AND trx_year=p_pintYear
				ORDER BY journal_seq DESC LIMIT 1;
            ELSE
            /*--Continuously--*/
                SELECT journal_seq + 1
                into v_intTotalJournal
                FROM erp.gl_transaction
                WHERE comp_cd=p_pstrCompCd
				ORDER BY journal_seq DESC LIMIT 1;
            END CASE;
                                
            IF v_intTotalJournal IS NULL THEN
                v_intResult := 1;
            ELSE
                v_intResult := v_intTotalJournal;
            END IF;
                
            RETURN v_intResult;
        END;
        $$ 
        LANGUAGE plpgsql;
       ");
       DB::unprepared("SELECT erp.fn_gl_get_last_journalseq('HEXSYS','GL', ".date('Y').", ".date('m').");");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.fn_gl_get_last_journalseq (p_pstrCompCd varchar(10),p_strJournalDoc varchar(10),p_pintYear int,p_pintMonth int);");
    }
}
