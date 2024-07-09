<?php

namespace App\Providers\Filament;

use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
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
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.users_management'))
                    ->icon('heroicon-o-users')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.reports_management'))
                    ->icon('heroicon-o-flag')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.trainings_management'))
                    ->icon('heroicon-o-book-open')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.trainees_management'))
                    ->icon('heroicon-o-user-circle')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.subscribtions_management'))
                    ->icon('heroicon-o-inbox-stack')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.coupons_management'))
                    ->icon('heroicon-o-receipt-percent')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.ratings_management'))
                    ->icon('heroicon-o-star')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(fn (): string => __('dashboard.levels_management'))
                    ->icon('heroicon-o-list-bullet')
                    ->collapsed(),
            ])
            ->sidebarFullyCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
