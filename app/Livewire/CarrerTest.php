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

    // 1. Khai báo thêm các thuộc tính từ URL
    public $startDate;
    public $endDate;
    public $period = '';
    public $startMonth = '';
    public $startYear = '';
    public $endMonth = '';
    public $endYear = '';

    // 2. Thêm tất cả vào $queryString để Livewire duy trì chúng khi phân trang
    protected $queryString = [
        'search',
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'period' => ['except' => ''],
        'startMonth' => ['except' => ''],
        'startYear' => ['except' => ''],
        'endMonth' => ['except' => ''],
        'endYear' => ['except' => '']
    ];

    public function mount($startDate = null, $endDate = null)
    {
        // 3. Lấy dữ liệu từ query parameter ngay khi mount component
        $this->startDate = $startDate ?? request()->query('startDate');
        $this->endDate = $endDate ?? request()->query('endDate');

        $this->period = request()->query('period', 'this_month');
        $this->startMonth = request()->query('startMonth');
        $this->startYear = request()->query('startYear');
        $this->endMonth = request()->query('endMonth');
        $this->endYear = request()->query('endYear');
    }

    public function render()
    {
        // 4. XÓA 2 dòng này:
        // $this->startDate = request()->query('startDate', $this->startDate);
        // $this->endDate = request()->query('endDate', $this->endDate);
        // Lý do: Livewire đã tự động đồng bộ qua $queryString rồi, gọi request()->query()
        // trong render() khi AJAX chạy sẽ làm mất giá trị do request tiếp theo không chứa param.

        $language = app()->getLocale();
        $carrerTestType = getCodeList('career_test_type', $language);

        \Log::info('Filtering with dates:', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);

        $query = Institute::query();

        if (auth('admin')->check() && !auth('admin')->user()->hasRole('super_admin')) {
            $institutes = auth('admin')->user()->institutes;

            if ($institutes && $institutes->isNotEmpty()) {
                $instituteIds = $institutes->pluck('id')->filter()->values()->toArray();

                if (!empty($instituteIds)) {
                    $query->whereIn('id', $instituteIds);
                } else {
                    \Log::warning('User has institutes but no valid IDs', [
                        'user_id' => auth('admin')->id(),
                        'institutes_count' => $institutes->count()
                    ]);
                    $query->whereRaw('1 = 0');
                }
            } else {
                \Log::info('Admin user has no institutes assigned', [
                    'user_id' => auth('admin')->id()
                ]);
                $query->whereRaw('1 = 0');
            }
        }

        $query->whereHas('carrerTestsTraineeResult', function($subQuery) {
            if ($this->startDate && $this->endDate) {
                $subQuery->whereDate('created_at', '>=', $this->startDate)
                    ->whereDate('created_at', '<=', $this->endDate);
            }
        });

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $institue = $query->orderBy('name', 'asc')->paginate(10);
        $institue->withPath('/admin/career-tests');
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
        $this->resetPage();
    }
}
