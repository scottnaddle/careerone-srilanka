<?php

namespace App\Filament\Pages\CareerGuidance;

use Filament\Pages\Page;

class CarrerTest extends Page
{
    protected static ?string $navigationLabel = 'Career Test';
    protected static ?string $navigationGroup = 'Career Guidance';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.career-guidance.carrer-test';
}
