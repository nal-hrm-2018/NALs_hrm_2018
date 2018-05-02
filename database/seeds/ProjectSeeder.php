<?php

use Illuminate\Database\Seeder;


use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
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
        $status = \App\Models\Status::pluck('id');
        foreach (range(1,40) as $index) {
            DB::table('projects')->insert([
                'id' => $faker->currencyCode."".rand(1,3000),
                'name' => $faker->name.$index,
                'income' => '10000000',
                'real_cost' => '30000000',
                'description' => 'nothing to say',
                'status_id' => $status[rand(0,count($status)-1)],
                'start_date' => $faker->dateTimeBetween('-2 years', '-3 months'),
                'estimate_end_date' => $faker->dateTimeBetween('-1 months', '-1 days'),

            ]);
        }
    }
}
