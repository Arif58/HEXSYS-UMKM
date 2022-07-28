<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.com_region', function (Blueprint $table) {
            $table->string('region_cd',20);
            $table->string('region_nm',100);
            $table->string('region_root',20)->nullable();
            $table->string('region_capital', 100)->nullable();
            $table->integer('region_level')->nullable();
            $table->string('default_st',1)->default('0');
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->timestamps();

            $table->primary('region_cd');
        });

        DB::statement("
        CREATE OR REPLACE VIEW vw_region
        AS SELECT prop.region_cd,
            prop.region_nm,
            prop.region_level,
            'Daerah Tingkat I'AS region_level_nm,
            prop.region_root,
            ''AS region_root_nm,
            prop.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            ''AS region_cd_kab,
            ''AS region_nm_kab,
            ''AS region_cd_kec,
            ''AS region_nm_kec,
            ''AS region_cd_kel,
            ''AS region_nm_kel
          FROM com_region prop
          WHERE prop.region_level = 1
        UNION
        SELECT kab.region_cd,
            kab.region_nm,
            kab.region_level,
            'Daerah Tingkat II'AS region_level_nm,
            kab.region_root,
            prop.region_nm AS region_root_nm,
            kab.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            kab.region_cd AS region_cd_kab,
            kab.region_nm AS region_nm_kab,
            ''AS region_cd_kec,
            ''AS region_nm_kec,
            ''AS region_cd_kel,
            ''AS region_nm_kel
          FROM com_region kab
            JOIN com_region prop ON prop.region_cd = kab.region_root
          WHERE kab.region_level = 2
        UNION
        SELECT kec.region_cd,
            kec.region_nm,
            kec.region_level,
            'Daerah Tingkat III'AS region_level_nm,
            kec.region_root,
            kab.region_nm AS region_root_nm,
            kec.region_capital,
            prop.region_cd AS region_cd_prop,
            prop.region_nm AS region_nm_prop,
            kab.region_cd AS region_cd_kab,
            kab.region_nm AS region_nm_kab,
            kec.region_cd AS region_cd_kec,
            kec.region_nm AS region_nm_kec,
            ''AS region_cd_kel,
            ''AS region_nm_kel
          FROM com_region kec
            JOIN com_region kab ON kab.region_cd = kec.region_root
            JOIN com_region prop ON prop.region_cd = kab.region_root
          WHERE kec.region_level = 3
        UNION
        SELECT kel.region_cd,
            kel.region_nm,
            kel.region_level,
            'Daerah Tingkat IV'AS region_level_nm,
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
            JOIN com_region kec ON kec.region_cd = kel.region_root
            JOIN com_region kab ON kab.region_cd = kec.region_root
            JOIN com_region prop ON prop.region_cd = kab.region_root
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
        DB::statement('DROP VIEW IF EXISTS vw_region');
        Schema::dropIfExists('com_region');
    }
}
