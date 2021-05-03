<?php

namespace Tests\Feature\buyer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BuyerTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function test_If_Buyers_Index_Is_Working_Properly()
    {
        $user = User::factory()->create();
        $this->json('GET', '/buyers', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

}
