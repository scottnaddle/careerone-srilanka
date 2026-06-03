<?php

namespace App\Http\Controllers\CGO;

use App\Enums\NoticeTypeEnums;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NoticeController extends Controller
{
    private object $modelFaq;
    private object $modelNotice;
    private string $currentFragment;

    public function __construct(Notice $modelNotice)
    {
        $this->modelNotice = $modelNotice;
        //$this->modelFaq = new \App\Models\Faq();
        //get fragment at url
        $this -> currentFragment = request()->segment(2) ?? 'notice';

        View::share([
            'isTabFaq' => $this->currentFragment === 'faq',
            'isTabNotice' => $this->currentFragment === 'notice',
        ]);

    }

    public function index(Request $request)
    {
        $listNotices = $this->modelNotice->getNoticeCGOList($request);
        $listNoticeTypeEnum = NoticeTypeEnums::cases();


        return view('cgo.informations.notice.index', compact('listNotices', 'listNoticeTypeEnum'));
    }

    public function apiGetNoticePage(Request $request)
    {
        $data = $this->modelNotice->getNoticeList($request);

        return response()->json($data);
    }

    public function show($id)
    {
        $notice = $this->modelNotice->getNoticeDetail($id);

        return view('cgo.informations.notice.notice-show', compact('notice'));
    }


}
