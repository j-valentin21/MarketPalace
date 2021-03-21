<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\MockObject\Api;
use PHPUnit\Framework\TestCase;
use App\Traits\ApiResponder;

class ApiResponderTest extends TestCase
{
    use ApiResponder;

//    public function test_example()
//    {
//        $user = new User();
//
//        $data = [
//            "name" => "Johnny Knows",
//            "email" => "knows@example.com",
//            "password" => "knows12345",
//            "password_confirmation" => "knows12345"
//        ];
//        $status = 200;
//        $response = $user->successResponse($data, $status);
//        dd($response);
//    }
}
//        $this->assertStatus(200);
//        ->assertJsonStructure([
//            "name",
//            "email",
//            "verified",
//            "admin",
//            "updated_at",
//            "created_at",
//            "id"
//        ]);
//    }
//}
