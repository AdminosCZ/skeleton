<?php

namespace App\Providers;

use App\Models\User;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsIconAlias;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('change-app-settings', fn (User $user): bool => $user->canChangeAppSettings());

        FilamentIcon::register([
            PanelsIconAlias::SIDEBAR_COLLAPSE_BUTTON => Heroicon::OutlinedChevronLeft,
            PanelsIconAlias::SIDEBAR_EXPAND_BUTTON => Heroicon::OutlinedChevronRight,
        ]);
    }
}
