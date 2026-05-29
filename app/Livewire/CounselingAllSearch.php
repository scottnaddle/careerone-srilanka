<?php

namespace App\Livewire;

use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class CounselingAllSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $sector = '';
    public $startDate = '';
    public $endDate = '';
    public $district = '';
    public $counselingField='';
    public $counselingType='';

    public function render()
    {
        $this->startDate=request()->query('startDate');
        $this->endDate=request()->query('endDate');
        $language=app()->getLocale();
        $districts = District::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->sector, function ($query) {
                $query->where('sector_id', $this->sector);
            })
            ->when($this->district, function ($query) {
                $query->where('district_id', $this->district);
            })->get();
        $counselingType= getCodeList('counselling_type',$language);
        $counselingField =getCodeList('counselling_field',$language);

        return view('livewire.counseling-all-search', [
            'districts' => $districts,
            'showCounselingType'=>$counselingType,
            'showwcounselingField'=>$counselingField

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
}