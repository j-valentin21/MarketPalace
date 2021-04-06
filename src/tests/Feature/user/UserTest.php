<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_If_Users_Index_Is_Working_Properly()
    {
       $user = User::factory()->create();
        $this->json('GET', '/users', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_Required_Fields_For_Storing_User()
    {
        $this->json('POST', '/users', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "name" => ["The name field is required."],
                "email" => ["The email field is required."],
                "password" => ["The password field is required."],
            ]);
    }

    public function test_Required_Fields_For_Updating_User()
    {
        $userData = [
            "email" => "test.com",
            "password" => "demo1",
        ];

        $this->json('POST', '/users', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "email" => ["The email must be a valid email address."],
                "password" => [
                    "The password must be at least 6 characters.",
                    "The password confirmation does not match."
                ],
            ]);
    }

    public function test_Successful_User_Creation()
    {
        $userData = [
            "name" => "Johnny Knows",
            "email" => "knows@example.com",
            "password" => "knows12345",
            "password_confirmation" => "knows12345"
        ];

       $response = $this->json('POST', '/users', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "name",
                "email",
                "verified",
                "admin",
                "updated_at",
                "created_at",
                "id"
            ]);
    }

    public function test_One_User_Is_Displayed_Based_On_Id()
    {
        $user = User::factory()->create();

        $this->json('GET', '/users/' . $user->id,  ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "email",
                "email_verified_at",
                "verified",
                "admin",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
    }

    public function test_User_Can_Update_Name_And_Email()
    {
        $user = User::factory()->create();
        $userData = [
            "name" => "Johnny Knows",
            "email" => "test@example.com",
        ];

       $response = $this->json('PUT', '/users/' . $user->id, $userData,  ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "email",
                "email_verified_at",
                "verified",
                "admin",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
        $this->assertEquals($response['name'], $userData['name']);
        $this->assertEquals($response['email'], $userData['email']);
    }

    public function test_User_Can_Deleted()
    {
        $user = User::factory()->create();

        $response = $this->json('DELETE', '/users/' . $user->id,   ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "email",
                "email_verified_at",
                "verified",
                "admin",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
        $this->assertNotEmpty($response['deleted_at']);
    }

    public function test_User_Can_Be_Verified()
    {
        $user = User::factory()->create();

        $this->json('GET', '/users/verify/' . $user->verification_token,   ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data" => 'The account has been verified successfully'
            ]);
    }
}
