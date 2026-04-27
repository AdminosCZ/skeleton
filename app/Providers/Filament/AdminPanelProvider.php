<?php

namespace App\Providers\Filament;

use Adminos\Modules\Feedmanager\Filament\FeedmanagerPlugin;
use App\Filament\Widgets\DevStatsWidget;
use App\Http\Middleware\SetApplicationLocale;
use App\Models\Setting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
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
            ->profile(\App\Filament\Pages\Auth\EditProfile::class, isSimple: false)
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('13rem')
            ->brandName('ADMINOS')
            ->brandLogo(fn (): string => self::brandingAsset('logo_light_path', 'branding/adminos-logo.png'))
            ->darkModeBrandLogo(fn (): string => self::brandingAsset(
                'logo_dark_path',
                'branding/adminos-logo-dark.png',
                fallbackKey: 'logo_light_path',
            ))
            ->brandLogoHeight('1.85rem')
            ->favicon(fn (): string => self::brandingAsset('favicon_path', 'favicon.svg'))
            ->colors([
                'primary' => Color::hex(\App\Filament\Pages\Settings\Branding::activeLightPrimary()),
                'gray' => Color::Slate,
                'success' => Color::hex('#22C55E'),
                'danger' => Color::hex('#EB4143'),
                'warning' => Color::hex('#F4B301'),
            ])
            ->darkMode()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                DevStatsWidget::class,
            ])
            ->plugins([
                FeedmanagerPlugin::make(),
            ])
            ->renderHook(
                PanelsRenderHook::TOPBAR_LOGO_AFTER,
                fn (): View => view('filament.topbar.widgets'),
            )
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): View => view('filament.footer'),
            )
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): View => view('filament.dynamic-theme'),
            )
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
                SetApplicationLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Resolve a branding asset URL: client upload (if set) → fallback to bundled default.
     * Optional fallbackKey lets the dark logo fall back to the light upload before the default.
     */
    private static function brandingAsset(string $key, string $defaultAsset, ?string $fallbackKey = null): string
    {
        $path = Setting::get("branding.{$key}");

        if (! $path && $fallbackKey) {
            $path = Setting::get("branding.{$fallbackKey}");
        }

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return asset($defaultAsset);
    }
}
