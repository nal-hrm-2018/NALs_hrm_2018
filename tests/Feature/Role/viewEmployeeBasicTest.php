<?php

namespace Tests\Feature\Role;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Employee;

class viewEmployeeBasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
  
    public function test_hasPermission(){
        $role="view_employee_basic";
        $id = 1;        
        $employee=Employee::find($id)->hasPermission($role);
        $this->assertTrue($employee);
    
    }
    public function test_not_hasPermission(){
        $role="view_employee_basic";  
        $id = 20;      
        $employee=Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($employee);
    
    }
}

