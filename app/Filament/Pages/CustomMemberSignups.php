<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Widgets\PageMemberSignupWidget;

use Filament\Tables\Columns\TextColumn;

class CustomMemberSignups extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public $data;

    protected static string $view = 'filament.pages.custom-member-signups';
    protected ?string $heading = '';
    public function mount()
    {
        $this->data = [
            'start_date' => request()->query('startDate', null),
            'end_date' => request()->query('endDate', null),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            PageMemberSignupWidget::make([
                'data' => $this->data,
            ]),
        ];
    }
}
