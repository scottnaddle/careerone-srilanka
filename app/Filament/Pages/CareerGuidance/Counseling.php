<?php

namespace App\Filament\Pages\CareerGuidance;

use Filament\Pages\Page;

class Counseling extends Page
{
    protected static ?string $navigationLabel = 'Guidance';
    protected static ?string $navigationGroup = 'Career Guidance';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.career-guidance.counseling';
}
