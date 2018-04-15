<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            DB::table('employees')->insert([
                'id' => $index,
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('12345678')
            ]);
        }
    }
}
