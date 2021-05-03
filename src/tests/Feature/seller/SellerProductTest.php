<?php

namespace Tests\Feature\seller;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SellerProductTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

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

    public function test_Seller_Product_Can_Be_Deleted()
    {
        $seller = Seller::all()->random()->id;
        $products = DB::table('products')->where('seller_id', $seller)->first();

        $this->json('DELETE', '/sellers/' . $seller . "/products/" . $products->id  , ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "description",
                "quantity",
                "status",
                "image",
                "seller_id",
                "created_at",
                "updated_at",
                "deleted_at"
            ]);
    }
}
