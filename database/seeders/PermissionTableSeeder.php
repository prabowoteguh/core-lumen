<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permission')->delete();

        $data = [
        	['description' => '', 'title' => 'Super User'],
			['description' => '', 'title' => 'Supervisi'],
			['description' => '', 'title' => 'Operator'],
			['description' => '', 'title' => 'Approval'],
			['description' => '', 'title' => 'Maker'],
			['description' => '', 'title' => 'Checker'],
        ];

        for ($i=0; $i < count($data); $i++) {
        	$data[$i]['id'] = ($i+1);
        	Permission::create($data[$i]);
        }
    }
}
