<?php

namespace App\Exports;

use App\Models\CgoUser;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ApprovedCgoUserExporter extends Exporter
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
            ExportColumn::make('counselings_count')
                ->label('Guidance')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->counselings->count();
                }),
            ExportColumn::make('cancel_count')
                ->label('Cancel')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->countCancelCounseling->count() ?? 'N/A';
                }),
            ExportColumn::make('events_count')
                ->label('Event')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->events->count() ?? 'N/A';
                }),
            ExportColumn::make('contents_count')
                ->label('Content')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->contents->count() ?? 'N/A';
                }),
            ExportColumn::make('qna_answers_count')
                ->label('Reply')
                ->getStateUsing(function (CgoUser $record) {
                    return $record->qnaAnswes->count() ?? 'N/A';
                }),
            ExportColumn::make('created_at')
                ->label('Created At')
                ->formatStateUsing(fn ($state) => $state ? $state->format('Y-m-d H:i:s') : ''),
            ExportColumn::make('verify_at')
                ->label('Verified At')
                ->formatStateUsing(function ($state) {
                    if (!$state) return '';

                    try {
                        return \Carbon\Carbon::parse($state)->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        return $state;
                    }
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your approved CGO users export has completed successfully and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
