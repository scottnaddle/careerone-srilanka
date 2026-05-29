<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\CareerTestTraineeResult;
use App\Models\CgoCounseling;
use App\Models\CgoUser;
use App\Models\CompanyBookmark;
use App\Models\DeviceToken;
use App\Models\District;
use App\Models\Event;
use App\Models\Institute;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\KeepTrainee;
use App\Models\OJT;
use App\Models\OjtBookmark;
use App\Models\OJTMatch;
use App\Models\Portfolio;
use App\Models\QNA;
use App\Models\QNAAnswer;
use App\Models\TraineeApply;
use App\Models\TraineeInstitute;
use App\Models\TraineeMatch;
use App\Models\TraineeNVQ;
use App\Models\TraineeRegCourse;
use App\Models\TraineeSector;
use App\Models\TraineeTrainingHistory;
use App\Models\TraineeUser;
use App\Services\Cgo\CounselingService;
use App\Services\Trainee\TraineeCasSyncService;
use App\Services\Trainee\TraineeInformationService;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    private string $model;
    protected $counselingService;

    public function __construct(CounselingService $counselingService, TraineeCasSyncService $traineeCasSyncService, TraineeTrainingSyncService $traineeTrainingSyncService)
    {
        $this->middleware('trainee.auth');
        $this->model = CgoCounseling::class;
        $this->counselingService = $counselingService;
        $this->traineeCasSyncService = $traineeCasSyncService;
        $this->traineeTrainingSyncService = $traineeTrainingSyncService;
    }

    public function index(Request $request)
    {
        $user = Auth::guard(activeGuard())->user();
        $counselings = $this->counselingService->getListsOfCounselingByCgoId($request, Auth::guard('trainee')->user()->id);
        $listScheduleCounseling = $this->counselingService->getListsOfScheduleCounselingByCgoId(Auth::guard('trainee')->user()->id);
        $currentDate = now();
        $qnas = QNA::latest()->take(5)->get();
        $events = Event::where('status', 2)->latest()->take(5)->get();
        $jobs = Job::where('application_starttime', '<=', $currentDate)->where('application_endtime', '>=', $currentDate)->latest()->take(5)->get();
        $ojts = OJT::latest()->take(5)->withCount('ojtMatches')->get();
        return view('trainee.my-page.my-page', compact('user', 'counselings', 'qnas', 'events', 'jobs', 'ojts', 'listScheduleCounseling'));
    }

    public function toggleOpenToWork(Request $request)
    {
        $status = $request->status;
        $user = Auth::guard(activeGuard())->user();
        if (!$user) {
            return back()->withErrors(['notfound' => 'Can not find the user']);
        }
        $user->open_to_work = $status;
        $user->save();
        return redirect()->route('trainee.my-page.my-page')->with('success', __('system.form.saved'));
    }

    public function togglePublicPortfolio(Request $request)
    {
        $status = $request->status;
        $user = Auth::guard(activeGuard())->user();
        if (!$user) {
            return back()->withErrors(['notfound' => 'Can not find the user']);
        }
        $user->public_portfolio = $status;
        $user->save();
        return redirect()->route('trainee.my-page.my-page')->with('success', __('system.form.saved'));
    }
    public function deActiveAccount()
    {
        $user = TraineeUser::where('id', Auth::guard('trainee')->user()->id)->first();
        if ($user) {

            $user->active = false;
            $user->save();

            if (isset(Auth::guard('trainee')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('trainee')->user()->id)
                    ->where('system', 'trainee')
                    ->delete();
            }
            Auth::guard('trainee')->logout();
            //Logout from CAS
            session()->invalidate();
            session()->regenerateToken();
            if (\phpCAS::isAuthenticated()) {
                \phpCAS::logoutWithRedirectService(env('CAS_CLIENT_SERVICE'));
            }

            return redirect()->route('homepage');
        }
        return redirect()->back();
    }
    public function getPersonalInformation()
    {
        $user = Auth::guard(activeGuard())->user();
        $districts = District::all();
        if(!empty($user->district_id)){
            $institutes = Institute::where('dist_id',$user->district_id)->orderBy('name', 'asc')->get();
        }else{
            $institutes = Institute::orderBy('name', 'asc')->get();
        }
        return view('trainee.my-page.personal-information', compact('user', 'institutes', 'districts'));
    }
    public function postPersonalInformation(Request $request)
    {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'full_name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:trainee_users,email,' . $request->id,
            'mobile' => 'required',
            'avatar' => 'image|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = TraineeUser::where('id', $request->id)->first();
        if (!$user) {
            return back()->withErrors(['notfound' => 'Can not find the user']);
        }


        $user->full_name = $request->full_name;
        $user->telephone = $request->telephone;
        $user->mobile = $request->mobile;
        //        $user->institute_id = $request->institute;
        //        $user->district_id = $request->district;
        if ($request->file('avatar')) {
            $storage_path = storage_path('app/public/' . activeGuard() . '/avatar/' . $user->id . '/');
            $fullName = $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move($storage_path, $fullName);
            $user->profile_image = env('APP_URL') . '/' . 'storage/' . activeGuard() . '/avatar/' . $user->id . '/' . $fullName;
        }
        $user->save();
        if ($user->email != $request->email) {
            $user->email_verified_at = null;
            $user->email = $request->email;
            $user->save();

            //Disable account to waiting verify email
//            $user->disabled = 1;
        }
        //Update on CAS
        $this->traineeCasSyncService->updateUser($user);

        return redirect()->route('trainee.my-page.personal-information')->with('success', __('system.form.saved'));
    }

    public function getMyInformation()
    {
        $user = TraineeUser::where('id', Auth::guard('trainee')->user()->id)->first();
        $this->traineeTrainingSyncService->syncTraineeTrainingInformation($user);
        if ($user) {
            $traineeInformationService = new TraineeInformationService();
            $informations = $traineeInformationService->getTraineeInformation($user->nic);
            return response()->json([
                'success' => true,
                'data' => $informations['message'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => "Can not find the user",
            ]);
        }
    }
}
