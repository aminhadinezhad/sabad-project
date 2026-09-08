<link href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

<style>
    :root {
        --brand-primary: #164194;
        --brand-primary-dark: #0f3170;
        --brand-complementary: #f18815;
        --brand-neutral: #c6c6c6;
        --brand-bg: #f6f6f6;
        --brand-white: #ffffff;
        --radius-lg: 20px;
        --radius-md: 14px;
        --mobile-width: 512px;
    }

    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100%;
    }

    body {
        font-family: 'Kalameh', Tahoma, sans-serif;
        /* background-color: #dfe3e8; */
        direction: rtl;
        display: flex;
        justify-content: center;
        min-height: 100vh;
        min-height: 100dvh;
    }

    /* ===== قاب موبایل ===== */
    .mobile-viewport {
        width: 100%;
        min-height: 100vh;
        min-height: 100dvh;
        background-color: var(--brand-bg);
        position: relative;
        padding-bottom: 90px;
    }

    /* ===== Menu Overlay ===== */
    .menu-overlay {
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-color: var(--brand-bg);
        z-index: 100;
        display: flex;
        flex-direction: column;
        visibility: hidden;
        transform: translateX(100%);
        transition: all 0.2s ease-in-out;
    }

    /* فقط از این عرض به بالا (دسکتاپ/تبلت)، محدود و وسط‌چین بشه */
    @media (min-width: 480px) {
        .mobile-viewport {
            max-width: var(--mobile-width);
            /* box-shadow: 0 0 40px rgba(0, 0, 0, 0.08); */
        }

        .bottom-nav {
            max-width: calc(var(--mobile-width) - 32px);
        }

        .menu-overlay {
            max-width: var(--mobile-width);
            right: calc(50% - (var(--mobile-width) / 2));
            transition: all 0s ease-in-out !important;
        }
    }

    /* ===== Glass effect ===== */
    .glass-panel {
        background-color: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 30px rgba(22, 65, 148, 0.08);
    }

    /* ===== Logo row ===== */
    .site-header__logo img {
        height: 60px;
        width: auto;
        display: block;
    }

    /* ===== Slider ===== */
    .slider {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        min-height: 220px;
        touch-action: pan-y;
        user-select: none;
    }

    .slider.dragging {
        cursor: grabbing;
    }

    .slider__track {
        display: flex;
        height: 100%;
        transition: transform 0.4s ease-in-out;
    }

    .slider__slide {
        min-width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        padding: 24px;
        color: var(--brand-white);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        user-select: none;
    }

    .slide-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        -webkit-user-drag: none;
        user-drag: none;
        pointer-events: none;
    }

    .slider__slide-content {
        position: relative;
        z-index: 1;
    }

    .slider__slide-content h2 {
        font-size: 19px;
        font-weight: 700;
    }

    .slider__slide-content p {
        font-size: 13px;
        line-height: 1.6;
        opacity: 0.9;
    }

    .slider__cta {
        display: inline-block;
        background-color: var(--brand-complementary);
        color: var(--brand-white);
        border-radius: 999px;
        padding: 8px 20px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: filter 0.2s, transform 0.2s;
    }

    .slider__cta:hover {
        filter: brightness(0.93);
        transform: translateY(-1px);
        color: var(--brand-white);
    }

    .slider__dots {
        position: absolute;
        bottom: 12px;
        right: 50%;
        transform: translateX(50%);
        z-index: 2;
    }

    .slider__dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
        padding: 0;
        transition: background-color 0.2s, width 0.2s;
    }

    .slider__dot--active {
        background-color: var(--brand-white);
        width: 18px;
        border-radius: 999px;
    }

    /* ===== Bottom Nav ===== */
    .bottom-nav {
        position: fixed;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 32px);
        z-index: 200;
        border-radius: 999px;
        padding: 12px 16px calc(12px + env(safe-area-inset-bottom));
    }

    .bottom-nav__item {
        color: #777;
        font-size: 10px;
        font-weight: 500;
        position: relative;
        text-decoration: none;
    }

    .bottom-nav__item svg {
        width: 21px;
        height: 21px;
    }

    .bottom-nav__item--active {
        color: var(--brand-primary);
        font-weight: 700;
    }

    .bottom-nav__badge {
        top: -4px;
        left: 8px;
        background-color: var(--brand-complementary);
        color: var(--brand-white);
        font-size: 9px;
        font-weight: 700;
        min-width: 14px;
        height: 14px;
    }

    /* ===== Menu Overlay: Header ===== */
    .menu-overlay.active {
        visibility: visible;
        transform: translateX(0);
    }

    .menu-overlay__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
    }

    .menu-overlay__title {
        font-size: 14px;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .menu-overlay__close {
        background: none;
        border: none;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        cursor: pointer;
    }

    .menu-overlay__body {
        flex: 1;
        display: flex;
        overflow: hidden;
    }

    /* ===== Menu Overlay: Sidebar دسته‌ها ===== */
    .menu-overlay__sidebar {
        width: 90px;
        flex-shrink: 0;
        border-left: 1px solid #eee;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .menu-overlay__cat-btn {
        border: none;
        background: none;
        color: var(--brand-primary-dark);
        width: 100%;
        height: 110px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-bottom: 1px solid #f2f2f2;
        cursor: pointer;
        padding: 16px 8px;
    }

    .menu-overlay__cat-btn-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .menu-overlay__cat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f7f7f7;
        padding: 8px;
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }

    .menu-overlay__cat-icon svg {
        width: 20px;
        height: 20px;
    }

    .menu-overlay__cat-btn.active .menu-overlay__cat-icon {
        background: #fff !important;
        border: 1px solid var(--brand-primary);
    }

    .menu-overlay__cat-label {
        font-size: 11px;
        font-weight: 600;
        color: #333;
        text-align: center;
    }

    /* ===== Menu Overlay: Content ===== */
    .menu-overlay__content {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
    }

    .menu-overlay__product-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: none;
        flex-direction: column;
        gap: 14px;
    }

    .menu-overlay__product-list.active {
        display: flex;
    }

    .menu-overlay__product-list li a {
        text-decoration: none;
        color: var(--brand-primary-dark);
        font-size: 13px;
        font-weight: 500;
    }
