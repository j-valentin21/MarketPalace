<?php

namespace Tests\Feature\product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductTransactionTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Product_Transaction_Index_Is_Working_Properly()
    {
        $this->json('GET', '/products/' . 1 . '/transactions', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
