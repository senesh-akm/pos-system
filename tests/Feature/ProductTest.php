<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_a_product_can_be_stored()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'barcode' => '1234567890',
            'price' => 1500.50,
            'stock' => 'In Stock',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'barcode' => '1234567890',
            'price' => 1500.50,
            'stock' => 'In Stock',
        ]);
    }

    #[Test]
    public function test_product_creation_fails_with_invalid_data()
    {
        $response = $this->post(route('products.store'), [
            'name' => '',
            'barcode' => '',
            'price' => -50,
            'stock' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'barcode', 'price', 'stock']);
    }
}
