<?php

namespace App\Filament\Widgets;

use App\Models\Trainee;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('dashboard.The number of users'), User::count())
                ->description('new users')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->chart([1, 3, 6, 7, 8, 12])
                ->color('success'),
            Stat::make(__('dashboard.The number of trainees'), Trainee::count())
                ->description('new users')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->chart([1, 3, 6, 7, 8, 12])
                ->color('success')
        ];
    }
}
