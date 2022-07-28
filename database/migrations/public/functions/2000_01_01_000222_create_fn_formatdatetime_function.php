<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnFormatdatetimeFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION public.fn_formatdatetime(p_dtinput timestamp without time zone)
            RETURNS character varying
            LANGUAGE plpgsql
            AS $$
                DECLARE v_Result Varchar(20);
            BEGIN
                v_Result := TO_CHAR(p_dtInput::timestamp,'DD/MM/YYYY HH24:MI:ss')::varchar;
                
                RETURN v_Result;
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
        DB::unprepared("DROP FUNCTION IF EXISTS public.fn_formatdatetime(p_dtinput timestamp without time zone);");
    }
}
