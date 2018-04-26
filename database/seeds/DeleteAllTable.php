<?php

use Illuminate\Database\Seeder;
use App\Models\Permissions;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Process;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\Team;





class DeleteAllTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Process::truncate();
//        Project::truncate();
//        Status::truncate();
//        Employee::truncate();
//        EmployeeType::truncate();
//        Team::truncate();
//        Role::truncate();
//        Permissions::truncate();

        $this->call(DeleteAllTable::class);
    }
}
