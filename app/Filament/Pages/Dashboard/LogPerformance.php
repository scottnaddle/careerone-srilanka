<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;

class LogPerformance extends Page
{
    protected static ?string $navigationLabel = 'Log Performance';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 5;
    protected static string $view = 'filament.pages.dashboard.log-performance';
}
