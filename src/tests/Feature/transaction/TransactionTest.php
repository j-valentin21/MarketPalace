<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_If_Transaction_Index_Is_Working_Properly()
    {
        $this->json('GET', '/transactions', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

}
