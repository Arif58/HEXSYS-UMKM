<?php
use Illuminate\Database\Seeder;
use App\Models\AuthRoleMenu;

class RoleMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthRoleMenu::insert([
            /*--superuser--*/
            /*--System--*/
            [ "menu_cd" => "SYS", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS01", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0101", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0102", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0103", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0104", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0105", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0106", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
                        
            /*--Inventori--*/
            /*[ "menu_cd" => "IMST", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST01", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST02", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST03", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST04", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IINV", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IINV01", "role_cd" => "superuser", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],*/
            
			
			/*--admin--*/
            /*--System--*/
            [ "menu_cd" => "SYS", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS01", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0101", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            //[ "menu_cd" => "SYS0102", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0103", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0104", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0105", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "SYS0106", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
                                     
			/*--Inventori--*/
            /*[ "menu_cd" => "IMST", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST01", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST02", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST03", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IMST04", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IINV", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],
            [ "menu_cd" => "IINV01", "role_cd" => "admin", "created_by" => "admin", "created_at" => date("Y-m-d H:i:s")],*/
			
        ]); 
    }
}
