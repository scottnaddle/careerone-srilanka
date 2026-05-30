<?php

namespace App\Filament\Resources\OJTResource\Pages;

use App\Filament\Resources\JobResource;
use App\Filament\Resources\OjtResource;
use App\Models\OJT;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Models\District;
use App\Models\Sector;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class TraineeListView extends ViewRecord
{
    protected static string $resource = OjtResource::class;
    protected static string $view = 'filament.pages.job-support.ojt.ojt-trainee-list';
    protected static ?string $title = 'View OJT';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    public $ojtData;
    public $ojt;
    public function mount($record): void
    {
        parent::mount($record);
        $this->record->load('sector', 'company', 'district');
        $this->ojtData = $this->record;
        $this->companyList = Company::whereNotNull('verified_by')->get();
        $ojt = OJT::find($record);
        $this->ojt = $ojt;
        $appliesQuery = $ojt->ojtTraineeApplies(); // Query builder

        if (request()->filled('search')) {
            $searchTerm = strtolower(request()->query('search'));
            $searchTerms = explode(' ', $searchTerm);

            $appliesQuery->whereHas('user', function($query) use ($searchTerms) {
                $query->where(function($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->whereRaw('LOWER(first_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ['%' . $term . '%'])
                            ->orWhereRaw('LOWER(full_name) LIKE ?', ['%' . $term . '%']);
                    }
                });
            });

        }

        $results = $appliesQuery->paginate(10);
        $this->ojtData->applyData = $results;
    }


    protected function getSectors()
    {
        return Sector::get();
    }
    protected function getDistricts()
    {
        return District::get();
    }

}
