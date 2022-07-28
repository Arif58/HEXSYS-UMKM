<?php

namespace Modules\Inventori\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InventoriDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(InventoriMenuTableSeeder::class);
        $this->call(InventoriRoleMenuTableSeeder::class);
        $this->call(InvInvUnitTableSeeder::class);
        $this->call(InvInvItemTypeTableSeeder::class);
        $this->call(InvInvPosInventoriTableSeeder::class);
        $this->call(InvInvItemMasterTableSeeder::class);
        $this->call(InvInvPosItemUnitTableSeeder::class);
        $this->call(InvInvItemGolonganTableSeeder::class);
        $this->call(InvInvItemKategoriTableSeeder::class);
    }
}
