<?php

namespace App\Exports;

use App\Models\CgoUser;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Carbon\Carbon;

class CgoApprovalUserExporter extends Exporter
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
            ExportColumn::make('created_at')
                ->label('Requested At')
                ->formatStateUsing(function ($state) {
                    if (!$state) return '';
                    try {
                        return Carbon::parse($state)->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        return $state;
                    }
                }),
            ExportColumn::make('status')
                ->label('Status')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->statusCgouser();
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your CGO approval list export has completed successfully and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
