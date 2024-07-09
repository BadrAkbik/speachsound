<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Number of users', User::count())
                ->description('new users')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->chart([1, 3, 6, 7, 8, 12])
                ->color('success')
        ];
    }
}
