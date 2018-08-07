<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAbsenceHRTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_hasPermission()
    {
        $role = "view_employee_absence_history";
        $id = 1;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }

    public function test_not_hasPermission()
    {
        $role = "view_employee_absence_history";
        $id = 6;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }
}
