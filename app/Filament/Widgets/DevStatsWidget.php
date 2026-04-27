<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DevStatsWidget extends StatsOverviewWidget
{
    protected function getHeading(): ?string
    {
        return __('dashboard.overview.heading');
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('dashboard.overview.users.label'), (string) User::count())
                ->description(__('dashboard.overview.users.description'))
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->url(url('/admin/users')),

            Stat::make(__('dashboard.overview.clients.label'), '0')
                ->description(__('dashboard.overview.clients.description'))
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('gray'),

            Stat::make(__('dashboard.overview.modules.label'), '0')
                ->description(__('dashboard.overview.modules.description'))
                ->descriptionIcon('heroicon-m-puzzle-piece')
                ->color('gray'),

            Stat::make(
                __('dashboard.overview.environment.label'),
                ucfirst((string) config('app.env')),
            )
                ->description(__('dashboard.overview.environment.description', [
                    'laravel' => app()->version(),
                    'php' => PHP_VERSION,
                ]))
                ->descriptionIcon('heroicon-m-bolt')
                ->color('success'),
        ];
    }
}
