<?php

namespace App\Http\Controllers\CGO;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\CgoCounseling;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\DeviceToken;
use App\Models\District;
use App\Models\Event;
use App\Models\Institute;
use App\Models\Job;
use App\Models\KeepTrainee;
use App\Models\OJT;
use App\Models\QNA;
use App\Models\TraineeUser;
use App\Services\Cgo\CounselingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class MyPageController extends Controller
{
    private string $model;
    protected $counselingService;

    public function __construct(CounselingService $counselingService)
    {
        $this->middleware('cgo.auth');
        $this->model = CgoCounseling::class;

        $this->counselingService = $counselingService;

    }

    public function index(Request $request)
    {
        $cgoId = Auth::guard('cgo')->user()->id;
        $activeGuard = activeGuard();
        $data = [
            'user' => Auth::guard($activeGuard)->user(),
            'counselings' => $this->getCounselingData($request, $cgoId),
            'statistics' => $this->getStatistics($request, $cgoId),
            'schedule' => $this->getScheduleData($cgoId),
            'recentItems' => $this->getRecentItems($activeGuard, $cgoId)
        ];
        return view('cgo.my-page.my-page', $data);
    }

    private function getCounselingData(Request $request, $cgoId)
    {
        return $this->counselingService->getListsOfCounselingByCgoId($request, $cgoId)->take(5);
    }

    private function getStatistics(Request $request, $cgoId)
    {
        $counselings = $this->counselingService->getListsOfCounselingByCgoId($request, $cgoId);
        $onlineOffline = $counselings->where('counseling_type', 2);
        $onlineOfflineCompleted = $onlineOffline->where('status', 3)->count();
        $offlineCGO = $counselings->whereIn('counseling_type', ['1', '3']);
        $offlineCGOCompleted = $offlineCGO->where('status', 3)->count();
        $completedCounselings = $this->counselingService
            ->getListsOfCounselingByCgoId($request, $cgoId, 'all')
            ->where('status', 3)
            ->whereNotNull('feedback');

        $averageFeedback = $completedCounselings->isEmpty()
            ? 0
            : ceil($completedCounselings->sum('feedback') / $completedCounselings->count());
        $onlineCounselingRequested = $counselings->where('counseling_type', 2)->where('status', 1)->count();
        $offlineCounselingRequested = $counselings->whereIn('counseling_type', ['1', '3'])->where('status', 1)->count();

        return [
            'onlineOfflineTotal' => $onlineOffline->count(),
            'onlineOfflineCompleted' => $onlineOfflineCompleted,
            'offlineCGOTotal' => $offlineCGO->count(),
            'offlineCGOCompleted' => $offlineCGOCompleted,
            'averageFeedback' => $averageFeedback,
            'onlineCounselingRequested' => $onlineCounselingRequested,
            'offlineCounselingRequested' => $offlineCounselingRequested,
        ];
    }

    private function getScheduleData($cgoId)
    {
        $currentDate = now();

        return [
            'listScheduleCounseling' => $this->counselingService->getListsOfScheduleCounselingByCgoId($cgoId),
            'listWorkingDayCurrentWeek' => $this->counselingService->getListsOfWorkingDayOfWeek($currentDate),
            'currentDate' => $currentDate
        ];
    }

    private function getRecentItems($activeGuard, $cgoId)
    {
        return [
            'qnas' => QNA::latest()->take(5)->get(),
            'events' => Event::where('system', $activeGuard)
                ->where('created_by', $cgoId)
                ->latest()
                ->take(5)
                ->get(),
            'jobs' => Job::latest()->take(5)->get(),
            'keepTrainees' => KeepTrainee::where('keeper_id', $cgoId)
                ->where('system', 'cgo')
                ->latest()
                ->take(5)
                ->get(),
            'ojts' => OJT::latest()
                ->withCount('ojtMatches')
                ->take(5)
                ->get()
        ];
    }

    public function getPersonalInformation() {
        $user = Auth::guard(activeGuard())->user();
        $districts = District::all();
        if(!empty($user->district_id)){
            $institutes = Institute::where('dist_id',$user->district_id)->orderBy('name')->get();
        }else{
            $institutes = Institute::orderBy('name')->get();
        }

        return view('cgo.my-page.personal-information', compact('user', 'institutes', 'districts'));
    }
    public function postPersonalInformation(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'first_name' => 'required|max:20',
        'last_name' => 'required|max:20',
        'email' => 'required|max:100|email',
        'telephone' => 'required',
        'institute' => 'required',
        'district' => 'required',
        'avatar' => 'image|max:1024',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    $user = Auth::guard('cgo')->user();
    if (!$user) {
        return back()->withErrors(['notfound' => 'Cannot find the logged-in user']);
    }
    $emailChanged = $user->email !== $request->email;
    $instituteChanged = $user->institute_id != $request->institute;
    $districtChanged = $user->district_id != $request->district;

    $user->fill([
        'first_name'   => $request->first_name,
        'last_name'    => $request->last_name,
        'email'        => $request->email,
        'telephone'    => $request->telephone,
        'institute_id' => $request->institute,
        'district_id'  => $request->district,
    ]);
    if ($emailChanged) {
        $user->email_verified_at = null;
    }
    if ($instituteChanged || $districtChanged) {
        $user->active = false;
    }
    if ($request->hasFile('avatar')) {
        $folder = activeGuard() . '/avatar/' . $user->id;
        $user->profile_image = saveImageAsWebp($request->file('avatar'), $folder);
    }

    $user->save();
    if ($emailChanged) {
        return redirect()->route('verification.isnotverified', [
            'u_type' => 'cgo',
            'token' => base64_encode($user->email),
        ]);
    }

    return redirect()->route('cgo.my-page.personal-information')->with('success', 'SAVED!');
}


    public function deActiveAccount()
    {
        $user = CgoUser::where('id', Auth::guard('cgo')->user()->id)->first();
        if ($user) {

            $user->active = false;
            $user->save();

            if (isset(Auth::guard('cgo')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('cgo')->user()->id)
                    ->where('system', 'cgo')
                    ->delete();
            }
            Auth::guard('cgo')->logout();
            //Logout from CAS
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('homepage');
        }
        return redirect()->back();
    }

    function verifyPassword (Request $request) {
        $user = Auth::guard('cgo')->user();
        if (Hash::check($request->password, $user->password)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    /**
     * Get qna author
     */


}
