<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محصولات</title>
</head>
<body>
    @include('partials.header')
    @include('partials.services-widget')

    <style>
        .products-section {
            padding: 0 16px;
            margin-top: 24px;
        }

        .products-section__title {
            font-size: 16px;
            font-weight: 700;
            color: #222;
            margin: 0 0 12px;
            text-align: center;
        }

        .products-category__title {
            display: flex;
            align-items: center;
            gap: 2px;
            color: #222;
            margin: 0 0 12px;
        }
        .products-category__title>h2 {
            font-size: 15px;
            margin: 0;
        }
        .products-category {
            margin-bottom: 24px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }

        .product-card {
            background-color: var(--brand-white);
            /* border: 1px solid #eee; */
            border-radius: var(--radius-md);
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product-card__name {
            font-size: 12px;
            font-weight: 600;
            color: #222;
            margin: 0;
        }

        .product-card__price {
            font-size: 13px;
            font-weight: 700;
            color: var(--brand-primary);
            margin: 0;
        }

        .product-card__price span {
            font-size: 10px;
            font-weight: 400;
            color: #888;
        }

        .product-card__btn {
            background-color: var(--brand-complementary);
            color: var(--brand-white);
            border: none;
            border-radius: 999px;
            padding: 7px 0;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>

    <section class="products-section">

{{-- <h2 class="products-section__title">محصولات فروشگاه</h2> --}}

<div class="products-category">
    <div class="products-category__title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round">
                                    <path d="M3.91145 12H18.0886C19.6914 12 20.2786 12.3707 19.8787 13.9821C19.1733 16.8246 17.1759 17.5306 15.3304 19.3859C14.8819 19.8369 15.5798 20.5032 15.5802 20.9992C15.5809 21.933 14.6928 22 13.9854 22H8.0146C7.30717 22 6.41908 21.933 6.41982 20.9992C6.4202 20.5137 7.0972 19.8159 6.66957 19.3859C4.82407 17.5306 2.82674 16.8246 2.12128 13.9821C1.72136 12.3707 2.30857 12 3.91145 12Z"></path>
                                    <path d="M18.5 12C18.5 10.2089 16.6001 8.98823 15 9.69218M10 6.96519C9.64708 6.49221 9.13252 6.14848 8.53891 6.01716C6.62631 5.59405 4.90104 7.65834 5.7151 9.49889C4.46855 9.64127 3.5 10.7067 3.5 12M16.292 9.48272C17.0733 7.68217 15.4185 5.58415 13.4611 6.01716C12.9848 3.32761 9.01516 3.32761 8.53891 6.01716" stroke-linecap="round"></path>
                                    <path d="M17 9L22 3" stroke-linecap="round"></path>
                                    <path d="M16 6L18 2" stroke-linecap="round"></path>
                                </svg>
        <h2>برنج</h2>
    </div>
    <div class="products-grid">
        @foreach ($products->where('category', 'rice') as $product)
            <div class="product-card" id="product-{{ $product->id }}">

                @if ($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width:100%; aspect-ratio:1; object-fit:cover; border-radius:8px;"
                    >
                @endif

                <h3 class="product-card__name">
                    {{ $product->name }}
                </h3>

                <p class="product-card__price">
                    {{ number_format($product->price) }}
                    <span>تومان</span>
                </p>

                <button
                    class="product-card__btn"
                    onclick="addToCart('{{ $product->name }}', {{ $product->price }})"
                >
                    افزودن به سبد
                </button>
            </div>
        @endforeach
    </div>
</div>
<div class="products-category">
    <div class="products-category__title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16.5751 3.08979C13.6421 2.55106 10.8277 4.49201 10.289 7.42494C10.0234 8.87061 8.87061 10.0234 7.42494 10.289C4.49201 10.8277 2.55106 13.6421 3.08979 16.5751C3.62852 19.508 6.44296 21.4489 9.37589 20.9102C15.2312 19.8347 19.8347 15.2312 20.9102 9.37589C21.4489 6.44296 19.508 3.62852 16.5751 3.08979Z"></path>
                                <path d="M11.1734 5.64062C12.2727 6.35349 13 7.59141 13 8.99919C13 11.2083 11.2091 12.9992 8.99998 12.9992C7.5922 12.9992 6.35428 12.2719 5.64142 11.1726"></path>
                            </svg>
        <h2>حبوبات</h2>
    </div>
    <div class="products-grid">
        @foreach ($products->where('category', 'legumes') as $product)
            <div class="product-card" id="product-{{ $product->id }}">

                @if ($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width:100%; aspect-ratio:1; object-fit:cover; border-radius:8px;"
                    >
                @endif

                <h3 class="product-card__name">
                    {{ $product->name }}
                </h3>

                <p class="product-card__price">
                    {{ number_format($product->price) }}
                    <span>تومان</span>
                </p>

                <button
                    class="product-card__btn"
                    onclick="addToCart('{{ $product->name }}', {{ $product->price }})"
                >
                    افزودن به سبد
                </button>
            </div>
        @endforeach
    </div>
</div>
<div class="products-category">
    <div class="products-category__title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round">
                                <path d="M12.5 4.5H8.5V4C8.5 3.05719 8.5 2.58579 8.79289 2.29289C9.08579 2 9.55719 2 10.5 2C11.4428 2 11.9142 2 12.2071 2.29289C12.5 2.58579 12.5 3.05719 12.5 4V4.5Z"></path>
                                <path d="M18 18V10.5227C18 7.39489 15.6149 4.78318 12.5 4.5H8.5C8.5 4.56544 8.5 4.59817 8.49959 4.63031C8.4881 5.52366 8.23745 6.39762 7.77372 7.16128C7.75703 7.18875 7.73968 7.2165 7.705 7.272L7.36364 7.81818C6.91572 8.53486 6.69175 8.8932 6.52218 9.27262C6.29168 9.78836 6.13518 10.3341 6.0573 10.8936C6 11.3052 6 11.7278 6 12.5729V18C6 19.8856 6 20.8284 6.58579 21.4142C7.17157 22 8.11438 22 10 22H14C15.8856 22 16.8284 22 17.4142 21.4142C18 20.8284 18 19.8856 18 18Z"></path>
                                <path d="M15.011 8.51372C15.6812 9.68758 15.6598 10.9688 14.9634 11.3755C14.267 11.7821 13.1591 11.1602 12.489 9.98628C11.8188 8.81242 11.8402 7.53117 12.5366 7.12453C13.233 6.71789 14.3409 7.33985 15.011 8.51372Z"></path>
                            </svg>
        <h2>خواربار</h2>
    </div>
    <div class="products-grid">
        @foreach ($products->where('category', 'groceries') as $product)
            <div class="product-card" id="product-{{ $product->id }}">

                @if ($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width:100%; aspect-ratio:1; object-fit:cover; border-radius:8px;"
                    >
                @endif

                <h3 class="product-card__name">
                    {{ $product->name }}
                </h3>

                <p class="product-card__price">
                    {{ number_format($product->price) }}
                    <span>تومان</span>
                </p>

                <button
                    class="product-card__btn"
                    onclick="addToCart('{{ $product->name }}', {{ $product->price }})"
                >
                    افزودن به سبد
                </button>
            </div>
        @endforeach
    </div>
</div>

</section>

    </div> <!-- بستن mobile-viewport -->

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

            const cartCountEl = document.getElementById('cart-count-mobile');
            if (cartCountEl) {
                const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCountEl.textContent = totalQuantity;
                cartCountEl.classList.toggle('d-none', totalQuantity === 0);
                cartCountEl.classList.toggle('d-flex', totalQuantity > 0);
            }

            alert(name + ' به سبد اضافه شد');
        }
    </script>
</body>
</html>