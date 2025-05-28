<?php

// File: routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CourseLecturerController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Students Routes
Route::apiResource('students', StudentController::class);

// Courses Routes
Route::apiResource('courses', CourseController::class);

// Lecturers Routes
Route::apiResource('lecturers', LecturerController::class);

// Enrollments Routes
Route::apiResource('enrollments', EnrollmentController::class);

// Course Lecturers Routes
Route::apiResource('course-lecturers', CourseLecturerController::class);