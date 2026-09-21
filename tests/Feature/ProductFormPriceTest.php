<?php

namespace Tests\Feature;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductFormPriceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');
        Permission::create(['name' => 'access_products']);
        $user = User::factory()->create(['has_access' => true]);
        $user->givePermissionTo('access_products');
        $this->actingAs($user);
    }

    public function test_edit_form_has_no_price_input_and_saving_keeps_the_price(): void
    {
        $brand = Brand::create(['name' => 'ساخت ایران']);
        $product = Product::create([
            'name' => 'برنج هاشمی', 'code' => 1, 'category' => 'rice',
            'brand_id' => $brand->id, 'unit' => 'کیلوگرم', 'price' => 150000,
        ]);

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertFormFieldHidden('price')
            ->fillForm(['name' => 'برنج هاشمی ممتاز'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('برنج هاشمی ممتاز', $product->fresh()->name);
        $this->assertSame(150000, (int) $product->fresh()->price);
    }

    public function test_create_form_still_asks_for_a_price(): void
    {
        Livewire::test(CreateProduct::class)
            ->assertFormFieldVisible('price');
    }
}
