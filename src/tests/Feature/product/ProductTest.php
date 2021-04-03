<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_If_Products_Index_Is_Working_Properly()
    {
        $this->json('GET', '/products', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_One_Product_Is_Displayed_Based_On_Id()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->json('GET', '/products/' . $user->id , ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id" ,
                "name",
                "description",
                "quantity",
                "status",
                "image",
                "seller_id",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
    }
}
