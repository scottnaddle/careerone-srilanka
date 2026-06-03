<?php

namespace App\Filament\Pages\Information;

use Filament\Pages\Page;

class Contents extends Page
{
    protected static ?string $navigationLabel = 'Information';
    protected static ?string $navigationGroup = 'Contents';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.information.contents';
}
