<?php

namespace App\Exports;

use App\Models\TraineeUser;
use App\Models\AdminUser;
use App\Models\CgoUser;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;

class TraineeExporter extends Exporter
{
    protected static ?string $model = TraineeUser::class;

    // Get the current user from the admin guard
    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth('admin')->user();
    }

    // Modify the query based on access permissions
    public static function modifyQuery(Builder $query): Builder
    {
        $user = auth('admin')->user();

        if (!$user->hasRole('super_admin')) {
            $query->whereHas('institutes', function ($q) use ($user) {
                $q->where('institute_head_office', $user->tvet_type);
            });
        }

        return $query;
    }

    public static function getColumns(): array
    {
        return [
//            ExportColumn::make('id')
//                ->label('ID'),

            ExportColumn::make('nic')
                ->label('NIC'),

            ExportColumn::make('full_name')
                ->label('Full Name'),

            ExportColumn::make('email')
                ->label('Email'),

            ExportColumn::make('gender')
                ->label('Gender')
                ->formatStateUsing(fn ($state) => match ($state) {
                    '1' => 'Male',
                    '2' => 'Female',
                    '3' => 'N/A',
                    default => $state,
                }),

            ExportColumn::make('telephone')
                ->label('Telephone'),

            ExportColumn::make('mobile')
                ->label('Mobile'),

            ExportColumn::make('permanant_address')
                ->label('Permanent Address'),

            ExportColumn::make('contact_address')
                ->label('Contact Address'),

            ExportColumn::make('std_surname')
                ->label('Surname'),

            ExportColumn::make('std_initials')
                ->label('Initials'),

            ExportColumn::make('institutes_info')
                ->label('Institute')
                ->formatStateUsing(function ($record) {
                    $user = auth('admin')->user();

                    $traineeInstitutes = $record->traineeInstitutes()
                        ->with('institute')
                        ->when(!$user->hasRole('super_admin'), function ($query) use ($user) {
                            $query->whereHas('institute', function ($q) use ($user) {
                                $q->where('institute_head_office', $user->tvet_type);
                            });
                        })
                        ->orderBy('start_date', 'desc')
                        ->get();

                    if ($traineeInstitutes->isEmpty()) {
                        return 'N/A';
                    }

                    $institutesList = [];
                    foreach ($traineeInstitutes as $item) {
                        $startDate = $item->start_date ? date('d/m/Y', strtotime($item->start_date)) : 'N/A';
                        $endDate = $item->end_date ? date('d/m/Y', strtotime($item->end_date)) : 'Present';
                        $institutesList[] = $item->institute->name . ' (' . $startDate . ' - ' . $endDate . ')';
                    }

                    return implode('; ', $institutesList);
                }),

            ExportColumn::make('nvq_level')
                ->label('NVQ Level (Latest)')
                ->formatStateUsing(function ($record) {
                    $latestTraining = $record->traineeInformation()
                        ->orderBy('updated_at', 'desc')
                        ->first();

                    if ($latestTraining && $latestTraining->nvq_content) {
                        $nvqData = json_decode($latestTraining->nvq_content, true);
                        if (is_array($nvqData) && !empty($nvqData) && isset($nvqData[0]['QUALIFICATION_LEVEL'])) {
                            return $nvqData[0]['QUALIFICATION_LEVEL'];
                        }
                    }
                    return 'N/A';
                }),

            ExportColumn::make('recommended_by')
                ->label('Recommended By')
                ->formatStateUsing(function ($record) {
                    $recommendedBy = null;
                    if ($record->recommended_by_user_id != null && $record->recommended_by_user_system != null) {
                        if ($record->recommended_by_user_system == 'cgo') {
                            $user = CgoUser::where('id', $record->recommended_by_user_id)->first();
                            $headOffice = $user->institute?->reg_no ?? 'N/A';
                            $recommendedBy = strtoupper($record->recommended_by_user_system) . ' - ' .
                                ($user?->fullName ?? 'Unknown') . ' (' . $headOffice . ')';
                        } else {
                            $user = AdminUser::where('id', $record->recommended_by_user_id)->first();
                            $headOffice = $user->tvet_type ?? 'N/A';
                            $recommendedBy = strtoupper($record->recommended_by_user_system) . ' - ' .
                                ($user?->fullName ?? 'Unknown') . ' (' . $headOffice . ')';
                        }
                    }
                    return $recommendedBy;
                }),

            ExportColumn::make('career_test_count')
                ->label('Career Tests')
                ->formatStateUsing(fn ($record) => $record->careerTest()->count()),

            ExportColumn::make('portfolio_count')
                ->label('Portfolios')
                ->formatStateUsing(fn ($record) => $record->portfolio()->count()),

            ExportColumn::make('counseling_count')
                ->label('Counseling Sessions')
                ->formatStateUsing(fn ($record) => $record->cgoCounseling()->count()),

            ExportColumn::make('applied_count')
                ->label('Job Applications')
                ->formatStateUsing(fn ($record) => $record->jobApplies()->count()),

            ExportColumn::make('active')
                ->label('Status')
                ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive'),

            ExportColumn::make('created_at')
                ->label('Created At')
                ->formatStateUsing(fn ($state) => $state ? $state->format('Y-m-d H:i:s') : ''),

            ExportColumn::make('updated_at')
                ->label('Updated At')
                ->formatStateUsing(fn ($state) => $state ? $state->format('Y-m-d H:i:s') : ''),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your trainee export has completed. ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
