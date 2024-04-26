<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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
//Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

Route::middleware('auth:api')->get('/datauser', function (Request $request) {
    return $request->user();
});

Route::get('/user', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store']);
Route::get('/user/show/{id}', [UserController::class, 'show']);
Route::patch('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy']);

   
Route::get('/job', [JobController::class, 'index']);
Route::post('/job/store', [JobController::class, 'store']);   
Route::get('/job/show/{id}', [JobController::class, 'show']);    
Route::put('/job/update/{id}', [JobController::class, 'update']); 
Route::delete('/job/destroy/{id}', [JobController::class, 'destroy']); 

//Route::get('job/stats', [JobController::class, 'getJobStats']);