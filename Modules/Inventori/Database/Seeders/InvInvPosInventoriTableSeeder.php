<?php

namespace Modules\Inventori\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvInvPosInventori;

class InvInvPosInventoriTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        InvInvPosInventori::truncate();
        InvInvPosInventori::insert([
            /* [
                "pos_cd"     => "WHMASTER",
                "pos_nm"     => "GUDANG UTAMA",
                "postrx_st"  => "1",
				"unit_link"  => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ],
            [
                "pos_cd"     => "UNIT01",
                "pos_nm"     => "UNIT01",
                "postrx_st"  => "1",
                "unit_link"  => "UNIT01",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ],
            [
                "pos_cd"     => "UNIT02",
                "pos_nm"     => "UNIT02",
                "postrx_st"  => "1",
                "unit_link"  => "UNIT02",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ],
			[
                "pos_cd"     => "UNIT03",
                "pos_nm"     => "UNIT03",
                "postrx_st"  => "1",
                "unit_link"  => "UNIT03",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ],
			[
                "pos_cd"     => "UNIT04",
                "pos_nm"     => "UNIT04",
                "postrx_st"  => "1",
                "unit_link"  => "UNIT04",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ],
			[
                "pos_cd"     => "UNIT05",
                "pos_nm"     => "UNIT05",
                "postrx_st"  => "1",
                "unit_link"  => "UNIT05",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s'),
            ], */
        ]);
    }
}
