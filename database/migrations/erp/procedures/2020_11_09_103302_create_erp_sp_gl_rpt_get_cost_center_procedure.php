<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpSpGlRptGetCostCenterProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_cost_center (p_pstrCompCd Varchar(10));");
        DB::unprepared("
            CREATE OR REPLACE FUNCTION erp.sp_gl_rpt_get_cost_center (p_pstrCompCd Varchar(10))
                RETURNS table(
                    comp_cds varchar,
                    cc_cds varchar,
                    cc_nms varchar
                )
            AS
            $$
            BEGIN
                return query
                SELECT 
                comp_cd,
                cc_cd,
                cc_nm
                FROM erp.gl_cost_center
                where comp_cd=p_pstrCompCd;
            END;
            $$ 
            LANGUAGE plpgsql;
        ");

        DB::unprepared("SELECT * from erp.sp_gl_rpt_get_cost_center('HEXSYS');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function if exists erp.sp_gl_rpt_get_cost_center (p_pstrCompCd Varchar(10));");
    }
}
