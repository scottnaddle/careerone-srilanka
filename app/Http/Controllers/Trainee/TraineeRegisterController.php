<?php

namespace App\Http\Controllers\Trainee;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trainee\Auth\RegisterRequest;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeCasSyncService;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\Request;
use App\Services\Trainee\TraineeInformationService;
class TraineeRegisterController extends Controller
{
    public function __construct(TraineeInformationService $traineeInfomationService, TraineeCasSyncService $traineeCasSyncService, TraineeTrainingSyncService $traineeSyncService) {
        $this->traineeInfomationService = $traineeInfomationService;
        $this->traineeCasSyncService = $traineeCasSyncService;
        $this->traineeSyncService = $traineeSyncService;
    }

    public function register(Request $request)
    {
//        $recommendedCgo = CgoUser::where('active', true)->get()->each(function ($cgo) {
//            $cgo->system = 'cgo';
//        });
//
//        $recommendedAdmin = AdminUser::where('active', true)->get()->each(function ($admin) {
//            $admin->system = 'admin';
//        });
//
//        $recommendedList = $recommendedCgo->merge($recommendedAdmin);
        $recommendedCgo = CgoUser::where('active', true)
            ->get()
            ->map(function ($cgo) {
                $cgo->system = 'cgo';
                $cgo->uid = 'cgo_' . $cgo->id;
                return $cgo;
            });

        $recommendedAdmin = AdminUser::where('active', true)
            ->get()
            ->map(function ($admin) {
                $admin->system = 'admin';
                $admin->uid = 'admin_' . $admin->id;
                return $admin;
            });

        $recommendedList = $recommendedCgo->concat($recommendedAdmin);

        if ($request->has('manual') && $request->manual == 1) {
            return view('trainee.auth.signup-manual', compact('recommendedList'));
        }

        return view('trainee.auth.signup', compact('recommendedList'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $isManual = $request->has('manual') && $request->manual == 1;
        $verificationMethod = $request->verification_type;
        $data = $request->except(['_token', 'verification_type', 'accept_terms']);
        $password = bcrypt($request->password);

        if ($isManual) {
            $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
            $userData = $this->buildManualUserData($data, $password);
        } else {
            $traineeInfo = $this->traineeInfomationService->getTraineeInformation($request->nic)['message'];
            if ($traineeInfo != 'No Information.') {
                $traineeInfo = $traineeInfo[0];
                $userData = $this->buildAutoUserData($data, $password, $traineeInfo);
            }else {
                return response()->json([
                    'error' => 'Not found trainee information in NVQ System.',
                    'nic' => $request->nic,
                ]);
            }
        }

        $user = TraineeUser::create($userData);

        // Sync with external systems
        $data['disabled'] = 0;
        $this->traineeCasSyncService->signUp($data);

        if (!$isManual) {
            $this->traineeSyncService->syncTraineeTrainingInformation($user);
        }

        // Send verification
        $token = base64_encode($request->email);
        $this->sendVerification($user, $token, $verificationMethod);

        return redirect()->route('verification.verify', [
            'u_type' => 'trainee',
            'token' => $token,
            'verification_method' => $verificationMethod
        ])->with('message', 'Sent');
    }

    private function buildManualUserData($data, $password)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'nic' => $data['nic'],
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'contact_address' => $data['contact_address'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'open_to_work' => 1,
            'public_portfolio' => 1,
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    private function buildAutoUserData($data, $password, $info)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'nic' => $data['nic'],
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $info['STD_FIRST_NAME'],
            'last_name' => $info['STD_SURNAME'],
            'full_name' => $data['full_name'],
            'permanant_address' => $info['STD_PERMANANT_ADDRESS'],
            'contact_address' => $info['STD_CONTACT_ADDRESS'],
            'gender' => getCodeIdByStringEn('gender', $info['STD_GENDER']),
            'mobile' => $data['mobile'],
            'std_surname' => $info['STD_SURNAME'],
            'std_initials' => $info['STD_INITIALS'],
            'open_to_work' => 1,
            'public_portfolio' => 1,
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    private function sendVerification($user, $token, $method)
    {
        match ($method) {
            Constant::email => $user->sendEmailVerify($token),
            Constant::sms => $user->sendSMSVerify($token),
            default => null
        };
    }

//    public function syncTraineeTrainingInformation($user)
//    {
//        try {
//            // Fetch trainee training information
//            $traineeTrainingInformations = $this->traineeInfomationService->getTrainingHistoryInformation($user->nic);
//
//            if ($traineeTrainingInformations['message'] != 'No Information.') {
//                // Save trainee training history
//                $traineeTrainingHistory = new TraineeTrainingHistory();
//                $traineeTrainingHistory->trainee_id = $user->id;
//                $traineeTrainingHistory->content = json_encode($traineeTrainingInformations['message']);
//                $traineeTrainingHistory->save();
//
//                // Save NVQ information
//                \Log::info("---------Syncing user information with NIC: " .$user->nic.'--------------');
//                foreach ($traineeTrainingInformations['message'] as $item) {
//                    // Ensure NVQ record is found before saving
//                    $nvq = NVQLevel::where(DB::raw('LOWER(code)'), strtolower($item['NVQ_QUALIFICATION']['QUALIFICATION_CODE']))->first();
//                    if ($nvq) {
//                        \Log::info("NVQ: " .$item['NVQ_QUALIFICATION']['QUALIFICATION_NAME']);
//                        \Log::info("- Effectivedate: " .$item['NVQ_QUALIFICATION']['EFFECTIVE_DATE']);
//                        \Log::info("- Found in DB: " .json_encode($nvq));
//                        $traineeNvq = new TraineeNVQ();
//                        $traineeNvq->trainee_id = $user->id;
//                        $traineeNvq->nvq_id = $nvq->id;
//                        $traineeNvq->effective_date = $item['NVQ_QUALIFICATION']['EFFECTIVE_DATE'];
//                        $traineeNvq->course_mode = $item['NVQ_QUALIFICATION']['COURSE_MODE'];
//                        $traineeNvq->save();
//                    }
//
//                    // Ensure Institute record is found before saving
//                    $institute = Institute::where(DB::raw('LOWER(reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))->first();
//                    if ($institute) {
//                        \Log::info("Institute: " .$item['INSTITUTE']['INSTITUTE_NAME']);
//                        \Log::info("- Start date: " .$item['COURSE']['START_DATE']);
//                        \Log::info("- End date: " .$item['COURSE']['END_DATE']);
//                        \Log::info("- Found in DB: " .json_encode($institute));
//                        $traineeInstitute = new TraineeInstitute();
//                        $traineeInstitute->trainee_id = $user->id;
//                        $traineeInstitute->institute_id = $institute->id;
//                        $traineeInstitute->start_date = $item['COURSE']['START_DATE'];
//                        $traineeInstitute->end_date = $item['COURSE']['END_DATE'];
//                        $traineeInstitute->save();
//                    }
//
//                    $sector = Sector::where(DB::raw('LOWER(name)'), strtolower($item['COURSE']['INDUSTRY_SECTOR']))->first();
//                    if ($sector) {
//                        \Log::info("Sector: " .$item['COURSE']['INDUSTRY_SECTOR']);
//                        \Log::info("- Start date: " .$item['COURSE']['START_DATE']);
//                        \Log::info("- End date: " .$item['COURSE']['END_DATE']);
//                        \Log::info("- Found in DB: " .json_encode($sector));
//                        $traineeSector = new TraineeSector();
//                        $traineeSector->trainee_id = $user->id;
//                        $traineeSector->sector_id = $sector->id;
//                        $traineeSector->start_date = $item['COURSE']['START_DATE'];
//                        $traineeSector->end_date = $item['COURSE']['END_DATE'];
//                        $traineeSector->save();
//                    }
//
//                    $course = ReqCourse::where(DB::raw('LOWER(institute_reg_no)'), strtolower($item['INSTITUTE']['INSTITUTE_REG_NO']))
//                        ->where(DB::raw('LOWER(course_name)'), strtolower($item['COURSE']['COURSE_NAME']))
//                        ->first();
//                    if ($course) {
//                        \Log::info("Course: " .$item['COURSE']['COURSE_NAME']);
//                        \Log::info("- Start date: " .$item['COURSE']['START_DATE']);
//                        \Log::info("- End date: " .$item['COURSE']['END_DATE']);
//                        \Log::info("- Found in DB: " .json_encode($course));
//                        $traineeRegCourse = new TraineeRegCourse();
//                        $traineeRegCourse->trainee_id = $user->id;
//                        $traineeRegCourse->reg_course_id = $course->id;
//                        $traineeRegCourse->batch_no = $item['COURSE']['BATCH_NO'];
//                        $traineeRegCourse->start_date = $item['COURSE']['START_DATE'];
//                        $traineeRegCourse->end_date = $item['COURSE']['END_DATE'];
//                        $traineeRegCourse->save();
//                    }
//                }
//            }
//        } catch (\Exception $e) {
//            // Handle the exception by logging the error or returning a custom message
//            \Log::error('Error syncing trainee training information: ' . $e->getMessage());
//
//            // Optionally, you can rethrow the exception or handle it gracefully
//            // return response()->json(['error' => 'An error occurred while syncing trainee information.']);
//        }
//    }

    public function checkNIC(Request $request)
    {
        if (TraineeUser::where('nic', $request->nic)->exists()) {
            return response()->json([
                'error' => 'The account with NIC: '.$request->nic.' already exists!',
                'data' => 'No information.',
                'exists' => '1'
            ]);
        }
        $traineeInformation = $this->traineeInfomationService->getTraineeInformation($request->nic);

        if (isset($traineeInformation['message']) && $traineeInformation['message'] != 'No Information.') {
            return response()->json([
                'success' => 'NIC confirmed!',
                'data' => $traineeInformation['message'],
                'exists' => '0'
            ]);
        }
        return response()->json([
            'error' => 'NIC confirm fail!',
            'data' => $traineeInformation['message'],
            'exists' => '0'
        ]);
    }
}
