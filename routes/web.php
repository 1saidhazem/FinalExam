<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    dd('Welcome UCAS');
});

Route::get('/test',[\App\Http\Controllers\ContryController::class, 'index']);


Route::get('/create',[\App\Http\Controllers\PhotoController::class ,'create']);
Route::get('/create2',[\App\Http\Controllers\ContryController::class ,'create']);

