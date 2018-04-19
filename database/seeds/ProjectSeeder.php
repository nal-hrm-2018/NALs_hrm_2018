<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,10) as $index) {
            DB::table('projects')->insert([
                'id' => 'PRO_000'.$index,
                'name' => 'Ecommerce'.$index,
                'income' => '10000000',
                'real_cost' => '30000000',
                'description' => 'nothing to say',
                'status' => 1,
                'start_date' => '2016-04-12',
                'end_date' => '2016-06-12'
            ]);
        }
    }
}
