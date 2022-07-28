<?php
use Illuminate\Database\Seeder;
use App\Models\AuthMenu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
    --*/
    public function run(){
        AuthMenu::truncate();
		
        AuthMenu::insert([
            /*--SETTING--*/
            /*--Admin--*/
            [ "menu_cd" => "SYS", "menu_nm" => "Sistem", "menu_no" => "01","menu_image" => "icon-cog2","menu_level" => "1", "menu_url" => "sistem", "menu_root" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS01", "menu_nm" => "Admin", "menu_no" => "0101","menu_image" => "","menu_level" => "2", "menu_url" => "sistem/admin", "menu_root" => "SYS", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0101", "menu_nm" => "User", "menu_no" => "010101","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/user", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0102", "menu_nm" => "Autorisasi", "menu_no" => "010102","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/autorisasi", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0103", "menu_nm" => "Kode", "menu_no" => "010103","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/kode", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0104", "menu_nm" => "Log Aktivitas", "menu_no" => "010104","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/log-activity", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0105", "menu_nm" => "Propinsi", "menu_no" => "010105","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/region", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0106", "menu_nm" => "Data Perusahaan", "menu_no" => "010106","menu_image" => "","menu_level" => "3", "menu_url" => "sistem/admin/company", "menu_root" => "SYS01", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            
			/*--INVENTORI--*/
            /*--Master--*/
            /*[ "menu_cd" => "IMST", "menu_nm" => "Data Master Inventori", "menu_no" => "10","menu_image" => "icon-database-menu","menu_level" => "1", "menu_url" => "i-data-master", "menu_root" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST01", "menu_nm" => "Warehouse", "menu_no" => "1001","menu_image" => "","menu_level" => 2, "menu_url" => "i-data-master/warehouse", "menu_root" => "IMST", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST02", "menu_nm" => "Satuan", "menu_no" => "1002","menu_image" => "","menu_level" => 2, "menu_url" => "i-data-master/satuan", "menu_root" => "IMST", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST03", "menu_nm" => "Tipe", "menu_no" => "1003","menu_image" => "","menu_level" => 2, "menu_url" => "i-data-master/tipe", "menu_root" => "IMST", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST04", "menu_nm" => "Principal", "menu_no" => "1004","menu_image" => "","menu_level" => 2, "menu_url" => "i-data-master/principal", "menu_root" => "IMST", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            /*--Inventori--*/
            /*[ "menu_cd" => "IINV", "menu_nm" => "Inventori", "menu_no" => "11","menu_image" => "icon-database-menu","menu_level" => "1", "menu_url" => "i-inventori", "menu_root" => "", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IINV01", "menu_nm" => "Master Inventori", "menu_no" => "1101","menu_image" => "","menu_level" => 2, "menu_url" => "i-inventori/master", "menu_root" => "IINV", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],*/
            
        ]);
    }
}
