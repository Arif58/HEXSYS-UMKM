<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoleUsersSeeder::class);
		$this->call(MenusTableSeeder::class);
        $this->call(RoleMenusTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
		
		$this->call(PublicComCodeTableSeeder::class);
		$this->call(PublicComUnitTableSeeder::class);
        $this->call(Modules\Inventori\Database\Seeders\InventoriDatabaseSeeder::class);
        //$this->call(ComNationTableSeeder::class);
        //$this->call(ComRegionTableSeeder::class);
        
        //$this->call(Modules\Data\Database\Seeders\DataDatabaseSeeder::class);
        //$this->call(Modules\Erp\Database\Seeders\ErpDatabaseSeeder::class);
		
		/*$path = "resources".DIRECTORY_SEPARATOR."sql".DIRECTORY_SEPARATOR."com_region.sql";
        /*DB::unprepared(file_get_contents($path));
        $this->command->info('com_region table seeded!');*/
		
        /*$path = "resources".DIRECTORY_SEPARATOR."sql".DIRECTORY_SEPARATOR."com_nation.sql";
        DB::unprepared(file_get_contents($path));
        $this->command->info('com_nation table seeded!');*/

        //pg_dump --column-inserts --data-only -U new_hexsys -p 5432 > resources/sql/data.sql
        //psql -U new_hexsys -h localhost -p 5432 < resources/sql/data.sql
        //\COPY com_region(region_cd, region_nm, region_root, region_capital, region_level, default_st, region_cd_maps, created_by, updated_by, created_at, updated_at) FROM 'resources/com_region.csv' DELIMITER ';' CSV;
        //iconv -f UTF-16 -t utf-8 data-only.sql > data.sql
    }
}
