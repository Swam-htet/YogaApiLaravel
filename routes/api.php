<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload-data', [
    App\Http\Controllers\YogaAPIController::class,
    'uploadData'
]);


Route::get('/courses', [
    App\Http\Controllers\YogaAPIController::class,
    'getCourses'
]);

Route::get('/classes', [
    App\Http\Controllers\YogaAPIController::class,
    'getClasses'
]);
