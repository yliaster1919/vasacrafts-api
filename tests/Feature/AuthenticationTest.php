<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Bridge\AccessToken;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_signup()
    {
        Storage::fake('sample');
        $file = UploadedFile::fake()->image('sample.jpg');
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => $contact_num ='09283429572',
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => $file,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> $contact_num,
                "address"=> $address,
                "profile_image"=> "public/uploads/".$file->hashName(),
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_signup_first_name_is_required()
    {
        Storage::fake('sample');
        $file = UploadedFile::fake()->image('sample.jpg');
        $response = $this->post('api/auth/signup',[
            'first_name' => NULL,
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => $file,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "first_name"=> [
                    "The first name field is required."
                ]
            ]        
        ]);
    }
    public function test_user_signup_last_name_is_required()
    {
        Storage::fake('sample');
        $file = UploadedFile::fake()->image('sample.jpg');
        $response = $this->post('api/auth/signup',[
            'first_name' => 'John',
            'last_name' => NULL,
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => $file,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "last_name"=> [
                    "The last name field is required."
                ]
            ]        
        ]);
    }
    public function test_user_signup_email_is_required()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => NULL,
            'password' => '12345678',
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "email"=> [
                    "The email field is required."
                ]
            ]        
        ]);
    }
    public function test_user_signup_email_must_be_valid()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalidemail',
            'password' => '12345678',
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "email"=> [
                    "The email field must be a valid email address."
                ]
            ]        
        ]);
    }
    public function test_user_signup_password_is_required()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => NULL,
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "password"=> [
                    "The password field is required."
                ]
            ]        
        ]);
    }
    public function test_user_signup_password_must_be_at_least_eight_characters()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => '1234567',
            'contact_num' => '09283429572',
            'address' => 'Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign-up failed.",
            "Error"=> [
                "password"=> [
                    "The password field must be at least 8 characters."
                ]
            ]        
        ]);
    }
    public function test_user_can_signup_with_contact_number()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => $contact_num ='09283429572',
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> $contact_num,
                "address"=> $address,
                "profile_image"=> NULL,
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_signup_without_contact_number()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => NULL,
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> NULL,
                "address"=> $address,
                "profile_image"=> NULL,
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_signup_with_address()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => NULL,
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> NULL,
                "address"=> $address,
                "profile_image"=> NULL,
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_signup_without_address()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => NULL,
            'address' => NULL,
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> NULL,
                "address"=> NULL,
                "profile_image"=> NULL,
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_signup_with_profile_image()
    {
        Storage::fake('sample');
        $file = UploadedFile::fake()->image('sample.jpg');
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => $contact_num ='09283429572',
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => $file,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> $contact_num,
                "address"=> $address,
                "profile_image"=> "public/uploads/".$file->hashName(),
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_signup_without_profile_image()
    {
        $response = $this->post('api/auth/signup',[
            'first_name' => $firstname ='John',
            'last_name' => $lastname ='Doe',
            'email' => $email ='johndoe@gmail.com',
            'password' => '12345678',
            'contact_num' => $contact_num ='09283429572',
            'address' => $address ='Random Address LKC-1919 St. Example City',
            'profile_image' => NULL,
        ]);
        $response->assertStatus(200)->assertJson([
            "Message"=> "Sign=-up successful.",
            "Email"=> $email,
            "User"=> [
                "user_id"=> 1,
                "first_name"=> $firstname,
                "last_name"=> $lastname,
                "contact_num"=> $contact_num,
                "address"=> $address,
                "profile_image"=> NULL,
                "id"=> 1
            ]    
        ]);
    }
    public function test_user_can_user_login()
    {
        $account = Account::factory()->create();
        $user = User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => $user->email,
            'password' => '12345678',
        ]);
        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->has('Message')
                 ->has('Access Token')
                 ->etc()
        );  
    }
    public function test_user_user_login_email_is_required()
    {
        $account = Account::factory()->create();
        User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => NULL,
            'password' => '12345678',
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login Failed",
            "Errors"=> [
                "email"=> [
                    "The email field is required."
                ]
            ]    
        ]);  
    }
    public function test_user_user_login_email_should_be_valid()
    {
        $account = Account::factory()->create();
        User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => 'invalid email',
            'password' => '12345678',
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login Failed",
            "Errors"=> [
                "email"=> [
                    "The email field must be a valid email address."
                ]
            ]    
        ]);  
    }
    public function test_user_user_login_email_should_be_registered()
    {
        $response = $this->post('api/auth/login',[
            'email' => 'unregisteredemail@example.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login failed",
            "Error"=> "Email not registered."   
        ]);  
    }
    public function test_user_login_password_is_required()
    {
        $account = Account::factory()->create();
        User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => 'invalid email',
            'password' => NULL,
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login Failed",
            "Errors"=> [
                "password"=> [
                    "The password field is required."
                ]
            ]    
        ]);      
    }
    public function test_user_login_password_should_be_at_least_eight_characters()
    {
        $account = Account::factory()->create();
        User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => 'invalid email',
            'password' => '1234567',
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login Failed",
            "Errors"=> [
                "password"=> [
                    "The password field must be at least 8 characters."
                ]
            ]    
        ]);      
    }
    public function test_user_should_login_with_matching_credentials()
    {
        $account = Account::factory()->create();
        $user = User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => $user->email,
            'password' => '1234567123',
        ]);
        $response->assertStatus(401)->assertJson([
            "Message"=> "Login failed",
            "Error"=> "Invalid credentials"  
        ]);      
    }
    public function test_user_can_logout()
    {
        $account = Account::factory()->create();
        $user = User::Where('id','=',$account->user_id)->first();
        $response = $this->post('api/auth/login',[
            'email' => $user->email,
            'password' => '12345678',
        ]);
        $response->assertStatus(200);
        $token = $user->createToken('Bearer Token')->accessToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
                    ->actingAs($user)->post('api/auth/logout');
        $response->assertStatus(200)
                 ->assertJson([
                    "Data"=> "Access token revoked",
                    "Message"=> "You have been successfully logged out."    
                 ]);
    }
}
