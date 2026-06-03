<?php

use App\Http\Controllers\SchoolKid\SchoolKidLoginController;
use App\Http\Controllers\SchoolKid\SchoolKidRegisterController;
use App\Http\Controllers\SchoolKid\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\SchoolKid\MyPageController;
use App\Http\Controllers\Trainee\CareerTestController;
use Illuminate\Support\Facades\Response;
/*
|--------------------------------------------------------------------------
| SchoolKid Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'schoolkid', 'as' => 'schoolkid.'], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/signin', [SchoolKidLoginController::class, 'login'])->name('login');
        Route::post('/signin', [SchoolKidLoginController::class, 'postLogin'])->name('postLogin');
        Route::get('/signup', [SchoolKidRegisterController::class, 'register'])->name('register');
        Route::post('/signup', [SchoolKidRegisterController::class, 'postRegister'])->name('postRegister');
        Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgotPassword');
        Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('postForgotPassword');
        Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetPassword');
        Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('postResetPassword');
        Route::get('/logout', [SchoolKidLoginController::class, 'logout'])->name('logout');
        Route::get('/check-NIC', [SchoolKidRegisterController::class, 'checkNIC'])->name('checkNIC');
    });
    Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
        Route::get('/', [MyPageController::class, 'index'])->name('my-page');
        Route::get('/personal-information', [MyPageController::class, 'getPersonalInformation'])->name('personal-information');
        Route::get('/deactive-account', [MyPageController::class, 'deActiveAccount'])->name('deactive-account');
        Route::get('/get-my-information', [MyPageController::class, 'getMyInformation'])->name('get-my-information');
        Route::post('/personal-information', [MyPageController::class, 'postPersonalInformation'])->name('personal-information.post');
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
    });
});
