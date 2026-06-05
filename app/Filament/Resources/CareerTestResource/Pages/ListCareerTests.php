<?php

namespace App\Filament\Resources\CareerTestResource\Pages;

use App\Filament\Resources\CareerTestResource;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Request;

class ListCareerTests extends ListRecords
{
    protected static string $resource = CareerTestResource::class;
    protected static string $view = 'filament.pages.career-guidance.carrer-test.career-test-list';
    protected static ?string $title = '';

    public function getCareerTestTraineeResult() {
        $careerTestType = CareerTest::all();
        $keyword = request()->query('keyword');
        $type = request()->query('type');
        $query = CareerTestTraineeResult::query();
        if ($type) {
            $query->where('career_test_id', $type);
        }

        if (!empty($keyword)) {
            $query->where('name', 'ILIKE', '%' . $keyword . '%');
        }

        $count = $query->count();
        $paginatedResults = $query->paginate(10);
        return [
            'results' => $paginatedResults,
            'count' => $count,
            'career_test_types' => $careerTestType
        ];
    }
}
