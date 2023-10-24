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
    public function test_products(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_categories(): void
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function test_employees(): void
    {
        $response = $this->get('/api/employees');

        $response->assertStatus(200);
    }
}
