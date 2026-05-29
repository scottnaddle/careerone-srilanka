<?php

namespace App\Services\Admin;

use App\Enums\JobStatusEnum;
use App\Models\Company;
use App\Models\Job;
use Filament\Forms\Components\Builder;

class CompanyJobService
{
    protected object $model;

    /**
     * JobService constructor.
     * @param Job $model
     */
    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function getAllCompany(array $data = [])
    {
        $companyQuery = $this->model
            ->whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->where('active', true);
        if (isset($data['sector'])) {
            $sectorId = $data['sector'];
            $companyQuery = Company::whereHas('jobs', function ($query) use ($sectorId) {
                $query->where('sector_id', $sectorId);
            });
        }
        if (isset($data['district'])) {
            $companyQuery->where('district', $data['district']);
        }

        if (isset($data['status'])) {
            $query = $data['status'] === 'oldest' ? 'asc' : 'desc';
            $companyQuery->orderBy('created_at', $query);
        }

        return $companyQuery;
    }

    public function getAllCompanyJobs()
    {
        $jobQuery = $this->model->jobs()->query();

        return $jobQuery;
    }
}
