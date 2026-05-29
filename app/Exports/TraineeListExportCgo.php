<?php

namespace App\Exports;

use App\Models\TraineeUser;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Models\TraineeInstitute;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TraineeListExportCgo implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function traineeUserFilter(Request $request, $matched = null, $ojt_id = null)
    {
        $query = TraineeUser::query();
        $query->where('active', true);

        if ($ojt_id) {
            $query->whereHas('ojtMatches', function ($query) use ($ojt_id) {
                $query->where('ojt_id', $ojt_id);
                $query ->where('apply_type','ojt_match');
            });
        }

        // Tìm kiếm dựa trên các trường username, first_name, và last_name
        if ($request->has('search') && $request->query('search') != '') {
            $searchTerm = '%' . $request->query('search') . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query
                    ->where('first_name', 'ILIKE', $searchTerm)
                    ->orWhere('last_name', 'ILIKE', $searchTerm)
                    ->orWhere('full_name', 'ILIKE', $searchTerm)
                    ->orWhere('nic', 'ILIKE', $searchTerm)
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'ILIKE', $searchTerm);
            });
        }
        if ($request->has('has-portfolio') && $request->query('has-portfolio') == 1) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('trainee_id')
                    ->from('portfolios')
                    ->whereNotNull('trainee_id');
            });
        }

        // Lọc theo loại trainee
        if ($request->has('trainee_type') && $request->query('trainee_type') != 'all') {
            $traineeType = $request->query('trainee_type');
            if ($traineeType == 'keep') {
                $query->whereHas('keepTrainee', function ($query) {
                    $query->where('trainee_id', DB::raw('trainee_users.id'));
                });
            } elseif ($traineeType == 'unkeep') {
                $query->whereDoesntHave('keepTrainee');
            }
        }

        // Sắp xếp theo first_name
        return $query->orderBy('full_name', 'asc');
    }

    public function collection()
    {
        $query = $this->traineeUserFilter($this->request);

        $list_trainee_ids = TraineeInstitute::where(
            'institute_id',
            auth('cgo')->user()?->institute_id
        )
            ->groupBy('trainee_id')
            ->pluck('trainee_id');

        $query->whereIn('id', $list_trainee_ids);

        return $query->get();
    }

    public function headings(): array
    {
        return ['Name', 'Address', 'Mobile', 'Email'];
    }

    public function map($trainee): array
    {
        return [
            $trainee->full_name,
            $trainee->contact_address,
            $trainee->mobile,
            $trainee->email,
        ];
    }
}

