<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/dashboard', [DashboardController::class, 'index']);
// ค้นหาโครงการ
Route::get('/project/search', [ProjectController::class, 'search']);
Route::post('/project/search', [ProjectController::class, 'search']);
Route::get('/project/{project_id}/info', [ProjectController::class, 'info']);

Route::middleware(['auth'])->group(function () {
    // การจัดการโครงการ
    Route::get('/project/list', [ProjectController::class, 'list']);
    Route::post('/project/list', [ProjectController::class, 'list']);        
    Route::get('/project/{project_id}/add', [ProjectController::class, 'add']);
    Route::post('/project/adding', [ProjectController::class, 'adding']);
    // บริหารจัดการโครงการ
    Route::get('/project/manage', [ProjectController::class, 'manage']);
    Route::post('/project/manage', [ProjectController::class, 'manage']);
    Route::get('/project/{project_id}/detail', [ProjectController::class, 'detail']);
    Route::get('/project/{project_id}/edit', [ProjectController::class, 'edit']);
    Route::post('/project/{project_id}/editing', [ProjectController::class, 'editing']);
    Route::get('/project/{project_id}/update', [ProjectController::class, 'update']);
    Route::post('/project/updating', [ProjectController::class, 'updating']);
    // ติดตามสถานะการพิจารณาโครงการ
    Route::get('/project/status', [ProjectController::class, 'status']);
    Route::get('/project/user/{user_id}', [ProjectController::class, 'status_followup']);

    // ติดตามประเมินผลโครงการ
    Route::get('/followup', [FollowupController::class, 'index']);
    Route::get('/followup/{project_id}/timeline', [FollowupController::class, 'timeline']);
    // Route::get('/followup/{project_id}/document', [FollowupController::class, 'document_add']);
    // Route::get('/followup/{project_id}/document/adding', [FollowupController::class, 'document_adding']);
    Route::get('/followup/{project_id}/info', [FollowupController::class, 'info']);
    // ข้อมูลทั่วไป
    Route::get('/followup/{project_id}/general', [FollowupController::class, 'general']);
    Route::post('/followup/{project_id}/general', [FollowupController::class, 'general']);
    Route::post('/followup/general/confirm', [FollowupController::class, 'general_confirm']);
    Route::post('/followup/general/save', [FollowupController::class, 'general_save']);
    Route::post('/followup/delete', [FollowupController::class, 'delete']);
    // แผนและผลการดำเนินงาน
    Route::get('/followup/{project_id}/performance', [FollowupController::class, 'performance']);
    Route::get('/followup/{project_id}/performance/export/{period}', [FollowupController::class, 'performance_export']);
    Route::get('/followup/{project_id}/performance/issue', [FollowupController::class, 'performance_issue']);
    Route::get('/followup/{project_id}/performance/confirm', [FollowupController::class, 'performance_confirm']);
    Route::post('/followup/{project_id}/performance/save', [FollowupController::class, 'performance_save']);
    // แผนและผลการเบิกจ่าย - แหล่งเงิน
    Route::get('/followup/{project_id}/disbursement/money', [FollowupController::class, 'disbursement_money']);
    Route::get('/followup/{project_id}/disbursement/money/export/{period}', [FollowupController::class, 'disbursement_money_export']);
    Route::get('/followup/{project_id}/disbursement/money/issue', [FollowupController::class, 'disbursement_money_issue']);
    Route::get('/followup/{project_id}/disbursement/money/confirm', [FollowupController::class, 'disbursement_money_confirm']);
    Route::post('/followup/{project_id}/disbursement/money/save', [FollowupController::class, 'disbursement_money_save']);
    // แผนและผลการเบิกจ่าย - กิจกรรม
    Route::get('/followup/{project_id}/disbursement/activity', [FollowupController::class, 'disbursement_activity']);
    Route::get('/followup/{project_id}/disbursement/activity/export/{period}', [FollowupController::class, 'disbursement_activity_export']);
    Route::get('/followup/{project_id}/disbursement/activity/issue', [FollowupController::class, 'disbursement_activity_issue']);
    Route::get('/followup/{project_id}/disbursement/activity/confirm', [FollowupController::class, 'disbursement_activity_confirm']);
    Route::post('/followup/{project_id}/disbursement/activity/save', [FollowupController::class, 'disbursement_activity_save']);

    // ข้อมูลมาสเตอร์
    Route::get('/master', [MasterController::class, 'index']);
    Route::get('/master/{id}/update', [MasterController::class, 'update']);
    Route::post('/master/updating', [MasterController::class, 'updating']);

    // ข้อมูลผู้ใช้งาน
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}/update', [UserController::class, 'update']);
    Route::post('/user/updating', [UserController::class, 'updating']);
});

Route::get('/pom', [DashboardController::class, 'pom']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
