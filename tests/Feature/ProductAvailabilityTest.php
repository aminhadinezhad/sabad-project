<?php

namespace Tests\Feature;

use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private function product(string $name, array $overrides = []): Product
    {
        return Product::create(array_merge(['name' => $name, 'category' => 'rice', 'price' => 150000], $overrides));
    }

    /** بخش HTML کارت یک کالا در صفحه اول */
    private function cardHtml(string $html, Product $product): string
    {
        $card = substr($html, strpos($html, 'id="product-'.$product->id.'"'));

        return substr($card, 0, strpos($card, '</h3>'));
    }

    public function test_new_and_existing_products_are_available_by_default(): void
    {
        $this->assertTrue($this->product('برنج هاشمی')->fresh()->is_available);
    }

    public function test_unavailable_product_shows_label_instead_of_price_and_add_button(): void
    {
        $off = $this->product('برنج هاشمی', ['is_available' => false]);
        $on = $this->product('برنج طارم', ['price' => 120000]);

        $html = $this->get(route('products.index'))->assertOk()->getContent();

        $offCard = $this->cardHtml($html, $off);
        $this->assertStringContainsString('product-card__unavailable">ناموجود', $offCard);
        $this->assertStringNotContainsString('data-qty-control', $offCard);
        $this->assertStringNotContainsString('product-card__price-row', $offCard);

        $onCard = $this->cardHtml($html, $on);
        $this->assertStringNotContainsString('ناموجود', $onCard);
        $this->assertStringContainsString('data-qty-control', $onCard);
        $this->assertStringContainsString('120,000', $onCard);
    }

    public function test_availability_is_switched_from_the_edit_form_not_the_table(): void
    {
        Filament::setCurrentPanel('admin');
        Permission::create(['name' => 'access_products']);
        $user = User::factory()->create(['has_access' => true]);
        $user->givePermissionTo('access_products');
        $this->actingAs($user);

        $brand = Brand::create(['name' => 'ساخت ایران']);
        $product = $this->product('برنج هاشمی', ['code' => 1, 'brand_id' => $brand->id, 'unit' => 'کیلوگرم']);

        Livewire::test(ListProducts::class)
            ->assertTableColumnDoesNotExist('is_available');

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertFormFieldVisible('is_available')
            ->fillForm(['is_available' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse($product->fresh()->is_available);
        $this->assertSame(150000, (int) $product->fresh()->price);
    }
}
