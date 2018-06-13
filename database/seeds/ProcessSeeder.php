<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Carbon\Carbon;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $manpowers = getArrayManPower();
        $employees = \App\Models\Employee::pluck('id');
        $projects = \App\Models\Project::pluck('id');
        $roles = Role::pluck('id');
        foreach (range(1, 40) as $index) {
            $project_id = $projects[rand(0, count($projects) - 1)];
            $start_dt = Carbon::parse(\App\Models\Project::find($project_id)->start_date);
            $end_dt = Carbon::parse(\App\Models\Project::find($project_id)->estimate_end_date);
            DB::table('processes')->insert([
                'employee_id' => $employees[rand(0, count($employees) - 1)],
                'project_id' => $project_id,
                'role_id' => $roles[rand(0, count($roles) - 1)],
                'check_project_exit' => 1,
                'man_power' => $manpowers[$this->frand(0,4)],
                'start_date' => $start_dt->addDays(rand(1, 5)),
                'end_date' => $end_dt->subDays(rand(6, 15)),
            ]);
        }
    }

    function frand($min, $max, $decimals = 0) {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}
