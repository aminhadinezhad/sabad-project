<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Support\PersianDate;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $products = Product::count();

        return [
            Stat::make('تعداد کالا', $products)
                ->description($products > 0 ? 'کالاهای جدید ثبت شده در سیستم' : 'هنوز چیزی ثبت نشده')
                ->descriptionIcon('heroicon-o-cube-transparent', IconPosition::Before)
                ->color('gray')
                ->chart($this->getMonthlyTrend(Product::class)),

            Stat::make('تعداد سفارشات', Order::count())
                ->description('روند سه ماهه ثبت سفارش')
                ->descriptionIcon('heroicon-o-clock', IconPosition::Before)
                ->color('warning')
                ->chart($this->getMonthlyTrend(Order::class)),

            Stat::make('تعداد مشتریان', Customer::count())
                ->description('روند سه ماهه ثبت نام مشتری')
                ->descriptionIcon('heroicon-o-user-plus', IconPosition::Before)
                ->color('primary')
                ->chart($this->getMonthlyTrend(Customer::class)),
        ];
    }

    private function getMonthlyTrend(string $modelClass): array
    {
        // months by Tehran time: the stored UTC time is moved to Tehran before it is grouped
        $months = collect(range(2, 0))->map(fn ($i) => Carbon::now(PersianDate::TIMEZONE)->subMonths($i)->format('Y-m'));
        $offset = PersianDate::offsetMinutes();

        $counts = $modelClass::query()
            ->selectRaw("strftime('%Y-%m', created_at, '{$offset} minutes') as month, count(*) as count")
            ->groupBy('month')
            ->pluck('count', 'month');

        return $months->map(fn ($month) => $counts[$month] ?? 0)->toArray();
    }
}
