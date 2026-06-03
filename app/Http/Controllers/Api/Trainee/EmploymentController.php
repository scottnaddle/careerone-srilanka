<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Enums\ApiResponseStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\NewLetter;
use App\Models\NewsletterCategory;
use App\Models\PolicyCategory;
use App\Services\Trainee\EmploymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{

    private EmploymentService  $employmentService;

    public function __construct(EmploymentService $employmentService)
    {
        $this->employmentService = $employmentService;
    }

    public function getEmployments()
    {
//        $result = $this->employmentService->getEmployments();
//        $data = null;
//        $status = ApiResponseStatusEnums::BAD_REQUEST;
//
//        if ($result) {
//            $data = $result;
//            $status = ApiResponseStatusEnums::OK;
//        }
//
//        return response()->json([
//            'success' => true,
//            'data' => $data,
//            'message' => 'Get list of employment policies successfully!',
//            'status' => $status->value
//        ]);

        $policyCategories = PolicyCategory::with('policies')->paginate(10);
        foreach ($policyCategories as $category) {
            if ($category->policies->count() > 0) {
                foreach ($category->policies as $policy) {
                    $policy->file = asset('storage/'.$policy->file);
                }
            }
        }

        $status = ApiResponseStatusEnums::OK;
        $data['total'] = $policyCategories->total();
        $data['data'] = $policyCategories;

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get list of new letters successfully.!',
            'status' => $status->value
        ]);
    }

    public function getNewsLetter(Request $request)
    {
        $newsletterCategories = NewsletterCategory::with('newsLetters')->paginate(10);
        foreach ($newsletterCategories as $category) {
            if ($category->newsLetters->count() > 0) {
                foreach ($category->newsLetters as $newsletter) {
                    $newsletter->attachment = asset($newsletter->attachment);
                }
            }
        }

        $status = ApiResponseStatusEnums::OK;
        $data['total'] = $newsletterCategories->total();
        $data['data'] = $newsletterCategories;

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get list of new letters successfully.!',
            'status' => $status->value
        ]);
    }

    public function getAllNewsLetter(Request $request)
    {
        $query = NewLetter::query();
        $keyword = $request->has('keyword') ? $request->query('keyword') : '';
        $status = ApiResponseStatusEnums::BAD_REQUEST;
        if ($keyword) {
            $query->where('title', 'ILIKE', '%' . $keyword . '%');
        }
        $data['data'] = $query->paginate(10);
        $data['total'] = $query->total();
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get list of new letters successfully.!',
            'status' => $status->value
        ]);
    }
}
