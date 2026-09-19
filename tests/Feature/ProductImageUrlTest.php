<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImageUrlTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $brand = Brand::create(['name' => 'ساخت ایران']);

        return Product::create(array_merge([
            'name' => 'برنج هاشمی',
            'code' => 1,
            'category' => 'rice',
            'brand_id' => $brand->id,
            'unit' => 'کیلوگرم',
            'price' => 1000,
        ], $overrides));
    }

    public function test_image_url_falls_back_to_placeholder_when_product_has_no_image(): void
    {
        $product = new Product(['image' => null]);

        $this->assertSame(asset(Product::PLACEHOLDER_IMAGE), $product->image_url);
    }

    public function test_image_url_points_to_storage_when_product_has_an_image(): void
    {
        $product = new Product(['image' => 'products/rice.jpg']);

        $this->assertSame(asset('storage/products/rice.jpg'), $product->image_url);
    }

    public function test_products_page_shows_placeholder_for_product_without_image(): void
    {
        $this->createProduct(['image' => null]);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertSee('src="'.asset(Product::PLACEHOLDER_IMAGE).'"', false);
        $response->assertSee('data-image="'.asset(Product::PLACEHOLDER_IMAGE).'"', false);
    }
}
