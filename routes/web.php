<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// shared routes for admin and company-owner
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job Applications
    Route::resource('job-applications', JobApplicationController::class);
    Route::put('job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');
});

// company-owner specific routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company/{id}', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit/{id}', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company/{id}', [CompanyController::class, 'update'])->name('my-company.update');
});

// admin specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    // Job Categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');
    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
});


require __DIR__ . '/auth.php';
