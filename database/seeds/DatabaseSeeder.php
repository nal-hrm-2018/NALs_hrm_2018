<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            DB::beginTransaction();
            $this->call(PermissionSeeder::class);
            $this->call(RoleSeeder::class);
            $this->call(TeamSeeder::class);
            $this->call(EmployeeTypeSeeder::class);
            $this->call(EmployeeSeeder::class);
            $this->call(StatusProjectSeeder::class);
            $this->call(ProjectSeeder::class);
            $this->call(ProcessSeeder::class);
            DB::commit();
        } catch (Exception $ex) {
           echo $ex->getMessage();
            DB::rollBack();
        }

    }
}
