<?php

namespace Modules\Inventori\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\InvInvItemType;

class InvInvItemTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        InvInvItemType::truncate();
        InvInvItemType::insert([
            [
                "type_cd" => "001",
                "type_nm" => "INVENTORI",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "type_cd" => "100",
                "type_nm" => "LAIN-LAIN",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
