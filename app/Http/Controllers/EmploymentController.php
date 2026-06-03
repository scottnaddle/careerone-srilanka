<?php

namespace App\Http\Controllers;

use App\Models\NewLetter;
use App\Models\NewsletterCategory;
use App\Models\PolicyCategory;
use App\Services\Trainee\EmploymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmploymentController extends Controller
{
    private EmploymentService  $employmentService;

    public function __construct(EmploymentService $employmentService) {
        $this->employmentService = $employmentService;
    }
    public function getEmploymentPolicy()
    {
        $data = $this->employmentService->getEmployments();
        $policyCategories = $data['data'];
        return view('career-guidance.employment.employment-policy')->with(['policyCategories' => $policyCategories]);
    }

    public function getMonthName($monthNumber)
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return $months[$monthNumber] ?? 'Unknown';
    }
    public function getNewsletter(Request $request)
    {
//        // $newLetters = NewLetter::all();
//        list($results, $counter) = $this->employmentService->getNewsletter($request);
//
//        $years = DB::table('new_letters')
//            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
//            ->distinct()
//            ->pluck('year');
//        // dd($results);
        $categories = NewsletterCategory::latest()->paginate(10);

        return view('career-guidance.employment.newsletter', compact('categories'));
    }

    public function previewNewsLetter($id) {
        $newsLetter = NewLetter::where('id', $id)->first();
        if ($newsLetter) {
            return view('career-guidance.employment.newsletter-preview', compact('newsLetter'));
        }else {
            return back()->withErrors('Can not find this newsletter');
        }
    }
}
