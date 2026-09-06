<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('تعداد کالا', 0)
                ->description('هنوز چیزی ثبت نشده')
                ->descriptionIcon('heroicon-o-cube-transparent', IconPosition::Before)
                ->color('gray')
                ->chart([0, 0, 0]),

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
        $months = collect(range(2, 0))->map(fn($i) => Carbon::now()->subMonths($i)->format('Y-m'));

        $counts = $modelClass::query()
            ->selectRaw("strftime('%Y-%m', created_at) as month, count(*) as count")
            ->groupBy('month')
            ->pluck('count', 'month');

        return $months->map(fn($month) => $counts[$month] ?? 0)->toArray();
    }
}
