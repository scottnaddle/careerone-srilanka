<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqArticle;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private object $modelFaq;

    public function __construct(Faq $modelFaq)
    {
        $this->modelFaq = $modelFaq;
    }

    public function apiGetFaqCGOPage(Request $request)
    {
        $data = $this->modelFaq->getFaqCGOList($request);

        if (response()->json($data)->getData()->data === null) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
            ]);
        }

        return response()->json($data);
    }

    public function cgoShow($id)
    {
        $faq = FaqArticle::class::where('faq_id', $id)->get();
        $faq->nav_title = Faq::class::find($id)->category_name;
        $odinals = 1;
        foreach ($faq as $eachFaq) {
            $eachFaq->ordinals = $odinals;
            $odinals++;
        }

        return view('company.informations.notice.faq-show', compact('faq'));
    }
}
