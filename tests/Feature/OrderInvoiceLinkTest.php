<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OrderInvoiceLinkTest extends TestCase
{
    use RefreshDatabase;

    private function placeOrder(): Order
    {
        $response = $this->post(route('orders.store'), [
            'full_name' => 'امین هادی نژاد',
            'phone' => '09120000018',
            'address' => 'تهران',
            'items' => [
                ['product_name' => 'برنج هاشمی', 'product_code' => '1', 'quantity' => 5, 'unit_price' => 100],
            ],
        ]);

        $order = Order::sole();

        // the customer lands on a signed success page
        $response->assertRedirect($order->successUrl());

        return $order;
    }

    public function test_after_ordering_the_pre_invoice_is_the_saved_order_with_its_number_and_time(): void
    {
        $order = $this->placeOrder();
        $order->forceFill(['created_at' => Carbon::parse('2026-09-24 22:00:00', 'UTC')])->saveQuietly();

        // the success page links to this order's own pre-invoice, not the cart preview
        $this->get($order->successUrl())
            ->assertOk()
            ->assertSee(e($order->invoiceUrl()), false)
            ->assertDontSee(route('orders.preview'), false);

        // it shows the order number, not «پیش فاکتور-جهت اطلاع», and the time it was placed
        $first = $this->get($order->invoiceUrl())->assertOk()->assertSee('۱۴۰۵/۰۷/۰۳ ۰۱:۳۰');
        $this->assertStringNotContainsString('جهت اطلاع', $this->numberCell($first->getContent()));

        // opening it again later shows the same time: it is the order's, not the moment of opening
        $this->travel(3)->hours();
        $this->get($order->invoiceUrl())->assertOk()->assertSee('۱۴۰۵/۰۷/۰۳ ۰۱:۳۰');
    }

    public function test_an_order_cannot_be_read_by_changing_the_number_in_the_address(): void
    {
        $order = $this->placeOrder();
        $other = Order::create(['customer_id' => Customer::sole()->id, 'tracking_code' => '99', 'total_price' => 1, 'status' => 'pending']);

        // without the signature, or with another order's number, the pages do not open
        $this->get('/orders/'.$order->id.'/invoice')->assertForbidden();
        $this->get('/orders/'.$order->tracking_code.'/success')->assertForbidden();
        $this->get(str_replace('/orders/'.$order->id.'/', '/orders/'.$other->id.'/', $order->invoiceUrl()))->assertForbidden();
    }

    /** The cell after «شماره سفارش» on the printed pre-invoice. */
    private function numberCell(string $html): string
    {
        $at = mb_strpos($html, 'شماره سفارش');

        return $at === false ? '' : mb_substr($html, $at, 300);
    }
}
