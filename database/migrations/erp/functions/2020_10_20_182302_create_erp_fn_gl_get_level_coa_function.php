<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpFnGlGetLevelCoaFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS ERP.FN_GL_GET_LEVELCOA (p_pstrCompCd varchar(10),p_pstrCoaCd varchar(20));");
        DB::unprepared("
        CREATE OR REPLACE FUNCTION ERP.FN_GL_GET_LEVELCOA (p_pstrCompCd varchar(10),p_pstrCoaCd varchar(20))
        RETURNS int
        AS
        $$
            DECLARE v_intResult int;
            v_strCoaRoot Varchar(20);
            v_strTempCoa Varchar(20);
        BEGIN

            v_intResult := 1;
            SELECT coa_root
            into v_strCoaRoot
            FROM erp.gl_coa
            WHERE comp_cd=p_pstrCompCd
            AND coa_cd=p_pstrCoaCd;
                
            IF v_strCoaRoot IS NULL OR v_strCoaRoot='' OR v_strCoaRoot=p_pstrCoaCd THEN
                v_intResult := 1;
            ELSE
                WHILE v_strCoaRoot IS NOT NULL OR v_strCoaRoot<>''
                LOOP
                    v_intResult 	:= v_intResult + 1;
                    v_strTempCoa 	:= v_strCoaRoot;
                            
                    SELECT coa_root
                    FROM erp.gl_coa
                    into v_strCoaRoot
                    WHERE comp_cd=p_pstrCompCd
                    AND coa_cd=v_strTempCoa;
                    
                    IF v_strCoaRoot IS NULL OR v_strCoaRoot='' THEN
                        EXIT;
                    ELSE
                        CONTINUE;
                    END IF;
                END LOOP;
            END IF;		
            
            RETURN v_intResult;
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
        DB::unprepared("DROP FUNCTION ERP.FN_GL_GET_LEVELCOA (p_pstrCompCd varchar(10),p_pstrCoaCd varchar(20));");
    }
}
