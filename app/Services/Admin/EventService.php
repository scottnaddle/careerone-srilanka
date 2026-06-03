<?php

namespace App\Services\Admin;

use App\Enums\StatusEnumsManagement;
use App\Models\Event;

class EventService
{
    protected object $model;

    /**
     * EventService constructor.
     * @param Event $model
     */
    public function __construct(Event $model) {
        $this->model = $model;
    }

    public function getEvents($system, $data = [])
    {
        $eventQuery = Event::selectRaw("
                MAX(districts.name) as district_name,
                COUNT(*) as content_count
            ");
        if ($system == 'cgo') {
            $eventQuery->selectRaw("
            MAX(cgo_users.id) as id,
             MAX(cgo_users.first_name) as cgo_first_name,
              MAX(cgo_users.last_name) as cgo_last_name,
                MAX(institutes.name) as institute_name ,
                institutes.institute_head_office AS institute_head_office,
                  SUM(CASE WHEN events.status = ". StatusEnumsManagement::PENDING_APPROVAL->value ." THEN 1 ELSE 0 END) as request,
                   SUM(CASE WHEN events.status = ". StatusEnumsManagement::APPROVED->value ." THEN 1 ELSE 0 END) as approval
                ")
                ->where('events.system', 'cgo')
                ->join('cgo_users', 'events.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->orderBy('approval', 'DESC');
            //Where with $data
            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
                $eventQuery->where(function ($query) use ($data) {
                    $keywords = strtolower($data['keywords_search']);

                    $query->whereRaw('LOWER(cgo_users.first_name) LIKE ?', ['%' . $keywords . '%'])
                        ->orWhereRaw('LOWER(cgo_users.last_name) LIKE ?', ['%' . $keywords . '%']);
                });
            }
            $eventQuery->groupBy('cgo_users.id','institutes.institute_head_office');
        } else if ($system == 'institute') {
            $eventQuery->selectRaw("institutes.id as id, districts.id as districts_id, MAX(institutes.name) as institute_name,   institutes.institute_head_office AS institute_head_office,
                SUM(CASE WHEN events.status = ". StatusEnumsManagement::PENDING_APPROVAL->value ." THEN 1 ELSE 0 END) as request,
                   SUM(CASE WHEN events.status = ". StatusEnumsManagement::APPROVED->value ." THEN 1 ELSE 0 END) as approval
            ")
                ->where('events.system', 'cgo')
                ->join('cgo_users', 'events.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'institutes.dist_id', '=', 'districts.id')
                ->when(!empty($data['head_office']), function ($q) use ($data) {
                    $q->where('institutes.institute_head_office', $data['head_office']);
                })
                ->orderBy('approval', 'DESC');
            //Where with $data
            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
                $eventQuery->whereRaw('LOWER(institutes.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
            }
            $eventQuery->groupBy('institutes.id', 'districts.id');
        }
        else if ($system == 'company') {
//            $eventQuery->selectRaw("MAX(company_recruiters.id) as id,
//             MAX(company_recruiters.first_name) as company_name,
//                SUM(CASE WHEN events.status = ". StatusEnumsManagement::PENDING_APPROVAL->value ." THEN 1 ELSE 0 END) as request,
//                   SUM(CASE WHEN events.status = ". StatusEnumsManagement::APPROVED->value ." THEN 1 ELSE 0 END) as approval
//            ")
//                ->where('events.system', 'company')
//                ->join('company_recruiters', 'events.created_by', '=', 'company_recruiters.id')
//                ->join('companies', 'companies.id', '=', 'company_recruiters.company_id')
//                ->join('districts', 'companies.district_id', '=', 'districts.id')
//                ->orderBy('company_name', 'ASC');
//            //Where with $data
//            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
//                $eventQuery->whereRaw('LOWER(companies.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
//            }
//            $eventQuery->groupBy('companies.id');
//
//            $eventQuery->selectRaw("MAX(company_recruiters.id) as id,
//             MAX(company_recruiters.first_name) as company_name,
//                SUM(CASE WHEN events.status = ". StatusEnumsManagement::PENDING_APPROVAL->value ." THEN 1 ELSE 0 END) as request,
//                   SUM(CASE WHEN events.status = ". StatusEnumsManagement::APPROVED->value ." THEN 1 ELSE 0 END) as approval
//            ")
//                ->where('events.system', 'company')
//                ->join('company_recruiters', 'events.created_by', '=', 'company_recruiters.id')
//                ->join('companies', 'companies.id', '=', 'company_recruiters.company_id')
//                ->join('districts', 'companies.district_id', '=', 'districts.id')
//                ->orderBy('company_name', 'ASC');
//            //Where with $data
//            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
//                $eventQuery->whereRaw('LOWER(companies.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
//            }
//            $eventQuery->groupBy('companies.id');

            $eventQuery->selectRaw("MAX(companies.id) as id,
             MAX(companies.name) as company_name,
                SUM(CASE WHEN events.status = ". StatusEnumsManagement::PENDING_APPROVAL->value ." THEN 1 ELSE 0 END) as request,
                   SUM(CASE WHEN events.status = ". StatusEnumsManagement::APPROVED->value ." THEN 1 ELSE 0 END) as approval
            ")
                ->where('events.system', 'company')
                ->join('company_recruiters', 'events.created_by', '=', 'company_recruiters.id')
                ->join('companies', 'companies.id', '=', 'company_recruiters.company_id')
                ->join('districts', 'companies.district_id', '=', 'districts.id')
                ->orderBy('approval', 'DESC');
            //Where with $data
            if (isset($data['keywords_search']) && $data['keywords_search'] != null) {
                $eventQuery->whereRaw('LOWER(companies.name) LIKE ?', ['%' . strtolower($data['keywords_search']) . '%']);
            }
            $eventQuery->groupBy('companies.id');



        } else {
            return false;
        }


        return $eventQuery;
    }
}
