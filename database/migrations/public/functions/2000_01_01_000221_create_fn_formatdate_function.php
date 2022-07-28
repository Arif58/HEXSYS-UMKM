<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnFormatdateFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION public.fn_formatdate(p_dtinput timestamp without time zone)
            RETURNS character varying
            LANGUAGE plpgsql
            AS $$
                DECLARE v_Result Varchar(10);
            BEGIN
                v_Result := TO_CHAR(p_dtInput::date,'DD/MM/YYYY');
                
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
        DB::unprepared("DROP FUNCTION IF EXISTS public.fn_formatdate(p_dtinput timestamp without time zone);");
    }
}
