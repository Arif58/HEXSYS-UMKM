<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetSppProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_spp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
        DB::unprepared("
			CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_spp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int)
			RETURNS table(
				employee_id varchar(20),
				parent_nm varchar(100),
				siswa_nm varchar(100),
				kelas varchar(20),
				spp numeric(19,2)
			)
		AS
		$$
		BEGIN
			return query
			SELECT ''::varchar AS employee_id, ''::varchar AS parent_nm,
			''::varchar AS siswa_nm, ''::varchar AS kelas,
			0::numeric AS spp;
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
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_spp (p_pstrCompCd Varchar(10), p_pintYear int, p_pintMonth int);");
    }
}
