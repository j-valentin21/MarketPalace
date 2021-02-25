<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public User $user;

    public function __construct()
    {
        $this->user = new User();
        parent::__construct();
    }

    public function test_If_User_Method_Is_Verified_Method_Is_Equal_To_The_String_1()
    {
        $result = $this->user->isVerified();
        $verify = $this->user->verified;

        $this->assertEquals($result, $verify);
        $this->assertIsString($result);
    }

    public function test_If_User_Method_Is_Admin_Is_Equal_To_The_String_True()
    {
        $result = $this->user->isAdmin();
        $verify = $this->user->admin;

        $this->assertEquals($result, $verify);
        $this->assertIsString($result);
    }

    public function test_If_Generate_Verification_Code_Method_Returns_A_Random_String_Of_Characters()
    {
        $result = $this->user->generateVerificationCode();
        $count = strlen($result);

        $this->assertEquals($count, '40');
        $this->assertIsString($result);
    }
}
