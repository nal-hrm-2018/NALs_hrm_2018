<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUser()
    {

        $user = factory(Employee::class)->create();
//        echo json_encode($user);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertSuccessful();
        $user->forceDelete();
    }
    public function testLoginTrue()
    {
        $credential = [
            'email' => 'hr1@nal.com',
            'password' => '123456'
        ];
        $this->post('login',$credential)->assertRedirect('/dashboard');
    }
    public function testLoginFalse()
    {
        $credential = [
            'email' => 'hr1@nal.com',
            'password' => '123'
        ];
        $this->post('login',$credential)->assertLocation('/');
    }
}
