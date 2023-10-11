<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanvasController;
use App\Http\Controllers\DapilCategoryController;
use App\Http\Controllers\DapilDistrictController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\StepOneController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'survey-sekolah',
    'controller' => StepOneController::class
], function () {
    Route::get('/', 'index');
    Route::get('/count', 'count');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
    Route::get('/villages', 'getVillages');
    Route::get('/schools', 'getSchools');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'assignment',
    'controller' => AssignmentController::class
], function () {
    Route::get('/', 'index');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
    Route::get('/district', 'district');
    Route::get('/dapil', 'dapil');
    Route::get('/user', 'users');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'dapil-category',
    'controller' => DapilCategoryController::class
], function () {
    Route::get('/', 'index');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'canvas',
    'controller' => CanvasController::class
], function () {
    Route::get('/', 'index');
    Route::get('/real', 'real');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'dapil-wilayah',
    'controller' => DapilDistrictController::class
], function () {
    Route::get('/', 'index');
    Route::get('/category', 'category');
    Route::get('/province', 'province');
    Route::get('/city', 'city');
    Route::get('/district', 'district');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'user',
    'controller' => UserController::class
], function () {
    Route::get('/', 'index');
    Route::get('/count', 'count');
    Route::get('/show/{id}', 'show');
    Route::post('/', 'store');
    Route::post('/update/{id}', 'update');
    Route::post('/changepassword', 'changePassword');
    Route::post('/delete/{id}', 'delete');
    Route::get('/me', 'getMe');
});
