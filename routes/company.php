<?php
use App\Http\Controllers\Company\CompanyLoginController;
use App\Http\Controllers\Company\CompanyRegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Company\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\JobSupportController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\OJTMatchController;
use App\Http\Controllers\Company\RegisterNewCompany;
use App\Http\Controllers\Company\MyPageController;
use App\Http\Controllers\Company\ChangePasswordController;
use App\Http\Controllers\Company\NoticeController;
use App\Http\Controllers\Company\FaqController;
use App\Http\Controllers\OJTAttachmentController;
use App\Http\Controllers\OJTController;

/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/search/{keyword}', [RegisterNewCompany::class, 'getSearch'])->name('search');

    Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
        Route::get('/', [MyPageController::class, 'index'])->name('my-page');
        Route::get('/personal-information', [MyPageController::class, 'getPersonalInformation'])->name('personal-information');
        Route::post('/personal-information', [MyPageController::class, 'postPersonalInformation'])->name('personal-information.post');
        Route::get('/company-information/{id}', [MyPageController::class, 'getCompanyInformation'])->name('company-information');
        Route::post('/company-information', [MyPageController::class, 'postCompanyInformation'])->name('company-information.post');
        Route::post('/remove-attachment', [MyPageController::class, 'removeAttachment'])->name('company-information.remove-attachment');
        Route::get('/deactive-account', [MyPageController::class, 'deActiveAccount'])->name('deactive-account');
        Route::get('/get-ds-divisions', [MyPageController::class, 'getDivision'])->name('get-division');
        Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('change-password');
        Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');

    });

    Route::group(['prefix' => 'register', 'as' => 'register.'], function () {
        Route::get('/', [RegisterNewCompany::class, 'getRegisterForm'])->name('get-form');
        Route::get('/get-headquarter', [RegisterNewCompany::class, 'getHeadQuarter']);
        Route::post('/', [RegisterNewCompany::class, 'postRegister'])->name('post-register');
    });

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/signin', [CompanyLoginController::class, 'login'])->name('login');
        Route::post('/signin', [CompanyLoginController::class, 'postLogin'])->name('postLogin');
        Route::get('/signup', [CompanyRegisterController::class, 'register'])->name('register');
        Route::post('/signup', [CompanyRegisterController::class, 'postRegister'])->name('postRegister');
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgotPassword');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('postForgotPassword');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetPassword');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('postResetPassword');
        Route::get('/logout', [CompanyLoginController::class, 'logout'])->name('logout');
    });

    Route::group(['prefix' => 'informations', 'as' => 'informations.'], function () {
        Route::get('/events', [EventController::class, 'index'])->name('event');
        Route::get('events/create', [EventController::class, 'create'])->name('event.create');
        Route::post('events/create', [EventController::class, 'store'])->name('event.create');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
        Route::put('events/update/{event}', [EventController::class, 'update'])->name('event.update');
        Route::delete('events/delete/{event}', [EventController::class, 'destroy'])->name('event.delete');
        Route::get('events/detail/{slug}', [EventController::class, 'show'])->name('event.detail');
        Route::post('events/search', [EventController::class, 'searchByFilter'])->name('event.search');


        Route::group(['prefix' => 'content-management', 'as' => 'content-management.', 'middleware' => ['company.auth']], function () {
            Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
                Route::get('/', [ContentManagementController::class, 'getVideos'])->name('list');
                Route::post('post', [ContentManagementController::class, 'postVideos'])->name('post');
                Route::get('delete/{slug}', [ContentManagementController::class, 'deleteVideo'])->name('delete');
                Route::get('show/{slug}', [ContentManagementController::class, 'getVideos'])->name('show');
            });

            Route::group(['prefix' => 'documents', 'as' => 'documents.'], function () {
                Route::get('/', [ContentManagementController::class, 'getDocuments'])->name('list');
                Route::post('post', [ContentManagementController::class, 'postDocument'])->name('post');
                Route::get('delete/{slug}', [ContentManagementController::class, 'deleteDocument'])->name('delete');
                Route::get('show/{id}', [ContentManagementController::class, 'getDocuments'])->name('show');
                Route::get('download/{id}', [ContentManagementController::class, 'downloadDocument'])->name('download');
            });
        });

    });

    Route::group(['prefix' => 'job-support', 'as' => 'job-support.'], function () {
        Route::group(['prefix' => 'job-vacancy', 'as' => 'job-vacancy.'], function () {
            Route::group(['prefix' => 'candidate-list', 'as' => 'candidate-list.'], function () {
                // Route::get('/', [JobSupportController::class, 'getCandidateList']);
                Route::get('/cv/{trainee_user_id}', [JobSupportController::class, 'getCVOfTrainee'])->name('get-cv');
                Route::put('/update-read', [JobSupportController::class, 'updateStatusReadTraineeCV'])->name('read');
                Route::put('/update-selected', [JobSupportController::class, 'selectedTraineeApply'])->name('selected');
                Route::put('/unselected', [JobSupportController::class, 'unselectedTraineeApply'])->name('unselected');
                Route::put('/employeed', [JobSupportController::class, 'employeedTraineeApply'])->name('employeed');
                Route::get('/{job_id}/{slug}', [JobSupportController::class, 'getJobVacancyCandidateList'])->name('list');
            //                Route::get('/', [JobSupportController::class, 'getJobVacancyList'])->name('list');
            });
            Route::get('/', [JobSupportController::class, 'getJobVacancyList'])->name('list');
            Route::get('/create', [JobSupportController::class, 'createJobVacancy'])->name('create');
	        Route::post('/', [JobSupportController::class, 'storeJobVacancy'])->name('store');
	        Route::get('/{job_id}/edit', [JobSupportController::class, 'editJobVacancy'])->name('edit');
            Route::put('/{job_id}', [JobSupportController::class, 'updateJobVacancy'])->name('update');
            Route::delete('/{job_id}', [JobSupportController::class, 'deleteJobVacancy'])->name('destroy');
	        Route::get('/{job_id}/{slug}', [JobSupportController::class, 'showJobVacancy'])->name('show');
	        Route::get('/{job_id}/download/{filename}', [JobSupportController::class, 'downloadFile'])->name('download-attachment');
        });
        Route::group(['prefix' => 'candidate-list', 'as' => 'candidate-list.'], function () {
            Route::get('/', [JobSupportController::class, 'getCandidateList'])->name('list');
        });

        Route::group(['prefix' => 'ojt-list', 'as' => 'ojt-list.'], function () {
            Route::get('/', [JobSupportController::class, 'ojtList'])->name('list');
            Route::get('/ojt-registration', [JobSupportController::class, 'ojtRegistration'])->name('registration');
            Route::get('/ojt-detail/{slug}', [JobSupportController::class, 'ojtDetail'])->name('detail');
            Route::post('/ojt-registration', [OJTController::class, 'store'])->name('postRegistration');
            Route::get('/delete/{id}', [OJTController::class, 'destroy'])->name('delete');
            Route::get('/trainee-information/{slug}/{trainee}', [OJTMatchController::class, 'ojtTraineeInformation'])->name('trainee-information');
            Route::post('/trainee-match', [OJTMatchController::class, 'store'])->name('match-trainee');
            Route::get('/ojt-detail/download/{id}', [OJTAttachmentController::class, 'download'])->name('ojt-detail.download');
            Route::get('/edit/{slug}', [JobSupportController::class, 'ojtEdit'])->name('edit');
            Route::get('/attachment/delete/{id}/{ojt_id}', [OJTAttachmentController::class, 'destroy'])->name('attachment.delete');
            Route::post('/update/{slug}', [OJTController::class, 'update'])->name('update');
            Route::get('/candidate-list/{slug}', [JobSupportController::class, 'ojtCandidateList'])->name('candidate-list');
            //add new
            Route::put('/update-read', [OJTMatchController::class, 'updateStatusReadTraineeCV'])->name('read');
            Route::post('/update-selected', [OJTMatchController::class, 'selectedTraineeApply'])->name('selected');
            Route::post('/unselected', [OJTMatchController::class, 'unselectedTraineeApply'])->name('unselected');
            Route::post('/employeed', [OJTMatchController::class, 'employeedTraineeApply'])->name('employeed');
            Route::post('/unemploy', [OJTMatchController::class, 'unemployTraineeApply'])->name('unemploy');


        });

        Route::group(['prefix' => 'trainee-list', 'as' => 'trainee-list.'], function(){
            Route::get('list', [JobSupportController::class, 'traineeList'])->name('list');
        });

    });
    Route::get('/download-user-manual/{language}', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/CareerPlatform_UserManual(Company)(en)_v1.0.pdf'),
            'tm' => public_path('files/CareerPlatform_UserManual(Company)(en)_v1.0.pdf'),
            'sn' => public_path('files/CareerPlatform_UserManual(Company)(sin)_v1.0.pdf'),
            default => public_path('files/CareerPlatform_UserManual(Company)(en)_v1.0.pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-user-manual');
    Route::get('/download-user-manual/{language}/simple', function ($language) {
        $filePath = match ($language) {
            'en' => public_path('files/(Company)CareerPlatform_v1.0.pdf'),
            'tm' => public_path('files/(Company)CareerPlatform_v1.0.pdf'),
            'sn' => public_path('files/(Company)CareerPlatform_v1.0.pdf'),
            default => public_path('files/(Company)CareerPlatform_v1.0.pdf'),
        };

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    })->name('download-user-manual-simple');
});
