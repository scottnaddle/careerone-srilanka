<?php

use App\Http\Controllers\Api\KeepTraineeController;
use App\Http\Controllers\Api\TraineeMatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Trainee\AuthController;
use App\Http\Controllers\Api\Trainee\CommonController;
use App\Http\Controllers\Api\Trainee\JobSupportController;
use App\Http\Controllers\Api\Trainee\InformationController;
use App\Http\Controllers\Api\Trainee\CareerGuidanceController;
use App\Http\Controllers\Api\Trainee\MyPageController;
use App\Http\Controllers\Api\Trainee\NotificationController;
use App\Http\Controllers\Api\Trainee\TraineeCounselingController;
use App\Http\Controllers\HealthCheckController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/trainee/cas/logout', [\App\Http\Controllers\Trainee\CasController::class, 'logout'])->name('cas_logout');
Route::get('/health-check', [HealthCheckController::class, 'check']);
Route::get('/get-provinces', [CommonController::class, 'getProvinces']);
Route::get('/get-institutes', [CommonController::class, 'getInstitutes']);
Route::group(['prefix' => 'trainee'], function () {
    Route::get('/user', [CommonController::class, 'getUserInformation']);
    Route::get('/register', [AuthController::class, 'getRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/delete-user', [CommonController::class, 'deleteTraineeUser']);
//    Route::post('/login', [App\Http\Controllers\Api\Trainee\AuthController::class, 'login'])->name('login');
//    Route::post('/login', [App\Http\Controllers\Api\Trainee\AuthController::class, 'login']);
    Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
    Route::get('/common-data', [CommonController::class, 'getCommonData']);
    Route::get('/get-province', [CommonController::class, 'getProvince']);
    Route::get('/get-district', [CommonController::class, 'getDistrict']);
    Route::get('/get-institute-by-district', [CommonController::class, 'getInstituteByDistrict']);
    Route::get('/district/{id}/institutes', [CommonController::class, 'getInstitutesByDistrict']);
    Route::get('/institute/{id}/districts', [CommonController::class, 'getDistrictsByInstitute']);
    Route::get('/get-divisional', [CommonController::class, 'getDivisionalSecretariat']);
    Route::get('/get-sector', [CommonController::class, 'getSector']);
    Route::get('/get-event-types', [CommonController::class, 'getEventTypes']);
    Route::get('/get-notice-types', [CommonController::class, 'getNoticeTypes']);
    Route::get('/get-banners', [CommonController::class, 'getBanners']);
    Route::get('/get-aboutus', [CommonController::class, 'getAboutus']);
    Route::get('/company-informations', [CommonController::class, 'getCompanyInformation']);
    Route::get('/homepage', [\App\Http\Controllers\Api\Trainee\HomeController::class, 'index']);
    Route::post('/check-nic', [\App\Http\Controllers\Api\Trainee\HomeController::class, 'checkNIC']);
    Route::post('/toggleOpenToWork', [MyPageController::class, 'toggleOpenToWork']);
    Route::post('/togglePublicPortfolio', [MyPageController::class, 'togglePublicPortfolio']);
    Route::get('/get-portfolios', [MyPageController::class, 'getPortfolios']);
    Route::get('/get-portfolio', [MyPageController::class, 'getPortfolio']);
    Route::get('/get-code-list', [CommonController::class, 'getCodeList']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/deactive-account', [MyPageController::class, 'deActiveAccount']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/notifications', [NotificationController::class, 'getAllNotifications']);
        Route::post('/markAsRead', [NotificationController::class, 'markAsRead']);
        Route::post('/markAllRead', [NotificationController::class, 'markAllRead']);
        Route::post('/update-trainee-information', [MyPageController::class, 'editTraineeInformation']);
        Route::get('/get-trainee-training-history', [CommonController::class, 'getTraineeTrainingHistory']);
        // Route::get('/trainee-cvs')
        Route::group(['prefix' => 'job-support'], function () {
            Route::get('/company-list', [JobSupportController::class, 'getCompanyList']);
            //            Route::get('/job-list', [JobSupportController::class, 'getJobList']);
            Route::get('/job-list', [JobSupportController::class, 'getJobPostList'])->withoutMiddleware('auth:sanctum');
            Route::get('/job-detail', [JobSupportController::class, 'getJobDetail'])->withoutMiddleware('auth:sanctum');
            Route::post('/apply-job', [JobSupportController::class, 'toggleApplyJob']);
            Route::get('/ojt-list', [JobSupportController::class, 'getOjtList']);
            Route::post('/toggle-bookmark-company', [JobSupportController::class, 'bookmarkCompany'])->name('toggleBookmarkCompany');
            Route::post('/toggle-bookmark-ojt', [JobSupportController::class, 'toggleOJTBookmark'])->name('toggleBookmarkOJT');
            Route::post('/toggle-bookmark-job', [JobSupportController::class, 'toggleJobBookmark'])->name('toggleBookmarkJob');
            Route::post('/change-apply-type', [JobSupportController::class, 'ojtApply'])->name('changeApplyType');
            Route::get('/candidate-list/{id}', [JobSupportController::class, 'getOJTCandidate'])->name('candidateList');

            Route::post('/ojt-apply', [JobSupportController::class, 'ojtApply'])->name('ojt-apply');
            Route::post('/ojt-unapply', [JobSupportController::class, 'OJTunApply'])->name('ojt-unapply');
        });
        Route::group(['prefix' => 'trainee-counseling'], function () {
            Route::get('/counseling-history', [TraineeCounselingController::class, 'indexJson'])->name('counseling-history');
            Route::get('/counseling-history/{id}', [TraineeCounselingController::class, 'showJson'])->name('counseling-list.show');
            Route::get('/counseling-request', [TraineeCounselingController::class, 'traineeCounselingRequestJson'])->name('counseling-request');
            Route::post('/counseling-request', [TraineeCounselingController::class, 'storeJson'])->name('store-online');
            Route::post('/counseling-feedback/{cgoCounseling}', [TraineeCounselingController::class, 'storeFeedbackJson'])->name('store-counseling-feedback');
            Route::post('/counseling-edit/{cgoCounseling}', [TraineeCounselingController::class, 'postEditJson'])->name('edit-counseling');
         });
        Route::group(['prefix' => 'information'], function () {
            Route::get('events', [InformationController::class, 'getEvents'])->withoutMiddleware('auth:sanctum');
            Route::group(['prefix' => 'qnas'], function () {
                Route::get('/', [InformationController::class, 'getAllQNA'])->withoutMiddleware('auth:sanctum');
                Route::get('/show', [InformationController::class, 'getQNA'])->withoutMiddleware('auth:sanctum');
                Route::post('/answer', [InformationController::class, 'answerQNA']);
                Route::post('/create', [InformationController::class, 'storeQNA']);
                Route::get('/delete/{id}', [InformationController::class, 'destroyQNA'])->name('delete');
                Route::get('/deletereply/{qNAAnswer}', [InformationController::class, 'destroyQNAComment'])->name('qnaanswer.delete');
                Route::post('/update/{id}', [InformationController::class, 'updateQNA'])->name('update');
            });
            Route::get('notices', [InformationController::class, 'getNotices'])->withoutMiddleware('auth:sanctum');
            Route::get('notices/{id}', [InformationController::class, 'getNoticeById'])->withoutMiddleware('auth:sanctum');
            Route::get('faqs', [InformationController::class, 'getFaqs'])->withoutMiddleware('auth:sanctum');;
        });

        Route::group(['prefix' => 'career-guidance'], function () {
            Route::group(['prefix' => 'career-test'], function () {
                Route::get('/get-results', [CareerGuidanceController::class, 'getResultList']);
                Route::get('/view-results/{id}', [CareerGuidanceController::class, 'viewResult']);
            });
        });
    });
    //Guest truy cap dc
    Route::group(['prefix' => 'career-guidance'], function () {
        Route::group(['prefix' => 'career-test'], function () {
            Route::get('/list', [CareerGuidanceController::class, 'getCareerTestList']);
            Route::get('/test/{id}', [CareerGuidanceController::class, 'attempt']);
            Route::post('/save-results', [CareerGuidanceController::class, 'postResults']);
            Route::post('/upload', [CareerGuidanceController::class, 'postUploadExistingTestResult']);
            Route::get('/trainee-test-list', [CareerGuidanceController::class, 'getTraineeCareerTestList']);
            Route::get('/download-result/{id}', [CareerGuidanceController::class, 'downloadResult'])->name('download-result');
            Route::post('/delete-result', [CareerGuidanceController::class, 'deleteCareerTest'])->middleware('auth:sanctum');
        });

        Route::group(['prefix' => 'employment'], function () {
            Route::get('/employment-policy', [\App\Http\Controllers\Api\Trainee\EmploymentController::class, 'getEmployments']);
            Route::get('/newsletter', [\App\Http\Controllers\Api\Trainee\EmploymentController::class, 'getNewsLetter']);
        });
        Route::get('career-category', [CareerGuidanceController::class, 'getCareerGuidanceCategory']);
        Route::get('career-guide', [CareerGuidanceController::class, 'getCareerGuide'])->withoutMiddleware('auth:sanctum');

        Route::get('/job-information', [CareerGuidanceController::class, 'getJobInformation']);
        Route::get('/career-expert-interview', [CareerGuidanceController::class, 'getCareerExpertInterview']);

        Route::get('career-menu-items', [CareerGuidanceController::class, 'getCareerGuidanceCategory'])->withoutMiddleware('auth:sanctum');
        Route::get('/contents/{id}', [CareerGuidanceController::class, 'getContents'])->withoutMiddleware('auth:sanctum');
        Route::get('/contents/details/{id}', [CareerGuidanceController::class, 'getContentDetails'])->name('contents.details')->withoutMiddleware('auth:sanctum');
        Route::group(['prefix' => 'contents', 'as' => 'contents.'], function () {
            Route::post('/reply', [CareerGuidanceController::class, 'storeComment']);
            Route::get('/like/{contentid}/{type}', [CareerGuidanceController::class, 'like']);

            Route::delete('/deletecommentreply/{qNAAnswer}', [CareerGuidanceController::class, 'destroyComment']);
        });

        /*New*/
        Route::get('/portfolios', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'show'])->name('portfolios.show');
        Route::get('/portfolios/create', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'create'])->name('portfolios.create');
        Route::get('/portfolios/edit', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'edit'])->name('portfolios.edit');
        Route::post('/portfolios', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'store'])->name('portfolios.store');
        Route::put('/portfolios/{portfolio}', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'update'])->name('portfolios.update');
        Route::post('/portfolios/delete', [\App\Http\Controllers\Api\Trainee\PortfolioController::class, 'deletePortfolio']);
        Route::post('/portfolios/upload-image', function(Illuminate\Http\Request $request) {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'type' => 'required|in:background,avatar'
            ]);
            try {
                // Store the file in the appropriate directory
                $path = $request->file('file')->store("portfolio/".auth('sanctum')->user()?->id, 'public');

                // Generate full URL to the stored image
                $url = \Storage::disk('public')->url($path);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'path' => $path
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload image: ' . $e->getMessage()
                ], 500);
            }
        });
        Route::post('/portfolios/evidence-upload', function(Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:50000', // 50MB max
            ]);
            try {
                $path = $request->file('file')->store('public/'.auth('sanctum')?->id().'/evidence');
                $publicPath = \Storage::url($path);

                return response()->json([
                    'success' => true,
                    'path' => $publicPath,
                    'url' => asset($publicPath), // Full URL
                    'message' => 'File uploaded successfully'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed: '.$e->getMessage()
                ], 500);
            }
        })->middleware('auth:sanctum');
        /*end new*/

    });


    Route::prefix('mobile-app-versions')->group(function () {
        Route::post('/new', [\App\Http\Controllers\Api\Trainee\MobileAppVersionController::class, 'store']);
        Route::get('/latest', [\App\Http\Controllers\Api\Trainee\MobileAppVersionController::class, 'latest']);
    })->withoutMiddleware('auth:sanctum');

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cgo'], function () {
    Route::get('search-institutes', [App\Http\Controllers\Api\Cgo\CounselingController::class, 'searchInstitutes']);
    Route::get('search-nvq-course', [App\Http\Controllers\Api\Cgo\CounselingController::class, 'searchNvqCourse']);
    Route::get('search-tvec-course', [App\Http\Controllers\Api\Cgo\CounselingController::class, 'searchTvecCourse']);
    Route::name('api.cgo.')->group(function () {
        Route::group(['prefix' => 'career-guidance', 'as' => 'career-guidance.'], function () {
            Route::group(['prefix' => 'counseling', 'as' => 'counseling.'], function () {
                Route::post('confirm-counseling', [App\Http\Controllers\Api\Cgo\CounselingController::class, 'confirmCounseling'])->name('confirm-counseling');
                Route::post('deny-counseling', [App\Http\Controllers\Api\Cgo\CounselingController::class, 'denyCounseling'])->name('deny-counseling');
            });
        });
    });
    Route::name('cgo.')->group(function () {
        Route::post('/keep-trainee', [KeepTraineeController::class, 'markKeeped'])->name('job-support.trainee-list.keeptrainee');
        Route::post('/job-match/trainee-match', [TraineeMatchController::class, 'store'])->name('job-support.trainee-list.trainee-match');
        Route::get('faqs', [App\Http\Controllers\CGO\FaqController::class, 'apiGetFaqCGOPage'])->name('faqs.list')->withoutMiddleware('auth:sanctum');
        Route::get('faqs/{id}', [App\Http\Controllers\CGO\FaqController::class, 'apiGetFaqById'])->name('faqs.get');
    });
});

