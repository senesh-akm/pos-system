<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_a_product_can_be_stored()
    {
        $this->withoutExceptionHandling();

        $image = UploadedFile::fake()->image('test_product_image.jpg');

        $response = $this->post(route('products.store'), [
            'product_image' => $image,
            'refnumber' => 'POS240227001',
            'name' => 'Test Product',
            'category' => 'Test',
            'barcode' => '1234567890',
            'price' => 1500.50,
            'stock' => 'In Stock',
        ]);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'refnumber' => 'POS240227001',
            'name' => 'Test Product',
            'category' => 'Test',
            'barcode' => '1234567890',
            'price' => 1500.50,
            'stock' => 'In Stock',
        ]);

        $product = Product::where('refnumber', 'POS240227001')->first();
        $this->assertNotNull($product->product_image);
    }

    #[Test]
    public function test_product_creation_fails_with_invalid_data()
    {
        $response = $this->post(route('products.store'), [
            'product_image' => '',
            'refnumber' => '',
            'name' => '',
            'category' => 'Test',
            'barcode' => '',
            'price' => -50.00,
            'stock' => '',
        ]);

        $response->assertSessionHasErrors(['refnumber', 'name', 'barcode', 'price', 'stock']);
    }

    #[Test]
    public function test_an_updates_can_be_product()
    {
        $this->withoutExceptionHandling();

        $product = Product::create([
            'refnumber' => 'POS240227001',
            'name' => 'Old Product',
            'category' => 'Electronics',
            'barcode' => '123456789',
            'price' => 500,
            'stock' => 'In Stock',
        ]);

        $updateProduct = [
            'refnumber' => 'POS240227002',
            'name' => 'Replace Product',
            'category' => 'Home Appliance',
            'barcode' => '012345678',
            'price' => 800,
            'stock' => 'Out of Stock',
        ];

        $response = $this->put(route('products.update', $product->id), $updateProduct);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'refnumber' => 'POS240227002',
            'name' => 'Replace Product',
            'category' => 'Home Appliance',
            'barcode' => '012345678',
            'price' => 800,
            'stock' => 'Out of Stock',
        ]);
    }

    #[Test]
    public function test_validates_a_product_update_data()
    {
        $product = Product::create([
            'refnumber' => 'POS240227001',
            'name' => 'Test Product',
            'category' => 'Test Category',
            'barcode' => '987654321',
            'price' => 600,
            'stock' => 'In Stock',
        ]);

        $response = $this->put(route('products.update', $product->id), [
            'refnumber' => '',
            'name' => '',
            'category' => 'Electronics',
            'barcode' => '',
            'price' => '',
            'stock' => '',
        ]);

        $response->assertSessionHasErrors(['refnumber', 'name', 'barcode', 'price', 'stock']);
    }

    #[Test]
    public function test_deletes_a_product_data()
    {
        $this->withoutExceptionHandling();

        $product = Product::create([
            'refnumber' => 'POS240227001',
            'name' => 'Delete Product',
            'category' => 'Product Category',
            'barcode' => '456789123',
            'price' => 400,
            'stock' => 'Out of Stock',
        ]);

        $response = $this->delete(route('products.destroy', $product->id));
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
