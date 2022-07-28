<?php
use Illuminate\Database\Seeder;
use App\Models\AuthRole;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthRole::truncate();
		
        AuthRole::insert([
            [
                'role_cd'       => 'superuser',
                'role_nm'       => 'Super User',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'admin',
                'role_nm'       => 'Administrator',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'admwh',
                'role_nm'       => 'Admin Gudang',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'usrwh',
                'role_nm'       => 'User Gudang',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			/* [
                'role_cd'       => 'supervisor',
                'role_nm'       => 'Supervisor',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'manager',
                'role_nm'       => 'Manager',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'direktur',
                'role_nm'       => 'Direktur',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'wketua',
                'role_nm'       => 'Wakil Ketua',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'role_cd'       => 'ketua',
                'role_nm'       => 'Ketua',
                'rule_tp'       => '1111',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ] */
        ]);
    }
}
