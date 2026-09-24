<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AnalyticsHeading;
use App\Filament\Widgets\CompanyInfoWidget;
use App\Filament\Widgets\DashboardStats;
use App\Http\Middleware\SetPanelLocale;
use Filament\FontProviders\LocalFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->font('Kalameh', url: asset('css/fonts.css'), provider: LocalFontProvider::class)
            // sabad is a Tamin Falat service, so it is named as one (login page, panel header, tab title)
            ->brandName('سبد تامین فلات')
            ->favicon(asset('ico/favicon-32x32.png'))
            ->navigationGroups([
                'فروشگاه آنلاین',
                'مدیریت سیستم',
            ])
            ->sidebarCollapsibleOnDesktop()
            ->breadcrumbs(false)
            ->colors([
                'primary' => Color::hex('#164194'),
                'warning' => Color::hex('#f18815'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                CompanyInfoWidget::class,
                AnalyticsHeading::class,
                DashboardStats::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetPanelLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
