<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\QNAAnswerController;
use App\Http\Controllers\QnaAttachmentController;
use App\Http\Controllers\QNAController;
use App\Http\Controllers\RegisterVerificationCodeController;
use App\Http\Controllers\UploadController;
use App\Services\ESMSService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAttachmentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/about-us', [HomepageController::class, 'aboutUs'])->name('homepage.about-us');
Route::get('/sitemap.xml', [
    \App\Http\Controllers\SitemapController::class,
    'generateSitemap'
]);
Route::group(['prefix' => 'guideline', 'as' => 'guideline.'], function () {
    Route::get('/', function () {return view('guideline.guideline');})->name('guideline');
});
Route::get('/trainee-policy', function () {return view('trainee.trainee-policy');});
Route::get('/contact-us', [HomepageController::class, 'contactUs'])->name('homepage.contact-us');
Route::get('/company/details/{id}/{slug}', [HomepageController::class, 'companyDetail'])->name('homepage.company-detail');
Route::get('/job/details/{job_id}/{slug}', [HomepageController::class, 'showJobVacancy'])->name('homepage.job-detail');
Route::post('/upload/temp', [HomepageController::class, 'tempUpload'])->name('upload.temp');
Route::get('/job/list', [HomepageController::class, 'getJobList'])->name('homepage.job-list');
Route::group(['prefix' => 'attempt-to-test', 'as' => 'testnow.'], function () {
    Route::get('/', [HomepageController::class, 'getTests'])->name('list');
    Route::get('/test/{id}', [HomepageController::class, 'attempt'])->name('attempt');
    Route::post('/save-results', [HomepageController::class, 'postResults'])->name('save-results');
    Route::get('/check-NIC', [HomepageController::class, 'checkNICForCareerTest'])->name('checkNIC');
});

Route::post('images/upload', [UploadController::class, 'store'])->name('upload.images');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admins', function () {
        return view('admin/dashboard');
    });
});
Route::get('/choose-login', function () {
    if (Auth::guard('admin')->check()) {
        return redirect('/admin/overview');
    }

    $guard = activeGuard();

    if ($guard === '' || !Auth::guard($guard)->check()) {
        return view('auth-verification.choose-login');
    }

    return redirect('/');
});

Route::post('/upload', [UploadController::class, 'store'])->name('upload');

Route::get('/institute', [InstituteController::class, 'index'])->name('institute');
Route::get('/districts', [DistrictController::class, 'getDistrictForSelect'])->name('district');

Route::get('/public-event', [EventController::class, 'getPublicEvent'])->name('get-public-event');

Route::get('verfication/verify/{u_type}/{token}/{verification_method}', [RegisterVerificationCodeController::class, 'index'])->name('verification.verify');
Route::get('verfication/isnotverified/{u_type}/{token}', [RegisterVerificationCodeController::class, 'isNotVerified'])->name('verification.isnotverified');

Route::get('verfication/resend_verify', [RegisterVerificationCodeController::class, 'resendCode'])->name('resend_verification')->middleware('throttle:resend_verification_code');
Route::post('verfication/verify', [RegisterVerificationCodeController::class, 'postCode'])->name('verification');
Route::post('request-reactive-account', [HomepageController::class, 'reactiveAccount'])->name('send-reactive-account-request');
Route::get('request-reactive-account', [HomepageController::class, 'getReactiveForm'])->name('get-reactive-account-request');

Route::post('upload-media', [UploadController::class, 'uploadFile'])->name('upload-media');

