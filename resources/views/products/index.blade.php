<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>محصولات</title>
</head>
<body>
    <h1>محصولات</h1>
    <a href="{{ route('cart.index') }}">🛒 مشاهده سبد خرید</a>

    <div id="products">
        <div class="product" data-name="لپ‌تاپ" data-price="45000000">
            <h3>لپ‌تاپ</h3>
            <p>قیمت: 45,000,000 تومان</p>
            <button onclick="addToCart('لپ‌تاپ', 45000000)">افزودن به سبد</button>
        </div>

        <div class="product" data-name="پرینتر" data-price="12000000">
            <h3>پرینتر</h3>
            <p>قیمت: 12,000,000 تومان</p>
            <button onclick="addToCart('پرینتر', 12000000)">افزودن به سبد</button>
        </div>
    </div>

    <script>
        function addToCart(name, price) {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existing = cart.find(item => item.product_name === name);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ product_name: name, quantity: 1, unit_price: price });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            alert(name + ' به سبد اضافه شد');
        }
    </script>
</body>
</html>