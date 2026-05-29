<?php

namespace App\Http\Controllers;

use App\Enums\WorkingDayEnum;
use App\Http\Requests\Company\JobSupport\OJT\OJTRegistrationRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\District;
use App\Models\OJT;
use App\Models\OJTAttachment;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\Cgo\NotificationManager;
use App\Jobs\SendOJTRegistrationNotificationJob;

class OJTController extends Controller
{
    public function __construct(private NotificationManager $notificationManager)
    {
        $this->middleware('company.auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OJTRegistrationRequest $request)
    {
        $data = $request->except(['_token', '_method']);

        if (activeGuard() == 'company' && Auth::guard(activeGuard())->check()) {
            $data['registration_date'] = now();
            $data['application_starttime'] = $request->filled('application_starttime')
                ? Carbon::parse($data['application_starttime'])->format('Y-m-d')
                : null;
            $data['application_endtime'] = $request->filled('application_endtime')
                ? Carbon::parse($data['application_endtime'])->format('Y-m-d')
                : null;
            $data['slug'] = Str::slug($data['title']);
            $data['created_by'] = Auth::guard(activeGuard())->user()->id;
            $data['company_id'] = Auth::guard(activeGuard())->user()->company_id;
            $data['system'] = activeGuard();

            // Xử lý gender
            $data['gender'] = $request->has('gender') ? json_encode($request->input('gender')) : json_encode([]);

            // Xử lý age_limitation
            $data['age_limitation'] = $request->has('age_limitation') ? true : false;
            if (!$data['age_limitation']) {
                $data['min_age'] = null;
                $data['max_age'] = null;
            }

            // Xử lý work_experience_limitation
            $data['work_experience_limitation'] = $request->has('work_experience_limitation') ? true : false;
            if ($data['work_experience_limitation']) {
                // Keep the provided values
            } else {
                $data['min_work_experience'] = null;
                $data['max_work_experience'] = null;
            }

            // Xử lý trạng thái theo ngày
            $currentDate = Carbon::now()->format('Y-m-d');
            $data['status'] = 1;
            if ($data['application_starttime'] && $data['application_endtime']) {
                if ($currentDate < $data['application_starttime'] || $currentDate > $data['application_endtime']) {
                    $data['status'] = 0;
                }
            }

            // Lưu dữ liệu
            $result=OJT::create($data);
            SendOJTRegistrationNotificationJob::dispatch($result->id);
            return redirect()->route('company.job-support.ojt-list.list')->with('success', __('company.Published OJT vacancy successfully'));
        } else {
            return redirect()->route('company.job-support.ojt-list.list')->withInput()->withErrors('Cannot create OJT or you do not have permission!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ojt = OJT::where('id', $id)->first();
        $sectors = Sector::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $ojt->working_day = explode(',', $ojt->working_day) ?? [];
        foreach ($ojt->working_day as $item) {
            $item = WorkingDayEnum::getNameByKey($item);
        }
        return view('cgo.job-support.trainee-list.ojt-details')->with(['ojt' => $ojt, 'sectors' => $sectors, 'districts' => $districts]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OJTRegistrationRequest $request, $slug)
    {
//        dd($request->all());
        $oJT = OJT::where('slug', $slug)->first();
        $data = $request->except(['_token', '_method']);
        if (activeGuard() == 'company' && Auth::guard(activeGuard())->check()) {
            $data['application_starttime'] = $data['application_starttime'] ? Carbon::parse($data['application_starttime'])->format('Y-m-d') : null;
            $data['application_endtime'] = $data['application_endtime'] ? Carbon::parse($data['application_endtime'])->format('Y-m-d') : null;
            // Xử lý gender
            $data['gender'] = $request->has('gender') ? json_encode($request->input('gender')) : json_encode([]);
            $currentDate = Carbon::now()->format('Y-m-d');
//
//            if ($data['application_starttime'] && $currentDate < $data['application_starttime']) {
//                $data['status'] = 0;
//            }
//
//            if ($data['application_endtime'] && $currentDate > $data['application_endtime']) {
//                $data['status'] = 3;
//            }

            $data['system'] = activeGuard();
            if (!isset($data['age_limitation'])) {
                $data['age_limitation'] = false;
                $data['min_age'] = null;
                $data['max_age'] = null;
            }

            if (!isset($data['work_experience_limitation'])) {
                $data['work_experience_limitation'] = false;
                $data['min_work_experience'] = null;
                $data['max_work_experience'] = null;
            }

            $oJT->update($data);
            return redirect()->route('company.job-support.ojt-list.list')->with('success', 'Update OJT successfully!');
        } else {
            return redirect()->route('company.job-support.ojt-list.list')->withInput()->withErrors('Can not update OJT or you do not have permission!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ojt = OJT::where('id', $id)->first();
        if ($ojt) {
            $ojt->delete();
            return redirect()->back()->with('success', 'Delete successfully!');
        }
        return redirect()->back()->withErrors('We can not delete this event or you do not have permission!');
    }
}
