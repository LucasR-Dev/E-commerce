<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all_products(): void
    {
        $response = $this->getjson('/api/products');

        $response->assertStatus(200);
    }

    public function test_create_a_new_product(): void
    {
        $response = $this->getjson('/api/products');

        $response->assertStatus(200);
    }

    public function test_update_product_id(): void
    {
        $response = $this->putjson('/api/products/{id}');

        $response->assertStatus(200);
    }

    public function test_delete_product_by_id(): void
    {
        $response = $this->deletejson('/api/products/{id}');

        $response->assertStatus(200);
    }
}
