<?php

namespace App\Http\Controllers\Api\Trainee;


use App\Http\Controllers\Controller;
use App\Models\CareerTestTraineeResult;
use App\Models\CompanyBookmark;
use App\Models\DeviceToken;
use App\Models\JobBookmark;
use App\Models\KeepTrainee;
use App\Models\OjtBookmark;
use App\Models\OJTMatch;
use App\Models\Portfolio;
use App\Models\QNA;
use App\Models\QNAAnswer;
use App\Models\SchoolKid;
use App\Models\TraineeApply;
use App\Models\TraineeInstitute;
use App\Models\TraineeMatch;
use App\Models\TraineeNVQ;
use App\Models\TraineeRegCourse;
use App\Models\TraineeSector;
use App\Models\TraineeTrainingHistory;
use App\Models\TraineeUser;
use App\Services\Trainee\TraineeCasSyncService;
use Spatie\LaravelPdf\Facades\Pdf;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends BaseController
{

    private $traineeCasSyncService;

    public function __construct()
    {
        $this->traineeCasSyncService = new TraineeCasSyncService();
    }
    public function toggleOpenToWork(Request $request): JsonResponse
    {
        $status = $request->status;
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json();
        }
        $user->open_to_work = $status == 1 ? 1 : 0;
        $user->save();
        $data['status'] = $status == 1 ? 1 : 0;
        $data['message'] = ($status == 1 ? 'Turn on' : 'Turn off') . ' open to work successfully!';
        return $this->sendResponse($data, 'Success');
    }

    public function togglePublicPortfolio(Request $request): JsonResponse
    {
        $status = $request->status;
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return back()->withErrors(['notfound' => 'Can not find the user']);
        }
        $user->public_portfolio = $status == 1 ? 1 : 0;
        $user->save();
        $data['status'] = $status == 1 ? 1 : 0;
        $data['message'] = ($status == 1 ? 'Turn on' : 'Turn off') . ' public portfolio successfully!';
        return $this->sendResponse($data, 'Success');
    }

    public function getPortfolios()
    {
        $user = Auth::guard('sanctum')->user();
        $portfolios = Portfolio::where('trainee_id', $user->id)->paginate(10);

        $data['data'] = $portfolios;
        $data['total'] = $portfolios->total();

        return $this->sendResponse($data, 'Get list portfolio successfully!');
    }


    public function getPortfolio(Request $request)
    {
        $id = $request->pid;
        $portfolio = Portfolio::where('id', $id)->first();

        if ($portfolio) {
            // Define the API endpoint of the external server
            $externalServerUrl = env('EXTERNAL_SERVER_URL') . '/generate-pdf';

            $fullNameSlug = \Str::slug(Auth::guard('sanctum')->user()->fullName);
            $fileName = $fullNameSlug . '-portfolio.pdf';

            try {
                // Make an HTTP request to the external server
                $response = \Http::withoutVerifying()->post($externalServerUrl, [
                    'url' => route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $request->pid]),
                    'file_name' => $fileName,
                ]);

                if ($response->successful()) {
                    // Get the file content and return it as a download
                    $fileContent = $response->body();

                    return response($fileContent, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Failed to generate PDF on the external server',
                        'details' => $response->json(),
                    ], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while contacting the external server',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json(['error' => 'Portfolio not found'], 404);
    }

    public function editTraineeInformation(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->getTable() === 'school_kids') {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|max:100|email|unique:school_kids,email,' . $user->id,
                //            'telephone' => 'required',
                'mobile' => 'required',
                'avatar' => 'image|max:1024'
            ], [
                'email.unique' => 'The email is existed.'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => true,
                ]);
            }
        }else {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|max:100|email|unique:trainee_users,email,' . $user->id,
                //            'telephone' => 'required',
                'mobile' => 'required',
                'avatar' => 'image|max:1024'
            ], [
                'email.unique' => 'The email is existed.'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => true,
                ]);
            }

        }

        if (!$user) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Can not find user!',
                'status' => true,
            ]);
        }

        $user->telephone = $request->telephone ?? $user->telephone;
        $user->mobile = $request->mobile ?? $user->mobile;
        if ($request->file('avatar')) {
            $storage_path = storage_path('app/public/' . activeGuard() . '/avatar/' . $user->id . '/');
            $fullName = $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move($storage_path, $fullName);
            $user->profile_image = env('APP_URL') . '/' . 'storage/' . activeGuard() . '/avatar/' . $user->id . '/' . $fullName;
        }
        $newUser = $user->save();

        if ($user->email != $request->email) {
            $user->email_verified_at = null;
            $user->email = $request->email;
            $user->save();

        }
        //Update on CAS
        if($user->getTable() !== 'school_kids') {
            $this->traineeCasSyncService->updateUser($user);
        }

        $data['data'] = $newUser;

        return response()->json([
            'success' => true,
            'data' => $user,
            'status' => true,
        ]);
    }

    public function deActiveAccount()
    {
        $u = Auth::guard('sanctum')->user();
        if ($u->getTable() === 'school_kids') {
            $user = SchoolKid::where('id', $u->id)->first();
        }else {
            $user = TraineeUser::where('id', $u->id)->first();
        }

        if ($user) {
            $user->active = false;
            $user->save();

            if (isset(Auth::guard('trainee')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('trainee')->user()->id)
                    ->where('system', 'trainee')
                    ->delete();
            }

            if (isset(Auth::guard('sanctum')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('sanctum')->user()->id)
                    ->where('system', 'trainee')
                    ->delete();
            }
            Auth::guard('sanctum')->user()->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Deactive account successfully!',
            'status' => 200
        ]);
    }

    public function getTrainningHistory() {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorise.'. ['error' => 'User not found.']);
        }

        $trainningInformation = TraineeTrainingHistory::where('id', $user->id)->first();
        $trainningInformation->content = json_decode($trainningInformation->content);
        if (!$trainningInformation) {
            return $this->sendError('Not found.'. ['error' => 'This trainee has no trainning informations.']);
        }

        return $this->sendResponse($trainningInformation, 'Get trainning information successfully!');
    }
}
