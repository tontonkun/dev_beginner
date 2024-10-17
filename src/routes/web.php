<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TimeRecordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\Auth\VerificationController;


Route::get('/auth/register', [RegisterController::class, 'showScreen']);
Route::post('/auth/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'firstHomePage']);
    Route::post('/start_work', [HomeController::class, 'afterStartWork']);
    Route::post('/end_work', [HomeController::class, 'afterEndWork']);
    Route::post('/start_rest', [HomeController::class, 'afterStartRest']);
    Route::post('/end_rest', [HomeController::class, 'afterEndRest']);
    Route::get('/time_record', [TimeRecordController::class, 'timeRecord']);
    Route::get('/time_record_forOneUser/{id}', [TimeRecordController::class, 'timeRecord_forOneUser'])->name('time.record_forOneUser');
    Route::get('/time_record_yesterday', [TimeRecordController::class, 'yesterdayRecord']);
    Route::get('/time_record_tomorrow', [TimeRecordController::class, 'tomorrowRecord']);
});
//勤務状況を算出する！！


Route::get('/auth/login', [LoginController::class, 'startLogin']);

Route::post('/auth/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);



Route::get('/user_list', [UserListController::class, 'UserList']);

//メール認証関連
Auth::routes(['verify' => true]);
Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
