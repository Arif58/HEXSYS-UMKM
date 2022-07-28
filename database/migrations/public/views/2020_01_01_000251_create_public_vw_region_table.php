<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicVwRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW public.vw_region
        AS SELECT prop.region_cd,
            prop.region_nm,
            prop.region_level,
            'Daerah Tingkat I'::text AS region_level_nm,
            prop.region_root,
            ''::character varying AS region_root_nm,
            prop.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            ''::character varying AS region_cd_kab,
            ''::character varying AS region_nm_kab,
            ''::text AS region_cd_kec,
            ''::text AS region_nm_kec,
            ''::text AS region_cd_kel,
            ''::text AS region_nm_kel
        FROM com_region prop
        WHERE prop.region_level = 1
        UNION
        SELECT kab.region_cd,
            kab.region_nm,
            kab.region_level,
            'Daerah Tingkat II'::text AS region_level_nm,
            kab.region_root,
            prop.region_nm AS region_root_nm,
            kab.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            kab.region_cd AS region_cd_kab,
            kab.region_nm AS region_nm_kab,
            ''::text AS region_cd_kec,
            ''::text AS region_nm_kec,
            ''::text AS region_cd_kel,
            ''::text AS region_nm_kel
        FROM com_region kab
            JOIN com_region prop ON prop.region_cd::text = kab.region_root::text
        WHERE kab.region_level = 2
        UNION
        SELECT kec.region_cd,
            kec.region_nm,
            kec.region_level,
            'Daerah Tingkat III'::text AS region_level_nm,
            kec.region_root,
            kab.region_nm AS region_root_nm,
            kec.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            kab.region_cd AS region_cd_kab,
            kab.region_nm AS region_nm_kab,
            kec.region_cd AS region_cd_kec,
            kec.region_nm AS region_nm_kec,
            ''::text AS region_cd_kel,
            ''::text AS region_nm_kel
        FROM com_region kec
            JOIN com_region kab ON kab.region_cd::text = kec.region_root::text
            JOIN com_region prop ON prop.region_cd::text = kab.region_root::text
        WHERE kec.region_level = 3
        UNION
        SELECT kel.region_cd,
            kel.region_nm,
            kel.region_level,
            'Daerah Tingkat IV'::text AS region_level_nm,
            kel.region_root,
            kec.region_nm AS region_root_nm,
            kel.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            kab.region_cd AS region_cd_kab,
            kab.region_nm AS region_nm_kab,
            kec.region_cd AS region_cd_kec,
            kec.region_nm AS region_nm_kec,
            kel.region_cd AS region_cd_kel,
            kel.region_nm AS region_nm_kel
        FROM com_region kel
            JOIN com_region kec ON kec.region_cd::text = kel.region_root::text
            JOIN com_region kab ON kab.region_cd::text = kec.region_root::text
            JOIN com_region prop ON prop.region_cd::text = kab.region_root::text
        WHERE kel.region_level = 4
        ORDER BY 5, 7, 9, 11;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW public.vw_region');
    }
}
