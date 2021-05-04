<?php

namespace Tests\Feature\product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    public function test_If_Products_Index_Is_Working_Properly()
    {
        $this->json('GET', '/products', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
