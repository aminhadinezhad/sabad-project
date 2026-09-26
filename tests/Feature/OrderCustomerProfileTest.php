<?php

namespace Tests\Feature;

use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class OrderCustomerProfileTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Filament::setCurrentPanel('admin');

        $admin = User::factory()->create(['has_access' => true]);
        $admin->givePermissionTo(Permission::findOrCreate('access_orders', 'web'));

        return $admin;
    }

    public function test_the_order_page_shows_the_customers_name_mobile_and_address_first(): void
    {
        $customer = Customer::create(['full_name' => 'هادی الکترونیک مبین', 'phone' => '09120000017', 'address' => 'تهران، میدان توحید']);
        $order = Order::create(['customer_id' => $customer->id, 'tracking_code' => '17', 'total_price' => 1366300, 'status' => 'pending']);

        $html = $this->actingAs($this->admin())->get('/admin/orders/'.$order->id.'/edit')
            ->assertOk()
            ->assertSeeInOrder(['پروفایل خریدار', 'هادی الکترونیک مبین', '09120000017', 'تهران، میدان توحید', 'اقدام ادمین'])
            ->getContent();

        // no landline or profile photo
        $this->assertStringNotContainsString('شماره تماس', $html);
        $this->assertStringNotContainsString('عکس پروفایل', $html);
    }

    public function test_a_customer_without_an_address_shows_a_dash_and_the_order_still_saves(): void
    {
        $customer = Customer::create(['full_name' => 'مشتری بدون آدرس', 'phone' => '09120000018']);
        $order = Order::create(['customer_id' => $customer->id, 'tracking_code' => '18', 'total_price' => 1000, 'status' => 'pending']);

        $this->actingAs($this->admin());

        Livewire::test(EditOrder::class, ['record' => $order->getRouteKey()])
            ->assertSee('مشتری بدون آدرس')
            ->fillForm(['admin_notes' => 'تماس گرفته شد'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('تماس گرفته شد', $order->fresh()->admin_notes);
        $this->assertNull($customer->fresh()->address, 'the profile section does not write to the customer');
    }
}
