<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Permissions;
use Illuminate\Support\Facades\DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $name=['view','create','edit','delete'];
        if(!Permissions::first()){
            foreach (range(0,count($name)-1) as $index) {
                DB::table('permissions')->insert([
                    'name'=> $name[$index],
                    'description' => $name[$index]
                ]);
            }
        }

    }
}
