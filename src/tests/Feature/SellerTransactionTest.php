<?php

namespace Tests\Feature;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SellerTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Seller_Transaction_Index_Is_Working_Properly()
    {
        $seller = Seller::all()->random()->id;

        $this->json('GET', '/sellers/' . $seller . '/transactions', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
