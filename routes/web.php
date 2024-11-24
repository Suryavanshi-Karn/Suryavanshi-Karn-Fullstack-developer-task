<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/test-error', function () {
    errorMessage('This is a test error message.');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/portfolio', 'portfolio')->name('portfolio');
    Route::get('/', 'index')->name('home');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin_students_dashboard_chart', [DashboardController::class, 'studentsDashboardChart']);


    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/updateProfile', [AdminController::class, 'updateProfile'])->name('updateProfile');
    
    Route::get('/updatePassword', [AdminController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/resetPassword', [AdminController::class, 'resetPassword'])->name('resetPassword');

    Route::get('/teacher', [AdminController::class, 'teacher'])->name('teacher');
    Route::post('/teacher_data', [AdminController::class, 'teacherdata'])->name('teacher_data');
    Route::get('/teacher_add', [AdminController::class, 'addTeacher']);
    Route::post('/saveTeacher', [AdminController::class, 'saveTeacher']);
    Route::get('/teacher_edit/{id}', [AdminController::class, 'editTeacher']);
    Route::get('/teacher_delete/{id}', [AdminController::class, 'deleteTeacher']);
    
    Route::get('/student', [StudentController::class, 'student'])->name('student');
    Route::post('/student_data', [StudentController::class, 'studentdata'])->name('student_data');
    Route::get('/student_add', [StudentController::class, 'addStudent']);
    Route::post('/saveStudent', [StudentController::class, 'saveStudent']);
    Route::get('/student_edit/{id}', [StudentController::class, 'editStudent']);
    Route::get('/student_delete/{id}', [StudentController::class, 'deleteStudent']);


});

require __DIR__.'/auth.php';
