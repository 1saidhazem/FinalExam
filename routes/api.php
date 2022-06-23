<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/login', [\App\Http\Controllers\PhotoController::class, 'login']);
Route::middleware('auth:api')->get('/user',function (Request $request){
    return $request->user();
});

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('/getUsers', [\App\Http\Controllers\PhotoController::class, 'getAllUser']);
    Route::get('/getUsersByPaginate', [\App\Http\Controllers\PhotoController::class, 'getUsersByPaginate']);
    Route::get('/user/{id}', [\App\Http\Controllers\PhotoController::class, 'show']);
    Route::post('/updateUser/{id}', [\App\Http\Controllers\PhotoController::class, 'update']);

// final project
    Route::post('/addNewCategory',[\App\Http\Controllers\cinemaMoviesController::class,'storeCategory']);
    Route::post('/addNewMovie',[\App\Http\Controllers\cinemaMoviesController::class,'store']);
    Route::post('/updateCategory/{id}', [\App\Http\Controllers\cinemaMoviesController::class, 'update']);
    Route::post('/updateMovie/{id}', [\App\Http\Controllers\cinemaMoviesController::class, 'updateMovie']);
    Route::post('/deleteCategory/{id}', [\App\Http\Controllers\cinemaMoviesController::class, 'destroyCategory']);
    Route::post('/deleteMovie/{id}', [\App\Http\Controllers\cinemaMoviesController::class, 'destroyMovie']);
});

// final project
Route::post('/addNewUser', [\App\Http\Controllers\PhotoController::class, 'store']);
Route::get('/getCategories',[\App\Http\Controllers\cinemaMoviesController::class,'getCategories']);
Route::get('/getMovies',[\App\Http\Controllers\cinemaMoviesController::class,'getMovies']);
Route::get('/SearchMovie',[\App\Http\Controllers\cinemaMoviesController::class,'getMoviesByPaginate']);



