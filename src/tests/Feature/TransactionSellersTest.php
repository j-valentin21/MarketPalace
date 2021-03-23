<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TransactionSellersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Transaction_Seller_Index_Is_Working_Properly()
    {
        $this->json('GET', '/transactions/1/sellers', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
