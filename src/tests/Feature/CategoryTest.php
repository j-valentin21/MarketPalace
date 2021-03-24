<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_If_Categories_Index_Is_Working_Properly()
    {
        $this->json('GET', '/categories', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_Required_Fields_For_Categories()
    {
        $this->json('POST', '/categories', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "name" => ["The name field is required."],
                "description" => ["The description field is required."]
            ]);
    }

    public function test_Successful_Category_Creation()
    {
        $categoryData = [
            "name" => "Johnny Knows",
            "description" => "gotta catch them all"
        ];

        $response = $this->json('POST', '/categories', $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "name",
                "description"
            ]);
    }

    public function test_One_User_Is_Displayed_Based_On_Id()
    {
        $category = Category::factory()->create();

        $this->json('GET', '/categories/' . $category->id,  ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "description"
            ]);
    }

    public function test_Categories_Can_Be_Updated()
    {
        $category = Category::factory()->create();
        $categoryData = [
            "name" => "Johnny Knows",
            "description" => "gotta catch them all",
        ];

        $response = $this->json('PUT', '/categories/' . $category->id, $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "description",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);
        $this->assertEquals($response['name'], $categoryData['name']);
        $this->assertEquals($response['description'], $categoryData['description']);
    }

    public function test_Categories_Can_Be_Deleted()
    {
        $category = Category::factory()->create();

        $response = $this->json('DELETE', '/categories/' . $category->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "description",
                "created_at",
                "updated_at",
                "deleted_at",
            ]);

        $this->assertNotEmpty($response['deleted_at']);
    }
}
