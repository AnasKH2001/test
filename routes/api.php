<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\PhotographyController;
use App\Http\Controllers\Api\ServiceController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/qr-generator', [QrController::class, 'generatePdfApi']);


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');
Route::post('provider/logout', [ProviderController::class, 'providerLogout'])
    ->middleware(['auth:sanctum', 'isProvider']);

Route::post('provider/addService',[ProviderController::class,'addService'])  ->middleware(['auth:sanctum', 'isProvider']);



Route::get('/venues', [VenueController::class, 'index']);
Route::get('/food', [FoodController::class, 'index']);
Route::get('/music', [MusicController::class, 'index']);
Route::get('/photography', [PhotographyController::class, 'index']);


Route::middleware(['auth:sanctum', 'isProvider'])->post('/services', [ServiceController::class, 'store']);
Route::middleware(['auth:sanctum', 'isProvider'])->delete('/services/{id}', [ServiceController::class, 'destroy']);
Route::middleware(['auth:sanctum', 'isProvider'])->get('/services', [ServiceController::class, 'index']);









