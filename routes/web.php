<?php

use App\Http\Controllers\Api\PlaceApiController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceMapController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [PlaceMapController::class, 'index'])->name('map');

Route::get('/places/data', [DataController::class, 'places'])->name('places.data'); // DATA TABLE CONTROLLER
Route::get('/places/api', [PlaceApiController::class, 'index'])->name('places.api'); // DATA TABLE CONTROLLER

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [PlaceMapController::class,'index'])->name('home');
    Route::resource('places', PlaceController::class);
});
