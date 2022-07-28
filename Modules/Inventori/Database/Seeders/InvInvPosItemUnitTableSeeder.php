<?php

namespace Modules\Inventori\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class InvInvPosItemUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::statement("
            insert into inv.inv_pos_itemunit (pos_cd,item_cd, unit_cd, quantity, created_by, created_at)
            select 
            inv_pos_inventori.pos_cd,
            master.item_cd,
            master.unit_cd,
            0 as quantity,
            'admin' as created_by,
            now() as created_at
            from inv.inv_pos_inventori
            join inv.inv_item_master master on 1=1
			--where inv_pos_inventori.pos_cd='WHMASTER'
        ");
    }
}
