<?php

namespace App\Services\Admin;

use App\Enums\StatusEnumsManagement;
use App\Models\Content;

class ContentService
{
    protected object $model;

    /**
     * ContentService constructor.
     * @param Content $model
     */
    public function __construct(Content $model) {
        $this->model = $model;
    }

    public function getContents($system, $data = [])
    {
        $contentQuery = Content::selectRaw("
                MAX(districts.name) as district_name,
                COUNT(*) as content_count
            ");
        if ($system == 'cgo') {
            $contentQuery
                ->selectRaw("
        institutes.institute_head_office AS institute_head_office,
        MAX(cgo_users.id) AS id,
        MAX(cgo_users.first_name) AS cgo_first_name,
        MAX(cgo_users.last_name) AS cgo_last_name,
        MAX(institutes.name) AS institute_name,
        SUM(CASE WHEN contents.content_type = 'video' THEN 1 ELSE 0 END) AS total_video,
        SUM(CASE WHEN contents.content_type != 'video' THEN 1 ELSE 0 END) AS total_content
    ")
                ->where('contents.system', 'cgo')
                ->where('contents.status', StatusEnumsManagement::APPROVED_BY_ADMIN->value)
                ->join('cgo_users', 'contents.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->groupBy('cgo_users.id', 'institutes.institute_head_office')
                ->orderByRaw('(SUM(CASE WHEN contents.content_type = \'video\' THEN 1 ELSE 0 END) + SUM(CASE WHEN contents.content_type != \'video\' THEN 1 ELSE 0 END)) DESC');
        } else if ($system == 'institute') {
            $contentQuery
                ->selectRaw("
        institutes.id as id,
        districts.id as districts_id,
        MAX(institutes.name) as institute_name,
        MAX(institutes.institute_head_office) as institute_head_office,
        SUM(CASE WHEN contents.content_type = 'video' THEN 1 ELSE 0 END) AS total_video,
        SUM(CASE WHEN contents.content_type != 'video' THEN 1 ELSE 0 END) AS total_content
    ")
                ->where('contents.system', 'cgo')
                ->where('contents.status', StatusEnumsManagement::APPROVED_BY_ADMIN->value)
                ->join('cgo_users', 'contents.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'institutes.dist_id', '=', 'districts.id')
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->groupBy('institutes.id', 'districts.id')
                ->orderByRaw("(
        SUM(CASE WHEN contents.content_type = 'video' THEN 1 ELSE 0 END) +
        SUM(CASE WHEN contents.content_type != 'video' THEN 1 ELSE 0 END)
    ) DESC");

// Where với từ khóa tìm kiếm
            if (!empty($data['keywords_search'])) {
                $contentQuery->whereRaw('LOWER(institutes.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
            }
        }
        else if ($system == 'company') {
            $contentQuery->selectRaw("MAX(company_recruiters.id) as id, MAX(company_recruiters.first_name) as company_name")->where('contents.system', 'company')
            ->join('company_recruiters', 'contents.created_by', '=', 'company_recruiters.id')
            ->join('companies', 'companies.id', '=', 'company_recruiters.company_id')
            ->join('districts', 'companies.district_id', '=', 'districts.id')

                ->orderBy('company_name', 'ASC');
            //Where with $data
            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
                $contentQuery->whereRaw('LOWER(companies.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
            }
            $contentQuery->groupBy('companies.id');
        } else {
            return false;
        }


        return $contentQuery;
    }
}
