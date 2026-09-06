<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>سبد خرید</title>
</head>

<body>
    <h1>سبد خرید</h1>

    <table border="1" id="cart-table">
        <thead>
            <tr>
                <th>محصول</th>
                <th>تعداد</th>
                <th>قیمت واحد</th>
                <th>جمع</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="cart-body"></tbody>
    </table>

    <h3>جمع کل: <span id="total-price">0</span> تومان</h3>

    <button id="checkout-btn" onclick="document.getElementById('order-modal').style.display='block'">
        ادامه ثبت سفارش
    </button>

    <!-- Modal -->
    <div id="order-modal" style="display:none; border:1px solid #000; padding:20px; margin-top:20px;">
        <h2>تکمیل اطلاعات سفارش</h2>

        <form id="order-form" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div>
                <label>نام و نام خانوادگی:</label>
                <input type="text" name="full_name" required>
            </div>
            <div>
                <label>شماره تلفن:</label>
                <input type="text" name="phone" required>
            </div>
            <div>
                <label>آدرس:</label>
                <textarea name="address"></textarea>
            </div>

            <div id="hidden-items"></div>

            <button type="submit">ثبت سفارش</button>
        </form>
    </div>

    <script>
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');

        function renderCart() {
            const tbody = document.getElementById('cart-body');
            let total = 0;
            tbody.innerHTML = '';
            cart.forEach((item, index) => {
                const rowTotal = item.quantity * item.unit_price;
                total += rowTotal;
                tbody.innerHTML += `
                    <tr>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_price.toLocaleString()}</td>
                        <td>${rowTotal.toLocaleString()}</td>
                        <td><button onclick="removeFromCart(${index})">حذف</button></td>
                    </tr>`;
            });
            document.getElementById('total-price').innerText = total.toLocaleString();

            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.style.display = cart.length > 0 ? 'inline-block' : 'none';
        }
        renderCart();

        function removeFromCart(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            fillHiddenItems();
        }

        function fillHiddenItems() {
            const container = document.getElementById('hidden-items');
            container.innerHTML = '';
            cart.forEach((item, index) => {
                container.innerHTML += `
                    <input type="hidden" name="items[${index}][product_name]" value="${item.product_name}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    <input type="hidden" name="items[${index}][unit_price]" value="${item.unit_price}">
                `;
            });
        }
        fillHiddenItems();
    </script>
</body>

</html>