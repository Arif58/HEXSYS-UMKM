<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicUuidGeneratev4Function extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* DB::unprepared("
			CREATE OR REPLACE FUNCTION public.uuid_generate_v4()
			RETURNS uuid
			LANGUAGE c
			PARALLEL SAFE STRICT
			AS '$libdir/uuid-ossp', $function$uuid_generate_v4$function$
			;
            $$;
        "); */
		//--DB User admin : postgres
		//DB::unprepared("DROP FUNCTION IF EXISTS public.uuid_generate_v4 CASCADE;");
		/* DB::unprepared('
			CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
        '); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::unprepared("DROP FUNCTION IF EXISTS public.uuid_generate_v4();");
		DB::unprepared('DROP FUNCTION IF EXISTS "uuid-ossp";');
    }
}