</style>

<div class="mobile-viewport">
    <!-- ردیف لوگو -->
    <nav class="px-3 pt-3 d-flex justify-content-center align-items-center">
        <a href="" target="" class="site-header__logo">
            <img src="{{ asset('assets/images/TopLogo-01.png') }}" alt="لوگو فروشگاه">
        </a>
    </nav>

    <!-- بنر -->
    <section class="px-3 mt-4">
        <div class="slider" id="mainSlider">
            <div class="slider__track" id="sliderTrack">
                <a href="" class="slider__slide">
                    <img src="{{ asset('assets/images/WebPage-Temp-Slider-01.jpg') }}" class="slide-bg" alt="بنر فروشگاه">
                </a>

                <a href="" class="slider__slide">
                    <img src="{{ asset('assets/images/WebPage-Temp-Slider-02.jpg') }}" class="slide-bg" alt="بنر فروشگاه">
                </a>

                 <a href="" class="slider__slide">
                    <img src="{{ asset('assets/images/WebPage-Temp-Slider-03.jpg') }}" class="slide-bg" alt="بنر فروشگاه">
                </a>

                 <a href="" class="slider__slide">
                    <img src="{{ asset('assets/images/WebPage-Temp-Slider-04.jpg') }}" class="slide-bg" alt="بنر فروشگاه">
                </a>

                 <a href="" class="slider__slide">
                    <img src="{{ asset('assets/images/WebPage-Temp-Slider-05.jpg') }}" class="slide-bg" alt="بنر فروشگاه">
                </a>
            </div>
            <div class="slider__dots d-flex gap-2" id="sliderDots"></div>
        </div>
    </section>

    <!-- منوی دسته‌بندی (اورلی تمام‌صفحه) -->
    <div class="menu-overlay" id="menuOverlay">
        <div class="menu-overlay__header">
            <div style="width: 36px;"></div>
            <h3 class="menu-overlay__title">دسته‌بندی محصولات</h3>
            <button class="menu-overlay__close" id="closeMenuOverlay">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L12 12M12 12L6 18M12 12L18 18M12 12L6 6"></path>
                </svg>
            </button>
        </div>

        <div class="menu-overlay__body">
            <div class="menu-overlay__sidebar">
                <button class="menu-overlay__cat-btn active" data-target="cat-rice">
                    <div class="menu-overlay__cat-btn-inner">
                        <div class="menu-overlay__cat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round">
                                <path d="M3.91145 12H18.0886C19.6914 12 20.2786 12.3707 19.8787 13.9821C19.1733 16.8246 17.1759 17.5306 15.3304 19.3859C14.8819 19.8369 15.5798 20.5032 15.5802 20.9992C15.5809 21.933 14.6928 22 13.9854 22H8.0146C7.30717 22 6.41908 21.933 6.41982 20.9992C6.4202 20.5137 7.0972 19.8159 6.66957 19.3859C4.82407 17.5306 2.82674 16.8246 2.12128 13.9821C1.72136 12.3707 2.30857 12 3.91145 12Z"></path>
                                <path d="M18.5 12C18.5 10.2089 16.6001 8.98823 15 9.69218M10 6.96519C9.64708 6.49221 9.13252 6.14848 8.53891 6.01716C6.62631 5.59405 4.90104 7.65834 5.7151 9.49889C4.46855 9.64127 3.5 10.7067 3.5 12M16.292 9.48272C17.0733 7.68217 15.4185 5.58415 13.4611 6.01716C12.9848 3.32761 9.01516 3.32761 8.53891 6.01716" stroke-linecap="round"></path>
                                <path d="M17 9L22 3" stroke-linecap="round"></path>
                                <path d="M16 6L18 2" stroke-linecap="round"></path>
                            </svg>
                        </div>
                        <span class="menu-overlay__cat-label">برنج</span>
                    </div>
                </button>

                <button class="menu-overlay__cat-btn" data-target="cat-legumes">
                    <div class="menu-overlay__cat-btn-inner">
                        <div class="menu-overlay__cat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16.5751 3.08979C13.6421 2.55106 10.8277 4.49201 10.289 7.42494C10.0234 8.87061 8.87061 10.0234 7.42494 10.289C4.49201 10.8277 2.55106 13.6421 3.08979 16.5751C3.62852 19.508 6.44296 21.4489 9.37589 20.9102C15.2312 19.8347 19.8347 15.2312 20.9102 9.37589C21.4489 6.44296 19.508 3.62852 16.5751 3.08979Z"></path>
                                <path d="M11.1734 5.64062C12.2727 6.35349 13 7.59141 13 8.99919C13 11.2083 11.2091 12.9992 8.99998 12.9992C7.5922 12.9992 6.35428 12.2719 5.64142 11.1726"></path>
                            </svg>
                        </div>
                        <span class="menu-overlay__cat-label">حبوبات</span>
                    </div>
                </button>

                <button class="menu-overlay__cat-btn" data-target="cat-groceries">
                    <div class="menu-overlay__cat-btn-inner">
                        <div class="menu-overlay__cat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round">
                                <path d="M12.5 4.5H8.5V4C8.5 3.05719 8.5 2.58579 8.79289 2.29289C9.08579 2 9.55719 2 10.5 2C11.4428 2 11.9142 2 12.2071 2.29289C12.5 2.58579 12.5 3.05719 12.5 4V4.5Z"></path>
                                <path d="M18 18V10.5227C18 7.39489 15.6149 4.78318 12.5 4.5H8.5C8.5 4.56544 8.5 4.59817 8.49959 4.63031C8.4881 5.52366 8.23745 6.39762 7.77372 7.16128C7.75703 7.18875 7.73968 7.2165 7.705 7.272L7.36364 7.81818C6.91572 8.53486 6.69175 8.8932 6.52218 9.27262C6.29168 9.78836 6.13518 10.3341 6.0573 10.8936C6 11.3052 6 11.7278 6 12.5729V18C6 19.8856 6 20.8284 6.58579 21.4142C7.17157 22 8.11438 22 10 22H14C15.8856 22 16.8284 22 17.4142 21.4142C18 20.8284 18 19.8856 18 18Z"></path>
                                <path d="M15.011 8.51372C15.6812 9.68758 15.6598 10.9688 14.9634 11.3755C14.267 11.7821 13.1591 11.1602 12.489 9.98628C11.8188 8.81242 11.8402 7.53117 12.5366 7.12453C13.233 6.71789 14.3409 7.33985 15.011 8.51372Z"></path>
                            </svg>
                        </div>
                        <span class="menu-overlay__cat-label">خواربار</span>
                    </div>
                </button>
            </div>

            <div class="menu-overlay__content">
                <ul class="menu-overlay__product-list active" id="cat-rice">
                    @foreach ($products->filter(fn ($p) => str_contains($p->name, 'برنج')) as $product)
                        <li><a href="#product-{{ $product->id }}">{{ $product->name }}</a></li>
                    @endforeach
                </ul>

                <ul class="menu-overlay__product-list" id="cat-legumes">
                    @foreach ($products->filter(fn ($p) => str_contains($p->name, 'لوبیا') || str_contains($p->name, 'نخود') || str_contains($p->name, 'لپه') || str_contains($p->name, 'عدس')) as $product)
                        <li><a href="#product-{{ $product->id }}">{{ $product->name }}</a></li>
                    @endforeach
                </ul>

                <ul class="menu-overlay__product-list" id="cat-groceries">
                    @foreach ($products->filter(fn ($p) => str_contains($p->name, 'تن') || str_contains($p->name, 'روغن') || str_contains($p->name, 'رب')) as $product)
                        <li><a href="#product-{{ $product->id }}">{{ $product->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- نوار پایین -->
    <nav class="bottom-nav glass-panel d-flex justify-content-around align-items-center">
        <a href="{{ route('products.index') }}" class="bottom-nav__item bottom-nav__item--active d-flex flex-column align-items-center gap-1">
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" color="currentColor" fill="none" stroke="rgb(159, 159, 169)">
                <path d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" stroke-width="1.5"></path>
                <path d="M12 15L12 18" stroke-width="1.5" stroke-linecap="round"></path>
              </svg>
            <span>خانه</span>
        </a>

        <a href="#" class="bottom-nav__item open-categories-trigger d-flex flex-column align-items-center gap-1">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span>دسته بندی</span>
        </a>

        <a href="{{ route('cart.index') }}" class="bottom-nav__item d-flex flex-column align-items-center gap-1 position-relative">
            <svg width="24" height="24" viewBox="0 0 24 24" color="currentColor" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 3L2.26491 3.0883C3.58495 3.52832 4.24497 3.74832 4.62248 4.2721C5 4.79587 5 5.49159 5 6.88304V9.5C5 12.3284 5 13.7426 5.87868 14.6213C6.75736 15.5 8.17157 15.5 11 15.5H19" stroke-width="1.5" stroke-linecap="round"></path>
                  <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" stroke-width="1.5"></path>
                  <path d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" stroke-width="1.5"></path>
                  <path d="M11 9H8" stroke-width="1.5" stroke-linecap="round"></path>
                  <path d="M5 6H16.4504C18.5054 6 19.5328 6 19.9775 6.67426C20.4221 7.34853 20.0173 8.29294 19.2078 10.1818L18.7792 11.1818C18.4013 12.0636 18.2123 12.5045 17.8366 12.7523C17.4609 13 16.9812 13 16.0218 13H5" stroke-width="1.5"></path>
                </svg>
            <span>سبد خرید</span>
            <span class="bottom-nav__badge position-absolute rounded-circle d-none align-items-center justify-content-center" id="cart-count-mobile">0</span>
        </a>

        <a href="#" class="bottom-nav__item d-flex flex-column align-items-center gap-1">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span>ورود</span>
        </a>
    </nav>

    <script>
        (function () {
            const slider = document.getElementById('mainSlider');
            const track = document.getElementById('sliderTrack');
            const dotsContainer = document.getElementById('sliderDots');
            const slides = track.children;
            const totalSlides = slides.length;
            let currentIndex = 0;
            let autoplayTimer = null;

            const menuOverlay = document.getElementById('menuOverlay');
            const closeMenuOverlay = document.getElementById('closeMenuOverlay');
            const catButtons = document.querySelectorAll('.menu-overlay__cat-btn');
            const productLists = document.querySelectorAll('.menu-overlay__product-list');

            function renderDots() {
                dotsContainer.innerHTML = '';
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('button');
                    dot.className = 'slider__dot' + (i === currentIndex ? ' slider__dot--active' : '');
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
            }

            function goToSlide(index) {
                currentIndex = (index + totalSlides) % totalSlides;
                track.style.transform = `translateX(${currentIndex * 100}%)`;
                renderDots();
                resetAutoplay();
            }

            function nextSlide() {
                goToSlide(currentIndex + 1);
            }

            function resetAutoplay() {
                clearInterval(autoplayTimer);
                autoplayTimer = setInterval(nextSlide, 4000);
            }

            /* ===== Touch (موبایل) ===== */
            let startX = 0;
            let startY = 0;
            let touchDragDistance = 0;
            let isSwiping = false;

            track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                touchDragDistance = 0;
                isSwiping = false;
            }, { passive: true });

            track.addEventListener('touchmove', (e) => {
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            const diffX = currentX - startX;
            const diffY = currentY - startY;

            // فقط وقتی حرکت افقی از عمودی بیشتره، به‌عنوان سوایپ اسلایدر در نظر بگیر
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 10) {
                isSwiping = true;
                touchDragDistance = diffX;
                e.preventDefault(); // جلوگیری از اسکرول عمودی صفحه حین سوایپ افقی
            }
                }, { passive: false });

            track.addEventListener('touchend', (e) => {
                if (!isSwiping) {
                    // این یه Tap واقعی بود، نه سوایپ — بذار لینک عادی کار کنه
                    return;
                }

                const diff = -touchDragDistance;

                if (Math.abs(diff) >= 50) {
                    if (diff > 0) {
                        goToSlide(currentIndex - 1);
                    } else {
                        goToSlide(currentIndex + 1);
                    }
                }

                isSwiping = false;
            }, { passive: true });

            /* جلوگیری از کلیک مجازی (ghost click) بعد از سوایپ واقعی روی موبایل */
            Array.from(slides).forEach((slide) => {
                slide.addEventListener('click', (e) => {
                    if (Math.abs(touchDragDistance) > 10 || Math.abs(mouseDragDistance) > 10) {
                        e.preventDefault();
                    }
                });
            });

            /* ===== Mouse (دسکتاپ) ===== */
            let mouseDown = false;
            let mouseStartX = 0;
            let mouseDragDistance = 0;

            track.addEventListener('mousedown', (e) => {
                mouseDown = true;
                mouseStartX = e.clientX;
                mouseDragDistance = 0;
                slider.classList.add('dragging');
                e.preventDefault();
            });

            document.addEventListener('mousemove', (e) => {
                if (!mouseDown) return;
                mouseDragDistance = e.clientX - mouseStartX;
            });

            document.addEventListener('mouseup', (e) => {
                if (!mouseDown) return;
                mouseDown = false;
                slider.classList.remove('dragging');

                const diff = mouseStartX - e.clientX;

                if (Math.abs(diff) < 50) return;

                if (diff > 0) {
                    goToSlide(currentIndex - 1);
                } else {
                    goToSlide(currentIndex + 1);
                }
            });

            renderDots();
            resetAutoplay();

            /* ===== منوی دسته‌بندی ===== */
            document.querySelectorAll('.open-categories-trigger').forEach((trigger) => {
                trigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    menuOverlay.classList.toggle('active');
                });
            });

            closeMenuOverlay.addEventListener('click', function () {
                menuOverlay.classList.remove('active');
            });

            catButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    catButtons.forEach((b) => b.classList.remove('active'));
                    btn.classList.add('active');

                    const targetId = btn.dataset.target;
                    productLists.forEach((list) => {
                        list.classList.toggle('active', list.id === targetId);
                    });
                });
            });

            productLists.forEach((list) => {
                list.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', function () {
                        menuOverlay.classList.remove('active');
                    });
                });
            });
        })();
    </script>