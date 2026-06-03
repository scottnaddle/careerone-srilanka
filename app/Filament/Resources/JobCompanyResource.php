<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobCompanyResource\Pages;
use App\Filament\Resources\JobCompanyResource\RelationManagers;
use App\Models\Job;
use App\Services\Admin\JobService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobCompanyResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $jobService = new JobService(new Job());
        return $table
            ->query($jobService->getAllJobPosting('job'))
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobCompanies::route('/'),
            'create' => Pages\CreateJobCompany::route('/create'),
            'edit' => Pages\EditJobCompany::route('/{record}/edit'),
        ];
    }
}
