<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CategoryTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_If_Category_Transaction_Index_Is_Working_Properly()
    {
        $categories = Category::all()->random()->id;

        $this->json('GET', '/categories/' . $categories . '/transactions', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "quantity",
                    "buyer_id",
                    "product_id",
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ]
            ]);

    }
}
