<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SellerProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Seller_Product_Index_Is_Working_Properly()
    {
        $seller = Seller::all()->random()->id;

        $this->json('GET', '/sellers/' . $seller . '/products', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_Required_Fields_For_Storing_Products()
    {
        $seller = Seller::all()->random()->id;

        $this->json('POST', '/sellers/' . $seller . "/products", ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "name" => ["The name field is required."],
                "description" => ["The description field is required."],
                "quantity" => ["The quantity field is required."],
                "image" => ["The image field is required."]
            ]);
    }

//    public function test_Success_Product_Creation()
//    {
//
//        $productData = [
//            'name' => 'Johnny Knows',
//            'description' => 'Apple',
//            'image' =>  'apple.jpg',
//            'quantity' => 1
//        ];
//
//
//           $this->json('POST', '/sellers/' . 1 . '/products', $productData, ['Accept' => 'application/json'])
//            ->assertStatus(201)
//            ->assertJsonStructure([
//                "name",
//                "email",
//                "verified",
//                "admin",
//                "updated_at",
//                "created_at",
//                "id"
//            ]);
//
//    }
}
