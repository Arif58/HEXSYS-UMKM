<?php

use Illuminate\Database\Seeder;
use App\Models\PublicComUnit;

class PublicComUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        PublicComUnit::truncate();

        /* PublicComUnit::insert([
			["unit_cd" => "UNIT01","unit_nm"=>"UNIT01","unit_root" => "","unit_data1" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			["unit_cd" => "UNIT02","unit_nm"=>"UNIT02","unit_root" => "","unit_data1" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			["unit_cd" => "UNIT03","unit_nm"=>"UNIT03","unit_root" => "","unit_data1" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			["unit_cd" => "UNIT04","unit_nm"=>"UNIT04","unit_root" => "","unit_data1" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			["unit_cd" => "UNIT05","unit_nm"=>"UNIT05","unit_root" => "","unit_data1" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
        ]); */
    }
}
