<?php
namespace Modules\Inventori\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthRoleMenu;

class InventoriRoleMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthRoleMenu::insert([
            /*--superuser--*/
            [ "menu_cd" => "INV", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV01", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0101", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0102", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0103", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0104", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0105", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0106", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV02", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV03", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV04", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0401", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0402", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0403", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0404", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0405", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0406", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0407", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0408", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0409", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV05", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV06", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0600", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0601", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0602", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0603", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0604", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            
            /* admin */
            [ "menu_cd" => "INV", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV01", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0101", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0102", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0103", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0104", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0105", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0106", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV02", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV03", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV04", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0401", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0402", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0403", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0404", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0405", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0406", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0407", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0408", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0409", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV05", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV06", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0600", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0601", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0602", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0603", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			//[ "menu_cd" => "INV0604", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			
			/*--admwh--*/
            [ "menu_cd" => "INV", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV01", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0101", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0102", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0103", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0104", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV02", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV03", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV04", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0401", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0402", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0403", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0404", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0405", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0406", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0408", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0409", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV05", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV06", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "INV0600", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			[ "menu_cd" => "INV0601", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0602", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "INV0603", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			//[ "menu_cd" => "INV0604", "role_cd" => "admwh", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
			
        ]); 
    }
}
