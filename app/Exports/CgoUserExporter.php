<?php

namespace App\Exports;

use App\Models\CgoUser;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CgoUserExporter extends Exporter
{
    protected static ?string $model = CgoUser::class;

    public static function getColumns(): array
    {
        return [
//            ExportColumn::make('id')
//                ->label('ID'),
            ExportColumn::make('first_name')
                ->label('First Name'),
            ExportColumn::make('last_name')
                ->label('Last Name'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('telephone')
                ->label('Telephone'),
            ExportColumn::make('institute.name')
                ->label('Institute'),
            ExportColumn::make('district.name')
                ->label('District'),
            ExportColumn::make('approval_status')
                ->label('Approval Status')
                ->getStateUsing(function (CgoUser $record) {
                    $status = $record->statusCgouser();
                    return match ($status) {
                        'Verified' => 'Verified',
                        'Request' => 'Request',
                        default => 'Rejected',
                    };
                }),
            ExportColumn::make('active')
                ->label('Status')
                ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive'),
            ExportColumn::make('created_at')
                ->label('Created At'),
//            ExportColumn::make('updated_at')
//                ->label('Updated At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your CGO users export has completed successfully and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
