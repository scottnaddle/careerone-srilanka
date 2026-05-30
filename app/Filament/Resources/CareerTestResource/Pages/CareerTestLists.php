<?php

namespace App\Filament\Resources\CareerTestResource\Pages;

use App\Filament\Resources\CareerTestResource;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\Institute;
use App\Models\TraineeInstitute;
use App\Models\TraineeUser;
use DatePeriod;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CareerTestLists extends ListRecords
{
    protected static string $resource = CareerTestResource::class;
    protected static string $view = 'filament.pages.career-guidance.carrer-test.carrer-test-trainee-result';

    public ?string $record = null; // Store the record ID

    public function mount(): void
    {
        parent::mount();
        $this->record = request()->route('record');
    }

//    public function getCareerTestTraineeResult()
//    {
//        $careerTestType = CareerTest::all();
//        $keyword = request()->query('keyword');
//        $type = request()->query('type');
//        $institute = Institute::all();
//        $query = CareerTestTraineeResult::query();
//        if ($type) {
//            $query->where('career_test_id', $type);
//        }
//
//        if (!empty($keyword)) {
//            $query->where('name', 'ILIKE', '%' . $keyword . '%');
//        }
//        $count = $query->count();
//        $paginatedResults = $query->paginate(10);
//        return [
//            'results' => $paginatedResults,
//            'count' => $count,
//            'career_test_types' => $careerTestType,
//            'institute' => $institute
//        ];
//    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
//        $id = request()->route('record') ?? request()->segment(3);
//        dd(request()->segments());
//        $show_date = request()->query('period');
//        $carrer_test_type = request()->query('carrer_type_type');
//        $institute = request()->query('institute');
//        $query = $this->getCareerTestTraineeResultsQuery($id, $show_date, $carrer_test_type, $institute);
        $query = $this->getCareerTestTraineeResultsQuery($this->record);

        return $table

            ->query($query)
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at')
            ->columns([
                TextColumn::make('test_type')
                    ->label(__('admin/career_test.career_test.table.career_test'))
                    ->getStateUsing(function ($record) {
                        return getCodeNameByCodeId('career_test_type', $record->careerTest->test_type) ?? 'N/A';
                    })->sortable(),
                TextColumn::make('institute.name')
                    ->label(__('admin/career_test.career_test.table.trainee_institute')),
//                    ->getStateUsing(function ($record) {
//                        return $record->institute->name ?? '';
//                    }),
                TextColumn::make('fullName')
                    ->label(__('admin/career_test.career_test.table.trainee_name'))
                    ->getStateUsing(function ($record) {
                        return $record->name ?? '';
                    })
                    ,
                TextColumn::make('created_at')->label(__('admin/career_test.career_test.table.date_of_test'))->date()->sortable(),
                Tables\Columns\TextColumn::make('approval')
                    ->label(__('admin/career_test.career_test.table.result'))
                    ->getStateUsing(function ($record) {
                        return $record->test_type == 1 || $record->test_type == 2 ? 'View More' : 'Download';
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if ($state === 'View More') {
                            return "<a target='_blank' href='" . route('admin.career-test.view-result', ['id' => $record->id]) . "'
                                        class='text-blue-500 flex items-center gap-1 font-medium'>
                                        " . __('admin/career_test.career_test.view_details') . "
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                            stroke-width='2' stroke='currentColor' class='size-5'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='M9 5l7 7-7 7' />
                                        </svg>
                                    </a>";
                        } else if ($state === 'Download') {
                            return "<a href='" . route('admin.career-test.download-result', ['id' => $record->id]) . "' target='_blank'
                                        class='text-primary text-base md:text-base flex items-center gap-1'>$state
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                            stroke-width='1.5' stroke='currentColor' class='size-4'>
                                            <path stroke-linecap='round' stroke-linejoin='round'
                                                d='M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3' />
                                        </svg>
                                    </a>";
                        }
                    })
                    ->html(),
                ])
                ->filters([
                    Tables\Filters\SelectFilter::make('test_type')
                        ->preload()
                        ->options(function () {
                            $testTypes = getCodeList('career_test_type');
                            $option = [];
                            foreach ($testTypes as $type) {
                                $option[$type->code_id] = $type->code_name;
                            }
                            return $option;
                        })
                        ->searchable()
                        ->query(function (Builder $query, array $data) {
                            if (!empty($data['value'])) {
                                $query->whereHas('careerTest', function ($q) use ($data) {
                                    $q->where('test_type', $data['value']);
                                });
                            }
                        }),
//                    Tables\Filters\SelectFilter::make('institute')
//                    ->preload()
//                    ->relationship('institute', 'name')
//                    ->searchable(),
//                    Tables\Filters\Filter::make('created_at')
//                        ->form([
//                            DatePicker::make('month')
//                                ->label('Created Month')
//                                ->format('Y-m') // Only select Year-Month
//                                ->displayFormat('F Y') // Show "January 2024" in UI
//                                ->required(),
//                        ])
//                        ->query(function (Builder $query, array $data) {
//                            if (!empty($data['month'])) {
//                                $date = \Carbon\Carbon::parse($data['month']);
//                                $query->whereYear('created_at', $date->year)
//                                    ->whereMonth('created_at', $date->month);
//                            }
//                        }),


                    // Tables\Filters\Filter::make('monthFilter')
                    //     ->form([
                    //         DatePicker::make('date')
                    //             ->label('Created At')
                    //             ->required(),
                    //     ])
                    //     ->query(function (\Builder $query, array $data) {
                    //         if (!empty($data['date'])) {
                    //             $query->whereDate('created_at', $data['date']);
                    //         }
                    //     }),
                ]);
    }

    public function getCareerTestTraineeResultsQuery($id)
    {
        return CareerTestTraineeResult::query()
            ->with(['careerTest', 'trainee'])
            ->when($id, function ($query) use ($id) {
                $query->where('institute_id', $id);
            });
//        $query = CareerTestTraineeResult::query()
//            ->with(['careerTest', 'trainee']);
//            ->where(function ($query) use ($show_date) {
//                $query->whereDoesntHave('traineeInstitute')
//                    ->orWhereHas('traineeInstitute', function ($query) {
//                        $query->whereDate('start_date', '<=', now())
//                            ->whereDate('end_date', '>=', now());
//                    });
//            });
//        $query->where('institute_id', $id);

//            if ($show_date) {
//                $year = substr($show_date, 0, 4);
//                $month = substr($show_date, 5, 2);
//
//                $query->whereYear('created_at', $year)
//                      ->whereMonth('created_at', $month);
//            }

//        if ($carrer_test_type) {
//            $query->whereHas('careerTest', function ($query) use ($carrer_test_type) {
//                $query->where('test_type', $carrer_test_type);
//            });
//        } else {
//            if ($id) {
//                $query->whereHas('careerTest', function ($query) use ($id) {
//                    $query->where('institute_id', $id);
//                });
//            }
//        }

//        if ($institute) {
//            $query->whereHas('traineeInstitute', function ($query) use ($institute) {
//                $query->whereHas('institute', function ($query) use ($institute) {
//                    $query->where('id', $institute);
//                });
//            });
//        }

//        return $query;
    }
}
