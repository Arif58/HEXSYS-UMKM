<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvVwStockAlertView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE VIEW inv.vw_stock_alert
        AS SELECT 
            positem.item_cd,
            master.item_nm,
            tipe.type_nm AS jenis,
            satuan.unit_nm AS satuan,
            master.minimum_stock,
            master.maximum_stock,
            sum(positem.quantity) AS stock,
            CASE
                WHEN sum(positem.quantity) < master.minimum_stock::numeric then 'min'::text
                WHEN sum(positem.quantity) > master.maximum_stock::numeric then 'max'::text
                ELSE '-'::text
            END AS alert_status
        FROM inv.inv_pos_itemunit positem
            JOIN inv.inv_item_master master ON master.item_cd::text = positem.item_cd::text
            LEFT JOIN inv.inv_item_type tipe ON tipe.type_cd::text = master.type_cd::text
            JOIN inv.inv_unit satuan ON satuan.unit_cd::text = master.unit_cd::text
            /*WHERE master.maximum_stock::numeric > 0*/
			WHERE master.unit_cd=positem.unit_cd
        GROUP BY positem.item_cd, master.item_nm, tipe.type_nm, satuan.unit_nm, master.minimum_stock, master.maximum_stock
        HAVING sum(positem.quantity) < master.minimum_stock::numeric or sum(positem.quantity) > master.maximum_stock::numeric
        ORDER BY master.item_nm;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP VIEW inv.vw_stock_alert");
    }
}
