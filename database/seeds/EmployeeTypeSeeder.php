<?php

use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['PO', 'BA', 'QA', 'TeamDev'];
        if (!\App\Models\EmployeeType::first()) {
            foreach (range(0, count($name) - 1) as $index) {
                DB::table('employee_types')->insert([
                    'name' => $name[$index]
                ]);
            }
        }


    }
}
