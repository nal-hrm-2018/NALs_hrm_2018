<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_hasPermission()
    {
        $role = "view_employee_project";
        $id = 1;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertTrue($result);
    }

    public function test_not_hasPermission()
    {
        $role = "view_employee_project";
        $id = 6;
        $result = Employee::find($id)->hasPermission($role);
        $this->assertNotTrue($result);
    }

    public function testListProject()
    {
        $credential = [
            'email' => 'hr1@nal.com',
            'password' => '123456'
        ];
        $this->post('login', $credential);
        $response = $this->get('employee', [1]);
        $view = $response->original;
//        dd($view);
        $response->assertStatus(200);
    }

}
