<?php

use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CareerTestController;
use App\Http\Controllers\Admin\QuestionAndAnswerController;
use App\Http\Controllers\Admin\SearchAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::controller(RegisterController::class)->group(function(){
    Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
        Route::get('/register', 'register')->name('register');
        Route::post('/register','store')->name('register-user');
        Route::get('/code-verification', 'register')->name('code_verification');
        Route::get('/check-NIC', 'checkNIC')->name('checkNIC');
        Route::post('/logout','logout')->name('logout');
        Route::get('/logout','logout');
    });
});

Route::controller(LoginController::class)->group(function(){
    Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
        Route::post('/login', 'postLogin')->name('login-post');
        Route::get('/login-classic', 'login')->name('login');
    });
});

Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function(){
    Route::get('/view-result/{id}', [CareerTestController::class, 'viewResult'])->name('view-result');
    Route::get('/download-result/{id}', [CareerTestController::class, 'downloadResult'])->name('download-result');
});

Route::group(['prefix' => 'admin-api', 'as' => 'admin-api.'], function(){
    Route::post('/show-district/{id}', [SearchAdminController::class, 'showDistrict'])->name('show-district');
    Route::post('/show-division/{id}', [SearchAdminController::class, 'showDivision'])->name('show-division');
    Route::post('/show-institute/{id}', [SearchAdminController::class, 'showInstitute'])->name('show-institute');
});

Route::group(['prefix' => 'qnas', 'as' => 'qnas.'], function() {
    Route::delete('/delete-reply/{qNAAnswer}', [QuestionAndAnswerController::class, 'destroyReply'])->name('delete-reply');
    Route::put('/update/{qNA}', [QuestionAndAnswerController::class, 'update'])->name('update');
    Route::get('/delete-qna/{id}', [QuestionAndAnswerController::class, 'destroy'])->name('delete');
    Route::get('/attachment/delete/{id}/{qna_id}', [QuestionAndAnswerController::class, 'destroyAttachment'])->name('attachment.delete');
});

Route::get('/download-user-manual', function () {
    $language = App::getLocale();
    $filePath = match ($language) {
        'en' => public_path('files/CareerPlatform_UserManual(Administrator)(en)_v1.0.pdf'),
        'tm' => public_path('files/CareerPlatform_UserManual(Administrator)(en)_v1.0.pdf'),
        'sn' => public_path('files/CareerPlatform_UserManual(Administrator)(sin)_v1.0.pdf'),
        default => public_path('files/CareerPlatform_UserManual(Administrator)(en)_v1.0.pdf'),
    };
    if (!file_exists($filePath)) {
        abort(404, 'File not found.');
    }
    return response()->download($filePath);
})->name('download-user-manual');
