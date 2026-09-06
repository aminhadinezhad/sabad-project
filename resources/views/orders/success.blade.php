<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سفارش ثبت شد</title>
</head>
<body style="text-align:center; margin-top:50px;">
    <h1 style="color: green;">✓ سفارش شما با موفقیت ثبت شد</h1>
    <p>شماره پیگیری شما: <strong>{{ $order->tracking_code }}</strong></p>
    <p>کارشناسان ما به‌زودی با شما تماس خواهند گرفت.</p>
    <a href="{{ route('products.index') }}">بازگشت</a>

    <form id="preview-form" action="{{ route('orders.preview') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="full_name" value="{{ $order->customer->full_name }}">
        <input type="hidden" name="phone" value="{{ $order->customer->phone }}">
        <input type="hidden" name="address" value="{{ $order->customer->address }}">

        @foreach ($items as $index => $item)
            <input type="hidden" name="items[{{ $index }}][product_name]" value="{{ $item->product_name }}">
            <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
            <input type="hidden" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}">
        @endforeach
    </form>

    <div style="margin-top: 30px;">
        <button type="button" onclick="previewInvoice()" style="padding: 10px 20px; cursor: pointer;">مشاهده پیش‌فاکتور</button>
    </div>

    <script>
        localStorage.removeItem('cart');

        function previewInvoice() {
            const form = document.getElementById('preview-form');
            form.target = '_blank';
            form.submit();
        }
    </script>
</body>
</html>

