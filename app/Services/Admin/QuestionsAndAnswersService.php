<?php

namespace App\Services\Admin;

use App\Models\QNA;
use App\Models\QNAAnswer;
use Illuminate\Database\Eloquent\Model;

class QuestionsAndAnswersService
{
    protected QNA $model;

    /**
     * QuestionsAndAnswersService constructor.
     * @param QNA $model
     */
    public function __construct(QNA $model)
    {
        $this->model = $model;
    }

    /**
     * Get the table record key for a given model.
     *
     * @param Model $record
     * @return string
     */
    public function getTableRecordKey(Model $record): string
    {
        return (string) $record->id;
    }

    /**
     * Get Q&A data with optional search keywords.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQNAs($system = '', $data = [])
    {
        if ($system == 'cgo') {
//            $qna = QNA::selectRaw("
//                MAX(cgo_users.id) as id,
//                MAX(cgo_users.first_name) as cgo_first_name,
//                MAX(cgo_users.last_name) as cgo_last_name,
//                MAX(institutes.name) as institute_name,
//                institutes.institute_head_office AS institute_head_office,
//                COUNT(DISTINCT q_n_a_s.id) as question,
//                COUNT(q_n_a_answers.id) as answers
//            ")
//                ->where('q_n_a_s.system', 'cgo')
//                ->join('cgo_users', 'q_n_a_s.created_by', '=', 'cgo_users.id')
//                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
//                ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
//                ->join('q_n_a_answers', 'q_n_a_answers.qna_id', '=', 'q_n_a_s.id')
//                ->groupBy('q_n_a_s.created_by', 'institutes.institute_head_office')
//                ->orderBy('question', 'DESC');

            $qna = QNA::selectRaw("
                MAX(cgo_users.id) as id,
                MAX(cgo_users.first_name) as cgo_first_name,
                MAX(cgo_users.last_name) as cgo_last_name,
                MAX(institutes.name) as institute_name,
                institutes.institute_head_office AS institute_head_office,
                COUNT(DISTINCT q_n_a_s.id) as question,
                COUNT(q_n_a_answers.id) as answers
            ")
                ->where('q_n_a_s.system', 'cgo')
                ->join('cgo_users', 'q_n_a_s.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
                ->join('q_n_a_answers', 'q_n_a_answers.qna_id', '=', 'q_n_a_s.id');
            if (!empty($data['head_office'])) {
                $qna->join('tvet_types', 'institutes.institute_head_office', '=', 'tvet_types.head_office_code')
                    ->where('tvet_types.head_office_code', $data['head_office']);
            }
            $qna->groupBy('q_n_a_s.created_by', 'institutes.institute_head_office')
                ->orderBy('question', 'DESC');
        } elseif ($system == 'company') {
            $qna = QNA::selectRaw("
                companies.id as id,
                MAX(companies.name) as company_name,
                MAX(districts.name) as district_name,
                COUNT(DISTINCT q_n_a_s.id) as question,
                COUNT(DISTINCT q_n_a_answers.id) as answers,
                COUNT(q_n_a_s.created_by) as created_by
            ")
                ->where('q_n_a_s.system', 'company')
                ->join('company_recruiters', 'q_n_a_s.created_by', '=', 'company_recruiters.id')
                ->join('companies', 'companies.id', '=', 'company_recruiters.company_id')
                ->join('districts', 'companies.district_id', '=', 'districts.id')
                ->leftJoin('q_n_a_answers', 'q_n_a_answers.qna_id', '=', 'q_n_a_s.id')
                ->groupBy('companies.id')->orderBy('question', 'DESC');
        } else if ($system == 'institute') {
            $qna = QNA::selectRaw("
                MAX(districts.id) as id,
                MAX(institutes.name) as institute_name,
                institutes.institute_head_office AS institute_head_office,
                COUNT(DISTINCT q_n_a_s.id) as question,
                COUNT(q_n_a_answers.id) as answers
            ")
                ->where('q_n_a_s.system', 'cgo')
                ->join('cgo_users', 'q_n_a_s.created_by', '=', 'cgo_users.id')
                ->join('institutes', 'cgo_users.institute_id', '=', 'institutes.id')
                ->join('districts', 'cgo_users.district_id', '=', 'districts.id')
                ->join('q_n_a_answers', 'q_n_a_answers.qna_id', '=', 'q_n_a_s.id')
                ->groupBy('q_n_a_s.created_by', 'institutes.institute_head_office')
                ->orderBy('question', 'DESC');
        } else {
            $qna = QNA::selectRaw("
                MIN(id) as id,
                DATE(q_n_a_s.created_at) as created_date,
                COUNT(CASE WHEN system = 'cgo' THEN 1 ELSE NULL END) as cgo,
                COUNT(CASE WHEN system = 'company' THEN 1 ELSE NULL END) as company,
                COUNT(CASE WHEN system = 'trainee' THEN 1 ELSE NULL END) as trainee,
                COUNT(*) as total_count
            ")
            ->groupBy(\DB::raw('DATE(q_n_a_s.created_at)'));
//            ->limit(5);
        }

        return $qna;
    }
}
