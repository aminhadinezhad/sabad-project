<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'علی رضایی',
            'phone' => '09121234567',
            'address' => 'تهران',
            'items' => [
                ['product_name' => 'برنج', 'quantity' => 1, 'unit_price' => 1000],
            ],
        ], $overrides);
    }

    public function test_order_is_created_with_valid_data(): void
    {
        $response = $this->post(route('orders.store'), $this->validPayload());

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', ['phone' => '09121234567', 'full_name' => 'علی رضایی']);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_full_name_shorter_than_two_characters_is_rejected(): void
    {
        $response = $this->post(route('orders.store'), $this->validPayload(['full_name' => 'ع']));

        $response->assertSessionHasErrors('full_name');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_phone_not_matching_iranian_format_is_rejected(): void
    {
        $response = $this->post(route('orders.store'), $this->validPayload(['phone' => '0912123456']));
        $response->assertSessionHasErrors('phone');

        $response = $this->post(route('orders.store'), $this->validPayload(['phone' => '08121234567']));
        $response->assertSessionHasErrors('phone');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_phone_typed_with_persian_digits_is_normalized_and_accepted(): void
    {
        $response = $this->post(route('orders.store'), $this->validPayload(['phone' => '۰۹۱۲۱۲۳۴۵۶۷']));

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', ['phone' => '09121234567']);
    }
}
