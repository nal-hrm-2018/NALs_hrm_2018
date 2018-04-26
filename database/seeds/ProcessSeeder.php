<?php

use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,10) as $index) {
            DB::table('processes')->insert([
                'employee_id' => 2,
                'project_id' => 'PRO_000'.$index,
                'role_id' => '1',
                'check_project_exit' => 1,
                'man_power' => 0.5,
                'start_date' => '2016-04-12',
                'end_date' => '2016-06-12'
            ]);
        }
    }
}
