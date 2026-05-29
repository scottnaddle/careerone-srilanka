<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Http\Requests\QnaAnswerRequest;
use App\Models\AdminUser;
use App\Models\CareerExpertInterview;
use App\Models\CareerGuidance;
use App\Models\CareerGuidanceCategory;
use App\Models\CareerTest;
use App\Models\CareerTestTraineeResult;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\ContentComment;
use App\Models\Institute;
use App\Models\Resource;
use App\Models\Sector;
use App\Models\TraineeInstitute;
use App\Models\TraineeUser;
use App\Services\Cgo\NotificationManager;
use App\Services\ContentViewLoggerService;
use App\Services\Trainee\TraineeTrainingSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class CareerGuidanceController extends BaseController
{
    protected $notificationManager;
    public function __construct(TraineeTrainingSyncService $traineeTrainingSyncService, NotificationManager $notificationManager) {
        $this->notificationManager = $notificationManager;
        $this->traineeTrainingSyncService = $traineeTrainingSyncService;
    }
    public function getCareerTestList(Request $request): JsonResponse
    {
        $data['data'] = CareerTest::paginate(10);
        $data['total'] = count($data['data']);
        return $this->sendResponse($data, ['message', 'Career test data retrive successfull!']);
    }

    public function attempt($id, Request $request)
    {
        //1: Career Interest test,  2: Career Key test , 3:Interest and Ability Test, 4: Interest, Ability and Personality Test
        $view = '';
        $careerTest = CareerTest::where('id', $id)->first();
        $type = 'html';
        switch ($careerTest->test_type) {
            case '1':
                $view = 'career-interest-test';
                break;
            case '2':
                $view = 'career-key-test';
                break;
            case '3':
                $type = 'link';
            case '4':
                $type = 'link';
                break;
        }
        $data['type'] = $type;
        if ($type == 'html') {
            if ($request->uid != '') {
                $traineeUser = TraineeUser::where('id', $request->uid)->first();
            }else {
                $traineeUser = auth('sanctum')->check();
            }
            $userFullName = $traineeUser ? $traineeUser->fullName : '';
            $userNIC = $traineeUser ? $traineeUser->nic : '';
            $institutes = [];
            if ($traineeUser) {
                $this->traineeTrainingSyncService->syncTraineeTrainingInformation($traineeUser);
            }
            if ($traineeUser && TraineeInstitute::where('trainee_id', $traineeUser->id)->count() > 0) {
                $histories = TraineeInstitute::where('trainee_id', $traineeUser->id)->get();
                foreach ($histories as $history) {
                    $institutes[] = $history->institute;
                }
                $institutes = array_unique($institutes);
            }else {
                $institutes = Institute::all();
            }
            $saveUrl = route('testnow.save-results');
            if ($view == '') {
                return $this->sendError('Error', ['message', 'Not found']);
            }
            // $data['data'] = route('career-guidance.career-test')
//            $data['data'] = view('homepage.career-test.' . $view, compact('userFullName', 'userNIC', 'saveUrl'))->render();
//            $data['data'] = env('APP_URL') . '/attempt-to-test/test/' . $id;

            return view('homepage.career-test.' . $view, compact('userFullName', 'userNIC', 'institutes'));
        } else {
            $data['data'] = $careerTest->link; //Link to attempt
        }
        return $this->sendResponse($data, ['message', 'Test retrive successfull!']);
    }

    public function getResultList(): JsonResponse
    {
        $user = auth('sanctum')->user();
        $resultList = CareerTestTraineeResult::where('trainee_id', $user->id)->paginate(10);
        $total = $resultList->count();
        $data['data'] = $resultList;
        $data['total'] = $total;
        return $this->sendResponse($data, ['message', 'List result retrive successfull!']);
    }

    public function viewResult($id)
    {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            switch ($result->test_type) {
                case 1:
                    return view('homepage.career-test.results.career-interest-test-result', compact('result'));
                case 2:
                    return view('homepage.career-test.results.career-key-test-result', compact('result'));
            }
        }
        return $this->sendError('Error', ['message', 'Sorry, We can not find this result in system!']);
    }

    public function postResults(Request $request)
    {
//        $traineeId = (auth('sanctum')->check()) ? null : auth('sanctum')->user()->id;
        $trainee = TraineeUser::where('nic', $request->nic)->first();
        $traineeId = $trainee ? $trainee->id : null;
        $traineeName = $request->name;
        $results = json_decode($request->results);
        $result = new CareerTestTraineeResult();
        $result->name = $traineeName;
        $result->trainee_id = $traineeId;
        $result->career_test_id = $request->type;
        $result->test_type = $request->type; //Career Key test
        $result->r = $results->realistic;
        $result->i = $results->investigative;
        $result->a = $results->artistic;
        $result->s = $results->social;
        $result->e = $results->enterprising;
        $result->c = $results->conventional;
        $result->note = null;
        $msg = 'Success';
        if ($result->save()) {
            return $this->sendResponse('Success', ['message', $msg]);
        } else {
            return $this->sendError('Error', ['message', 'Error when save database']);
        }
    }

    /**
     * API get career guidance category
     * @param Request $request
     * @return JsonResponse
     */
    public function getCareerGuidanceCategory(Request $request): JsonResponse
    {
        try {
            $careerGuidanceCategories = CareerGuidanceCategory::paginate(10)->appends($request->query());
            foreach($careerGuidanceCategories as $careerGuidanceCategory) {
                $careerGuidanceCategory->total_child =  count($careerGuidanceCategory->careerGuidances);
            }
            if ($careerGuidanceCategories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found',
                    'status' => 404
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $careerGuidanceCategories->total(),
                    'data' => $careerGuidanceCategories
                ],
                'message' => 'Data retrieved successfully',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data',
                'status' => 500
            ], 500);
        }
    }


    /**
     * API get career guide
     * @param Request $request
     * @return JsonResponse
     */
    public function getCareerGuide(Request $request): JsonResponse
    {
        $categoryId = $request->query('category_id', 1);
        $limit = $request->query('limit');

        $careerGuideQuery = CareerGuidance::where('category_id', $categoryId)
            ->with('owner');

        if ($limit) {
            $careerGuides = $careerGuideQuery->limit($limit)->get();
        } else {
            $careerGuides = $careerGuideQuery->paginate(10)->appends($request->query());
        }

        $careerGuides->transform(function ($guide) {
            $guide->thumbnail = asset($guide->thumbnail);
            $guide->owner_first_name = $guide->owner->first_name ?? 'Unknown';
            $guide->owner_last_name = $guide->owner->last_name ?? 'Unknown';
            unset($guide->owner);
            return $guide;
        });

        $response = [
            'success' => true,
            'data' => [
                'total' => $limit ? $limit : $careerGuides->total(),
                'data' => $limit ? ['data' => $careerGuides] : $careerGuides,
            ],
            'message' => 'Data retrieved successfully',
            'status' => 200,
        ];
        return response()->json($response, 200);
    }

    public function getJobInformation(Request $request): JsonResponse
    {
        $title = $request->has('title') ? $request->query('title') : '';

        $sectorsAndJobs = Sector::with([
            'jobs' => function ($query) use ($title) {
                if ($title) {
                    $query->where('title', 'like', "%$title%");
                }
            },
            'getSubSectors.jobs' => function ($query) use ($title) {
                if ($title) {
                    $query->where('title', 'like', "%$title%");
                }
            }
        ])->where('sector_id', null)->get();
        $sectorsAndJobs->each(function ($sector) {
            $sector->jobs->each(function ($job) {
                $attachments = json_decode($job->attachment_details, true);
                if (is_array($attachments)) {
                    $job->attachment_details = array_map(function ($attachment) {
                        $attachment['path'] = asset('storage/'.$attachment['path']);
                        return $attachment;
                    }, $attachments);
                }
            });
        });
        $response = [
            'success' => true,
            'data' => [
                'total' => $sectorsAndJobs->count(),
                'data' => $sectorsAndJobs,
            ],
            'message' => 'Data retrieved successfully',
            'status' => 200,
        ];
        return response()->json($response, 200);
    }

    public function getTraineeCareerTestList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : '';
        $type = $request->has('type') ? $request->type : 'all';
        $test_type = $request->has('test_type') ? $request->test_type : 'all';
        $count = 0;
        $results = CareerTestTraineeResult::query();
        $results->where('trainee_id', Auth::guard('sanctum')->user()->id)->with(['careerTest']);
        if ($type != 'all') {
            $results->where('type', $type);
        }
        if ($test_type != 'all') {
            $results->where('career_test_id', $test_type);
        }
        if ($keyword != '') {
            $results->whereHas('careerTest', function ($q) {
                $q->where('test_name', "ILIKE", '%' . $q . '%');
            })->get();
        }
        $count = $results->count();
        $results = $results->orderBy('created_at', 'desc')->paginate(10);
        foreach ($results as $result) {
            if ($result->trainee_id != '') {
                $result->trainee_name = $result->trainee->fullName;
                $result->institute = 'NAITA';
            } else {
                $result->trainee_name = $result->name;
            }

            if ($result->attachment != null && file_exists($result->attachment)) {
                $result->attachment = asset($result->attachment);
            }

        }
        $response = [
            'success' => true,
            'data' => [
                'total' => $count,
                'data' => $results,
            ],
            'message' => 'Get list career test successfully!',
            'status' => 200,
        ];
        return response()->json($response, 200);
    }

    public function postUploadExistingTestResult(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'test_type' => 'required',
            'attachment' => ($request->action == 'add') ? ['required', File::types(['doc', 'docx', 'pdf'])->max('2gb')] : '',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => [
                    'data' => $validator->errors,
                ],
                'message' => 'Fail to upload career test!',
                'status' => 400,
            ];
            return response()->json($response, 400);
        }
        if ($request->action == 'add') {
            $result = new CareerTestTraineeResult();
        } elseif ($request->action == 'edit') {
            $result = CareerTestTraineeResult::where('id', $request->id)->first();
            if (!$result) {
                $response = [
                    'success' => false,
                    'data' => [
                        'data' => $validator->errors,
                    ],
                    'message' => 'Career test not found!',
                    'status' => 400,
                ];
                return response()->json($response, 400);
            }
        }
        $result->name = Auth::guard('sanctum')->user()->first_name;
        $result->nic = Auth::guard('sanctum')->user()->nic;
        $result->trainee_id = Auth::guard('sanctum')->user()->id;
        $result->career_test_id = $request->test_type;
        $result->test_type = $request->test_type;
        if ($request->has('attachment') && $request->file('attachment')) {
            $file = $request->file('attachment');
            $fullName = $file->getClientOriginalName();
            $storage_path = storage_path('app/public/trainee/career-guidance/career-test/' . Auth::guard(activeGuard())->user()->id . '/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $file->move($storage_path, $fullName);
//            $path = env('APP_URL') . '/' . 'storage/' . activeGuard() . '/career-guidance/career-test/' . Auth::guard(activeGuard())->user()->id . '/' . $fullName;
            $result->attachment = 'storage/trainee/career-guidance/career-test/' . Auth::guard(activeGuard())->user()->id . '/' . $fullName;
        }
        if ($result->save()) {
            $data['data'] = $result;
            $response = [
                'success' => true,
                'data' => [
                    'data' => $result,
                ],
                'message' => 'Data retrieved successfully',
                'status' => 200,
            ];
            return response()->json($response, 200);
        }
    }

    public function deleteCareerTest(Request $request) {
        $id = $request->id;

        $result = CareerTestTraineeResult::where('id', $id) ->where('trainee_id', Auth::guard('sanctum')->user()->id)->first();
        if ($result) {
            // unlink($result->attachment);
            $result->delete();
            $response = [
                'success' => true,
                'data' => [
                    'data' => $result,
                ],
                'message' => 'Delete trainee result successfully',
                'status' => 200,
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'success' => false,
                'data' => [
                    'data' => $result,
                ],
                'message' => 'Trainee result not found',
                'status' => 400,
            ];
            return response()->json($response, 400);
        }
    }

    public function getCareerExpertInterview(Request $request) {
        $query = CareerExpertInterview::with('owner');
        if ($request->has('search') && $request->query('search')) {
            $query->where('title', 'ILIKE', '%' . $request->query('search') . '%');
        }
        $query->orderBy('created_at', 'desc');

        $careerExpertInterviews = $query->paginate(10);

        $response = [
            'success' => true,
            'data' => [
                'data' => $careerExpertInterviews,
            ],
            'message' => 'Data retrieved successfully',
            'status' => 200,
        ];
        return response()->json($response, 200);
    }

    public function downloadResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            if (file_exists($result->attachment)) {
                return response()->download($result->attachment);
            }else {
                return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
            }
        }
        return redirect()->back()->withErrors(trans('system.information.content_management.not_found'));
    }


    /**
     * API get career guidance category
     * @param Request $request
     * @return JsonResponse
     */
    public function getCareerMenuItems(Request $request): JsonResponse
    {
        try {
            $careerGuidanceCategories = CareerGuidanceCategory::get();

            if ($careerGuidanceCategories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found',
                    'status' => 404
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $careerGuidanceCategories->total(),
                    'data' => $careerGuidanceCategories
                ],
                'message' => 'Data retrieved successfully',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data',
                'status' => 500
            ], 500);
        }
    }


    public function getContents($categoryId, Request $request) {
        $keyword = $request->has('search') ? $request->search : '';
        $categoryId = $categoryId;

        // Lấy thông tin category
        $category = CareerGuidanceCategory::where('id', $categoryId)->firstOrFail();

        // Lấy danh sách content đã được approved
        $contentsQuery = $category->contentApproved()->latest();

        // Lọc theo keyword nếu có
        if (!empty($keyword)) {
            $contentsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('intro', 'LIKE', "%$keyword%");
            });
        }

        // Lấy dữ liệu
        $contents = $contentsQuery->paginate(10); // hoặc ->get() nếu không muốn phân trang
        foreach ($contents as $content) {
            if ($content->content_type != 'video') {
                $attachments = json_decode($content->attachment_details, true);
                if (is_array($attachments)) {
                    $attachments['path'] = asset($attachments['path']);
                    $attachments['filename'] = $attachments['filename'];
                    $content->attachment_details = $attachments;
                }
            }
            if($content->thumbnail != '') {
                $content->thumbnail = asset($content->thumbnail);
            }
        }
        $response = [
            'success' => true,
            'data' => [
                'data' => $contents,
            ],
            'message' => 'Data retrieved successfully',
            'status' => 200,
        ];
        return response()->json($response, 200);

    }

    public function getContentDetails($contentId, ContentViewLoggerService $logger) {
        $writeLog = $logger->logView('content', $contentId);
        $content = Content::where('id', $contentId)->first();
        if ($content) {
            $user = $this->getAuthorContent($content->system, $content->created_by);
            $content->author = $user;
            foreach ($content->comments as $item) {
                $user = $this->getAuthorContent($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorContent($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }

            if ($content->content_type !== 'video') {
                $attachments = json_decode($content->attachment_details, true);
                if (is_array($attachments)) {
                    $attachments['path'] = asset($attachments['path']);
                    $content->attachment_details = $attachments;
                }
            }
            if ($content->content_type == 'video') {
                $content->attachment_details = [];
            }
            if($content->thumbnail != '') {
                $content->thumbnail = asset($content->thumbnail);
            }
            $response = [
                'success' => true,
                'data' => [
                    'data' => $content,
                ],
                'message' => 'Data retrieved successfully',
                'status' => 200,
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => true,
            'data' => [
                'data' => [],
            ],
            'message' => 'Can not find content',
            'status' => 200,
        ];
        return response()->json($response, 200);

    }

    public function getAuthorContent($system, $id)
    {
        $user = null;
        switch ($system) {
            case 'cgo':
                $user = CgoUser::where(['id' => $id])->first();
                break;
            case 'company':
                $user = CompanyRecruiter::where(['id' => $id])->first();
                break;
            case 'admin':
                $user = AdminUser::where(['id' => $id])->first();
                break;
            case 'trainee':
                $user = TraineeUser::where(['id' => $id])->first();
                break;
        }
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeComment(QnaAnswerRequest $request)
    {
        $data = $request->all();
        $data['content_id'] = $data['qna_id'];
        $activeGuard = auth('sanctum')->check() ? 'trainee' : 'guest';

        if (auth('sanctum')->check()) {
            $data['system'] = $activeGuard;
            $data['answer_by'] = auth('sanctum')->user()->id;
            $userNameReply = !empty(auth('sanctum')->user()->fullName) ? auth('sanctum')->user()->fullName  : auth('sanctum')->user()->first_name.' '.auth('sanctum')->user()->last_name;



            $data['parent_id'] = $data['parent_id'] ?? null;
            $data['type'] = 'content';

            $contentCommentAnswer = ContentComment::create($data);


            $userReplyName = trim($userNameReply) ?: '';
            if ($contentCommentAnswer) {
                if ($data['parent_id']) {
                    $commentParent = ContentComment::where('id', $data['parent_id'])
                        ->where('type', $data['type'])
                        ->first();

                    if ($commentParent) {
                        $authorCommentParentId = $commentParent->author->id;

                        if ($authorCommentParentId !== $data['answer_by'] || $commentParent->system != $data['system']) {
                            $this->notificationManager->SendNotificationReplyContent($commentParent,$userReplyName);
                        }
                    }
                } else {
                    // Notify if it's a reply to the main QNA
                    $qNA = Content::with('author')->find($contentCommentAnswer->content_id);

                    if ($qNA) {
                        if ($data['answer_by'] != $qNA->created_by || $qNA->system != $data['system']) {
                            $this->notificationManager->SendNotificationReplyContent($qNA,$userReplyName);
                        }
                    }
                }

                return $this->sendResponse($data, ['message', 'Comment successfull!']);
            }
        }
        return $this->sendError('Error', ['message', 'Can not comment in Content!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyComment($contentCommentId)
    {
        $contentCommentAnswer = ContentComment::find($contentCommentId);
        if ($contentCommentAnswer) {
            foreach ($contentCommentAnswer->children as $reply) {
                $reply->delete();
            }

            $contentCommentAnswer->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Reply not found'], 404);
        }
    }


    public function like($id, $type = 'content')
    {
        if ($type == 'content') {
            $content = Content::findOrFail($id);
        }else {
            $content = Resource::findOrFail($id);
        }
        if ($content) {
            $content->likes += 1;
            $content->save();

            return response()->json([
                'success' => true,
                'likes' => $content->likes,
            ]);
        }
    }
}
