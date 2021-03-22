<?php

namespace Tests\Feature;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuyerTest extends TestCase
{
    use RefreshDatabase;

    public function test_If_Buyers_Index_Is_Working_Properly()
    {
        $user = User::factory()->create();
        $this->json('GET', '/buyers', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

}
