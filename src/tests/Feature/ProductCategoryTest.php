<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Product_Transaction_Index_Is_Working_Properly()
    {
        $this->json('GET', '/products/' . 1 . '/categories', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_If_Product_Category_Can_Be_Updated()
    {
        $products = Product::all()->random()->id;
        $categoryId =   rand(1,25);

        $this->json('PUT', '/products/' . $products . '/categories/' . $categoryId , ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "name",
                    "description",
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ]
            ]);
    }

    public function test_If_Product_Category_Responds_With_Status_Code_404_When_Resource_Does_Not_Exist()
    {
        $products = Product::all()->random()->id;
        $categoryId =   rand(50,100);

        $this->json('DELETE', '/products/' . $products . '/categories/' . 31 , ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                    "error",
                    "code"
            ]);
    }

    public function test_If_Product_Category_Can_Be_Deleted()
    {
        $products = Product::all()->first();
        $categoryId = $products->categories->pluck('id')->first();

        $this->json('DELETE', '/products/' . $products->id . '/categories/' . $categoryId , ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
