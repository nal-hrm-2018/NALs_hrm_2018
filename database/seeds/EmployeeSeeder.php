<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,10) as $index) {
            DB::table('employees')->insert([
                'email' => str_random(10) . '@gmail.com',
                'password' => bcrypt('secret'),
                'name' => 'Nguyen Van An',
                'birthday' => '1990-02-10',
                'gender' => 1,
                'mobile' => '01234567890',
                'address' => '120/14 Nguyen Luong Bang, Lien Chieu, Da Nang',
                'marital_status' => 1,
                'startwork_date' => '2016-04-12',
                'endwork_date' => '2018-04-12',
                'curriculum_vitae' => 1,
                'is_employee' => 1,
                'avatar' => "abc",
                'employee_type_id' => 1,
                'teams_id' => 1,
                'roles_id' => 1
            ]);
        }
    }
}
