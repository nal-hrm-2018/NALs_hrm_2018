<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\EmployeeType;
use App\Models\Role;
use App\Models\Team;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $employee_types = EmployeeType::pluck('id');
        $teams = Team::pluck('id');
        $roles = Role::where('name','<>','PO')->pluck('id');

        if (Employee::where('email', '=', 'admin@gmail.com')->get()->isEmpty()) {
                DB::table('employees')->insert([
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('12345678'),
                    'name' => $faker->name,
                    'birthday' => $faker->dateTimeBetween('-40 years', '-10 years'),
                    'gender' => rand(1, 2),
                    'mobile' => '0905123421',
                    'address' => $faker->address,
                    'marital_status' => rand(1, 2),
                    'startwork_date' => $faker->dateTimeBetween('-2 years', '-2 months'),
                    'endwork_date' => $faker->dateTimeBetween('-1 months', 'now'),
                    'curriculum_vitae' => 1,
                    'is_employee' => 1,
                    'avatar' => $faker->imageUrl(480, 600),
                    'employee_type_id' => $employee_types[rand(0, count($employee_types) - 1)],
                    'team_id' => $teams[rand(0, count($teams) - 1)],
                    'role_id' => $roles[rand(0, count($roles) - 1)],
                ]);
        }


        foreach (range(1, 40) as $index) {
            DB::table('employees')->insert([
                'email' => $faker->email,
                'password' => bcrypt('12345678'),
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-40 years', '-10 years'),
                'gender' => rand(1, 2),
                'mobile' => '0905123421',
                'address' => $faker->address,
                'marital_status' => rand(1, 2),
                'startwork_date' => $faker->dateTimeBetween('-2 years', '-2 months'),
                'endwork_date' => $faker->dateTimeBetween('-1 months', 'now'),
                'curriculum_vitae' => 1,
                'is_employee' => 1,
                'avatar' => $faker->imageUrl(480, 600),
                'employee_type_id' => $employee_types[rand(0, count($employee_types) - 1)],
                'team_id' => $teams[rand(0, count($teams) - 1)],
                'role_id' => $roles[rand(0, count($roles) - 1)],
            ]);
        }


    }

}
