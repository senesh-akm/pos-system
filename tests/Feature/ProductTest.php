<?php

namespace Tests\Feature;

use App\Models\Product;
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

    #[Test]
    public function test_an_updates_can_be_product()
    {
        $this->withoutExceptionHandling();

        $product = Product::create([
            'name' => 'Old Product',
            'barcode' => '123456789',
            'price' => 500,
            'stock' => 'In Stock',
        ]);

        $updateProduct = [
            'name' => 'Replace Product',
            'barcode' => '012345678',
            'price' => 800,
            'stock' => 'Out of Stock',
        ];

        $response = $this->put(route('products.update', $product->id), $updateProduct);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Replace Product',
            'barcode' => '012345678',
            'price' => 800,
            'stock' => 'Out of Stock',
        ]);
    }

    #[Test]
    public function test_validates_a_product_update_data()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'barcode' => '987654321',
            'price' => 600,
            'stock' => 'In Stock',
        ]);

        $response = $this->put(route('products.update', $product->id), [
            'name' => '',
            'barcode' => '',
            'price' => '',
            'stock' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'barcode', 'price', 'stock']);
    }

    #[Test]
    public function test_deletes_a_product_data()
    {
        $this->withoutExceptionHandling();

        $product = Product::create([
            'name' => 'Delete Product',
            'barcode' => '456789123',
            'price' => 400,
            'stock' => 'Out of Stock',
        ]);

        $response = $this->delete(route('products.destroy', $product->id));
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
