<?php

namespace App\Http\Controllers\SchoolKid;

use App\Http\Controllers\Controller;
use App\Models\CgoCounseling;
use App\Models\DeviceToken;
use App\Models\District;
use App\Models\Event;
use App\Models\Institute;
use App\Models\Job;
use App\Models\OJT;
use App\Models\QNA;
use App\Models\SchoolKid;
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

    public function __construct()
    {
        $this->middleware('schoolkid.auth');
    }

    public function index(Request $request)
    {
        $user = Auth::guard(activeGuard())->user();
        $qnas = QNA::latest()->take(5)->get();
        $events = Event::where('status', 2)->latest()->take(5)->get();
        return view('schoolkid.my-page.my-page', compact('user', 'qnas', 'events'));
    }

    public function deActiveAccount()
    {
        $user = SchoolKid::where('id', Auth::guard('schoolkid')->user()->id)->first();
        if ($user) {

            $user->active = false;
            $user->save();

            if (isset(Auth::guard('schoolkid')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('schoolkid')->user()->id)
                    ->where('system', 'schoolkid')
                    ->delete();
            }
            Auth::guard('schoolkid')->logout();

            return redirect()->route('homepage');
        }
        return redirect()->back();
    }
    public function getPersonalInformation()
    {
        $user = Auth::guard(activeGuard())->user();
        $districts = District::all();
        return view('schoolkid.my-page.personal-information', compact('user', 'districts'));
    }
    public function postPersonalInformation(Request $request)
    {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'full_name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:school_kids,email,' . $request->id,
            'mobile' => 'required',
            'avatar' => 'image|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = SchoolKid::where('id', $request->id)->first();
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

        return redirect()->route('schoolkid.my-page.personal-information')->with('success', __('system.form.saved'));
    }

    public function getMyInformation()
    {
        $user = SchoolKid::where('id', Auth::guard('schoolkid')->user()->id)->first();
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
