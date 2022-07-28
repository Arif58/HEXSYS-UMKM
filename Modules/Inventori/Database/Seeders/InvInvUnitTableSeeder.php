<?php

namespace Modules\Inventori\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvInvUnit;

class InvInvUnitTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        InvInvUnit::truncate();
        InvInvUnit::insert([
            [
                "unit_cd" => "PCS",
                "unit_nm" => "PCS",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "BUAH",
                "unit_nm" => "BUAH",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "DUS",
                "unit_nm" => "DUS",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "BOX",
                "unit_nm" => "BOX",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "PACK",
                "unit_nm" => "PACK",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "ROLL",
                "unit_nm" => "ROLL",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "SET",
                "unit_nm" => "SET",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "EKS",
                "unit_nm" => "EKS",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "LEMBAR",
                "unit_nm" => "LEMBAR",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "BOTOL",
                "unit_nm" => "BOTOL",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "GALON",
                "unit_nm" => "GALON",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "KALENG",
                "unit_nm" => "KALENG",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "KG",
                "unit_nm" => "KILOGRAM",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "GR",
                "unit_nm" => "GRAM",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "ONS",
                "unit_nm" => "ONS",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "KWINTAL",
                "unit_nm" => "KWINTAL",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "TON",
                "unit_nm" => "TON",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "LT",
                "unit_nm" => "LITER",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "ML",
                "unit_nm" => "MILILITER",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "CC",
                "unit_nm" => "CC",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "M",
                "unit_nm" => "METER",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "unit_cd" => "CM",
                "unit_nm" => "SENTIMETER",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