Route::post('attached_files/delete', [UploadController::class, 'fileDestroy'])->name('file-delete');
Route::get('/notices', [\App\Http\Controllers\NoticeController::class, 'index'])->name('notices.index');
Route::get('/faqs/{id}', [\App\Http\Controllers\FaqController::class, 'cgoShow'])->name('faqs.show');
Route::group(['prefix' => 'informations', 'as' => 'informations.'], function () {
    Route::group(['prefix' => 'qnas', 'as' => 'qnas.'], function () {
        Route::get('/', [QNAController::class, 'index'])->name('list');
        Route::post('/create', [QNAController::class, 'store'])->name('create');
        Route::get('/edit/{slug}', [QNAController::class, 'getUpdate'])->name('get-update');
        Route::put('/update/{qNA}', [QNAController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [QNAController::class, 'destroy'])->name('delete');
        Route::get('/reply/{slug}', [QNAController::class, 'show'])->name('reply');

        Route::post('/reply', [QNAAnswerController::class, 'store'])->name('qnaanswer.create');

        Route::delete('/deletereply/{qNAAnswer}', [QNAAnswerController::class, 'destroy'])->name('qnaanswer.delete');

        Route::get('/download/{id}', [QNAController::class, 'downloadDocument'])->name('download');
        Route::get('/attachment/delete/{id}/{qna_id}', [QnaAttachmentController::class, 'destroy'])->name('attachment.delete');
        Route::get('/attachments/preview/{id}', [QnaAttachmentController::class, 'previewAttachment'])->name('attachments.preview');
    });
    Route::group(['prefix' => 'contents', 'as' => 'contents.'], function () {
        Route::post('/reply', [\App\Http\Controllers\ContentCommentController::class, 'store'])->name('content-comments.create');
        Route::get('/like/{contentid}/{type}', [\App\Http\Controllers\ContentCommentController::class, 'like'])->name('content.like');

        Route::delete('/deletecommentreply/{qNAAnswer}', [\App\Http\Controllers\ContentCommentController::class, 'destroy'])->name('content-comments.delete');
    });


    Route::group(['prefix' => 'events', 'as' => 'events.'], function () {
        Route::get('/', [EventController::class, 'index'])->name('event');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/create', [EventController::class, 'store'])->name('create');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/update/{event}', [EventController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('delete');
        Route::get('/detail/{slug}', [EventController::class, 'show'])->name('detail');
        Route::post('/search', [EventController::class, 'searchByFilter'])->name('search');
        Route::get('/download/{id}', [EventController::class, 'downloadDocument'])->name('download');
        Route::get('/attachments/delete/{id}/{event_id}', [EventAttachmentController::class, 'destroy'])->name('attachments.delete');
        Route::get('/attachments/preview/{id}', [EventAttachmentController::class, 'previewAttachment'])->name('attachments.preview');
        Route::get('/preview-file-counseling/{id}', [EventAttachmentController::class, 'showFileCounseling'])->name('showFileCounseling');
    });

    Route::get('/notices', [\App\Http\Controllers\NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/{id}', [\App\Http\Controllers\NoticeController::class, 'show'])->name('notices.show');
    Route::get('/faqs/{id}', [\App\Http\Controllers\FaqController::class, 'cgoShow'])->name('faqs.show');
    Route::get('/get/faqs', [\App\Http\Controllers\FaqController::class, 'apiGetFaqCGOPage'])->name('faqs.list');
    Route::get('/get/faqs/{id}', [\App\Http\Controllers\FaqController::class, 'apiGetFaqById'])->name('faqs.get');
    Route::get('/get/faqs/article/{id}', [\App\Http\Controllers\FaqController::class, 'getFaqArticleById'])->name('faqs.get-article');
});

Route::group(['prefix' => 'career-guidance', 'as' => 'career-guidance.'], function () {
    Route::group(['prefix' => 'career-information', 'as' => 'career-information.'], function () {
        Route::get('/job-information', [\App\Http\Controllers\CareerGuidanceController::class, 'getJobInformation'])->name('job-information');
        Route::get('/job-information/job-details/{slug}', [\App\Http\Controllers\CareerGuidanceController::class, 'getJobInformationDetails'])->name('job-information.job-details');
        Route::get('/career-expert-interview', [\App\Http\Controllers\CareerGuidanceController::class, 'getCareerExpertInterview'])->name('career-expert-interview');

        Route::get('/contents/{id}', [\App\Http\Controllers\CareerGuidanceController::class, 'getContents']);
        Route::get('/contents/details/{id}', [\App\Http\Controllers\CareerGuidanceController::class, 'getContentDetails'])->name('contents.details');
        Route::get('/contents/details/preview-file/{id}', [\App\Http\Controllers\CareerGuidanceController::class, 'previewFile'])->name('contents.details.preview');
        Route::get('/success-stories-of-graduates', [\App\Http\Controllers\CareerGuidanceController::class, 'getSuccessStoriesOfGraduates'])->name('success-stories-of-graduates');
    });
    Route::group(['prefix' => 'career-guide', 'as' => 'career-guide.'], function () {
        Route::get('/', [\App\Http\Controllers\CareerGuidanceController::class, 'getCareerGuide'])->name('career-guide');
        Route::get('/view-more/{id}', [\App\Http\Controllers\CareerGuidanceController::class, 'getCareerGuideByCategoryId'])->name('view-more');
    });
    Route::group(['prefix' => 'employment', 'as' => 'employment.'], function () {
        Route::get('/employment-policy', [EmploymentController::class, 'getEmploymentPolicy'])->name('employment-policy');
        Route::get('/newsletter', [EmploymentController::class, 'getNewsletter'])->name('newsletter');
        Route::get('/newsletter/preview/{id}', [EmploymentController::class, 'previewNewsLetter'])->name('newsletter.preview');
    });
});

Route::get('/token-expired', function () {
    return view('token-expired');
})->name('token.expired');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notification', [NotificationController::class, 'show'])->name('notifications.notification');

Route::group(['prefix' => 'fcm'], function () {
    Route::post('/save-fcm-token', [NotificationController::class, 'saveTokenFcm'])->name('save-token-fcm');
});

Route::get('/locale/{lang}', [LocaleController::class, 'setLocale'])->name('setLocale');
Route::get('/preview', [LocaleController::class, 'showFile']);
Route::post('/log-content-view', [HomepageController::class, 'writeLogContentViews']);


Route::group(['prefix' => 'sector', 'as' => 'sector.'], function () {
    Route::get('/ict', [HomepageController::class, 'getIctSector'])->name('ict');
    Route::get('/tourism', [HomepageController::class, 'getTourismSector'])->name('tourism');
    Route::get('/manufactoring', [HomepageController::class, 'getManufactoringSector'])->name('manufactoring');
    Route::get('/construction', [HomepageController::class, 'getConstructionSector'])->name('construction');
});
Route::middleware('auth:admin')->group(function () {
    Route::get('/deploy/run', [\App\Http\Controllers\DeployController::class, 'run']);
});
Route::middleware('auth:trainee')->group(function () {
    Route::get('/dispatch-portfolios-job', [\App\Http\Controllers\Trainee\PortfolioController::class, 'generatePortfolios']);
});
Route::get('/test-sms-simple', function () {
    $smsService = new ESMSService();

    try {
        // Tạo session
        $session = $smsService->createSession();

        // Thông tin gửi SMS
        $alias = "TVEC";
        $messageType = "TEXT";
        $phoneNumber = "+94707940390";

        // Kết quả
        $results = [];

        // Gửi 50 tin nhắn liên tục
        for ($i = 1; $i <= 100; $i++) {
            $message = "SMS No. #{$i} - " . date('H:i:s');

            try {
                // Gọi hàm sendMessagesMultiLang với retry (3 lần)
                $response = $smsService->sendMessagesMultiLang(
                    $session,
                    $alias,
                    $message,
                    $phoneNumber,
                    $messageType,
                    3, // maxRetries
                    1000 // retryDelay ms
                );

                $results[] = [
                    'stt' => $i,
                    'message' => $message,
                    'response' => $response,
                    'status' => $response == 200 ? 'Thành công' : 'Thất bại',
                    'time' => date('H:i:s')
                ];

                // In ra kết quả mỗi tin nhắn
                echo "SMS #{$i}: " . ($response == 200 ? '✓ Thành công' : '✗ Thất bại') .
                    " (Code: {$response}) - " . date('H:i:s') . "<br>";

                // Chờ 100ms giữa các tin nhắn
                usleep(100000);

            } catch (\Exception $e) {
                $results[] = [
                    'stt' => $i,
                    'message' => $message,
                    'response' => 'Lỗi',
                    'status' => 'Exception',
                    'error' => $e->getMessage(),
                    'time' => date('H:i:s')
                ];

                echo "Tin nhắn #{$i}: ✗ Lỗi - " . $e->getMessage() . "<br>";
            }
        }

        // Đóng session
        $smsService->closeSession($session);

        // Tổng kết
        $successCount = count(array_filter($results, fn($r) => $r['response'] == 200));
        $failCount = 50 - $successCount;

        echo "<hr>";
        echo "<h3>📊 Tổng kết:</h3>";
        echo "Sum: 50<br>";
        echo "Success: {$successCount}<br>";
        echo "Fail: {$failCount}<br>";
        echo "Tỷ lệ thành công: " . round(($successCount / 50) * 100, 2) . "%<br>";

    } catch (\Exception $e) {
        echo "❌ Lỗi hệ thống: " . $e->getMessage();
    }
});

// Magic Link Login
Route::get('/magic-link', [MagicLinkController::class, 'showForm'])->name('magic-link.form');
Route::post('/magic-link', [MagicLinkController::class, 'send'])->name('magic-link.send');
Route::get('/magic-link/verify', [MagicLinkController::class, 'verify'])->name('magic-link.verify');
