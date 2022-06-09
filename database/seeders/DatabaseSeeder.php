<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermittanceTypeTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ConfigurationTableSeeder;
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
            PermittanceTypeTableSeeder::class,
        	UsersTableSeeder::class,
        	ConfigurationTableSeeder::class,
        ]);
    }
}
