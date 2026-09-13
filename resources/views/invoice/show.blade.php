<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>@yield('title', 'سبد پیش‌فاکتور')</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('ico/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('ico/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('ico/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('ico/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('ico/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('ico/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('ico/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('ico/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('ico/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('ico/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('ico/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('ico/manifest.json') }}">
    <link href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/pdf-print.css') }}" rel="stylesheet">

    <title>پیش فاکتور سفارش</title>
</head>

<body>
    <div class="container">
        <table class="table mt-5 mb-0 w-100">
            <thead>
                <tr>
                    <td class="no-border">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="color-dark-blue  text-align-center">تاریخ سفارش</td>
                                <td class="color-dark-blue  text-align-center">
                                    {{ \App\Helpers\PersianHelper::toPersianDigits($orderDate) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="color-dark-blue text-align-center">شماره سفارش </td>
                                <td class="color-dark-blue text-align-center">
                                    {{ $trackingCode ? \App\Helpers\PersianHelper::toPersianDigits($trackingCode) : 'پیش فاکتور-جهت اطلاع' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="no-border text-align-center">
                        <img src="{{ asset('assets/images/tf-logo.png') }}" class="img-fluid logo" width="200" alt="لوگو">
                        <br>
                        <div class="text-align-center color-dark-blue"><b>taminfalat.com</b></div>
                    </td>
                    <td class="no-border">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="color-dark-blue text-align-center">روش پرداخت</td>
                                <td class="color-dark-blue text-align-center"> پیش فاکتور-جهت اطلاع
                                </td>
                            </tr>
                            <tr>
                                <td class="color-dark-blue text-align-center">کد پیگیری</td>
                                <td class="color-dark-blue text-align-center">
                                    پیش فاکتور-جهت اطلاع
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
            <tr>
                <table class="table mt-5 w-100">
                    <tr>
                        <td class=""><b>فروشنده</b></td>
                        <td>
                            <table class="table table-sm  w-100 mb-0">
                                <tr>
                                    <td class="no-border">
                                        <b>فروشنده</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        فروشگاه آنلاین تامین فلات
                                    </td>
                                    <td class="no-border">
                                        <b>شناسه ملی</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                    </td>
                                    <td class="no-border">
                                        <b>شماره ثبت</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border">
                                        <b>شماره اقتصادی</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                    </td>
                                    <td class="no-border">
                                        <b>تلفن</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        ۰۲۱۹۱۰۰۱۲۱۴
                                    </td>
                                    <td class="no-border">
                                        <b>فکس</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        ۰۲۱-۴۴۸۵۸۱۴۰
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border">
                                        <b>نشانی شرکت</b>
                                    </td>
                                    <td class="no-border color-dark-blue" colspan="5">
                                        تهران، بزرگراه اشرفی اصفهانی، خیابان عرب حسینی، پلاک ۷۰، طبقه ۱، واحد ۱
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class=""><b>خریدار</b></td>
                        <td>
                            <table class="table table-sm  w-100 mb-0">
                                <tr>
                                    <td class="no-border">
                                        <b>خریدار</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        {{ $customer['full_name'] }}
                                    </td>
                                    <td class="no-border">
                                        <b>کدملی/شناسه ملی</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                    <td class="no-border">
                                        <b>شماره همراه</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        {{ $customer['phone'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border">
                                        <b>شماره تماس در فاکتور</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                    <td class="no-border">
                                        <b>شماره تماس</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                    <td class="no-border">
                                        <b>کد پستی</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border">
                                        <b>کد ارجاع</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                    <td class="no-border">
                                        <b>شماره کارت</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                    <td class="no-border">
                                        <b>بانک</b>
                                    </td>
                                    <td class="no-border color-dark-blue">
                                        پیش فاکتور-جهت اطلاع
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border">
                                        <b>نشانی</b>
                                    </td>
                                    <td class="no-border color-dark-blue" colspan="5">
                                        {{ $customer['address'] ?? 'پیش فاکتور-جهت اطلاع' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr class="bg-grey">
                <th class="bg-grey">ردیف</th>
                <th class="bg-grey">کد کالا</th>
                <th class="bg-grey">شرح کالا</th>
                <th class="bg-grey">تعداد</th>
                <th class="bg-grey">مبلغ واحد (تومان)</th>
                <th class="bg-grey">مبلغ کل (تومان)</th>
                <th class="bg-grey">جمع مالیات و عوارض (تومان)</th>
                <th class="bg-grey">جمع مبلغ کل پس از تخفیف و مالیات و عوارض (تومان)</th>
            </tr>
            <tbody>
                @foreach($items as $index => $item)
                @php
                $rowTotal = $item['quantity'] * $item['unit_price'];
                $rowTax = $item['tax'] ?? 0;
                $rowFinal = $rowTotal + $rowTax;
                @endphp
                <tr>
                    <td>{{ \App\Helpers\PersianHelper::toPersianDigits($index + 1) }}</td>
                    <td>
                        {{ \App\Helpers\PersianHelper::toPersianDigits($item['product_code'] ?? '-') }}
                    </td>
                    <td>{{ $item['product_name'] }}</td>
                    <td class="text-align-center">
                        {{ \App\Helpers\PersianHelper::toPersianDigits($item['quantity']) }}
                    </td>
                    <td class="text-align-center">
                        <strong>{{ \App\Helpers\PersianHelper::toPersianDigits(number_format($item['unit_price'])) }}</strong>
                    </td>
                    <td class="text-align-center">
                        <strong>{{ \App\Helpers\PersianHelper::toPersianDigits(number_format($rowTotal)) }}</strong>
                    </td>
                    <td class="text-align-center">
                        <strong>{{ \App\Helpers\PersianHelper::toPersianDigits(number_format($rowTax)) }}</strong>
                    </td>
                    <td class="text-align-center">
                        <strong>{{ \App\Helpers\PersianHelper::toPersianDigits(number_format($rowFinal)) }}</strong>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td class="bg-grey" colspan="3">
                        جمع نهایی
                    </td>
                    <td class="text-align-center bg-grey">
                        {{ \App\Helpers\PersianHelper::toPersianDigits(collect($items)->sum('quantity')) }}
                    </td>
                    <td class="text-align-center bg-grey" colspan="3">
                        جمع مبلغ کل پس از تخفیف و مالیات و عوارض(تومان)
                    </td>
                    <td class="text-align-center bg-grey">
                        <strong class="very-bold">{{ \App\Helpers\PersianHelper::toPersianDigits(number_format($totalPrice)) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <div>مبلغ به حروف: <b>{{ $amountInWords }}</b></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <div>این پیش فاکتور به درخواست مشتری تهیه و هم اکنون نهایی نشده است. امکان تغییر قیمت محتمل است.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <div>در این پیش فاکتور، به دلیل نهایی نشدن سفارش، <b>هزینه ارسال</b>، محاسبه نشده است و در زمان نهایی شدن به این پیش فاکتور اضافه می شود.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <div>این پیش فاکتور معتبر و در نشانی <b><a href="{{ $proformaUrl }}">{{ $proformaUrl }}</a> </b> قابل دسترس است.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="p-3">
                            <span class="px-2"><strong>مهر و امضای فروشنده</strong></span>
                        </div>
                    </td>
                    <td colspan="5">
                        <div class="p-3">
                            <span><strong class="px-2">مهر و امضای خریدار</strong></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col">
                <b>توضیحات</b>
                <ul>
                    <li class="color-dark-blue">پشتیبانی فروشگاه: ۰۲۱۹۱۰۰۱۲۱۴
                    </li>
                    <li class="color-dark-blue">صدای مشتری: ۰۹۹۹۹۹۲۹۱۱۷
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>