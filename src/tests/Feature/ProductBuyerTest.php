<?php

namespace Tests\Feature;

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

    public function test_If_Product_Transaction_Index_Is_Working_Properly()
    {
        $this->json('GET', '/products/' . 1 . '/buyers', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "verified",
                    "admin",
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ]
            ]);
    }
}
