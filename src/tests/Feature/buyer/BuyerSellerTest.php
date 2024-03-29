<?php

namespace Tests\Feature\buyer;

use App\Models\Buyer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BuyerSellerTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Buyer_Seller_Index_Is_Working_Properly()
    {
        $buyer = Buyer::all()->random()->id;

        $this->json('GET', '/buyers/' . $buyer . '/sellers', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
