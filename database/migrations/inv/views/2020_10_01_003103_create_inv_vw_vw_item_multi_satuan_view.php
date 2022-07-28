<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvVwVwItemMultiSatuanView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP VIEW IF EXISTS inv.vw_item_multi_satuan;
            CREATE OR REPLACE VIEW inv.vw_item_multi_satuan
            AS SELECT master.item_cd,
				master.item_nm,
				unit_satuan.unit_cd AS unit_item_cd,
				unit_satuan.unit_nm AS unit_item_nm,
				concat('1 ', unit_satuan.unit_nm, ' = ', item_unit.conversion, ' ', unit.unit_nm)::character varying AS konversi
			FROM inv.inv_item_master master
				 JOIN inv.inv_unit unit ON unit.unit_cd::text = master.unit_cd::text
				 JOIN inv.inv_item_unit item_unit ON item_unit.item_cd::text = master.item_cd::text
				 JOIN inv.inv_unit unit_satuan ON unit_satuan.unit_cd::text = item_unit.unit_cd::text;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop view if exists inv.vw_item_multi_satuan");
    }
}
