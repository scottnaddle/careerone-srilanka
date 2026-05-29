<?php

use App\Http\Controllers\Api\TraineeMatchController;
use App\Http\Controllers\CGO\CgoLoginController;
use App\Http\Controllers\CGO\CgoRegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CGO\FaqController;
use App\Http\Controllers\CGO\ForgotPasswordController;
use App\Http\Controllers\CGO\NoticeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CGO\CareerTestController;
use App\Http\Controllers\CGO\MyPageController;
use App\Http\Controllers\CGO\JobSupportController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\TraineeUserController;
use App\Http\Controllers\CGO\CounselingController;
use App\Http\Controllers\EventAttachmentController;
use App\Http\Controllers\OJTController;
use App\Http\Controllers\OJTMatchController;
use Illuminate\Support\Facades\Response;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'cgo', 'as' => 'cgo.'], function () {

    Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
        Route::get('/', [MyPageController::class, 'index'])->name('my-page');
        Route::get('/personal-information', [MyPageController::class, 'getPersonalInformation'])->name('personal-information');
        Route::post('/personal-information', [MyPageController::class, 'postPersonalInformation'])->name('personal-information.post');
        Route::post('/verify-password', [MyPageController::class, 'verifyPassword'])->name('verify-password');
        Route::get('/deactive-account', [MyPageController::class, 'deActiveAccount'])->name('deactive-account');
    });

    Route::group(['prefix' => 'informations', 'as' => 'informations.'], function () {

        Route::group(['prefix' => 'content-management', 'as' => 'content-management.', 'middleware' => ['cgo.auth']], function () {
            Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
                Route::get('/', [ContentManagementController::class, 'getVideos'])->name('list');
                Route::post('post', [ContentManagementController::class, 'postVideos'])->name('post')->withoutMiddleware('cgo.auth');
                Route::get('delete/{slug}', [ContentManagementController::class, 'deleteVideo'])->name('delete');
                Route::get('show/{slug}', [ContentManagementController::class, 'getVideos'])->name('show')->withoutMiddleware('cgo.auth');
            });

            Route::group(['prefix' => 'documents', 'as' => 'documents.'], function () {
                Route::get('/', [ContentManagementController::class, 'getDocuments'])->name('list');
                Route::post('post', [ContentManagementController::class, 'postDocument'])->name('post');
                Route::get('delete/{slug}', [ContentManagementController::class, 'deleteDocument'])->name('delete');
                Route::get('show/{id}', [ContentManagementController::class, 'getDocuments'])->name('show')->withoutMiddleware('cgo.auth');
                Route::get('download/{id}', [ContentManagementController::class, 'downloadDocument'])->name('download')->withoutMiddleware('cgo.auth');
            });
            Route::group(['prefix' => 'peer-review', 'as' => 'peer-review.'], function () {
                Route::get('/', [ContentManagementController::class, 'getPeerReviewList'])->name('list');
                Route::get('/{id}/{peer_id}', [ContentManagementController::class, 'getPeerReviewContentDetails'])->name('details');
                Route::post('/submit', [ContentManagementController::class, 'submitResponse'])->name('submitResponse');
            });
            Route::get('show-review/{content}', [ContentManagementController::class, 'showReview'])->name('show-review');
            Route::get('list-review-content', [ContentManagementController::class, 'listReviewContent'])->name('list-review-content');
            Route::get('content-detail/{content}', [ContentManagementController::class, 'contentDetail'])->name('content-detail');
            Route::group(['prefix' => 'resource', 'as' => 'resource.'], function () {
                Route::get('/', [\App\Http\Controllers\CGO\ResourceController::class, 'getResourceList'])->name('list');
                Route::get('/{id}', [\App\Http\Controllers\CGO\ResourceController::class, 'getContentDetails'])->name('details');
                Route::get('download/{id}', [\App\Http\Controllers\CGO\ResourceController::class, 'downloadDocument'])->name('download')->withoutMiddleware('cgo.auth');
            });
        });
    });
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/signin', [CgoLoginController::class, 'login'])->name('login');
        Route::post('/signin', [CgoLoginController::class, 'postLogin'])->name('postLogin');
        Route::get('/signup', [CgoRegisterController::class, 'register'])->name('register');
        Route::post('/signup', [CgoRegisterController::class, 'postRegister'])->name('postRegister');
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgotPassword');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('postForgotPassword');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetPassword');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('postResetPassword');
        Route::get('/logout', [CgoLoginController::class, 'logout'])->name('logout');
    });

    Route::group(['prefix' => 'career-guidance', 'as' => 'career-guidance.'], function () {
        Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function () {
            Route::get('/', [CareerTestController::class, 'index'])->name('list');
            Route::get('/view-result/{id}', [CareerTestController::class, 'viewResult'])->name('view-result');
            Route::get('/download-result/{id}', [CareerTestController::class, 'downloadResult'])->name('download-result');
        });
        Route::group(['prefix' => 'counseling', 'as' => 'counseling.'], function () {
            Route::get('/my-schedule', [CounselingController::class, 'getMySchedule'])->name('my-schedule');
            Route::get('/counseling-list', [CounselingController::class, 'getCounselingList'])->name('counseling-list');
            Route::get('/counseling-list/{id}', [CounselingController::class, 'show'])->name('counseling-list.show');
            Route::put('/counseling-list/{id}', [CounselingController::class, 'update'])->name('counseling-list.update');
            Route::post('/counseling-list/reject/{id}', [CounselingController::class, 'rejectCounseling'])->name('counseling-list.reject');
            Route::post('/counseling-list/{id}', [CounselingController::class, 'storeResultCounseling'])->name('store-result-counseling');
            Route::get('/create-offline', [CounselingController::class, 'createOfflineCounseling'])->name('create-offline');
            Route::post('/create-offline', [CounselingController::class, 'storeOfflineCounseling'])->name('store-offline');
            Route::get('/attachments/{id}/download', [CounselingController::class, 'downloadAttachment'])->name('attachments.download');
            Route::post('/change-cgo', [CounselingController::class, 'changeCGO'])->name('change-cgo');
            Route::get('/create-offline/get-trainee-info/{nic}', [CounselingController::class, 'getTraineeInfo'])->name('create-offline.get-trainee-info');
        });
        //        Route::group(['prefix' => 'career-information', 'as' => 'career-information.'], function () {
        //            Route::get('/job-information', [CareerTestController::class, 'getJobInformation'])->name('job-information');
        //            Route::get('/job-information/job-details/{slug}', [CareerTestController::class, 'getJobInformationDetails'])->name('job-information.job-details');
        //            Route::get('/career-expert-interview', [CareerTestController::class, 'getCareerExpertInterview'])->name('career-expert-interview');
        //        });
        //
        //        Route::group(['prefix' => 'career-guide', 'as' => 'career-guide.'], function () {
        //            Route::get('/', [CareerTestController::class, 'getCareerGuide'])->name('career-guide');
        //        });


    });

    Route::group(['prefix' => 'job-support', 'as' => 'job-support.'], function () {
        Route::group(['prefix' => 'trainee-list', 'as' => 'trainee-list.'], function () {
            Route::get('/', [JobSupportController::class, 'listTrainee'])->name('list');
            Route::get('/export', [JobSupportController::class, 'exportTrainee'])
                ->name('trainees.export');
            Route::get('/ojt-match/{trainee}', [JobSupportController::class, 'OJTMatch'])->name('ojt-match');
            Route::get('/ojt-match/ojt-details/{trainee_id}/{slug}', [JobSupportController::class, 'ojtDetails'])->name('ojt-match.ojt-details');
            Route::get('/job-match/{trainee}', [JobSupportController::class, 'jobMatch'])->name('job-match');
            Route::get('/job-match/job-details/{trainee}/{slug}', [JobSupportController::class, 'jobDetails'])->name('job-match.job-details');
            Route::get('/information/{id}', [TraineeUserController::class, 'show'])->name('information');
            Route::post('/trainee-match', [TraineeMatchController::class, 'store'])->name('match-job');
        });

        Route::group(['prefix' => 'company-list', 'as' => 'company-list.'], function () {
            Route::get('/', [JobSupportController::class, 'listCompany'])->name('list');
            Route::get('/job-list/{company}', [JobSupportController::class, 'companyJobList'])->name('job-list');
            Route::get('/job-list/job-details/{slug}', [JobSupportController::class, 'companyJobListDetails'])->name('job-list.job-details');
        });

        Route::group(['prefix' => 'job-list', 'as' => 'job-list.'], function () {
            Route::get('/', [JobSupportController::class, 'jobList'])->name('list');
            Route::get('/job-details/{slug}', [JobSupportController::class, 'jobListJobDetails'])->name('job-details');
            Route::get('/candidate-list/{job_id}/{slug}', [JobSupportController::class, 'getJobVacancyCandidateList'])->name('candidate-list');
            Route::get('/matched-list/{job_id}/{slug}', [JobSupportController::class, 'getJobVacancyMatchedList'])->name('list-matched');
            Route::get('/applied-list/{job_id}/{slug}', [JobSupportController::class, 'getJobVacancyAppliedList'])->name('list-applied');
            Route::post('/trainee-match', [JobSupportController::class, 'storeJobMatched'])->name('match-trainee');
            Route::get('/trainee-information/{slug}/{trainee}', [JobSupportController::class, 'jobTraineeInformation'])->name('trainee-information');
            Route::get('/trainee-applied-information/{slug}/{trainee}', [JobSupportController::class, 'jobTraineeAppliedInformation'])->name('trainee-applied-information');
            Route::get('/trainee-match/{slug}', [JobSupportController::class, 'jobTraineeMatch'])->name('trainee-match');
        });

        Route::group(['prefix' => 'ojt-list', 'as' => 'ojt-list.'], function () {
            Route::get('/', [JobSupportController::class, 'listOJT'])->name('list');
            Route::get('/ojt-registration', [JobSupportController::class, 'ojtRegistration'])->name('registration');
            Route::post('/ojt-registration', [JobSupportController::class, 'postOJTRegistration'])->name('postRegistration');
            Route::get('/list-matched/{slug}', [JobSupportController::class, 'ojtListMatched'])->name('list-matched');
            Route::get('/list-applied/{slug}', [JobSupportController::class, 'ojtListApplied'])->name('list-applied');
            Route::get('/trainee-match/{slug}', [JobSupportController::class, 'ojtTraineeMatch'])->name('trainee-match');
            Route::get('/trainee-information/{slug}/{trainee}', [JobSupportController::class, 'ojtTraineeInformation'])->name('trainee-information');
            Route::get('/trainee-applied-information/{slug}/{trainee}', [JobSupportController::class, 'ojtTraineeAppliedInformation'])->name('trainee-applied-information');
            Route::post('/trainee-match', [OJTMatchController::class, 'store'])->name('match-trainee');
            Route::get('/ojt-details/{id}', [OJTController::class, 'show'])->name('ojt-detail');
            Route::get('/ojt-detail/{id}', [JobSupportController::class, 'ojtDetail'])->name('ojt_detail');
        });
    });
    Route::get('/download-user-manual/{language}', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/CareerPlatform_UserManual(CGO)(en)_v1.0.pdf'),
            'tm' => public_path('files/CareerPlatform_UserManual(CGO)(en)_v1.0.pdf'),
            'sn' => public_path('files/CareerPlatform_UserManual(CGO)(sin)_v1.0.pdf'),
            default => public_path('files/CareerPlatform_UserManual(CGO)(en)_v1.0.pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-user-manual');

    Route::get('/download-user-manual/{language}/simple', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/(CGO)CareerPlatform_v1.0.pdf'),
            'tm' => public_path('files/(CGO)CareerPlatform_v1.0.pdf'),
            'sn' => public_path('files/(CGO)CareerPlatform_v1.0.pdf'),
            default => public_path('files/(CGO)CareerPlatform_v1.0.pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-user-manual-simple');

    Route::get('/download-training-document/{language}', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/CareerPlatform(en).pdf'),
            'tm' => public_path('files/CareerPlatform(tamil).pdf'),
            'sn' => public_path('files/CareerPlatform(Sin).pdf'),
            default => public_path('files/CareerPlatform(en).pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-training-document');
});

