<?php

namespace Tests\Feature\user;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

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
                "errors" => [
                    "name",
                    [
                        "The name field is required."
                    ],
                    "email",
                    [
                        "The email field is required.",
                        "The email must be unique"
                    ],
                    "password",
                    [
                        "password field is required",
                        "password must have at least 6 characters"
                    ]
            ]
            ]);
    }

    public function test_Required_Fields_For_Updating_User()
    {
        $userData = [
            "email" => "test.com",
            "password" => "demo1",
        ];

        $this->json('PUT', '/users/' . 1, $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    "email" , [
                        'The email must be unique'
                    ],
                    "password", [
                        "password must have at least 6 characters"
                    ]
                ]
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
                "identifier",
                "name",
                "email",
                "isVerified",
                "isAdmin",
                "creationDate",
                "lastChange",
                "deletedDate",
            ]);
    }

    public function test_User_Can_Update_Name_And_Email()
    {
        $user = User::factory()->create();
        $userData = [
            "name" => "Johnny Knows",
            "email" => "test@example.com",
        ];

       $this->json('PUT', '/users/' . $user->id, $userData,  ['Accept' => 'application/json'])
            ->assertStatus(200);

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
