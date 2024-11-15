<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// upload data
Route::post('/upload-data', [
    App\Http\Controllers\YogaAPIController::class,
    'uploadData'
]);

// reset db
Route::post('/reset-db', [
    App\Http\Controllers\YogaAPIController::class,
    'resetDB'
]);


// get all courses
Route::get('/courses', [
    App\Http\Controllers\YogaAPIController::class,
    'getCourses'
]);

// create course
Route::post('/courses', [
    App\Http\Controllers\YogaAPIController::class,
    'createCourse'
]);

// update course
Route::put('/courses/{id}', [
    App\Http\Controllers\YogaAPIController::class,
    'updateCourse'
]);

// delete course
Route::delete('/courses/{id}', [
    App\Http\Controllers\YogaAPIController::class,
    'deleteCourse'
]);

// get all classes
Route::get('/classes', [
    App\Http\Controllers\YogaAPIController::class,
    'getClasses'
]);


// get class by id
Route::get('/classes/{id}', [
    App\Http\Controllers\YogaAPIController::class,
    'getClassById'
]);

// create class
Route::post('/classes', [
    App\Http\Controllers\YogaAPIController::class,
    'createClass'
]);

// update class
Route::put('/classes/{id}', [
    App\Http\Controllers\YogaAPIController::class,
    'updateClass'
]);

// delete class
Route::delete('/classes/{id}', [
    App\Http\Controllers\YogaAPIController::class,
    'deleteClass'
]);


// book  classes
Route::post('/bookings', [
    App\Http\Controllers\YogaAPIController::class,
    'bookClass'
]);

// get all bookings
Route::get('/bookings', [
    App\Http\Controllers\YogaAPIController::class,
    'getBookings'
]);

// get booked classes
Route::get('/booked-classes',[
    App\Http\Controllers\YogaAPIController::class,
    'getClassesByBookingInfo'
]);

