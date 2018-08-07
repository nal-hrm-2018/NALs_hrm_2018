<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
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
//    public function testLogin_Success()
//    {
//    	$response = $this->json('POST', 'api/login', [
//    		'email' => 'admin@gmail.com',
//    		'password'=>'12345678'
//    	]);
//    	 $response->assertStatus(200);
//    	 $response->assertJson([
//    	 	"result_code"=> 200,
//    		"result_message"=> "Login success!"
//    	 ]);
//    	 //
//    }
//
//    public function testLogin_no_value()
//    {
//    	$response = $this->json('POST', 'api/login');
//    	$response->assertStatus(200);
//    	$response->assertJson([
//    	 	"result_code"=> 401,
//    		"result_message"=> "invalid_email_or_password"
//    	 ]);
//    }
//
//    public function testLogin_no_email()
//    {
//    	$response = $this->json('POST', 'api/login',[
//    		'password'=>'12345678'
//    	]);
//    	 $response->assertStatus(200);
//    	 $response->assertJson([
//    	 	"result_code"=> 401,
//    		"result_message"=> "invalid_email_or_password"
//    	 ]);
//    }
//
//    public function testLogin_no_password()
//    {
//    	$response = $this->json('POST', 'api/login',[
//    		'email' => 'admin@gmail.com'
//    	]);
//    	 $response->assertStatus(500);
//
//    }
//    public function testLogin_incorrect_email()
//    {
//    	$response = $this->json('POST', 'api/login',[
//    		'email' => 'ad@gmail.com',
//    		'password'=>'123456'
//    	]);
//    	 $response->assertStatus(200);
//    	 $response->assertJson([
//    	 	"result_code"=> 401,
//    		"result_message"=> "invalid_email_or_password"
//    	 ]);
//    }
//    public function testLogin_incorrect_password()
//    {
//
//    	$response = $this->json('POST', 'api/login',[
//    		'email' => 'admin@gmail.com',
//    		'password'=>'123456'
//    	]);
//    	 $response->assertStatus(200);
//    	 $response->assertJson([
//    	 	"result_code"=> 401,
//    		"result_message"=> "invalid_email_or_password"
//    	 ]);
//    }
}
