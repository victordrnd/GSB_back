<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          RoleTableSeeder::class
        ]);
        
        $this->call([
          StatusTableSeeder::class
        ]);

        $this->call([
          TypeTableSeeder::class
        ]);

        $this->call([PermissionSeeder::class]);
        $this->call([RolePermissionSeedeer::class]);
        $this->call([NotificationGroupSeeder::class]);

        
    }
}
