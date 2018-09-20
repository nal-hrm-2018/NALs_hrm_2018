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

    public function test_hasPermission_viewEmployeeBasic(){
        $role="view_employee_basic";
        $id = 1;
        $result=Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }
    public function test_not_hasPermission_viewEmployeeBasic(){
        $role="view_employee_basic";
        $id = 20;
        $result=Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }
    public function test_hasPermission_viewProjectAbsenceHistory(){
        $role="view_project_absence_history";
        $id = 3;
        $result=Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }
    public function test_not_hasPermission_viewProjectAbsenceHistory(){
        $role="view_project_absence_history";
        $id = 5;
        $result=Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }
    public function testPermmissionViewListEmployee()
    {
        $role = "view_list_employee";
        $employee = Employee::find(1)->hasPermission($role);
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

    public function testHasPermissionViewProjectEmployee()
    {
        $role = "view_employee_project";
        $id = 1;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }

    public function testNotHasPermissionViewProjectEmployee()
    {
        $role = "view_employee_project";
        $id = 6;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }
    public function testHasPermissionViewEmployeeAbsenceHR()
    {
        $role = "view_employee_absence_history";
        $id = 1;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }

    public function testNotHasPermissionViewEmployeeAbsenceHR()
    {
        $role = "view_employee_absence_history";
        $id = 6;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }
}
