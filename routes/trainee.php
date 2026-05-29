<?php

use App\Http\Controllers\Trainee\JobCareerInformationController;
use App\Http\Controllers\Trainee\TraineeLoginController;
use App\Http\Controllers\Trainee\TraineeRegisterController;
use App\Http\Controllers\Trainee\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\Trainee\MyPageController;
use App\Http\Controllers\Trainee\CompleteProfileController;
use App\Http\Controllers\Trainee\ChangePasswordController;
use App\Http\Controllers\Trainee\NoticeController;
use App\Http\Controllers\Trainee\FaqController;
use App\Http\Controllers\Trainee\CareerTestController;
use App\Http\Controllers\Trainee\JobSupportController;
use \App\Http\Controllers\Trainee\PortfolioController;
use App\Http\Controllers\Trainee\TraineeCounselingController;
use Subfission\Cas\Facades\Cas;
use Illuminate\Support\Facades\Response;
/*
|--------------------------------------------------------------------------
| Trainee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'trainee', 'as' => 'trainee.'], function () {
    Route::get('/preview-cv', [\App\Http\Controllers\Trainee\PortfolioController::class, 'previewResume'])->name('preview-cv');
    Route::group(['prefix' => 'cas',  'as' => 'cas.'], function () {
        Route::get('/login', [\App\Http\Controllers\Trainee\CasController::class, 'getLogin'])->name('get-login');
        Route::post('/logout', [\App\Http\Controllers\Trainee\CasController::class, 'logout'])->name('cas_logout');
    });
    Route::get('/get-institutes/{districtId}', [TraineeCounselingController::class, 'getInstituteByDistrictId'])->name('get-institute-by-district');
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/signin', [TraineeLoginController::class, 'login'])->name('login');
        Route::post('/signin', [TraineeLoginController::class, 'postLogin'])->name('postLogin');
        Route::get('/signup', [TraineeRegisterController::class, 'register'])->name('register');
        Route::post('/signup', [TraineeRegisterController::class, 'postRegister'])->name('postRegister');
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgotPassword');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('postForgotPassword');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetPassword');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('postResetPassword');
        Route::get('/logout', [TraineeLoginController::class, 'logout'])->name('logout');
        Route::get('/check-NIC', [TraineeRegisterController::class, 'checkNIC'])->name('checkNIC');
    });

    Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
        Route::get('/', [MyPageController::class, 'index'])->name('my-page');
        Route::get('/open-to-work', [MyPageController::class, 'toggleOpenToWork'])->name('toggle-open-to-work');
        Route::get('/public-portfolio', [MyPageController::class, 'togglePublicPortfolio'])->name('toggle-public-portfolio');
        Route::get('/personal-information', [MyPageController::class, 'getPersonalInformation'])->name('personal-information');
        Route::get('/deactive-account', [MyPageController::class, 'deActiveAccount'])->name('deactive-account');
        Route::get('/get-my-information', [MyPageController::class, 'getMyInformation'])->name('get-my-information');
        Route::post('/personal-information', [MyPageController::class, 'postPersonalInformation'])->name('personal-information.post');
        Route::get('/complete-profile', [CompleteProfileController::class, 'show'])->name('complete-profile');
        Route::post('/complete-profile', [CompleteProfileController::class, 'store'])->name('complete-profile.store');
        Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('change-password');
        Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
    });

    Route::group(['prefix' => 'career-guidance', 'as' => 'career-guidance.'], function () {
        Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function () {
            Route::get('/', [CareerTestController::class, 'index'])->name('list');
            Route::get('/upload', [CareerTestController::class, 'getUpload'])->name('get-upload');
            Route::post('/upload', [CareerTestController::class, 'postUploadExistingTestResult'])->name('upload');
            Route::get('/view-result/{id}', [CareerTestController::class, 'viewResult'])->name('view-result');
            Route::get('/download-result/{id}', [CareerTestController::class, 'downloadResult'])->name('download-result');
            Route::get('/delete-result/{id}', [CareerTestController::class, 'deleteResult'])->name('delete-result');
            //            Route::get('/attempt/{id}', [CareerTestController::class, 'attempt'])->name('attempt');
        });
        Route::group(['prefix' => 'career-information', 'as' => 'career-information.'], function () {
            Route::get('/job-information', [CareerTestController::class, 'getJobInformation'])->name('job-information');
            Route::get('/job-information/job-details/{slug}', [CareerTestController::class, 'getJobInformationDetails'])->name('job-information.job-details');
            Route::get('/career-expert-interview', [CareerTestController::class, 'getCareerExpertInterview'])->name('career-expert-interview');
        });

        Route::group(['prefix' => 'career-guide', 'as' => 'career-guide.'], function () {
            Route::get('/', [CareerTestController::class, 'getCareerGuide'])->name('career-guide');
        });
        Route::group(['prefix' => 'counseling', 'as' => 'counseling.'], function () {
            Route::get('/counseling-history', [TraineeCounselingController::class, 'index'])->name('counseling-history');
            Route::get('/counseling-list/{id}', [TraineeCounselingController::class, 'show'])->name('counseling-list.show');
            Route::get('/counseling-request', [TraineeCounselingController::class, 'traineeCounselingRequest'])->name('counseling-request');
            Route::post('/counseling-request', [TraineeCounselingController::class, 'store'])->name('store-online');
            Route::post('/counseling-feedback/{cgoCounseling}', [TraineeCounselingController::class, 'storeFeedback'])->name('store-counseling-feedback');
            Route::get('/attachments/{id}/download', [TraineeCounselingController::class, 'downloadAttachment'])->name('attachments.download');

            Route::get('/counseling-edit/{id}', [TraineeCounselingController::class, 'getEditCounseling'])->name('get-edit');
            Route::put('/counseling-edit/{cgoCounseling}', [TraineeCounselingController::class, 'postEdit'])->name('post-edit');
        });

        Route::group(['prefix' => 'job-career-information', 'as' => 'job-career-information.'], routes: function () {
            Route::get('/job-information', [JobCareerInformationController::class, 'jobInformation'])->name('job-information');
            Route::get('/career-expert-interview', [JobCareerInformationController::class, 'careerExpertInterview'])->name('career-expert-interview');
            Route::get('/job-details/{slug}', [JobCareerInformationController::class, 'jobDetails'])->name('job-details');
        });

        Route::group(['prefix' => 'employment', 'as' => 'employment.'], function () {
            Route::get('/employment-policy', [\App\Http\Controllers\Trainee\EmploymentController::class, 'employmentPolicy'])->name('employment-policy');
            Route::get('/newsletter', [\App\Http\Controllers\Trainee\EmploymentController::class, 'getNewsletter'])->name('newsletter');
        });

        /*New*/
        Route::get('/portfolios', [PortfolioController::class, 'show'])->name('portfolios.show');
        Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
        Route::get('/portfolios/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
        Route::post('/portfolios/upload-image', function(Illuminate\Http\Request $request) {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'type' => 'required|in:background,avatar'
            ]);
            try {
                // Store the file in the appropriate directory
                $path = $request->file('file')->store("portfolio/".auth()->guard('trainee')->user()?->id, 'public');

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
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            try {
                $path = $request->file('file')->store('public/'.auth()->guard('trainee')->id().'/evidence');
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
        })->middleware('auth:trainee');
        /*end new*/

        Route::group(['prefix' => 'portfolio', 'as' => 'portfolio.'], function () {
            Route::get('/my-portfolio', [PortfolioController::class, 'getMyPortfolios'])->name('get-portfolio');
            Route::post('/save-portfolio', [PortfolioController::class, 'savePortfolio']);
            Route::get('/load-portfolio/{id}', [PortfolioController::class, 'loadPortfolio']);
            Route::get('/delete-portfolio', [PortfolioController::class, 'deletePortfolio']);
            Route::get('/export-portfolio', [PortfolioController::class, 'exportPortfolio'])->name('export-portfolio');
            Route::get('/get-my-information', [PortfolioController::class, 'getMyInformation']);
            Route::get('/preview', [PortfolioController::class, 'previewPortfolio'])->name('preview-portfolio');
            Route::get('/edit', [PortfolioController::class, 'editPorfolio'])->name('edit-portfolio');

            Route::get('/my-resume', [PortfolioController::class, 'getMyResumes'])->name('get-resume');
            Route::get('/upload-resume', [PortfolioController::class, 'getUploadResume'])->name('get-upload-resume');
            Route::post('/upload-resume', [PortfolioController::class, 'postUploadResume'])->name('upload-resume');
            Route::get('/delete-resume', [PortfolioController::class, 'deleteResume']);
            Route::get('/preview-resume', [PortfolioController::class, 'previewResume'])->name('preview-resume');
        });
    });

    Route::group(['prefix' => 'job-support', 'as' => 'job-support.'], function () {
        Route::group(['prefix' => 'job-list', 'as' => 'job-list.'], function () {
            Route::get('/job-list', [JobSupportController::class, 'showJobList'])->name('job-list');
            Route::post('/mark-job', [JobSupportController::class, 'toggleJobBookmark'])->name('mark');
            Route::get('/job-detail/{job_id}/{slug}', [JobSupportController::class, 'showJobDetail'])->name('job-detail');
            Route::put('/job-detail/toggleApply', [JobSupportController::class, 'toggleApply'])->name('toggle-apply');
        });

        Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
            Route::get('/company-list', [JobSupportController::class, 'companyList'])->name('company-list');
            Route::post('/mark-company', [JobSupportController::class, 'toggleBookmarkCompany'])->name('mark-company');
            Route::get('/details/{id}/{slug}', [JobSupportController::class, 'companyDetail'])->name('detail');
            Route::get('/job-detail/{id}/{slug}', [JobSupportController::class, 'jobDetail'])->name('job-detail');
            Route::get('/event-detail/{company}/{id}/{slug}', [JobSupportController::class, 'eventDetail'])->name('event-detail');
            Route::get('/events/{id}/{slug}', [JobSupportController::class, 'companyEvent'])->name('event-list');
            Route::get('/job-post/{id}/{slug}', [JobSupportController::class, 'companyJob'])->name('job-post');
            Route::post('/match-job', [JobSupportController::class, 'matchJob'])->name('match-job');
        });

        Route::group(['prefix' => 'ojt', 'as' => 'ojt.'], function () {
            Route::get('/list', [JobSupportController::class, 'ojtListCustom'])->name('ojt-list');
            Route::post('/mark-ojt', [JobSupportController::class, 'toggleOjtBookmark'])->name('mark-ojt');
            Route::get('/ojt-detail/{id}/{slug}', [JobSupportController::class, 'ojtDetail'])->name('ojt-detail');
            Route::post('/ojt-apply', [JobSupportController::class, 'ojtApply'])->name('ojt-apply');
            Route::post('/ojt-unapply', [JobSupportController::class, 'OJTunApply'])->name('ojt-unapply');
        });
    });
    Route::get('/download-user-manual/{language}', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/CareerPlatform_UserManual(Trainee)(en)_v1.0.pdf'),
            'tm' => public_path('files/CareerPlatform_UserManual(Trainee)(en)_v1.0.pdf'),
            'sn' => public_path('files/CareerPlatform_UserManual(Trainee)(sin)_v1.0.pdf'),
            default => public_path('files/CareerPlatform_UserManual(Trainee)(en)_v1.0.pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-user-manual');
});
