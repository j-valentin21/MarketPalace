<?php

namespace Tests\Feature\seller;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SellerProductTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function setUp()
    : void {

        parent::setUp();

        Artisan::call('db:seed');
    }

    public function test_Required_Fields_For_Storing_Products()
    {
        $seller = Seller::all()->random()->id;

        $this->json('POST', '/sellers/' . $seller . "/products", ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    "title", [ "The title field is required."],
                    "details", ["The details field is required."],
                    "stock",[
                        "The stock field is required.",
                        "The stock field must be an integer",
                        "The stock field must have a minimum value of 1"
                    ],
                    "image",
                    [
                        "The image field is required.",
                        "The image field must be an image"
                    ]
                ]
            ]);
    }
}
