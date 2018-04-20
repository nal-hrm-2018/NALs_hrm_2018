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
        $role = array('PO','TeamDev','BA','ScrumMater');
        $faker = Faker::create();
        foreach (range(0,count ($role)) as $index) {
            DB::table('roles')->insert([
                'id' => $index,
                'name'=> $role[$index],
            ]);
        }
        $this->call(RoleSeeder::class);
    }
}
