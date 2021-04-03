<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductBuyerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Product_Buyer_Index_Is_Working_Properly()
    {
        $product =  Product::all()->random()->id;

        $this->json('GET', '/products/' . $product . '/buyers', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
