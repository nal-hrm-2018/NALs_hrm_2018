<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ProjectSeeder extends Seeder
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
            DB::table('projects')->insert([
                'id' => $index,
                'name'=> $faker->name,
                'status' => $faker->title
            ]);
        }
        $this->call(ProjectSeeder::class);
    }
}
