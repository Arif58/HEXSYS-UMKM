<?php
use Illuminate\Database\Seeder;
use App\Models\AuthConfiguration;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthConfiguration::truncate();

        AuthConfiguration::insert([
            [ "configuration_cd" => "APP_DESC", "configuration_nm" => "Deskripsi Aplikasi", "configuration_group" => "APP_CD", "configuration_value" => "INVENTORY MANAGEMENT SYSTEM", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "APP_NAME", "configuration_nm" => "Nama Aplikasi", "configuration_group" => "APP_CD", "configuration_value" => "INVENTORY MANAGEMENT SYSTEM", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "INST_NAME", "configuration_nm" => "Nama Organisasi", "configuration_group" => "APP_CD", "configuration_value" => "HEXSYS", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "configuration_cd" => "APP_ALIAS_DESC", "configuration_nm" => "Deskripsi Aplikasi", "configuration_group" => "APP_CD", "configuration_value" => "IMS", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "INST_LOGO", "configuration_nm" => "Logo Organisasi", "configuration_group" => "APP_CD", "configuration_value" => "images/logo.png", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "APP_ALIAS_LOGO", "configuration_nm" => "Logo Organisasi", "configuration_group" => "APP_CD", "configuration_value" => "/images/favicon.ico", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "APP_LOGO", "configuration_nm" => "Logo Organisasi", "configuration_group" => "APP_CD", "configuration_value" => "images/logo.png", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "LOG_ST", "configuration_nm" => "Status Log", "configuration_group" => "APP_CD", "configuration_value" => "ON", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "configuration_cd" => "DEF_PROP", "configuration_nm" => "Default Propinsi", "configuration_group" => "APP_CD", "configuration_value" => "31", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "configuration_cd" => "DEF_KAB", "configuration_nm" => "Default Kabupaten", "configuration_group" => "APP_CD", "configuration_value" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "configuration_cd" => "DEFAULT_REGION3", "configuration_nm" => "Default Kecamatan", "configuration_group" => "APP_CD", "configuration_value" => "31", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "configuration_cd" => "DEFAULT_REGION4", "configuration_nm" => "Default Kelurahan", "configuration_group" => "APP_CD", "configuration_value" => "31", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],

			['configuration_cd' => 'WHPOS_TRX', 'configuration_nm' => 'Gudang Utama', 'configuration_group' => 'APP_CD', 'configuration_value' => 'WHMASTER', 'created_by' => 'admin', 'created_at' => date('Y-m-d H:i:s')],
			['configuration_cd' => 'COMP_CD', 'configuration_nm' => 'Kode Perusahaan', 'configuration_group' => 'APP_CD', 'configuration_value' => 'HEXSYS', 'created_by' => 'admin', 'created_at' => date('Y-m-d H:i:s')],
			[ "configuration_cd" => "APPROVAL_PO", "configuration_nm" => "Approval Purchasing", "configuration_group" => "APP_CD", "configuration_value" => "APP05", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
        ]);
    }
}
