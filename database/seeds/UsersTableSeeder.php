<?php
use Illuminate\Database\Seeder;
use App\Models\AuthUser;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthUser::truncate();
		
        //--Password = adminadmin
		AuthUser::insert([
            ['user_id' => 'super','user_nm' => 'Super User','email' => 'super@mail.com','password' => '$2y$10$JafDMyGGK6/zv5drxJss1uvF39mojh3/KHYg8eQtBLjCeYyvdZ.hS','phone' => '',"active" => true,'email_verified_at' => date("Y-m-d H:i:s"),'token_register' => "",'created_by' => 'admin','created_at' => date('Y-m-d H:i:s')],
        ]);
		AuthUser::insert([
            ['user_id' => 'admin','user_nm' => 'Administrator','email' => 'admin@mail.com','password' => '$2y$10$JafDMyGGK6/zv5drxJss1uvF39mojh3/KHYg8eQtBLjCeYyvdZ.hS','phone' => '',"active" => true,'email_verified_at' => date("Y-m-d H:i:s"),'token_register' => "",'created_by' => 'admin','created_at' => date('Y-m-d H:i:s')],
        ]);
		
		//--Password = password
		AuthUser::insert([
            ['user_id' => 'admwh','user_nm' => 'Admin Gudang','email' => 'admwh@mail.com','password' => '$2y$10$v/SgFswfvNRmwtQAPMsPf.gLGW5DBZ8r7IN52.lcM6BLq0MFkO7BW','phone' => '',"active" => true,'email_verified_at' => date("Y-m-d H:i:s"),'token_register' => "",'created_by' => 'admin','created_at' => date('Y-m-d H:i:s')],
        ]);
		
    }
}
