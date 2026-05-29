<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\District;
use App\Models\Institute;

class CarrerTest extends Component
{
    use WithPagination;

    public $search = '';
    public $sector = '';
    public $district = '';
    public $counselingField='';
    public $counselingType='';
    public $startDate;
    public $endDate;
    protected $queryString = ['search', 'startDate', 'endDate' => ['except' => '']];
    public function mount()
    {
        $this->startDate = request()->query('startDate');
        $this->endDate = request()->query('endDate');
    }
    public function render()
    {
        $this->startDate=request()->query('startDate');
        $this->endDate=request()->query('endDate');
        $language = app()->getLocale();
        $carrerTestType = getCodeList('career_test_type', $language);

        $institue = Institute::where('active_status', 'Active')
            ->whereHas('carrerTestsTraineeResult') // Chỉ lấy institute có career test trainee result
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name','asc')
            ->paginate(10);

        return view('livewire.carrer-test', [
            'carrerTestType' => $carrerTestType,
            'institue' => $institue,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSector()
    {
        $this->resetPage();
    }

    public function updatingDistrict()
    {
        $this->resetPage();
    }
    public function searchInstitute()
    {

    }
}
