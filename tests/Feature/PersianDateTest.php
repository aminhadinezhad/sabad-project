<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Support\PersianDate;
use Filament\Facades\Filament;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PersianDateTest extends TestCase
{
    use RefreshDatabase;

    public function test_stored_utc_times_are_shown_in_tehran_time(): void
    {
        // stored as the app keeps it (UTC): Thursday 2026-09-24 22:00, which is 01:30 on Friday in Tehran
        $stored = Carbon::parse('2026-09-24 22:00:00', 'UTC');

        $this->assertSame('1405/07/03', PersianDate::date($stored), 'past midnight in Tehran it is already the next day');
        $this->assertSame('جمعه، 1405/07/03 01:30', PersianDate::dateTime($stored));
    }

    public function test_a_daytime_order_keeps_its_day_and_moves_its_hour(): void
    {
        $stored = Carbon::parse('2026-09-22 10:00:00', 'UTC');

        // 10:00 UTC is 13:30 in Tehran; Tuesday is written without a half-space
        $this->assertSame('سه شنبه، 1405/06/31 13:30', PersianDate::dateTime($stored));
    }

    public function test_empty_values_show_nothing(): void
    {
        $this->assertSame('', PersianDate::date(null));
        $this->assertSame('', PersianDate::dateTime(''));
    }

    public function test_the_printed_invoice_shows_the_order_time_in_tehran(): void
    {
        $customer = Customer::create(['full_name' => 'مشتری آزمایشی', 'phone' => '09120000000']);
        $order = Order::create(['customer_id' => $customer->id, 'tracking_code' => '1', 'total_price' => 1000, 'status' => 'pending']);

        // placed at 01:30 on Friday, Tehran time, and stored in UTC as the app does
        $order->forceFill(['created_at' => Carbon::parse('2026-09-24 22:00:00', 'UTC')])->saveQuietly();

        // the invoice prints Persian digits
        $this->get(route('orders.invoice', $order))
            ->assertOk()
            ->assertSee('۱۴۰۵/۰۷/۰۳ ۰۱:۳۰')
            ->assertDontSee('۱۴۰۵/۰۷/۰۲ ۲۲:۰۰');
    }

    public function test_every_admin_list_shows_tehran_dates(): void
    {
        Filament::setCurrentPanel('admin');

        $admin = User::factory()->create(['has_access' => true]);
        foreach (['access_orders', 'access_products', 'access_customers', 'access_admins'] as $name) {
            $admin->givePermissionTo(Permission::findOrCreate($name, 'web'));
        }

        $customer = Customer::create(['full_name' => 'مشتری آزمایشی', 'phone' => '09120000001']);
        $order = Order::create(['customer_id' => $customer->id, 'tracking_code' => '2', 'total_price' => 1000, 'status' => 'pending']);
        $order->forceFill(['created_at' => Carbon::parse('2026-09-24 22:00:00', 'UTC')])->saveQuietly();

        $this->actingAs($admin);

        // each list renders its date column through PersianDate; the order placed at 01:30 Tehran
        // time on Friday shows Friday's date
        $this->get('/admin/orders')->assertOk()->assertSee('1405/07/03');
        $this->get('/admin/products')->assertOk();
        $this->get('/admin/customers')->assertOk();
        $this->get('/admin/users')->assertOk();
        $this->get('/admin/orders/'.$order->id.'/edit')->assertOk();
    }

    public function test_tehran_is_three_and_a_half_hours_ahead(): void
    {
        $this->assertSame(210, PersianDate::offsetMinutes());
    }
}
