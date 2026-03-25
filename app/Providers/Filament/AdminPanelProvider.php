<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\HtmlString; // Tambahkan ini untuk custom logo HTML

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('pengurus-ppalamin')
            ->login()
            
            // Branding & Estetika (Logo + Teks Berdampingan)
            ->brandName('Ponpes Al-Amin')
            ->brandLogo(fn () => new HtmlString('
                <div class="flex items-center gap-3">
                    <img src="' . asset('images/logo-ponpes.png') . '" class="h-10 w-10 object-contain" alt="Logo Ponpes">
                    <span class="text-xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">Ponpes Al-Amin</span>
                </div>
            '))
            ->favicon(asset('images/logo-ponpes.png'))
            
            // Warna Tema Emerald (Hijau Modern)
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->font('Inter')
            
            // Fitur User Experience
            ->sidebarCollapsibleOnDesktop() 
            ->maxContentWidth(MaxWidth::Full)
            ->spa() 
            ->databaseNotifications()
            
            // Pengelompokan Menu
            ->navigationGroups([
                NavigationGroup::make()->label('Transaksi')->icon('heroicon-o-banknotes'),
                NavigationGroup::make()->label('Master Data')->icon('heroicon-o-folder'),
                NavigationGroup::make()->label('Konten Web')->icon('heroicon-o-globe-alt'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\DashboardStats::class, // Sesuaikan ke DashboardStats
                \App\Filament\Widgets\PemasukanSppChart::class,
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
            ]);
    }
}