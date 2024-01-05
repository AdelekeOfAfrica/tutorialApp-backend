<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace'=>'Api'], function(){
   // Route::post('/login',[UserController::class,'login']);
   Route::post('/login','Usercontroller@login');
    //authentication  layer
    Route::group(['middleware'=>['auth:sanctum']], function(){
        Route::any('/courseList','CourseController@courseList');
        Route::any('/courseDetail','CourseController@courseDetail');
        Route::any('/lessonList','LessonController@lessonList');
    });
});



// Route::post('/auth/login',[UserController::class,'loginUser']);
