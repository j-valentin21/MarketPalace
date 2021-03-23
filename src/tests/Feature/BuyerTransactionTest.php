<?php

namespace Tests\Feature;

use App\Models\Buyer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BuyerTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Buyer_Transaction_Index_Is_Working_Properly()
    {
        $buyer = Buyer::all()->random()->id;

        $this->json('GET', '/buyers/' . $buyer . '/transactions', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
