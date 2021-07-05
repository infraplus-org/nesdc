<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FollowupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/followup/{project_id}/performance/issue/add', [FollowupController::class, 'performance_issue_add']);
Route::post('/followup/{project_id}/disbursement/money/issue/add', [FollowupController::class, 'disbursement_money_issue_add']);
Route::post('/followup/{project_id}/disbursement/activity/issue/add', [FollowupController::class, 'disbursement_activity_issue_add']);
