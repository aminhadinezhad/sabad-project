<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Helpers\PersianHelper;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // ۱. اعتبارسنجی اطلاعات ورودی
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string|max:500',
            'items'     => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        // ۲. پیدا کردن یا ساختن مشتری بر اساس شماره تلفن
        $customer = Customer::updateOrCreate(
            ['phone' => $validated['phone']],
            [
                'full_name' => $validated['full_name'],
                'address'   => $validated['address'] ?? null,
            ]
        );

        // ۳. محاسبه‌ی جمع کل قیمت
        $totalPrice = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        // ۴. ساخت سفارش
        $order = Order::create([
            'customer_id'   => $customer->id,
            'tracking_code' => '0',
            'total_price'   => $totalPrice,
            'status'        => 'pending',
        ]);

        // به‌روز‌رسانی tracking_code با order ID
        $order->update(['tracking_code' => (string) $order->id]);

        // ۵. ذخیره‌ی آیتم‌های سفارش
        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_name' => $item['product_name'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
            ]);
        }

        // ۶. ریدایرکت به صفحه‌ی موفقیت
        return redirect()->route('orders.success', ['trackingCode' => $order->tracking_code]);
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string|max:500',
            'items'     => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        $totalPrice = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        return view('invoice.show', [
            'customer'      => $validated,
            'items'         => $validated['items'],
            'totalPrice'    => $totalPrice,
            'trackingCode'  => null,
            'orderDate'     => \Morilog\Jalali\Jalalian::now(new \DateTimeZone('Asia/Tehran'))->format('l، Y/m/d H:i'),
            'proformaUrl'   => url()->current(),
            'amountInWords' => PersianHelper::numberToPersianWords($totalPrice),
        ]);
    }

    public function success($trackingCode)
    {
        $order = Order::where('tracking_code', $trackingCode)->firstOrFail();
        $items = $order->items()->get();

        return view('orders.success', ['order' => $order, 'items' => $items]);
    }

    public function invoice(Order $order)
    {
        $items = $order->items->map(function ($item) {
            return [
                'product_code' => null,
                'product_name' => $item->product_name,
                'quantity'     => $item->quantity,
                'unit_price'   => $item->unit_price,
                'tax'          => $item->vat_amount ?? 0,
            ];
        })->toArray();

        return view('invoice.show', [
            'orderDate'     => \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('l، Y/m/d H:i'),
            'trackingCode'  => $order->tracking_code,
            'customer'      => [
                'full_name' => $order->customer->full_name,
                'phone'     => $order->customer->phone,
                'address'   => $order->customer->address,
            ],
            'items'         => $items,
            'totalPrice'    => $order->total_price,
            'amountInWords' => PersianHelper::numberToPersianWords($order->total_price),
            'proformaUrl'   => route('orders.invoice', $order),
        ]);
    }
}
