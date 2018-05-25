<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = array('PO','Dev','BA','ScrumMaster');
        if(!\App\Models\Role::first()){
            foreach (range(0,count ($role)-1) as $index) {
                DB::table('roles')->insert([
                    'name'=> $role[$index],
                ]);
            }
        }

    }
}
