<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testPermmissionViewListEmployee(){
        $role="view_list_employee";
        $employee=Employee::find(1)->hasPermission($role);
        $this->assertTrue($employee);
    }

    public function testPermissionViewAbsenceHistory(){
        $role="view_absence_history";
        $employee=Employee::find(1)->hasPermission($role);
        $this->assertTrue($employee);
    }

    public function testPermissionViewAddNewAbsence(){
        $role="add_new_absence";
        $employee=Employee::find(1)->hasPermission($role);
        $this->assertTrue($employee);
    }


}
