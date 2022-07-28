<?php

use Illuminate\Database\Seeder;
use App\Models\PublicComCode;

class PublicComCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        PublicComCode::truncate();

        PublicComCode::insert([
			/*['com_cd' => 'APPROVAL_TP_01','code_nm'=>'SUBSTITUSI', 'code_group' => 'APPROVAL_TP','code_value' => NULL,'created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
			['com_cd' => 'APPROVAL_TP_02','code_nm'=>'PARALEL', 'code_group' => 'APPROVAL_TP','code_value' => NULL,'created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],*/
			['com_cd' => 'APPROVAL_TP_03','code_nm'=>'HIRARKI', 'code_group' => 'APPROVAL_TP','code_value' => NULL,'created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
			
			['com_cd' => 'GENDER_TP_01','code_nm'=>'Laki-Laki', 'code_group' => 'GENDER_TP','code_value' => NULL,'created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
            ['com_cd' => 'GENDER_TP_02','code_nm'=>'Perempuan', 'code_group' => 'GENDER_TP','code_value' => NULL,'created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
			['com_cd' => 'BLOOD_TP_1','code_nm'=>'A',   'code_group' => 'BLOOD_TP','code_value' => '','created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
            ['com_cd' => 'BLOOD_TP_2','code_nm'=>'B',   'code_group' => 'BLOOD_TP','code_value' => '','created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
            ['com_cd' => 'BLOOD_TP_3','code_nm'=>'AB',   'code_group' => 'BLOOD_TP','code_value' => '','created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
            ['com_cd' => 'BLOOD_TP_4','code_nm'=>'O',   'code_group' => 'BLOOD_TP','code_value' => '','created_by'=>'admin','created_at' => date('Y-m-d H:i:s')],
			[
                "com_cd" => "OCCUPATION_CD_01",
                "code_nm" => "PNS",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_02",
                "code_nm" => "TNI",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_03",
                "code_nm" => "POLRI",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_04",
                "code_nm" => "GURU",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_05",
                "code_nm" => "DOSEN",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_06",
                "code_nm" => "PELAJAR",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_07",
                "code_nm" => "MAHASISWA",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_08",
                "code_nm" => "PETANI",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_09",
                "code_nm" => "NELAYAN",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_10",
                "code_nm" => "BURUH",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_11",
                "code_nm" => "SWASTA",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_12",
                "code_nm" => "WIRASWASTA",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_13",
                "code_nm" => "SEKTOR INFORMAL",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_14",
                "code_nm" => "IBU RUMAH TANGGA",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_98",
                "code_nm" => "PENSIUN",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "OCCUPATION_CD_99",
                "code_nm" => "LAIN-LAIN",
                "code_group" => "OCCUPATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
			[
                "com_cd" => "EDUCATION_CD_01",
                "code_nm" => "SD",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_02",
                "code_nm" => "SMP",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_03",
                "code_nm" => "SMU",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_04",
                "code_nm" => "D1",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_05",
                "code_nm" => "D2",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_06",
                "code_nm" => "D3",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_07",
                "code_nm" => "D4",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_08",
                "code_nm" => "S1",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_09",
                "code_nm" => "S2",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "EDUCATION_CD_10",
                "code_nm" => "S3",
                "code_group" => "EDUCATION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
			[
                "com_cd" => "MARITAL_TP_3",
                "code_nm" => "Janda / Duda",
                "code_group" => "MARITAL_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "MARITAL_TP_1",
                "code_nm" => "Single",
                "code_group" => "MARITAL_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "MARITAL_TP_2",
                "code_nm" => "Menikah",
                "code_group" => "MARITAL_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
			[
                "com_cd" => "RACE_CD_02",
                "code_nm" => "JAWA",
                "code_group" => "RACE_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RACE_CD_99",
                "code_nm" => "LAIN-LAIN",
                "code_group" => "RACE_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RACE_CD_01",
                "code_nm" => "MELAYU",
                "code_group" => "RACE_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RACE_CD_04",
                "code_nm" => "SUNDA",
                "code_group" => "RACE_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RACE_CD_03",
                "code_nm" => "BATAK",
                "code_group" => "RACE_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_07",
                "code_nm" => "ALIRAN KEPERCAYAAN",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_04",
                "code_nm" => "HINDU",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_05",
                "code_nm" => "BUDHA",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_06",
                "code_nm" => "KONG HU CU",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_03",
                "code_nm" => "PROTESTAN",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_02",
                "code_nm" => "KATOLIK",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "RELIGION_CD_01",
                "code_nm" => "ISLAM",
                "code_group" => "RELIGION_CD",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
			[
                "com_cd" => "ID_TP_1",
                "code_nm" => "KTP",
                "code_group" => "IDENTITY_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "ID_TP_5",
                "code_nm" => "KITAS",
                "code_group" => "IDENTITY_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "ID_TP_3",
                "code_nm" => "SIM",
                "code_group" => "IDENTITY_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "ID_TP_4",
                "code_nm" => "Pasport",
                "code_group" => "IDENTITY_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            [
                "com_cd" => "ID_TP_2",
                "code_nm" => "KK",
                "code_group" => "IDENTITY_TP",
                "code_value" => "",
                "created_by" => "admin",
                "created_at" => date('Y-m-d H:i:s')
            ],
            
            /*--DAY_TP--*/
            ["com_cd" => "DAY_TP_01","code_nm"=>"Senin",    "code_group" => "DAY_TP","code_value" => "Monday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_02","code_nm"=>"Selasa",   "code_group" => "DAY_TP","code_value" => "Tuesday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_03","code_nm"=>"Rabu",     "code_group" => "DAY_TP","code_value" => "Wednesday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_04","code_nm"=>"Kamis",    "code_group" => "DAY_TP","code_value" => "Thursday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_05","code_nm"=>"Jumat",    "code_group" => "DAY_TP","code_value" => "Friday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_06","code_nm"=>"Sabtu",    "code_group" => "DAY_TP","code_value" => "Saturday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "DAY_TP_07","code_nm"=>"Minggu",   "code_group" => "DAY_TP","code_value" => "Sunday","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			
			/*--Status Perpindahan Barang--*/
            ["com_cd" => "MOVE_TP_1","code_nm"=>"In", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_2","code_nm"=>"Out", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_3","code_nm"=>"Transfer", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_4","code_nm"=>"Convert", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_5","code_nm"=>"Opname", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_6","code_nm"=>"Adjustment", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_7","code_nm"=>"Retur", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "MOVE_TP_8","code_nm"=>"Booked", "code_group" => "MOVE_TP","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],

            /*--Status Opname--*/
            ["com_cd" => "OPNAME_ST_1","code_nm"=>"Belum Selesai", "code_group" => "OPNAME_ST","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "OPNAME_ST_2","code_nm"=>"Menunggu Persetujuan", "code_group" => "OPNAME_ST","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
            ["com_cd" => "OPNAME_ST_3","code_nm"=>"Sudah Selesai", "code_group" => "OPNAME_ST","code_value" => "","created_by"=>"admin","created_at" => date("Y-m-d H:i:s")],
			
			/*--VAT / Pajak--*/
            [ "com_cd" => "VAT_TP_0", "code_nm" => "No VAT", "code_group" => "VAT_TP","code_value" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "com_cd" => "VAT_TP_1", "code_nm" => "Include", "code_group" => "VAT_TP","code_value" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "com_cd" => "VAT_TP_2", "code_nm" => "Exclude", "code_group" => "VAT_TP","code_value" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			
			/*--FILE_TP--*/
            [ "com_cd" => "FILE_TP_01", "code_nm" => "DOKUMEN", "code_group" => "FILE_TP","code_value" => "icon-file-pdf text-danger-400", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "com_cd" => "FILE_TP_02", "code_nm" => "GAMBAR", "code_group" => "FILE_TP","code_value" => "icon-image2 text-primary-400", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],

        ]);
    }
}
